<?php
include_once "../database/dbconfig.php";
header("Content-Type:application/json; charset=UTF-8");
date_default_timezone_set('Asia/Manila');

function phpMailer($stud, $subject)
{
  include_once "../mail/send_email.php";
  $mail = new email();
  $mail->stud = $stud;
  $mail->sendEmail($stud->student_name, $stud->email, $subject);
}

function getStudentEmail($conn, $student_id)
{
  $sql = 'SELECT email FROM "user" WHERE type = \'student\' AND id = :id LIMIT 1';
  $st = $conn->prepare($sql);
  $st->execute([':id' => $student_id]);
  return $st->fetchColumn() ?: "gmail not available";
}

$method = $_SERVER["REQUEST_METHOD"];
if ($method === "POST") {
  // INSERT or UPDATE
  if (isset($_POST['insert'])) {
    $subject = trim($_POST['subject']);
    $student = trim($_POST['id']);
    $status = trim($_POST['status']);
    $dateStr = trim($_POST['date']); // YYYY-MM-DD
    $timestamp = $dateStr . ' ' . date('H:i:s');

    $stud = (object) [
      'id' => $student,
      'student_name' => $_POST['student_name'],
      'status' => $status,
      'time' => $dateStr . ' ' . date('g:i A'),
      'subject' => $_POST['subject_name'],
      'email' => getStudentEmail($conn, $student)
    ];

    try {
      // Attempt to update first
      $upd = $conn->prepare("
        UPDATE subject_attendance
        SET status = :status, date = :dt
        WHERE subject_id = :sub AND student_id = :stu
          AND date = :dt
      ");
      $upd->execute([
        ':status' => $status,
        ':dt' => $timestamp,
        ':sub' => $subject,
        ':stu' => $student
      ]);
      if ($upd->rowCount() > 0) {
        phpMailer($stud, "Attendance Update Notification");
        exit(json_encode(["message" => "Attendance Updated!", "color" => "green"]));
      }

      // Else insert
      $ins = $conn->prepare("
        INSERT INTO subject_attendance(subject_id, student_id, status, date)
        VALUES(:sub,:stu,:status,:dt)
      ");
      $ins->execute([
        ':sub' => $subject,
        ':stu' => $student,
        ':status' => $status,
        ':dt' => $timestamp
      ]);
      phpMailer($stud, "Attendance Notification");
      exit(json_encode(["message" => "Attendance Recorded!", "color" => "green"]));
    } catch (PDOException $e) {
      $ei = $e->errorInfo;
      exit(json_encode([
        "message" => "Integrity Constraint Violation: " . $e->getMessage(),
        "errorInfo" => $ei,
        "color" => "red"
      ]));
    }
  }

  // DELETE
  if (isset($_POST['delete'])) {
    $st = $conn->prepare("DELETE FROM subject_attendance WHERE id = :id");
    if ($st->execute([':id' => trim($_POST['id'])]))
      exit(json_encode(["message" => "Attendance Deleted!", "color" => "green"]));
    exit(json_encode(["message" => "Cannot Delete Attendance!", "color" => "red"]));
  }

  // PRINT
  if (isset($_POST['print'])) {
    $st = $conn->prepare("
      SELECT u.first_name AS fname, u.last_name AS lname,
             sa.status, sa.date
      FROM subject_attendance sa
      JOIN \"user\" u ON sa.student_id = u.id
      WHERE sa.subject_id = :sub AND sa.date BETWEEN :from AND :to
    ");
    $st->execute([
      ':sub' => $_POST['subject'],
      ':from' => $_POST['fromDate'],
      ':to' => $_POST['toDate']
    ]);
    $rows = $st->fetchAll(PDO::FETCH_ASSOC);
    exit(json_encode(array_map(fn($r) => [
      'Student' => $r['lname'] . ' ' . $r['fname'],
      'Attendance' => $r['status'],
      'Date' => $r['date']
    ], $rows)));
  }
}

// GET ROUTES
if ($method === "GET") {
  // LIST TAMED
  if (isset($_GET['attendance'])) {
    $st = $conn->prepare("
      SELECT s.id sid, s.last_name, s.first_name,
             COALESCE(sa.status, 'No Record') AS status,
             sc.qrcode, sa.id AS attendance_id
      FROM \"user\" s
      JOIN student_subject ss ON s.id = ss.student_id
      LEFT JOIN subject_attendance sa
        ON s.id = sa.student_id
        AND DATE(sa.date)=:dt
        AND sa.subject_id=:sub
      LEFT JOIN student_code sc ON s.id = sc.student_id
      WHERE s.type='student' AND ss.subject_id=:sub
    ");
    $st->execute([':dt' => $_GET['date'], ':sub' => $_GET['subject']]);
    $resp = array_map(fn($r) =>
      (object) [
        'id' => $r['sid'],
        'qrcode' => $r['qrcode'],
        'lastName' => $r['last_name'],
        'firstName' => $r['first_name'],
        'status' => $r['status'],
        'attendanceId' => $r['attendance_id']
      ], $st->fetchAll(PDO::FETCH_ASSOC));
    exit(json_encode($resp));
  }

  // STUDENT ATTENDANCE
  if (isset($_GET['student_attendance'])) {
    $st = $conn->prepare("
      SELECT status, date, subject_id 
      FROM subject_attendance
      WHERE student_id=:id AND date BETWEEN :f AND :t
        AND subject_id=:sub
      ORDER BY date
    ");
    $st->execute([
      ':id' => $_GET['id'],
      ':f' => $_GET['firstDate'],
      ':t' => $_GET['lastDate'],
      ':sub' => $_GET['subject']
    ]);
    $out = [];
    while ($r = $st->fetch(PDO::FETCH_ASSOC)) {
      $o = (object) ['status' => $r['status'], 'date' => $r['date']];
      if (!isset($_GET['for_printing']))
        $o->subject = $r['subject_id'];
      $out[] = $o;
    }
    exit(json_encode($out));
  }

  // STUDENT SUMMARY
  if (isset($_GET['student_summary'])) {
    $st = $conn->prepare("
      SELECT COUNT(*) AS total,
             SUM(CASE WHEN status='present' THEN 1 ELSE 0 END) AS attended,
             SUM(CASE WHEN status='absent' THEN 1 ELSE 0 END) AS absences
      FROM subject_attendance
      WHERE student_id=:id AND subject_id=:sub
    ");
    $st->execute([':id' => $_GET['id'], ':sub' => $_GET['subject']]);
    exit(json_encode($st->fetch(PDO::FETCH_ASSOC)));
  }

  // TEACHER SUMMARY
  if (isset($_GET['teacher_summary'])) {
    $resp = [];
    $st = $conn->prepare("SELECT COUNT(*) FROM student_subject WHERE subject_id=:sub");
    $st->execute([':sub' => $_GET['subject']]);
    $resp['total'] = (int) $st->fetchColumn();

    $st = $conn->prepare("
      SELECT
        SUM(CASE WHEN status='present' THEN 1 ELSE 0 END)::int AS present,
        SUM(CASE WHEN status='absent' THEN 1 ELSE 0 END)::int AS absent
      FROM subject_attendance
      WHERE subject_id=:sub AND DATE(date)=CURRENT_DATE
    ");
    $st->execute([':sub' => $_GET['subject']]);
    $row = $st->fetch(PDO::FETCH_ASSOC);
    $resp['present'] = $row['present'];
    $resp['absent'] = $row['absent'];
    exit(json_encode($resp));
  }

  // TEACHER GRAPH
  if (isset($_GET['teacher_graph'])) {
    $year = intval($_GET['year']);
    $sub = $_GET['subject'];
    // initialize months
    $resp = array_map(fn($m) => [
      'year' => $year,
      'month' => $m,
      'attendance_percentage' => 0,
      'present_count' => 0,
      'absent_count' => 0
    ], range(1, 12));
    $st = $conn->prepare("
      SELECT
        EXTRACT(YEAR FROM date)::int AS year,
        EXTRACT(MONTH FROM date)::int AS month,
        SUM(CASE WHEN status='present' THEN 1 ELSE 0 END)::int AS present_count,
        SUM(CASE WHEN status='absent' THEN 1 ELSE 0 END)::int AS absent_count,
        (SUM(CASE WHEN status='present' THEN 1 ELSE 0 END)::decimal / COUNT(*)) * 100 AS attendance_percentage
      FROM subject_attendance
      WHERE EXTRACT(YEAR FROM date)=:yr AND subject_id=:sub
      GROUP BY year, month
      ORDER BY year, month
    ");
    $st->execute([':yr' => $year, ':sub' => $sub]);
    while ($r = $st->fetch(PDO::FETCH_ASSOC)) {
      $idx = $r['month'] - 1;
      $resp[$idx] = $r;
    }
    exit(json_encode($resp));
  }
}