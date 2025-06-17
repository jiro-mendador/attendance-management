<?php
include_once "../database/dbconfig.php";
header("Content-Type:application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["insert"])) {
    $subject = $_POST["subjectName"];
    $teacher = $_POST["teacher"];

    if (isSubjectNameDuplicate($conn, $subject, 0)) {
      echo json_encode(array("message" => "Subject Name Already Exists!", "color" => "red"));
      return;
    }

    $sql = "INSERT INTO \"subject\" (subject_name, teacher_id) VALUES (:subject, :teacher)";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':subject', $subject);
    $statement->bindParam(':teacher', $teacher);

    if ($statement->execute()) {
      echo json_encode(array("message" => "New Subject Added!", "color" => "green"));
    } else {
      echo json_encode(array("message" => "Failed To Add Subject", "color" => "red"));
    }
    return;
  }

  if (isset($_POST["update"])) {
    $subject = $_POST["subjectName"];
    $teacher = $_POST["teacher"];
    $id = $_POST["id"];

    if (isSubjectNameDuplicate($conn, $subject, $id)) {
      echo json_encode(array("message" => "Subject Name Already Exists!", "color" => "red"));
      return;
    }

    $sql = "UPDATE \"subject\" SET subject_name = :subject, teacher_id = :teacher WHERE id = :id;";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':subject', $subject);
    $statement->bindParam(':teacher', $teacher);
    $statement->bindParam(':id', $id);

    if ($statement->execute()) {
      echo json_encode(array("message" => "Subject Updated!", "color" => "green"));
    } else {
      echo json_encode(array("message" => "Failed To Update Subject", "color" => "red"));
    }
    return;
  }

  if (isset($_POST["delete"])) {
    $subject = $_POST["subject"];

    $deleteSqls = [
      "DELETE FROM \"student_subject\" WHERE subject_id = :subject",
      "DELETE FROM \"subject_attendance\" WHERE subject_id = :subject",
      "DELETE FROM \"subject\" WHERE id = :subject"
    ];

    foreach ($deleteSqls as $deleteSql) {
      $deleteStatement = $conn->prepare($deleteSql);
      $deleteStatement->bindParam(":subject", $subject, PDO::PARAM_INT);
      if (!$deleteStatement->execute()) {
        echo json_encode(array("message" => "Cannot Delete Subject!", "color" => "red"));
        return;
      }
    }

    echo json_encode(array("message" => "Subject Deleted!", "color" => "green"));
    return;
  }

  return;
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
  if (isset($_GET["subjects"])) {
    $sql = "SELECT 
      s.id as id, 
      s.subject_name as subject_name, 
      u.last_name || ' ' || u.first_name as teacher_name,
      s.teacher_id as teacher_id
    FROM \"subject\" s 
    LEFT JOIN \"user\" u ON u.id = s.teacher_id";

    $statement = $conn->prepare($sql);
    if ($statement->execute()) {
      $response = [];
      while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $subject = new stdClass();
        $subject->id = $row["id"];
        $subject->name = $row["subject_name"];
        $subject->teacher = $row["teacher_id"];
        $subject->teacher_name = $row["teacher_name"];
        $response[] = $subject;
      }
      echo json_encode($response);
    }
    return;
  }

  if (isset($_GET["subject"])) {
    $id = intval($_GET["id"]); // <-- clean and cast to integer

    $sql = "SELECT * FROM subject WHERE id = :id;";
    $statement = $conn->prepare($sql);
    $statement->bindParam(":id", $id, PDO::PARAM_INT);

    if ($statement->execute()) {
      $response = [];
      while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $subject = new stdClass();
        $subject->id = $row["id"];
        $subject->name = $row["subject_name"];
        $subject->teacher = $row["teacher_id"];
        $response[] = $subject;
      }
      echo json_encode($response);
    }
    return;
  }

  if (isset($_GET["teacher_subject"])) {
    $id = $_GET["id"];
    $isAdmin = isset($_GET["isAdmin"]) ? $_GET["isAdmin"] : false;

    $sql = $isAdmin ? "SELECT * FROM \"subject\"" : "SELECT * FROM \"subject\" WHERE teacher_id = :id";
    $statement = $conn->prepare($sql);

    if (!$isAdmin) {
      $statement->bindParam(":id", $id, PDO::PARAM_INT);
    }

    if ($statement->execute()) {
      $response = [];
      while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $subject = new stdClass();
        $subject->id = $row["id"];
        $subject->name = $row["subject_name"];
        $subject->teacher = $row["teacher_id"];
        $response[] = $subject;
      }
      echo json_encode($response);
    }
    return;
  }

  if (isset($_GET["student_subject"])) {
    $id = $_GET["id"];
    $sql = "SELECT 
      ss.subject_id as id,
      s.subject_name as subject_name   
    FROM \"student_subject\" ss  
    JOIN \"subject\" s ON s.id = ss.subject_id 
    WHERE ss.student_id = :id";

    $statement = $conn->prepare($sql);
    $statement->bindParam(":id", $id, PDO::PARAM_INT);

    if ($statement->execute()) {
      $response = [];
      while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $subject = new stdClass();
        $subject->id = $row["id"];
        $subject->name = $row["subject_name"];
        $response[] = $subject;
      }
      echo json_encode($response);
    }
    return;
  }

  if (isset($_GET["search"])) {
    $searchQuery = $_GET['search'];

    $sql = "SELECT 
      s.id as id, 
      s.subject_name as subject_name, 
      u.last_name || ' ' || u.first_name as teacher_name,
      s.teacher_id as teacher_id
    FROM \"subject\" s 
    LEFT JOIN \"user\" u ON u.id = s.teacher_id
    WHERE 
      CAST(s.id AS TEXT) LIKE :searchQuery OR 
      s.subject_name ILIKE :searchQuery OR 
      u.first_name ILIKE :searchQuery OR 
      u.last_name ILIKE :searchQuery";

    $statement = $conn->prepare($sql);
    $searchParam = '%' . $searchQuery . '%';
    $statement->bindParam(':searchQuery', $searchParam, PDO::PARAM_STR);

    if ($statement->execute()) {
      $response = [];
      while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $subject = new stdClass();
        $subject->id = $row["id"];
        $subject->name = $row["subject_name"];
        $subject->teacher = $row["teacher_id"];
        $subject->teacher_name = $row["teacher_name"];
        $response[] = $subject;
      }
      echo json_encode($response);
    }
    return;
  }
}

function isSubjectNameDuplicate($conn, $subject, $id)
{
  $sql = "SELECT * FROM \"subject\" WHERE subject_name = :sn AND id != :id;";
  $statement = $conn->prepare($sql);
  $statement->bindParam(':sn', $subject);
  $statement->bindParam(':id', $id);
  $statement->execute();
  $results = $statement->fetchAll(PDO::FETCH_ASSOC);
  return $results ?? null;
}