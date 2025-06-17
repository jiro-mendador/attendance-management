<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User</title>
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
      z-index: 50;
    }
  </style>
</head>

<body>
  <div class="wrapper px-8 text-sm">
    <?php include ("navbar.php") ?>
    <!-- * notif -->
    <div id="notif" class="hidden my-4 p-4 bg-green-100 rounded-xl">
      <p class="text-green-400 font-semibold text-base">
        HEHEHEHEHE
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
          <h3 id="table_title" class="text-xl font-semibold">User</h3>
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
              <th scope="col" class="px-6 py-3">First Name</th>
              <th scope="col" class="px-6 py-3">Last Name</th>
              <th scope="col" class="px-6 py-3">Email</th>
              <th scope="col" class="px-6 py-3">Password</th>
              <th scope="col" class="px-6 py-3">Type</th>
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
        <h3 class="text-xl font-semibold">Adding User</h3>
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
          <label for="firstName" class="font-semibold">First Name</label>
          <input type="text" name="firstName" id="firstName" class="border px-4 py-2 rounded-xl" required />
        </div>
        <div class="flex flex-col gap-4">
          <label for="lastName" class="font-semibold">Last Name</label>
          <input type="text" name="lastName" id="lastName" class="border px-4 py-2 rounded-xl" required />
        </div>
        <div class="flex flex-col gap-4">
          <label for="middleName" class="font-semibold">Middle Name</label>
          <input type="text" name="middleName" id="middleName" class="border px-4 py-2 rounded-xl" required />
        </div>
        <div class="flex flex-col gap-4">
          <label for="bday" class="font-semibold">Birthdate</label>
          <input type="date" name="bday" id="bday" class="border px-4 py-2 rounded-xl" required />
        </div>
        <select name="gender" id="gender" class="w-full border px-4 py-2 rounded-xl" required>
          <option value="">Choose Gender</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
          <option value="Other">Other</option>
        </select>
        <select name="type" id="type" class="w-full border px-4 py-2 rounded-xl" required>
          <option value="">Choose User Type</option>
          <option value="student">Student</option>
          <option value="teacher">Teacher</option>
          <option value="admin">Admin</option>
        </select>
        <div id="pickSubject" class="hidden flex-col gap-4 border p-4 rounded-xl">
          <!-- <label id="pickSubjectLabel" for="sub1" class="font-semibold">Pick Subjects</label>
          <div class="flex items-center gap-4">
            <input id="sub1" type="checkbox" name="subjectGroup">
            <label for="sub1">Subject 1</label>
          </div>
          <div class="flex items-center gap-4">
            <input id="sub2" type="checkbox" name="subjectGroup">
            <label for="sub2">Subject 2</label>
          </div> -->
        </div>
        <div class="flex flex-col gap-4">
          <label for="email" class="font-semibold">Email</label>
          <input type="email" name="email" id="email" class="border px-4 py-2 rounded-xl" required />
        </div>
        <div class="flex flex-col gap-4">
          <label for="password" class="font-semibold">Password</label>
          <input type="password" name="password" id="password" class="border px-4 py-2 rounded-xl" required />
        </div>
        <input id="submit" type="submit" name="insert" value="Save"
          class="font-semibold py-2 bg-green-400 text-white rounded-xl" />
      </form>
    </div>

  </div>

  <script>
    $(document).ready(() => {

      const CURRENT_USER_TYPE = sessionStorage.getItem("loggedInType");
      const CURRENT_USER_ID = sessionStorage.getItem("loggedInId");

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

      $("#table_title").text(
        CURRENT_USER_TYPE === "teacher"
          ? "Student" : "User"
      );

      $('#inputs>div:nth-of-type(1)>h3').text(
        CURRENT_USER_TYPE === "teacher"
          ? "Adding Student" : "Adding User"
      );

      if (CURRENT_USER_TYPE === "teacher") {
        $("#type>option:nth-of-type(3)").addClass("hidden");
        $("#type>option:nth-of-type(4)").addClass("hidden");
      }

      getAllUser();

      $(document).on('click', '.edit', function () {
        var userId = $(this).data('id');
        prevUserType = $(this).closest('tr').find('.type').text();
        if (prevUserType === "teacher") {
          $("#type>option:nth-of-type(2)").addClass("hidden");
        }
        getUser(userId);
      });

      $(document).on('click', '.delete', function () {
        var userId = $(this).data('id');
        deleteUser(userId);
      });

      $(document).on('input', '#searchInput', function () {
        search($("#searchInput").val());
      });

      $("#openInputs").click(() => {
        $('#submit').attr("name", "insert");
        $("#inputs").removeClass("hidden");
        $("#inputs").addClass("flex");
        $("#table").hide();
      })

      $("#closeInputs").click(() => {
        resetForm();
        $("#type>option:nth-of-type(2)").removeClass("hidden");
        $('#inputs>div:nth-of-type(1)>h3').text("Adding User");
        $('#submit').attr("name", "insert");
        $("#inputs").addClass("hidden");
        $("#inputs").removeClass("flex");
        $("#table").show();
      })

      $("#type").change((e) => {
        if (e.target.value === "student") {
          getAvailableSubjects();
          $("#pickSubject").removeClass("hidden");
          $("#pickSubject").addClass("flex");
        } else {
          $("#pickSubject").addClass("hidden");
          $("#pickSubject").removeClass("flex");
        }
      })

      $('#userForm').submit(function (event) {
        // Prevent form submission if validation fails
        event.preventDefault();

        if ($("#type").val() === "student" && validateSubjectSelection()) {
          $('#inputNotif').addClass(colorClassMap["red"].bg);
          $('#inputNotif').addClass(colorClassMap["red"].text);
          $('#inputNotif>p').text("Please select at least one subject");
          $('#inputNotif').fadeIn().delay(1000).fadeOut();
          return;
        }

        // Serialize the form data
        var formData = $(this).serialize();
        if ($('#submit').attr("name") === "update") {
          formData += '&id=' + $("#submit").data("id");
        }
        formData += '&' + $("#submit").attr("name");

        $.ajax({
          type: 'POST',
          url: 'user_crud.php',
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
            // $('#inputNotif').show();
            $('#inputNotif').fadeIn().delay(1000).fadeOut();

            if ($('#submit').attr("name") !== "update" && response.color === "green") {
              resetForm();
            }

            getAllUser();

            if (response.color === "green" && CURRENT_USER_ID == $("#submit").data("id") && $("#type").val() !== prevUserType) {
              alert("Current account type has changed. Please login again...");
              sessionStorage.removeItem('loggedInId');
              sessionStorage.removeItem('loggedInType');
              sessionStorage.removeItem('loggedInFirstName');
              sessionStorage.removeItem('loggedInLastName');
              sessionStorage.clear();
              window.location.href = baseUrl + "login.php?currentPage=Login";
              return;
            }

          },
          error: function (xhr, status, error) {
            console.error(xhr.responseText);
          }
        });
      });

      function getUser(id) {
        $.ajax({
          type: 'GET',
          url: 'user_crud.php?user=true&id=' + id,
          success: function (response) {
            if (response.length > 0) {
              $.each(response, function (index, user) {

                $('#inputs>div:nth-of-type(1)>h3').text("Editing User");
                $('#submit').attr("name", "update");

                $('#pickSubject').empty();
                $('#pickSubject').append('<label class="font-semibold">Subjects</label>');

                populateInputs(user);

                console.log(user);

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

      function deleteUser(id) {
        // * check if the user is deleting its own account
        if (Number(CURRENT_USER_ID) === Number(id)) {
          $('#notif').removeClass("bg-green-100");
          $('#notif>p').removeClass("text-green-400");
          $('#notif').addClass("bg-red-100");
          $('#notif>p').addClass("text-red-400");
          $('#notif>p').text("ERROR! YOU CANNOT DELETE YOUR OWN AND CURRENT LOGGED ACCOUNT!");
          $('#notif').fadeIn().delay(1300).fadeOut();
          return;
        }
        $.ajax({
          type: 'POST',
          url: 'user_crud.php',
          data: "delete=true&id=" + id,
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

            getAllUser();
          },
          error: function (xhr, status, error) {
            console.error(xhr.responseText);
          }
        });
      }

      function getAllUser() {
        let url = "user_crud.php?users=true" + (CURRENT_USER_TYPE === "teacher"
          ? "&for_teacher=true&teacher_id=" + CURRENT_USER_ID : "");
        $.ajax({
          type: 'GET',
          url: url,
          success: function (response) {
            // Clear existing table rows
            $('#table tbody').empty();

            // Check if there are users returned from the server
            if (response.length > 0) {
              // Loop through each user and append a new row to the table
              $.each(response, function (index, user) {
                var row = '<tr class="hover:bg-green-50">' +
                  '<td class="px-6 py-2">' + user.id + '</td>' +
                  '<td class="px-6 py-2">' + user.firstName + '</td>' +
                  '<td class="px-6 py-2">' + user.lastName + '</td>' +
                  '<td class="px-6 py-2">' + user.email + '</td>' +
                  '<td class="px-6 py-2">' + user.password + '</td>' +
                  '<td class="px-6 py-2 type">' + user.type + '</td>' +
                  '<td class="px-6 py-2 flex flex-wrap justify-center gap-4">' +
                  '<button class="edit underline text-blue-400" data-id=' + user.id + '">Edit</button>' +
                  '<button class="delete underline text-red-400" data-id=' + user.id + '>Delete</button>' +
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

      function getAvailableSubjects() {
        let url = "subject_crud.php?" + (CURRENT_USER_TYPE === "teacher"
          ? "teacher_subject=true&id=" + CURRENT_USER_ID : "subjects=true");
        $.ajax({
          type: 'GET',
          url: url,
          success: function (response) {
            // Clear existing content in the pickSubject div
            $('#pickSubject').empty();

            // Check if there are subjects returned from the server
            if (response.length > 0) {
              // Loop through each subject and append a new checkbox to the pickSubject div
              $.each(response, function (index, subject) {
                var subjectCheckbox = '<div class="flex items-center gap-4">' +
                  '<input id="sub' + subject.id + '" type="checkbox" name="subjectGroup[]" value="' + subject.id + '"/>' +
                  '<label for="sub' + subject.id + '">' + subject.name + '</label>' +
                  '</div>';

                if (index === 0) {
                  $('#pickSubject').append('<label class="font-semibold">Pick Available Subjects</label>');
                }
                // Append the new checkbox to the pickSubject div
                $('#pickSubject').append(subjectCheckbox);
              });
            } else {
              // If no subjects are returned, display a message in the div
              $('#pickSubject').html('<label class="text-red-400 font-semibold">No available subjects...</label>');
            }
          },
          error: function (xhr, status, error) {
            console.error(xhr.responseText);
          }
        });
      }

      function validateSubjectSelection() {
        var type = $("#type").val();
        var checkedSubjects = $('input[name="subjectGroup[]"]:checked').length;
        return type === "student" && checkedSubjects < 1;
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

        $('#pickSubject').empty();
        $("#pickSubject").addClass("hidden");
        $("#pickSubject").removeClass("flex");

      }

      function populateInputs(userData) {
        $('#firstName').val(userData.firstName);
        $('#lastName').val(userData.lastName);
        $('#middleName').val(userData.middleName);
        $('#bday').val(userData.bday);
        $('#gender').val(userData.gender);
        $('#type').val(userData.type);
        $('#email').val(userData.email);
        $('#password').val(userData.password);
        $("#submit").data("id", userData.id);

        if (userData.type === 'student') {
          $('#pickSubject').empty();
          userData.subjects.forEach(subject => {
            var isChecked = subject.active ? "checked" : "";
            var subjectCheckbox = '<div class="flex items-center gap-4">' +
              '<input id="sub' + subject.subjectId + '" type="checkbox" name="subjectGroup[]" value="' + subject.subjectId + '" ' + isChecked + '/>' +
              '<label for="sub' + subject.subjectId + '">' + subject.subjectName + '</label>' +
              '</div>';
            $('#pickSubject').append(subjectCheckbox);
          });

          $("#pickSubject").removeClass("hidden");
          $("#pickSubject").addClass("flex");
        }
      }

      function search(query) {
        let url = 'user_crud.php?search=' + query;
        if (CURRENT_USER_TYPE === "teacher") {
          url += "&for_teacher=true&teacher_id=" + CURRENT_USER_ID;
        }
        $.ajax({
          type: 'GET',
          url: url,
          success: function (response) {
            // Clear existing table rows
            $('#table tbody').empty();

            // Check if there are users returned from the server
            if (response.length > 0) {
              // Loop through each user and append a new row to the table
              $.each(response, function (index, user) {
                var row = '<tr class="hover:bg-green-50">' +
                  '<td class="px-6 py-2">' + user.id + '</td>' +
                  '<td class="px-6 py-2">' + user.firstName + '</td>' +
                  '<td class="px-6 py-2">' + user.lastName + '</td>' +
                  '<td class="px-6 py-2">' + user.email + '</td>' +
                  '<td class="px-6 py-2">' + user.password + '</td>' +
                  '<td class="px-6 py-2">' + user.type + '</td>' +
                  '<td class="px-6 py-2 flex flex-wrap justify-center gap-4">' +
                  '<button class="edit underline text-blue-400" data-id=' + user.id + '">Edit</button>' +
                  '<button class="delete underline text-red-400" data-id=' + user.id + '>Delete</button>' +
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


    });
  </script>
</body>

</html>


<!-- ! RESUME HERE ON THE LOGIC IF TEACHER IS LOGGED INSTEAD OF ADMIN -->