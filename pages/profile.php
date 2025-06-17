<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="../styles/main.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
  <div class="wrapper px-8">
    <?php include ("navbar.php") ?>
    <!-- * inputs -->
    <div id="inputs" class="shadow-xl p-8 mb-8 rounded-xl max-w-screen-md mx-auto">
      <div class="flex justify-between items-center">
        <h3 class="text-xl font-semibold mb-4">Update Your Information</h3>
      </div>

      <!-- * inputs notif -->
      <div id="inputNotif" class="hidden p-4 rounded-xl">
        <p class="text-inherit font-semibold text-base">
          No notifications so far...
        </p>
      </div>

      <form id="userForm" class="flex flex-col gap-4 overflow-y-auto p-4" method="POST">
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
        <div class="flex flex-col gap-4">
          <label for="gender" class="font-semibold">Gender</label>
          <select name="gender" id="gender" class="w-full border px-4 py-2 rounded-xl" required>
            <option value="">Choose Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
          </select>
        </div>
        <div class="flex flex-col gap-4">
          <label for="email" class="font-semibold">Email</label>
          <input type="email" name="email" id="email" class="border px-4 py-2 rounded-xl" required />
        </div>
        <div class="flex flex-col gap-4">
          <label for="password" class="font-semibold">Password</label>
          <input type="password" name="password" id="password" class="border px-4 py-2 rounded-xl" required />
        </div>
        <input id="submit" type="submit" name="profile" value="Save" data-id="32"
          class="font-semibold py-2 bg-green-400 text-white rounded-xl" />
      </form>
    </div>
  </div>


  <script>

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

    getUser(sessionStorage.getItem("loggedInId"));

    $('#userForm').submit(function (event) {
      // Prevent form submission if validation fails
      event.preventDefault();

      // Serialize the form data
      var formData = $(this).serialize();
      formData += '&id=' + $("#submit").data("id");
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
          $('#inputNotif').fadeIn().delay(1000).fadeOut();

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
              populateInputs(user);
              console.log(user);
            });
          }
        },
        error: function (xhr, status, error) {
          console.error(xhr.responseText);
        }
      });
    }

    function populateInputs(userData) {
      $('#firstName').val(userData.firstName);
      $('#lastName').val(userData.lastName);
      $('#middleName').val(userData.middleName);
      $('#bday').val(userData.bday);
      $('#gender').val(userData.gender);
      $('#email').val(userData.email);
      $('#password').val(userData.password);
      $("#submit").data("id", userData.id);
    }

  </script>
</body>

</html>