<?php
include_once ("../database/dbconfig.php");

if (isset($_GET["table"]) && isset($_GET["id"]) && isset($_GET["page"])) {

  $table = $_GET["table"];
  $id = $_GET["id"];
  $page = $_GET["page"];

  $sql = "DELETE FROM " . $table . " WHERE id = :id;";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $id);

  if ($stmt->execute()) {
    $url = $page . "&notifMessage=Data%20Deleted&notifColor=green";
  } else {
    $url = $page . "&notifMessage=Cannot%20Delete%20Data&notifColor=red";
  }
  header("Location:" . $url);
  exit();
}


?>