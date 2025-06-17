<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <link rel="stylesheet" href="../styles/main.css">
  <style>
    .login {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <?php include("navbar.php"); ?>
    <div
      class="login w-5/6 sm:w-full max-w-lg flex flex-col gap-4 mx-auto px-8 py-16 text-sm border rounded-xl shadow-xl">
      <!-- * notif -->
      <div id="notif" class="hidden bg-green-100 text-green-400 p-4 rounded-xl">
        <p class="text-inherit font-semibold text-base">
          NOTHING TO SEE HERE...
        </p>
      </div>
      <h1 class="font-bold text-2xl">Login to your account.</h1>
      <form id="loginForm" method="POST" class="mt-4 flex flex-col gap-4 font-semibold">
        <div class="flex flex-col gap-2">
          <label for="email">Email</label>
          <input name="email" id="email" type="email" class="border rounded-xl px-4 py-2" required>
        </div>
        <div class="flex flex-col gap-2">
          <label for="password">Password</label>
          <input name="password" id="password" type="password" class="border rounded-xl px-4 py-2" required>
        </div>
        <div class="self-end flex gap-2 text-gray-400">
          <input id="showPassword" type="checkbox">
          <label for="showPassword">Show password</label>
        </div>
        <input id="login" name="login" type="submit" value="Login"
          class="bg-green-400 text-white mt-4 w-full rounded-xl px-4 p-2">
      </form>
    </div>
  </div>

  <script>

    $(document).ready(function () {

      let loggedInId = sessionStorage.getItem("loggedInId");
      if (loggedInId && loggedInId !== "" && loggedInId !== undefined) {
        window.location.href = "./overview.php";
      }

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

      $("#showPassword").change(function () {
        $("#password").prop("type", $("#password").prop("type")
          === "password" ? "text" : "password");
      })

      $("#loginForm").submit(function (e) {
        e.preventDefault();

        let formData = $(this).serialize();
        formData += "&login=true";

        $.ajax({
          type: 'POST',
          url: 'user_crud.php',
          data: formData,
          success: function (response) {
            console.log("respone : ", response);
            console.log("respone : ", response.message);

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

            if (response.message === "Login Success!") {
              sessionStorage.setItem('loggedInId', response.id);
              sessionStorage.setItem('loggedInType', response.type);
              sessionStorage.setItem('loggedInUserFirstName', response.firstName);
              sessionStorage.setItem('loggedInUserLastName', response.lastName);

              if (response.type === "teacher") {
                window.location.href = 'attendance.php?currentPage=Attendance';
              } {
                window.location.href = 'overview.php?currentPage=Overview';
              }

            }

          },
          error: function (xhr, status, error) {
            console.error(xhr.responseText);
          }
        });
      });







    });

  </script>
</body>

</html>