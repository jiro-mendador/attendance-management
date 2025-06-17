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
    <div id="notif" class="hidden my-4 p-4 bg-green-100 rounded-xl">
      <p class="text-green-400 font-semibold text-base">
        Nothing to see here yet...
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
        <form class="w-f sm:w-auto border w-full rounded-xl flex flex-nowrap items-center gap-2 px-4 py-2">
          <button type="submit" name="searchBtn" value="search">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
              class="text-gray-400 size-6">
              <path fill-rule="evenodd"
                d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z"
                clip-rule="evenodd" />
            </svg>
          </button>
          <input id="searchInput" type="text" name="searchInput" placeholder="Search" class="outline-none">
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
          </tbody>
        </table>
      </div>
    </div>

    <!-- * inputs -->
    <div id="inputs"
      class="hidden bg-white inputs w-4/5 sm:w-full flex-col gap-8 shadow-xl p-8 max-w-sm mx-auto rounded-xl">
      <div class="flex justify-between items-center">
        <h3 class="text-xl font-semibold">Adding Subject</h3>
        <svg id="closeInputs" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
          <path fill-rule="evenodd"
            d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z"
            clip-rule="evenodd" />
        </svg>
      </div>

      <!-- * inputs notif -->
      <div id="inputNotif" class="hidden p-4 rounded-xl">
        <p class="text-inherit font-semibold text-base">
          No notifications so far...
        </p>
      </div>

      <form id="userForm" class="flex flex-col gap-4 max-h-96 overflow-y-auto p-4" method="POST">
        <div class="flex flex-col gap-4">
          <label for="subjectName" class="font-semibold">Subject Name</label>
          <input type="text" name="subjectName" id="subjectName" class="border px-4 py-2 rounded-xl" required />
        </div>
        <select name="teacher" id="teacher" class="w-full border px-4 py-2 rounded-xl" required>
          <!-- <option value="">Choose Teacher</option>
          <option value="1">Teacher 1</option>
          <option value="2">Teacher 2</option>
          <option value="3">Teacher 3</option> -->
        </select>
        <input id="submit" type="submit" name="insert" value="Save"
          class="font-semibold py-2 bg-green-400 text-white rounded-xl" />
      </form>
    </div>
  </div>


  <script>
    $(document).ready(() => {

      const colorClassMap = {
        green: {
          bg: 'bg-green-100',
          text: 'text-green-400'
        },
        red: {
          bg: 'bg-red-100',
          text: 'text-red-400'
        },
      };

      getAllSubject();
      getAllTeacher();

      $(document).on('click', '.edit', function () {
        var subjectId = $(this).data('id');
        getSubject(subjectId);
      });

      $(document).on('click', '.delete', function () {
        var subjectId = $(this).data('id');
        deleteSubject(subjectId);
      });

      $(document).on('input', '#searchInput', function () {
        search($("#searchInput").val());
      });

      $("#openInputs").click(() => {
        $("#inputs").removeClass("hidden");
        $("#inputs").addClass("flex");
        $("#table").hide();
      })

      $("#closeInputs").click(() => {
        resetForm();
        $('#inputs>div:nth-of-type(1)>h3').text("Adding Subject");
        $('#inputs>submit').attr("name", "insert");
        $("#inputs").addClass("hidden");
        $("#inputs").removeClass("flex");
        $("#table").show();
      })

      $('#userForm').submit(function (event) {
        // Prevent form submission if validation fails
        event.preventDefault();

        // Serialize the form data
        var formData = $(this).serialize();
        if ($('#submit').attr("name") === "update") {
          formData += '&id=' + $("#submit").data("id");
        }
        formData += '&' + $("#submit").attr("name");

        $.ajax({
          type: 'POST',
          url: 'subject_crud.php',
          data: formData,
          success: function (response) {

            Object.keys(colorClassMap).forEach(color => {
              $('#inputNotif').removeClass(colorClassMap[color].bg);
              $('#inputNotif').removeClass(colorClassMap[color].text);
            });

            if (colorClassMap[response.color]) {
              $('#inputNotif').addClass(colorClassMap[response.color].bg);
              $('#inputNotif').addClass(colorClassMap[response.color].text);
            }

            $('#inputNotif>p').text(response.message);
            $('#inputNotif').fadeIn().delay(1000).fadeOut();

            if ($('#submit').attr("name") !== "update" && response.color === "green") {
              resetForm();
            }

            getAllSubject();

          },
          error: function (xhr, status, error) {
            console.error(xhr.responseText);
          }
        });
      });

      function getSubject(id) {
        $.ajax({
          type: 'GET',
          url: 'subject_crud.php?subject=true&id=' + id,
          success: function (response) {
            if (response.length > 0) {
              $.each(response, function (index, subject) {

                $('#inputs>div:nth-of-type(1)>h3').text("Editing Subject");
                $('#submit').attr("name", "update");

                populateInputs(subject);

                console.log(subject);

                // * open inputs
                $('#inputs').removeClass('hidden');
                $('#inputs').addClass('flex');
                $("#table").hide();

              });
            }
          },
          error: function (xhr, status, error) {
            console.error(xhr.responseText);
          }
        });
      }

      function populateInputs(subject) {
        $('#subjectName').val(subject.name);
        $('#teacher option[value="' + subject.teacher + '"]').attr("selected", "true");
        $("#submit").data("id", subject.id);
      }

      function getAllSubject() {
        $.ajax({
          type: 'GET',
          url: 'subject_crud.php?subjects=true',
          success: function (response) {
            // Clear existing table rows
            $('#table tbody').empty();

            // Check if there are users returned from the server
            if (response.length > 0) {
              // Loop through each user and append a new row to the table
              $.each(response, function (index, subject) {
                var row = '<tr class="hover:bg-green-50">' +
                  '<td class="px-6 py-2">' + subject.id + '</td>' +
                  '<td class="px-6 py-2">' + subject.name + '</td>' +
                  '<td class="px-6 py-2">' + subject.teacher_name + '</td>' +
                  '<td class="px-6 py-2 flex flex-wrap justify-center gap-4">' +
                  '<button class="edit underline text-blue-400" data-id=' + subject.id + '">Edit</button>' +
                  '<button class="delete underline text-red-400" data-id=' + subject.id + '>Delete</button>' +
                  '</td>' +
                  '</tr>';

                // Append the new row to the table body
                $('#table tbody').append(row);
              });
            } else {
              // If no users are returned, display a message in the table
              $('#table tbody').html('<tr><td colspan="7" class="p-4 w-full text-center text-gray-400">NO DATA AVAILABLE</td></tr>');
            }
          },
          error: function (xhr, status, error) {
            // Handle errors
            console.error(xhr.responseText);
          }
        });
      }

      function getAllTeacher() {
        let url = "user_crud.php?teachers=true";
        $.ajax({
          type: 'GET',
          url: url,
          success: function (response) {
            // Clear existing content in the pickSubject div
            $('#teacher').empty();

            // Check if there are subjects returned from the server
            if (response.length > 0) {
              // Loop through each subject and append a new checkbox to the pickSubject div
              $.each(response, function (index, teacher) {
                var option = `<option value="${teacher.id}">${teacher.lastName} ${teacher.firstName}</option>`;
                $('#teacher').append(option);
              });
            } else {
              // If no subjects are returned, display a message in the div
              $('#pickSubject').html('<option class="text-red-400 font-semibold">No available teacher...</option>');
            }
          },
          error: function (xhr, status, error) {
            console.error(xhr.responseText);
          }
        });
      }

      function resetForm() {
        var form = document.getElementById("userForm");

        var inputs = form.getElementsByTagName("input");
        for (var i = 0; i < inputs.length; i++) {
          if (inputs[i].value !== "Save") {
            inputs[i].value = "";
          }
        }

        var selects = form.getElementsByTagName("select");
        for (var i = 0; i < selects.length; i++) {
          selects[i].selectedIndex = 0;
        }
      }

      function search(query) {
        let url = 'subject_crud.php?search=' + query;
        $.ajax({
          type: 'GET',
          url: url,
          success: function (response) {
            // Clear existing table rows
            $('#table tbody').empty();

            // Check if there are users returned from the server
            if (response.length > 0) {
              // Loop through each user and append a new row to the table
              $.each(response, function (index, subject) {
                var row = '<tr class="hover:bg-green-50">' +
                  '<td class="px-6 py-2">' + subject.id + '</td>' +
                  '<td class="px-6 py-2">' + subject.name + '</td>' +
                  '<td class="px-6 py-2">' + subject.teacher_name + '</td>' +
                  '<td class="px-6 py-2 flex flex-wrap justify-center gap-4">' +
                  '<button class="edit underline text-blue-400" data-id=' + subject.id + '">Edit</button>' +
                  '<button class="delete underline text-red-400" data-id=' + subject.id + '>Delete</button>' +
                  '</td>' +
                  '</tr>';

                // Append the new row to the table body
                $('#table tbody').append(row);
              });
            } else {
              // If no users are returned, display a message in the table
              $('#table tbody').html('<tr><td colspan="7" class="p-4 w-full text-center text-gray-400">NO DATA AVAILABLE</td></tr>');
            }
          },
          error: function (xhr, status, error) {
            // Handle errors
            console.error(xhr.responseText);
          }
        });
      }

      function deleteSubject(id) {
        $.ajax({
          type: 'POST',
          url: 'subject_crud.php',
          data: "delete=true&subject=" + id,
          success: function (response) {
            Object.keys(colorClassMap).forEach(color => {
              $('#notif').removeClass(colorClassMap[color].bg);
              $('#notif').removeClass(colorClassMap[color].text);
            });

            if (colorClassMap[response.color]) {
              $('#notif').addClass(colorClassMap[response.color].bg);
              $('#notif').addClass(colorClassMap[response.color].text);
            }

            $('#notif>p').text(response.message);
            $('#notif').fadeIn().delay(1000).fadeOut();

            getAllSubject();
          },
          error: function (xhr, status, error) {
            console.error(xhr.responseText);
          }
        });
      }
    });
  </script>

</body>

</html>