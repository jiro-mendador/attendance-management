<?php
include_once "../database/dbconfig.php";

// List of allowed tables to prevent SQL injection
$allowed_tables = ['subject_attendance', 'user', 'student_subject', 'student_code'];

if (isset($_GET["table"]) && isset($_GET["id"]) && isset($_GET["page"])) {
  $table = $_GET["table"];
  $id = $_GET["id"];
  $page = $_GET["page"];

  // Validate table name
  if (!in_array(strtolower($table), $allowed_tables)) {
    $url = $page . "?notifMessage=Invalid%20Table%20Name&notifColor=red";
    header("Location:" . $url);
    exit();
  }

  try {
    $sql = "DELETE FROM " . $table . " WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
      $url = $page . "?notifMessage=Data%20Deleted&notifColor=green";
    } else {
      $url = $page . "?notifMessage=Cannot%20Delete%20Data&notifColor=red";
    }
  } catch (PDOException $e) {
    $url = $page . "?notifMessage=Error%20Deleting%20Data&notifColor=red";
  }

  header("Location:" . $url);
  exit();
}