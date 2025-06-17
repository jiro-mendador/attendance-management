<?php
include_once "../database/dbconfig.php";
header("Content-Type:application/json; charset=UTF-8");
date_default_timezone_set('Asia/Manila');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["insert"])) {
    $subject = htmlspecialchars(trim($_POST["subject"]));
    $student = htmlspecialchars(trim($_POST["id"]));
    $status = htmlspecialchars(trim($_POST["status"]));
    $date = htmlspecialchars(trim($_POST["date"]));

    $stud = new stdClass();
    $stud->id = $student;
    $stud->student_name = $_POST["student_name"];
    $stud->status = $status;
    $stud->time = $date . " " . date('g:i A');
    $stud->subject = $_POST["subject_name"];
    $stud->email = getStudentEmail($conn, $student);

    // Get the current time
    $currentTime = date('H:i:s');
    // Combine the date and time
    $date = $date . ' ' . $currentTime;

    try {
      // Check if attendance record already exists
      $existingAttendanceQuery = "SELECT * FROM \"subject_attendance\" WHERE subject_id = :subject AND student_id = :student AND date = :date";
      $existingAttendanceStatement = $conn->prepare($existingAttendanceQuery);
      $existingAttendanceStatement->bindParam(":subject", $subject, PDO::PARAM_INT);
      $existingAttendanceStatement->bindParam(":student", $student, PDO::PARAM_INT);
      $existingAttendanceStatement->bindParam(":date", $date, PDO::PARAM_STR);
      $existingAttendanceStatement->execute();
      $existingAttendance = $existingAttendanceStatement->fetch(PDO::FETCH_ASSOC);

      if ($existingAttendance) {
        // Update existing record
        $attendanceId = $existingAttendance['id'];
        $updateAttendanceQuery = "UPDATE \"subject_attendance\" SET status = :status WHERE id = :attendanceId";
        $updateAttendanceStatement = $conn->prepare($updateAttendanceQuery);
        $updateAttendanceStatement->bindParam(":status", $status, PDO::PARAM_STR);
        $updateAttendanceStatement->bindParam(":attendanceId", $attendanceId, PDO::PARAM_INT);

        if ($updateAttendanceStatement->execute()) {
          $emailSubject = "Attendance Update Notification";
          phpMailer($stud, $emailSubject);
          echo json_encode(array("message" => "Attendance Updated!", "color" => "green"));
        } else {
          echo json_encode(array("message" => "Failed To Update Attendance", "color" => "red"));
        }
      } else {
        // Insert new record
        $insertAttendanceQuery = "INSERT INTO \"subject_attendance\" (subject_id, student_id, status, date) VALUES (:subject, :student, :status, :date)";
        $insertAttendanceStatement = $conn->prepare($insertAttendanceQuery);
        $insertAttendanceStatement->bindParam(":subject", $subject, PDO::PARAM_INT);
        $insertAttendanceStatement->bindParam(":student", $student, PDO::PARAM_INT);
        $insertAttendanceStatement->bindParam(":status", $status, PDO::PARAM_STR);
        $insertAttendanceStatement->bindParam(":date", $date, PDO::PARAM_STR);

        if ($insertAttendanceStatement->execute()) {
          $emailSubject = "Attendance Notification";
          phpMailer($stud, $emailSubject);
          echo json_encode(array("message" => "Attendance Recorded!", "color" => "green"));
        } else {
          echo json_encode(array("message" => "Failed To Add User", "color" => "red"));
        }
      }
    } catch (PDOException $e) {
      $errorInfo = $e->errorInfo;
      echo json_encode(
        array(
          "message" => "Integrity Constraint Violation: " . $e->getMessage(),
          "errorInfo" => $errorInfo,
          "color" => "red"
        )
      );
    }
  }

  if (isset($_POST["delete"])) {
    $id = htmlspecialchars(trim($_POST["id"]));
    $deleteSql = "DELETE FROM \"subject_attendance\" WHERE id = :id";
    $deleteStatement = $conn->prepare($deleteSql);
    $deleteStatement->bindParam(":id", $id, PDO::PARAM_INT);
    if ($deleteStatement->execute()) {
      echo json_encode(array("message" => "Attendance Deleted!", "color" => "green"));
    } else {
      echo json_encode(array("message" => "Cannot Delete Attendance!", "color" => "red"));
    }
  }

  if (isset($_POST["print"])) {
    $subject = htmlspecialchars(trim($_POST["subject"]));
    $from = htmlspecialchars(trim($_POST["fromDate"]));
    $to = htmlspecialchars(trim($_POST["toDate"]));

    $sql = "SELECT u.first_name AS fname, u.last_name AS lname, 
                sa.status AS status, sa.date AS date 
                FROM \"subject_attendance\" sa 
                JOIN \"user\" u ON sa.student_id = u.id 
                WHERE subject_id = :subject 
                AND date >= :from AND date <= :to";

    $statement = $conn->prepare($sql);
    $statement->bindParam(":subject", $subject, PDO::PARAM_INT);
    $statement->bindParam(":from", $from, PDO::PARAM_STR);
    $statement->bindParam(":to", $to, PDO::PARAM_STR);

    if ($statement->execute()) {
      $response = array();
      while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $attendance = new stdClass();
        $attendance->Student = $row["lname"] . " " . $row["fname"];
        $attendance->Attendance = $row["status"];
        $attendance->Date = $row["date"];
        $response[] = $attendance;
      }
      echo json_encode($response);
    }
  }
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
  if (isset($_GET["attendance"])) {
    $subject = $_GET["subject"];
    $date = $_GET["date"];

    $sql = "SELECT s.id AS sid, 
                s.last_name AS last_name, 
                s.first_name AS first_name, 
                COALESCE(sa.status, 'No Record') AS status,
                sc.qrcode AS qrcode,
                sa.id AS attendance_id 
                FROM \"user\" s 
                JOIN \"student_subject\" ss ON s.id = ss.student_id 
                LEFT JOIN \"subject_attendance\" sa ON s.id = sa.student_id 
                    AND DATE(sa.date) = :date 
                    AND sa.subject_id = :subject 
                LEFT JOIN \"student_code\" sc ON s.id = sc.student_id 
                WHERE s.type = 'student' 
                AND ss.subject_id = :subject";

    $statement = $conn->prepare($sql);
    $statement->bindParam(":date", $date, PDO::PARAM_STR);
    $statement->bindParam(":subject", $subject, PDO::PARAM_STR);

    if ($statement->execute()) {
      $response = array();
      while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $student = new stdClass();
        $student->id = $row["sid"];
        $student->qrcode = $row["qrcode"];
        $student->lastName = $row["last_name"];
        $student->firstName = $row["first_name"];
        $student->status = $row["status"];
        $student->attendanceId = $row["attendance_id"];
        $response[] = $student;
      }
      echo json_encode($response);
    }
    return;
  }

  if (isset($_GET["student_attendance"])) {
    $id = $_GET["id"];
    $subject = $_GET["subject"];
    $firstDate = $_GET["firstDate"];
    $lastDate = $_GET["lastDate"];

    $sql = "SELECT * 
                FROM \"subject_attendance\" 
                WHERE student_id = :id 
                AND date >= :firstDate 
                AND date <= :lastDate 
                AND subject_id = :subject 
                ORDER BY date";

    $statement = $conn->prepare($sql);
    $statement->bindParam(":id", $id, PDO::PARAM_INT);
    $statement->bindParam(":firstDate", $firstDate, PDO::PARAM_STR);
    $statement->bindParam(":lastDate", $lastDate, PDO::PARAM_STR);
    $statement->bindParam(":subject", $subject, PDO::PARAM_INT);

    if ($statement->execute()) {
      $response = array();
      while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $attendance = new stdClass();
        $attendance->status = $row["status"];
        $attendance->date = $row["date"];
        if (!isset($_GET["for_printing"])) {
          $attendance->subject = $row["subject_id"];
        }
        $response[] = $attendance;
      }
      echo json_encode($response);
    }
    return;
  }

  if (isset($_GET["student_summary"])) {
    $id = intval($_GET["id"]);
    $subject = intval($_GET["subject"]);

    $sql = "SELECT COUNT(*) AS totalAttendance, SUM(CASE WHEN status = 'Present' THEN 1 ELSE 0 END) AS presentCount, 
    SUM(CASE WHEN status = 'Absent' THEN 1 ELSE 0 END) AS absentCount FROM subject_attendance WHERE student_id = :id AND subject_id = :subject";

    $statement = $conn->prepare($sql);
    $statement->bindParam(":id", $id, PDO::PARAM_INT);
    $statement->bindParam(":subject", $subject, PDO::PARAM_INT);

    $response = array(
      "total" => 0,
      "attended" => 0,
      "absences" => 0,
      "error" => "",
    );

    // if ($statement->execute()) {
    //   $row = $statement->fetch(PDO::FETCH_ASSOC);
    //   if ($row) {
    //     $response["total"] = $row["totalAttendance"];
    //     $response["attended"] = $row["presentCount"];
    //     $response["absences"] = $row["absentCount"];
    //   }
    // }

    if ($statement->execute()) {
      $row = $statement->fetch(PDO::FETCH_ASSOC);
      if ($row) {
        $response["error"] = "Fetched row: " . print_r($row, true);

        // Safe access
        $response["total"] = $row["totalattendance"] ?? 0;
        $response["attended"] = $row["presentcount"] ?? 0;
        $response["absences"] = $row["absentcount"] ?? 0;
      } else {
        $response["error"] = "No data returned.";
      }
    } else {
      $response["error"] = "Query execution failed.";
    }

    echo json_encode($response);
    return;
  }

  if (isset($_GET["teacher_summary"])) {
    $id = $_GET["id"];
    $subject = $_GET["subject"];

    $sql = "SELECT COUNT(*) AS total_student 
                FROM \"student_subject\" 
                WHERE subject_id = :subject";

    $statement = $conn->prepare($sql);
    $statement->bindParam(":subject", $subject, PDO::PARAM_INT);

    $response = array();

    if ($statement->execute()) {
      $row = $statement->fetch(PDO::FETCH_ASSOC);
      if ($row) {
        $response["total"] = $row["total_student"];
      }

      $sql = "SELECT 
                    SUM(CASE WHEN status = 'Present' THEN 1 ELSE 0 END) AS present,
                    SUM(CASE WHEN status = 'Absent' THEN 1 ELSE 0 END) AS absent
                    FROM \"subject_attendance\"
                    WHERE subject_id = :subject AND date = CURRENT_DATE";

      $statement = $conn->prepare($sql);
      $statement->bindParam(":subject", $subject, PDO::PARAM_INT);

      if ($statement->execute()) {
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if ($row) {
          $response["present"] = $row["present"];
          $response["absent"] = $row["absent"];
        }
      }

      echo json_encode($response);
    }
    return;
  }

  if (isset($_GET["teacher_graph"])) {
    $year = $_GET["year"];
    $subject = $_GET["subject"];

    $response = array();
    for ($month = 1; $month <= 12; $month++) {
      $response[] = array(
        "year" => $year,
        "month" => $month,
        "attendance_percentage" => 0,
        "present_count" => 0,
        "absent_count" => 0,
      );
    }

    $sql = "SELECT 
                EXTRACT(YEAR FROM date) AS year,
                EXTRACT(MONTH FROM date) AS month,
                SUM(CASE WHEN status = 'Present' THEN 1 ELSE 0 END) AS present_count,
                SUM(CASE WHEN status = 'Absent' THEN 1 ELSE 0 END) AS absent_count,
                (SUM(CASE WHEN status = 'Present' THEN 1 ELSE 0 END)::float / COUNT(*)) * 100 AS attendance_percentage
                FROM \"subject_attendance\"
                WHERE EXTRACT(YEAR FROM date) = :year AND subject_id = :subject
                GROUP BY EXTRACT(YEAR FROM date), EXTRACT(MONTH FROM date)
                ORDER BY year, month";

    $statement = $conn->prepare($sql);
    $statement->bindParam(":year", $year, PDO::PARAM_INT);
    $statement->bindParam(":subject", $subject, PDO::PARAM_INT);

    if ($statement->execute()) {
      while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $responseIndex = $row["month"] - 1;
        $response[$responseIndex]["attendance_percentage"] = $row["attendance_percentage"];
        $response[$responseIndex]["present_count"] = $row["present_count"];
        $response[$responseIndex]["absent_count"] = $row["absent_count"];
      }
    }

    echo json_encode($response);
    return;
  }
}

function phpMailer($stud, $emailSubject)
{
  include_once "../mail/send_email.php";
  $mail = new email();
  $mail->stud = $stud;
  $mail->sendEmail(
    $stud->student_name,
    $stud->email,
    $emailSubject
  );
}

function getStudentEmail($conn, $student_id)
{
  $sql = "SELECT email FROM \"user\" WHERE type = 'student' AND id = :id LIMIT 1";
  $statement = $conn->prepare($sql);
  $statement->bindParam(":id", $student_id, PDO::PARAM_INT);
  if ($statement->execute()) {
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
      return $row["email"];
    }
  }
  return "gmail not available";
}