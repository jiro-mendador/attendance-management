<?php
$currentPage = "Home";
if (isset($_GET["currentPage"])) {
  $currentPage = $_GET["currentPage"];
}
?>

<link rel="stylesheet" href="../styles/navbar.css">

<header class="flex items-center justify-between gap-4 p-4 text-base font-semibold rounded-none">
  <a href="home.php?currentPage=Home">
    <div class="flex items-center gap-4 text-green-400">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
        class="w-10 h-10">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
      </svg>
      <span class="text-black">Attendance Management</span>
    </div>
  </a>
  <button class="block lg:hidden relative">
    <svg id="menu" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
      stroke="currentColor" class="w-6 h-6 self-end">
      <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5" />
    </svg>
  </button>
  <nav id="nav" class="hidden lg:flex flex-wrap justify-center gap-4 text-sm">
    <a id="homeNav" href="home.php?currentPage=Home" class="p-2 <?php echo $currentPage === "Home"
      ? "active" : "" ?>">Home</a>
    <a id="overviewNav" href="overview.php?currentPage=Overview" class="p-2 <?php echo $currentPage === "Overview"
      ? "active" : "" ?>">Overview</a>
    <a id="attendanceNav" href="attendance.php?currentPage=Attendance" class="p-2 <?php echo $currentPage === "Attendance"
      ? "active" : "" ?>">Attendance</a>
    <a id="userNav" href="user.php?currentPage=Users" class="p-2 <?php echo $currentPage === "Users"
      ? "active" : "" ?>">User</a>
    <a id="subjectNav" href="subject.php?currentPage=Subjects" class="p-2 <?php echo $currentPage === "Subjects"
      ? "active" : "" ?>">Subject</a>
    <a id="profileNav" href="profile.php?currentPage=Profile" class="p-2 <?php echo $currentPage === "Profile"
      ? "active" : "" ?>">Profile</a>
    <a id="loginNav" href="login.php?currentPage=Login" class="p-2 <?php echo $currentPage === "Login"
      ? "active" : "" ?>">Login</a>
    <a id="logoutNav" href="#" class="p-2">Logout</a>
  </nav>
</header>

<script>

  var currentUrl = window.location.href;
  var parts = currentUrl.split('/');
  var url = parts.pop();
  var baseUrl = parts.join('/') + '/';

  if (sessionStorage.getItem("loggedInId") === null || sessionStorage.getItem("loggedInId") === undefined) {
    if (url !== "login.php?currentPage=Login" && url !== "home.php?currentPage=Home") {
      // Redirect to the login page if the current URL is neither the login nor the home page
      var redirectUrl = "login.php?currentPage=Login";
      // alert("last part : " + redirectUrl);
      // alert("redirect : " + baseUrl + redirectUrl);
      window.location.href = baseUrl + redirectUrl;
    }
  } else {
    // User is already logged in
    var currentUrl = window.location.href;
    var parts = currentUrl.split('/');
    var url = parts.pop();
    var baseUrl = parts.join('/') + '/';

    if (url === "login.php?currentPage=Login") {
      var homePageUrl = "home.php?currentPage=Home";
      // alert("redirect: " + baseUrl + homePageUrl);
      window.location.href = baseUrl + homePageUrl;
    }
  }

  // Hide all navigation links by default
  $("#overviewNav, #attendanceNav, #userNav, #subjectNav, #profileNav, #logoutNav").addClass("hidden");

  // Check if the user is logged in
  if (sessionStorage.getItem("loggedInId") !== null && sessionStorage.getItem("loggedInId") !== undefined) {
    $("#loginNav").addClass("hidden");
    $("#logoutNav, #overviewNav, #profileNav").removeClass("hidden");

    var loggedInType = sessionStorage.getItem("loggedInType");
    if (loggedInType === "teacher") {
      $("#attendanceNav").removeClass("hidden");
      $("#userNav").removeClass("hidden");
    } else if (loggedInType === "admin") {
      $("#attendanceNav, #userNav, #subjectNav").removeClass("hidden");
    } else {
      $("#overviewNav").removeClass("hidden");
    }
  }

  // * changing the text "User" to "Student" when teacher logs
  $("#userNav").text(sessionStorage.getItem("loggedInType") === "teacher"
    ? "Student" : "User");

  let menuOpen = false;
  let menu = document.querySelector("#menu");
  let nav = document.querySelector("#nav");
  menu.addEventListener("click", function () {
    menuOpen = !menuOpen;
    this.querySelector('path').setAttribute('d',
      menuOpen ? 'M6 18 18 6M6 6l12 12' : 'M3.75 9h16.5m-16.5 6.75h16.5');
    nav.className = menuOpen ?
      "flex flex-col gap-4 text-xs absolute top-20 right-4 bg-white border rounded-xl p-4 text-center"
      : "hidden lg:flex flex-wrap justify-center gap-4 text-sm";
  });

  window.onresize = checkWindowSize;
  function checkWindowSize() {
    if (window.innerWidth >= 768 && menuOpen) {
      menu.querySelector('path').setAttribute('d', 'M3.75 9h16.5m-16.5 6.75h16.5');
      nav.className = "hidden lg:flex flex-wrap justify-center gap-4 text-sm";
      menuOpen = false;
    }
  }


  // * when logging out
  $("#logoutNav").click(function () {
    sessionStorage.removeItem('loggedInId');
    sessionStorage.removeItem('loggedInType');
    sessionStorage.removeItem('loggedInFirstName');
    sessionStorage.removeItem('loggedInLastName');
    sessionStorage.clear();
    window.location.href = baseUrl + "home.php?currentPage=Home";
  });

</script>