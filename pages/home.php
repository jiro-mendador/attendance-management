<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@latest/dist/tailwind.min.css" rel="stylesheet"> -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="../styles/main.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <style>
    .title {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 40;
    }

    @media screen and (min-width:640px) {
      #default-carousel>div:nth-of-type(2) {
        height: 500px;
      }
    }
  </style>
</head>

<body>
  <div class="wrapper mt-14">
    <?php include ("navbar.php") ?>
    <div class="flex flex-col items-center gap-4">
      <!-- hero -->
      <div id="default-carousel" class="relative w-full" data-carousel="slide">
        <!-- title -->
        <div class="title text-white flex flex-col gap-2 bg-black bg-opacity-50 p-4 rounded-xl font-bold shadow-xl">
          <h3 class="text-xs uppercase">Welcome to Attendance Management System</h3>
          <h1 class="md:text-4xl text-sm hidden md:block">Efficient and effective.</h1>
          <p class="text-gray-200 text-xs font-light">Let's make tracking of attendance easy.</p>
        </div>
        <!-- Carousel wrapper -->
        <div class="relative h-56 overflow-hidden rounded-none sm:h-96">
          <!-- Item 1 -->
          <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <img src="../images/school-1.jpg"
              class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
          </div>
          <!-- Item 2 -->
          <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <img src="../images/school-2.jpg"
              class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
          </div>
          <!-- Item 3 -->
          <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <img src="../images/school-3.jpg"
              class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
          </div>
        </div>
        <!-- Slider indicators -->
        <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
          <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1"
            data-carousel-slide-to="0"></button>
          <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2"
            data-carousel-slide-to="1"></button>
          <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3"
            data-carousel-slide-to="2"></button>
        </div>
        <!-- Slider controls -->
        <button type="button"
          class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
          data-carousel-prev>
          <span
            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5 1 1 5l4 4" />
            </svg>
            <span class="sr-only">Previous</span>
          </span>
        </button>
        <button type="button"
          class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
          data-carousel-next>
          <span
            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 9 4-4-4-4" />
            </svg>
            <span class="sr-only">Next</span>
          </span>
        </button>
      </div>
      <!-- cards -->
      <div class="flex flex-wrap gap-4 p-4">
        <div
          class="flex-1 min-w-64 border border-gray-200 rounded-lg shadow bg-green-400 text-white hover:text-black hover:bg-white">
          <a href="#">
            <img class="rounded-t-lg" src="../images/teacher.jpg" alt="" />
          </a>
          <div class="p-5">
            <a href="#">
              <h5 class="mb-2 text-xl font-bold tracking-tight">Streamlined for Teachers
              </h5>
            </a>
            <p class="hidden md:block mb-3 text-sm font-normal">
              Teachers can effortlessly scan students' QR
              codes using their camera web/phone, reducing time spent on roll calls and increasing classroom efficiency.
            </p>
          </div>
        </div>
        <div
          class="flex-1 min-w-64 border border-gray-200 rounded-lg shadow bg-blue-400 text-white hover:text-black hover:bg-white">
          <a href="#">
            <img class="rounded-t-lg" src="../images/attendance.jpg" alt="" />
          </a>
          <div class="p-5">
            <a href="#">
              <h5 class="mb-2 text-xl font-bold tracking-tight">Accurate Attendance Tracking
              </h5>
            </a>
            <p class="hidden md:block mb-3 text-sm font-normal">
              Ensure accurate and reliable attendance records with our QR code-based system. Say goodbye to manual
              errors and lost attendance sheets.
            </p>
          </div>
        </div>
        <div
          class="flex-1 min-w-64 border border-gray-200 rounded-lg shadow bg-red-400 text-white hover:text-black hover:bg-white">
          <a href="#">
            <img class="rounded-t-lg" src="../images/qrcode.jpg" alt="" />
          </a>
          <div class="p-5">
            <a href="#">
              <h5 class="mb-2 text-xl font-bold tracking-tight">QR Code Technology
              </h5>
            </a>
            <p class="hidden md:block mb-3 text-sm font-normal">
              Leverage the power of QR codes for a modern approach to attendance management. Each student is assigned a
              unique QR code, making the process quick and foolproof.
            </p>
          </div>
        </div>
        <div class="flex-1 min-w-64 border border-gray-200 rounded-lg shadow bg-white hover:bg-gray-100">
          <div class="p-5">
            <a href="#">
              <h5 class="mb-2 text-2xl font-bold tracking-tight text-green-400">Revolutionize Your Attendance Management
              </h5>
            </a>
            <p class="hidden md:block mb-3 text-sm font-normal">
              Attendance Management System leverages QR code technology to simplify and automate the process of tracking
              student attendance. Teachers can quickly scan QR codes, ensuring accurate and efficient attendance
              records.
            </p>
            <a href="login.php?currentPage=Login">
              <button class="p-4 bg-green-400 text-white font-bold rounded-xl text-sm my-4 animate-bounce">Login
                now</button>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- flowbite -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</body>

</html>