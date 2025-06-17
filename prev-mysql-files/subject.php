<?php
include_once ("../database/dbconfig.php");

$notifMessage = "";
$notifColor = "";

if (isset($_GET["notifMessage"]) && $_GET["notifColor"]) {
  $notifMessage = $_GET["notifMessage"];
  $notifColor = $_GET["notifColor"];
}

$editId = 0;
$editSubject = "";
$editTeacher = "";

if (isset($_GET["id"])) {
  $editId = $_GET["id"];
  $editSubject = $_GET["subject"];
  $editTeacher = $_GET["teacher"];
}

// * get all data
$results = array();
$sql = "SELECT * FROM subject";
$stmt = $conn->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);


// * get teachers
$teachers = array();
$teacherSql = "SELECT * FROM user WHERE type = 'teacher' ";
$teacherStmt = $conn->prepare($teacherSql);
$teacherStmt->execute();
$teachers = $teacherStmt->fetchAll(PDO::FETCH_ASSOC);


// * insert
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST["insert"])) {
  $subject = $_POST["subjectName"];
  $teacher = $_POST["teacher"];

  $sql = "INSERT INTO subject VALUES (default, :subject, :teacher)";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':subject', $subject);
  $stmt->bindParam(':teacher', $teacher);

  if (isSubjectNameDuplicate($conn, $subject, 0)) {
    $url = "subject.php?currentPage=Subjects&notifMessage=Cannot Add Subject Exists&notifColor=red";
    header("Location:" . $url);
    exit();
  }

  if ($stmt->execute()) {
    $url = "subject.php?currentPage=Subjects&notifMessage=New Subject Added&notifColor=green";
  } else {
    $url = "subject.php?currentPage=Subjects&notifMessage=Cannot Add Subject&notifColor=red";
  }
  header("Location:" . $url);
  exit();
}

// * update
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST["update"])) {
  $subject = $_POST["subjectName"];
  $teacher = $_POST["teacher"];

  $sql = "UPDATE subject SET subject_name = :subject, teacher_id = :teacher WHERE id = :id;";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':subject', $subject);
  $stmt->bindParam(':teacher', $teacher);
  $stmt->bindParam(':id', $editId);

  if (isSubjectNameDuplicate($conn, $subject, $editId)) {
    $url = "subject.php?currentPage=Subjects&notifMessage=Cannot Update Subject Name Exists&notifColor=red";
    header("Location:" . $url);
    exit();
  }

  if ($stmt->execute()) {
    $url = "subject.php?currentPage=Subjects&notifMessage=Subject Updated&notifColor=green";
  } else {
    $url = "subject.php?currentPage=Subjects&notifMessage=Cannot Update Subject&notifColor=red";
  }
  header("Location:" . $url);
  exit();
}

