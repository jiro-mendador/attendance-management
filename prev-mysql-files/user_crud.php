<?php

include_once "../database/dbconfig.php";
include_once 'phpqrcode/qrlib.php';

header("Content-Type:application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (isset($_POST["insert"]) || isset($_POST["update"])) {

    $firstName = htmlspecialchars(trim($_POST["firstName"]));
    $lastName = htmlspecialchars(trim($_POST["lastName"]));
    $middleName = htmlspecialchars(trim($_POST["middleName"]));
    $bday = htmlspecialchars(trim($_POST["bday"]));
    $gender = htmlspecialchars(trim($_POST["gender"]));
    $type = htmlspecialchars(trim($_POST["type"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $password = htmlspecialchars(trim($_POST["password"]));

    if (isset($_POST["insert"])) {
      try {

        if (isNameDuplicate($conn, $firstName, $lastName, $middleName, 0)) {
          echo json_encode(array("message" => "This name already exists!", "color" => "red"));
          return;
        }

        if (isEmailDuplicate($conn, $email, 0)) {
          echo json_encode(array("message" => "Please choose/use another email...", "color" => "red"));
          return;
        }

        $sql = "INSERT INTO user VALUES (default, :fn, :ln, :mn, :bd, :gd, :tp, :em, :pw);";
        $statement = $conn->prepare($sql);
        $statement->bindParam(":fn", $firstName, PDO::PARAM_STR);
        $statement->bindParam(":ln", $lastName, PDO::PARAM_STR);
        $statement->bindParam(":mn", $middleName, PDO::PARAM_STR);
        $statement->bindParam(":bd", $bday, PDO::PARAM_STR);
        $statement->bindParam(":gd", $gender, PDO::PARAM_STR);
        $statement->bindParam(":tp", $type, PDO::PARAM_STR);
        $statement->bindParam(":em", $email, PDO::PARAM_STR);
        $statement->bindParam(":pw", $password, PDO::PARAM_STR);

        if ($statement->execute()) {
          if ($type === "student") {
            $lastId = $conn->lastInsertId();
            $subjects = isset($_POST['subjectGroup']) ? $_POST['subjectGroup'] : [];

            foreach ($subjects as $subject) {
              $sql = "INSERT INTO student_subject VALUES (default, :subject, :user)";
              $statement = $conn->prepare($sql);
              $statement->bindParam(":subject", $subject, PDO::PARAM_INT);
              $statement->bindParam(":user", $lastId, PDO::PARAM_INT);
              $statement->execute();
            }

            $sanitizedLastName = preg_replace('/[^A-Za-z0-9_-]/', '', $lastName);
            $path = '../images/';
            $qrcode = $path . $sanitizedLastName . '_' . time() . ".png";
            $qrimage = $sanitizedLastName . '_' . time() . ".png";
            QRcode::png($lastId, $qrcode, 'H', 4, 4); //*generates the qr

            $sql = "INSERT INTO student_code VALUES (default, :id, :code);";
            $statement = $conn->prepare($sql);
            $statement->bindParam(":id", $lastId, PDO::PARAM_STR);
            $statement->bindParam(":code", $qrcode, PDO::PARAM_STR);
            $statement->execute();

          }
          echo json_encode(array("message" => "New " . $type . " Added!", "color" => "green"));
        } else {
          echo json_encode(array("message" => "Failed To Add User", "color" => "red"));
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

    if (isset($_POST["update"])) {
      $id = htmlspecialchars(trim($_POST["id"]));

      if (isNameDuplicate($conn, $firstName, $lastName, $middleName, $id)) {
        echo json_encode(array("message" => "This name already exists!", "color" => "red"));
        return;
      }

      if (isEmailDuplicate($conn, $email, $id)) {
        echo json_encode(array("message" => "Please choose/use another email...", "color" => "red"));
        return;
      }

      if ($type !== "admin" && !isAdminExists($conn, $id)) {
        echo json_encode(array("message" => "The system needs at least 1 admin", "color" => "red"));
        return;
      }

      try {
        $sql = "UPDATE user SET first_name = :fn, last_name = :ln, middle_name = :mn, 
      birthdate = :bd, gender = :gd,  type = :tp, email = :em, password = :pw WHERE id = :id;";
        $statement = $conn->prepare($sql);
        $statement->bindParam(":fn", $firstName, PDO::PARAM_STR);
        $statement->bindParam(":ln", $lastName, PDO::PARAM_STR);
        $statement->bindParam(":mn", $middleName, PDO::PARAM_STR);
        $statement->bindParam(":bd", $bday, PDO::PARAM_STR);
        $statement->bindParam(":gd", $gender, PDO::PARAM_STR);
        $statement->bindParam(":tp", $type, PDO::PARAM_STR);
        $statement->bindParam(":em", $email, PDO::PARAM_STR);
        $statement->bindParam(":pw", $password, PDO::PARAM_STR);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);

        if ($statement->execute()) {

          // delete existing student_subject associations for the student
          $deleteSql = "DELETE FROM student_subject WHERE student_id = :user";
          $deleteStatement = $conn->prepare($deleteSql);
          $deleteStatement->bindParam(":user", $id, PDO::PARAM_INT);
          $deleteStatement->execute();

          // delete existing subject_attendance associations for the student
          $deleteSql = "DELETE FROM subject_attendance WHERE student_id = :user";
          $deleteStatement = $conn->prepare($deleteSql);
          $deleteStatement->bindParam(":user", $id, PDO::PARAM_INT);
          $deleteStatement->execute();

          // delete existing subject associations for the teacher
          $deleteSql = "DELETE FROM subject WHERE teacher_id = :user";
          $deleteStatement = $conn->prepare($deleteSql);
          $deleteStatement->bindParam(":user", $id, PDO::PARAM_INT);
          $deleteStatement->execute();

          if ($type === "student") {
            $subjects = isset($_POST['subjectGroup']) ? $_POST['subjectGroup'] : [];
            // insert the new subject associations for the student
            foreach ($subjects as $subject) {
              $insertSql = "INSERT INTO student_subject (subject_id, student_id) VALUES (:subject, :user)";
              $insertStatement = $conn->prepare($insertSql);
              $insertStatement->bindParam(":subject", $subject, PDO::PARAM_INT);
              $insertStatement->bindParam(":user", $id, PDO::PARAM_INT);
              $insertStatement->execute();
            }
          }
          echo json_encode(array("message" => $type . " Updated!", "color" => "green"));
        } else {
          echo json_encode(array("message" => "Failed To Update User", "color" => "red"));
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
  }

  if (isset($_POST["profile"])) {

    $firstName = htmlspecialchars(trim($_POST["firstName"]));
    $lastName = htmlspecialchars(trim($_POST["lastName"]));
    $middleName = htmlspecialchars(trim($_POST["middleName"]));
    $bday = htmlspecialchars(trim($_POST["bday"]));
    $gender = htmlspecialchars(trim($_POST["gender"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $password = htmlspecialchars(trim($_POST["password"]));

    if (isset($_POST["profile"])) {
      $id = htmlspecialchars(trim($_POST["id"]));
      try {
        $sql = "UPDATE user SET first_name = :fn, last_name = :ln, middle_name = :mn, 
      birthdate = :bd, gender = :gd, email = :em, password = :pw WHERE id = :id;";
        $statement = $conn->prepare($sql);
        $statement->bindParam(":fn", $firstName, PDO::PARAM_STR);
        $statement->bindParam(":ln", $lastName, PDO::PARAM_STR);
        $statement->bindParam(":mn", $middleName, PDO::PARAM_STR);
        $statement->bindParam(":bd", $bday, PDO::PARAM_STR);
        $statement->bindParam(":gd", $gender, PDO::PARAM_STR);
        $statement->bindParam(":em", $email, PDO::PARAM_STR);
        $statement->bindParam(":pw", $password, PDO::PARAM_STR);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);

        if ($statement->execute()) {
          echo json_encode(array("message" => "Information Updated!", "color" => "green"));
        } else {
          echo json_encode(array("message" => "Failed To Update User", "color" => "red"));
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
  }

  if (isset($_POST["delete"])) {
    $id = htmlspecialchars(trim($_POST["id"]));

    // * delete on student subject if teacher
    $deleteSql = "DELETE FROM student_subject WHERE student_id = :user";
    $deleteStatement = $conn->prepare($deleteSql);
    $deleteStatement->bindParam(":user", $id, PDO::PARAM_INT);
    $deleteStatement->execute();

    // * delete on subject attendance if student
    $deleteSql = "DELETE FROM subject_attendance WHERE student_id = :user";
    $deleteStatement = $conn->prepare($deleteSql);
    $deleteStatement->bindParam(":user", $id, PDO::PARAM_INT);
    $deleteStatement->execute();

    $sql = "SELECT qrcode FROM student_code WHERE student_id = :userId";
    $statement = $conn->prepare($sql);
    $statement->bindParam(":userId", $id, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    if ($result) {
      $filename = $result['qrcode'];
      $fullPath = '../images/' . $filename;
      if (file_exists($fullPath)) {
        // * delete image on file folder
        if (unlink($fullPath)) {
          // * delete on student code if student
          $deleteSql = "DELETE FROM student_code WHERE student_id = :user";
          $deleteStatement = $conn->prepare($deleteSql);
          $deleteStatement->bindParam(":user", $id, PDO::PARAM_INT);
          $deleteStatement->execute();
        }
      }
    }

    // * delete on subject if teacher
    $deleteSql = "DELETE FROM subject WHERE teacher_id = :user";
    $deleteStatement = $conn->prepare($deleteSql);
    $deleteStatement->bindParam(":user", $id, PDO::PARAM_INT);
    $deleteStatement->execute();

    // * finally delete the user
    $deleteSql = "DELETE FROM user WHERE id = :user";
    $deleteStatement = $conn->prepare($deleteSql);
    $deleteStatement->bindParam(":user", $id, PDO::PARAM_INT);
    if ($deleteStatement->execute()) {
      echo json_encode(array("message" => "User Deleted!", "color" => "green"));
    } else {
      echo json_encode(array("message" => "Cannot Delete User!", "color" => "red"));
    }

  }

  if (isset($_POST["login"])) {
    $email = htmlspecialchars(trim($_POST["email"]));
    $password = htmlspecialchars(trim($_POST["password"]));

    $sql = "SELECT * FROM user WHERE email = :email AND password = :pw;";
    $statement = $conn->prepare($sql);
    $statement->bindParam(":email", $email, PDO::PARAM_STR);
    $statement->bindParam(":pw", $password, PDO::PARAM_STR);

    if ($statement->execute()) {
      $row = $statement->fetch(PDO::FETCH_ASSOC);
      if ($row) {
        $dbPassword = $row["password"];
        $dbEmail = $row["email"];
        if ($email == $dbEmail && $password == $dbPassword) {
          $firstName = $row["first_name"];
          $lastName = $row["last_name"];
          $id = $row["id"];
          $type = $row["type"];
          echo json_encode(
            array(
              "message" => "Login Success!",
              "color" => "green",
              "type" => $type,
              "id" => $id,
              "firstName" => $firstName,
              "lastName" => $lastName,
            )
          );
        } else {
          echo json_encode(array("message" => "Incorrect email or password...", "color" => "red"));
        }
      } else {
        echo json_encode(array("message" => "Incorrect email or password...", "color" => "red"));
      }
    } else {
      echo json_encode(array("message" => "Cannot login right now...", "color" => "red"));
    }
  }
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {

  if (isset($_GET["users"])) {

    $isForTeacher = false;
    $teacher_id = 0;
    if (isset($_GET["for_teacher"])) {
      $isForTeacher = $_GET["for_teacher"];
      $teacher_id = $_GET["teacher_id"];
    }

    $response = array();
    $sql = "SELECT * FROM user;";

    if ($isForTeacher) {
      $sql = "SELECT DISTINCT u.* FROM user u
      JOIN student_subject ss ON u.id = ss.student_id
      JOIN subject s ON ss.subject_id = s.id
      WHERE u.type = 'student' AND s.teacher_id = :teacher_id";
    }
    $statement = $conn->prepare($sql);
    if ($isForTeacher) {
      $statement->bindParam(":teacher_id", $teacher_id, PDO::PARAM_STR);
    }

    if ($statement->execute()) {
      $response = array();
      while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $user = new stdClass();
        $user->id = $row["id"];
        $user->firstName = $row["first_name"];
        $user->lastName = $row["last_name"];
        $user->middleName = $row["middle_name"];
        $user->bday = $row["birthdate"];
        $user->gender = $row["gender"];
        $user->type = $row["type"];
        $user->email = $row["email"];
        $user->password = $row["password"];
        $response[] = $user;
      }
      echo json_encode($response);
    }
    return;
  }

  if (isset($_GET["user"])) {
    $response = array();
    $id = $_GET["id"];

    $sql = "SELECT * FROM user WHERE id = :id;";
    $statement = $conn->prepare($sql);
    $statement->bindParam(":id", $id, PDO::PARAM_INT);

    if ($statement->execute()) {
      $response = array();
      while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $user = new stdClass();
        $user->id = $row["id"];
        $user->firstName = $row["first_name"];
        $user->lastName = $row["last_name"];
        $user->middleName = $row["middle_name"];
        $user->bday = $row["birthdate"];
        $user->gender = $row["gender"];
        $user->type = $row["type"];
        $user->email = $row["email"];
        $user->password = $row["password"];

        // * get subjects
        // $subject_sql = "SELECT s.subject_name, s.id FROM student_subject sb JOIN subject s 
        //   ON sb.subject_id = s.id WHERE student_id = :id;";
        $subject_sql = "SELECT s.id AS subject_id, s.subject_name AS subject_name, 
        sb.student_id as stud_id, sb.subject_id AS student_subject_id 
        FROM subject s 
        LEFT JOIN student_subject sb ON s.id = sb.subject_id AND sb.student_id = :id";
        $subject_statement = $conn->prepare($subject_sql);
        $subject_statement->bindParam(":id", $user->id, PDO::PARAM_INT);
        if ($subject_statement->execute()) {
          $user->subjects = array();
          while ($subject_row = $subject_statement->fetch(PDO::FETCH_ASSOC)) {
            $active = ($subject_row["stud_id"] == $user->id) ? true : false; // Check for NULL separately
            $user->subjects[] = array(
              "subjectName" => $subject_row["subject_name"],
              "subjectId" => $subject_row["subject_id"],
              "active" => $active,
            );
          }
        }

        $response[] = $user;
      }
      echo json_encode($response);
    }
    return;
  }

  if (isset($_GET['search'])) {

    $isForTeacher = false;
    $teacher_id = 0;
    if (isset($_GET["for_teacher"])) {
      $isForTeacher = $_GET["for_teacher"];
      $teacher_id = $_GET["teacher_id"];
    }

    $searchQuery = $_GET['search'];
    $sql = "SELECT * FROM user 
            WHERE id LIKE :searchQuery 
            OR first_name LIKE :searchQuery 
            OR last_name LIKE :searchQuery 
            OR middle_name LIKE :searchQuery 
            OR birthdate LIKE :searchQuery 
            OR gender LIKE :searchQuery 
            OR type LIKE :searchQuery 
            OR email LIKE :searchQuery 
            OR password LIKE :searchQuery";

    if ($isForTeacher) {
      $sql = "
    SELECT DISTINCT u.*
    FROM user u
    JOIN student_subject ss ON u.id = ss.student_id
    JOIN subject s ON ss.subject_id = s.id
    WHERE u.type = 'student' 
      AND s.teacher_id = :teacher_id
      AND (
          u.id LIKE :searchQuery 
          OR u.first_name LIKE :searchQuery 
          OR u.last_name LIKE :searchQuery 
          OR u.middle_name LIKE :searchQuery 
          OR u.birthdate LIKE :searchQuery 
          OR u.gender LIKE :searchQuery 
          OR u.email LIKE :searchQuery
      )";
    }

    $statement = $conn->prepare($sql);
    $searchParam = '%' . $searchQuery . '%';
    $statement->bindParam(':searchQuery', $searchParam, PDO::PARAM_STR);
    if ($isForTeacher) {
      $statement->bindParam(':teacher_id', $teacher_id, PDO::PARAM_INT);
    }
    $statement->execute();

    if ($statement->execute()) {
      $response = array();
      while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $user = new stdClass();
        $user->id = $row["id"];
        $user->firstName = $row["first_name"];
        $user->lastName = $row["last_name"];
        $user->middleName = $row["middle_name"];
        $user->bday = $row["birthdate"];
        $user->gender = $row["gender"];
        $user->type = $row["type"];
        $user->email = $row["email"];
        $user->password = $row["password"];
        $response[] = $user;
      }
    }
    echo json_encode($response);
  }

  if (isset($_GET["admin_summary"])) {

    $sql = "SELECT COUNT(*) as user_count,
      SUM(CASE WHEN type = 'student' THEN 1 ELSE 0 END) AS student_count,
      SUM(CASE WHEN type = 'admin' THEN 1 ELSE 0 END) AS admin_count,
      SUM(CASE WHEN type = 'teacher' THEN 1 ELSE 0 END) AS teacher_count
      FROM user";
    $statement = $conn->prepare($sql);

    if ($statement->execute()) {
      $response = array();
      while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $admin = new stdClass();
        $admin->users_count = $row["user_count"];
        $admin->admin_count = $row["admin_count"];
        $admin->teacher_count = $row["teacher_count"];
        $admin->student_count = $row["student_count"];
        $response[] = $admin;
      }
    }

    echo json_encode($response);
  }

  if (isset($_GET["teachers"])) {
    $sql = "SELECT * FROM user WHERE type='teacher';";
    $statement = $conn->prepare($sql);
    if ($statement->execute()) {
      $response = array();
      while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $teacher = new stdClass();
        $teacher->id = $row["id"];
        $teacher->firstName = $row["first_name"];
        $teacher->lastName = $row["last_name"];
        $teacher->middleName = $row["middle_name"];
        $response[] = $teacher;
      }
      echo json_encode($response);
    }
    return;
  }
}

function isNameDuplicate($conn, $fName, $lName, $mName, $id)
{
  $sql = "SELECT * FROM user WHERE first_name = :fn AND last_name = :ln AND middle_name = :mn AND id != :id;";
  $statement = $conn->prepare($sql);
  $statement->bindParam(':fn', $fName);
  $statement->bindParam(':ln', $lName);
  $statement->bindParam(':mn', $mName);
  $statement->bindParam(':id', $id);
  $statement->execute();
  $results = $statement->fetchAll(PDO::FETCH_ASSOC);
  return $results ?? null;
}

function isEmailDuplicate($conn, $email, $id)
{
  $sql = "SELECT * FROM user WHERE email = :em AND id != :id;";
  $statement = $conn->prepare($sql);
  $statement->bindParam(':em', $email);
  $statement->bindParam(':id', $id);
  $statement->execute();
  $results = $statement->fetchAll(PDO::FETCH_ASSOC);
  return $results ?? null;
}

function isAdminExists($conn, $id)
{
  $sql = "SELECT COUNT(*) as count FROM user WHERE type = 'admin' AND id != :id;";
  $statement = $conn->prepare($sql);
  $statement->bindParam(':id', $id, PDO::PARAM_INT);
  $statement->execute();
  $result = $statement->fetch(PDO::FETCH_ASSOC);
  return $result['count'] > 0;
}