if (isset($_GET["searchInput"]) && isset($_GET["searchBtn"])) {
  $query = $_GET["searchInput"];
  $query = "%" . $query . "%";
  $sql = "SELECT * FROM subject WHERE id LIKE :id OR subject_name LIKE :sn OR teacher_id LIKE :tc;";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(":id", $query, PDO::PARAM_STR);
  $stmt->bindParam(":sn", $query, PDO::PARAM_STR);
  $stmt->bindParam(":tc", $query, PDO::PARAM_STR);
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// * catching duplicate
function isSubjectNameDuplicate($conn, $subject, $id)
{
  $sql = "SELECT * FROM subject WHERE subject_name = :sn AND id != :id;";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':sn', $subject);
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $results ?? null;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Subject</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <link rel="stylesheet" href="../styles/main.css">
  <style>
    .max-h-table {
      max-height: 720px;
      min-height: 200px;
    }

    table tr:nth-child(even) {
      background-color: #F2F4F7;
    }

    .inputs {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 40;
    }
  </style>
</head>

<body>
  <div class="wrapper px-8 text-sm">
    <?php include ("navbar.php"); ?>

    <!-- * notif -->
    <div id="notif" class="hidden my-4 p-4 bg-<?php echo $notifColor ?>-100 rounded-xl">
      <p class="text-<?php echo $notifColor ?>-400 font-semibold text-base">
        <?php echo $notifMessage ?>
      </p>
    </div>

    <!-- * table -->
    <div id="table" class="max-h-table mb-8 flex flex-col gap-8 p-8 rounded-xl shadow-lg">
      <div class="flex flex-wrap justify-between gap-4 items-center">
        <div id="openInputs" class="flex items-center gap-4">
          <div class="bg-green-400 text-white p-2 rounded-xl w-fit">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
              <path fill-rule="evenodd"
                d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z"
                clip-rule="evenodd" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold">Subject</h3>
        </div>
        <!-- * search -->
        <form action="subject.php?currentPage=Subjects" class="w-f sm:w-auto border w-full rounded-xl flex flex-nowrap items-center gap-2 px-4 py-2">
          <button type="submit" name="searchBtn" value="search">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
              class="text-gray-400 size-6">
              <path fill-rule="evenodd"
                d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z"
                clip-rule="evenodd" />
            </svg>
          </button>
          <input type="text" name="searchInput" placeholder="Search" class="outline-none">
        </form>
      </div>
      <div class="overflow-auto">
        <table class="w-full border-collapse">
          <thead>
            <tr class="bg-gray-400 text-white">
              <th scope="col" class="px-6 py-3">ID</th>
              <th scope="col" class="px-6 py-3">Subject Name</th>
              <th scope="col" class="px-6 py-3">Teacher</th>
              <th scope="col" class="px-6 py-3">Actions</th>
            </tr>
          </thead>
          <tbody class="text-center font-semibold">
            <?php
            if (count($results) <= 0) {
              echo '
            <tr>
            <td colspan="4" class="p-4 w-full text-center text-gray-400">NO DATA AVAILABLE</td>
            </tr>
            ';
            } else {
              foreach ($results as $row) {
                echo '<tr class="bg-white border-b hover:bg-green-50">
              <td class="px-6 py-2">' . $row["id"] . '</td>
              <td class="px-6 py-2">' . $row["subject_name"] . '</td>
              <td class="px-6 py-2">' . $row["teacher_id"] . '</td>
              <td class="px-6 py-2 flex flex-wrap justify-center gap-4">
                <a href="subject.php?currentPage=Subjects&id=' . $row["id"] .
                  '&subject=' . $row["subject_name"] . '&teacher=' . $row["teacher_id"] . '" class="underline text-blue-400">Edit</a>
                <a href="delete.php?currentPage=Subjects&id=' . $row["id"] .
                  '&table=subject&page=subject.php?currentPage=Subjects" class="underline text-red-400">Delete</a>
              </td>
              </tr>
              ';
              }
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- * inputs -->
    <div id="inputs"
      class="hidden bg-white inputs w-4/5 sm:w-full flex-col gap-8 shadow-xl p-8 max-w-sm mx-auto rounded-xl">
      <div class="flex justify-between items-center">
        <h3 class="text-xl font-semibold"><?php echo $editId != 0 ? "Editing" : "Adding" ?> Subject</h3>
        <a href="subject.php?currentPage=Subjects">
          <svg id="closeInputs" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
            class="size-6">
            <path fill-rule="evenodd"
              d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z"
              clip-rule="evenodd" />
          </svg>
        </a>
      </div>
      <form class="flex flex-col gap-4" method="POST">
        <div class="flex flex-col gap-4">
          <label for="subjectName" class="font-semibold">Subject Name</label>
          <input type="text" name="subjectName" id="subjectName" class="border px-4 py-2 rounded-xl"
            value="<?php echo $editSubject ?>" required />
        </div>
        <select name="teacher" id="teacher" class="w-full border px-4 py-2 rounded-xl" required>
          <option value="">Choose Teacher</option>
          <?php foreach ($teachers as $teacher): ?>
            <option value="<?php echo $teacher['id']; ?>" <?php echo $editTeacher == $teacher['id'] ? "selected" : ""; ?>>
              <?php echo htmlspecialchars($teacher['first_name']) . " " . htmlspecialchars($teacher['last_name']); ?>
            </option>
          <?php endforeach; ?>
        </select>

        <!-- <select name="teacher" id="teacher" class="w-full border px-4 py-2 rounded-xl" required>
          <option value="">Choose Teacher</option>
          <option value="1" <?php echo $editTeacher == 1 ? "selected" : "" ?>>Teacher 1</option>
          <option value="2" <?php echo $editTeacher == 2 ? "selected" : "" ?>>Teacher 2</option>
          <option value="3" <?php echo $editTeacher == 3 ? "selected" : "" ?>>Teacher 3</option>
        </select> -->
        <input type="submit" name="<?php echo $editId != 0 ? "update" : "insert" ?>" value="Save"
          class="font-semibold py-2 bg-green-400 text-white rounded-xl">
      </form>
    </div>
  </div>


  <script>
    $(document).ready(() => {

      var notifMessage = <?php echo json_encode($notifMessage); ?>;
      $('#notif').hide();
      if (notifMessage !== "") {
        $('#notif').fadeIn().delay(1000).fadeOut();
      }

      var editId = <?php echo json_encode($editId); ?>;
      if (editId != 0) {
        $("#inputs").removeClass("hidden");
        $("#inputs").addClass("flex");
        $("#table").hide();
      }

      $("#openInputs").click(() => {
        $("#inputs").removeClass("hidden");
        $("#inputs").addClass("flex");
        $("#table").hide();
      });

    });
  </script>

</body>

</html>