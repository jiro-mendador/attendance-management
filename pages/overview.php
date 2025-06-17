<?php

// $userLevel = "teacher";
$userLevel = "student";
// $userLevel = "admin";

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Overview</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> -->
  <link rel="stylesheet" href="../styles/main.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
  <div class="wrapper text-sm">
    <?php include("navbar.php"); ?>
    <div class="flex flex-wrap justify-between items-center gap-y-8 gap-x-4 px-8 py-4">
      <div class="flex flex-col gap-2">
        <span class="text-lg font-semibold">Hello <span id="current_username">Username</span>!</span>
        <span class="text-xs text-gray-400">We hope you're having a great day.</span>
      </div>
      <!-- teacher -->
      <div id="teacher_summary" class="hidden flex-wrap gap-4">
        <select name="teacher_subject" id="teacher_subject"
          class="w-full sm:w-auto border text-base font-semibold p-4 rounded-xl border-gray-400 bg-gray-100">
          <!-- <option value="">Class A</option>
          <option value="">Class B</option> -->
        </select>
        <div class="w-full sm:w-auto flex gap-4 items-center border p-4 rounded-xl text-sm bg-blue-400 text-white">
          <div class="p-2 bg-gray-50 rounded-xl text-blue-400">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
            </svg>
          </div>
          <div class="flex flex-col">
            <span id="total_students" class="text-base font-semibold">42</span>
            <span>Total Students</span>
          </div>
        </div>
        <div class="w-full sm:w-auto flex gap-4 items-center border p-4 rounded-xl text-sm bg-green-400 text-white">
          <div class="p-2 bg-white rounded-xl text-green-400">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M15.182 15.182a4.5 4.5 0 0 1-6.364 0M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z" />
            </svg>
          </div>
          <div class="flex flex-col">
            <span id="present_today" class="text-base font-semibold">36</span>
            <span>Present Today</span>
          </div>
        </div>
        <div class="w-full sm:w-auto flex gap-4 items-center border p-4 rounded-xl text-sm bg-red-400 text-white">
          <div class="p-2 bg-gray-50 rounded-xl text-red-400">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M15.182 16.318A4.486 4.486 0 0 0 12.016 15a4.486 4.486 0 0 0-3.198 1.318M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z" />
            </svg>
          </div>
          <div class="flex flex-col">
            <span id="absent_today" class="text-base font-semibold">6</span>
            <span>Absent Today</span>
          </div>
        </div>
      </div>
      <!-- student -->
      <div id="student_summary" class="hidden flex-wrap gap-4 items-center">
        <div class="flex flex-wrap justify-between gap-4 items-center text-white">
          <select name="student_subject" id="student_subject"
            class="p-4 font-semibold text-black border rounded-xl w-full sm:w-auto border-gray-400 bg-gray-100">
          </select>
          <div class="flex flex-wrap justify-center md:justify-start gap-4 text-xs font-semibold">
            <div class="flex flex-wrap gap-4 items-center border p-4 rounded-xl w-full sm:w-auto bg-blue-400">
              <span class="bg-blue-600 p-1 rounded-full"></span>
              <span>Total Attendance</span>
              <span id="totalAttendance" class="text-base">36</span>
            </div>
            <div class="flex flex-wrap gap-4 items-center border p-4 rounded-xl w-full sm:w-auto bg-green-400">
              <span class="bg-green-600 p-1 rounded-full"></span>
              <span>Attended</span>
              <span id="attended" class="text-base">31</span>
            </div>
            <div class="flex flex-wrap gap-4 items-center border p-4 rounded-xl w-full sm:w-auto bg-red-400">
              <span class="bg-red-600 p-1 rounded-full"></span>
              <span>Absences</span>
              <span id="absences" class="text-base">5</span>
            </div>
          </div>
        </div>
      </div>
      <!-- admin -->
      <div id="admin_summary" class="w-full hidden gap-4">
        <div class="w-full bg-white rounded-lg shadow p-4 md:p-6">
          <!-- title -->
          <div class="flex justify-between mb-3">
            <div class="flex items-center">
              <div class="flex justify-center items-center">
                <h5 class="text-xl font-bold leading-none text-gray-900 pe-1">Users</h5>
                <span id="users_count" class="text-xl font-bold mx-2">0</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                  <path fill-rule="evenodd"
                    d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z"
                    clip-rule="evenodd" />
                  <path
                    d="M5.082 14.254a8.287 8.287 0 0 0-1.308 5.135 9.687 9.687 0 0 1-1.764-.44l-.115-.04a.563.563 0 0 1-.373-.487l-.01-.121a3.75 3.75 0 0 1 3.57-4.047ZM20.226 19.389a8.287 8.287 0 0 0-1.308-5.135 3.75 3.75 0 0 1 3.57 4.047l-.01.121a.563.563 0 0 1-.373.486l-.115.04c-.567.2-1.156.349-1.764.441Z" />
                </svg>
              </div>
            </div>
          </div>
          <!-- card -->
          <div class="  p-3 rounded-lg">
            <div class="grid grid-cols-3 gap-3 mb-2">
              <dl class="bg-orange-400 rounded-lg flex flex-col items-center justify-center h-[78px]">
                <dt id="admin_count"
                  class="w-8 h-8 rounded-full bg-white text-orange-600 text-sm font-medium flex items-center justify-center mb-1">
                  0</dt>
                <dd class="text-white text-sm font-medium">Admins</dd>
              </dl>
              <dl class="bg-green-400 rounded-lg flex flex-col items-center justify-center h-[78px]">
                <dt id="teacher_count"
                  class="w-8 h-8 rounded-full bg-white text-green-600 text-sm font-medium flex items-center justify-center mb-1">
                  0</dt>
                <dd class="text-white text-sm font-medium">Teachers</dd>
              </dl>
              <dl class="bg-violet-400 rounded-lg flex flex-col items-center justify-center h-[78px]">
                <dt id="student_count"
                  class="w-8 h-8 rounded-full bg-white text-violet-600 text-sm font-medium flex items-center justify-center mb-1">
                  0</dt>
                <dd class="text-white text-sm font-medium">Students</dd>
              </dl>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- * show also the overview of teacher on admin -->
    <!-- admin -->
    <div id="admin_teacher_overview" class="p-8 hidden justify-center">
      <div class="flex flex-wrap gap-4">
        <select name="admin_subject" id="admin_subject"
          class="w-full sm:w-auto border text-base font-semibold p-4 rounded-xl border-gray-400 bg-gray-100">
        </select>
        <div class="w-full sm:w-auto flex gap-4 items-center border p-4 rounded-xl text-sm bg-blue-400 text-white">
          <div class="p-2 bg-gray-50 rounded-xl text-blue-400">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
            </svg>
          </div>
          <div class="flex flex-col">
            <span id="admin_total_students" class="text-base font-semibold">42</span>
            <span>Total Students</span>
          </div>
        </div>
        <div class="w-full sm:w-auto flex gap-4 items-center border p-4 rounded-xl text-sm bg-green-400 text-white">
          <div class="p-2 bg-white rounded-xl text-green-400">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M15.182 15.182a4.5 4.5 0 0 1-6.364 0M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z" />
            </svg>
          </div>
          <div class="flex flex-col">
            <span id="admin_present_today" class="text-base font-semibold">36</span>
            <span>Present Today</span>
          </div>
        </div>
        <div class="w-full sm:w-auto flex gap-4 items-center border p-4 rounded-xl text-sm bg-red-400 text-white">
          <div class="p-2 bg-gray-50 rounded-xl text-red-400">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M15.182 16.318A4.486 4.486 0 0 0 12.016 15a4.486 4.486 0 0 0-3.198 1.318M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z" />
            </svg>
          </div>
          <div class="flex flex-col">
            <span id="admin_absent_today" class="text-base font-semibold">6</span>
            <span>Absent Today</span>
          </div>
        </div>
      </div>
    </div>

    <!-- * show graph for teachers and show calendar for students -->
    <!-- admin and teacher -->
    <div id="admin_teacher_graph" class="px-8 py-4 hidden flex-col gap-4">
      <div class="relative flex flex-col rounded-xl bg-white bg-clip-border text-gray-700 shadow-md">
        <div
          class="relative mx-4 mt-4 flex flex-col gap-4 overflow-hidden rounded-none bg-transparent bg-clip-border text-gray-700 shadow-none md:flex-row md:items-center">
          <div class="w-max rounded-lg bg-blue-400 p-5 text-white">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" aria-hidden="true" class="h-6 w-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M6.429 9.75L2.25 12l4.179 2.25m0-4.5l5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0l4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0l-5.571 3-5.571-3">
              </path>
            </svg>
          </div>
          <div>
            <h6
              class="block font-sans text-base font-semibold leading-relaxed tracking-normal text-blue-gray-900 antialiased">
              Attendance
            </h6>
            <p class="block max-w-sm font-sans text-sm font-normal leading-normal text-gray-700 antialiased">
              This chart shows the percentage of attendance throughout the year
            </p>
          </div>
        </div>
        <div class="pt-6 px-2 pb-0">
          <div id="bar-chart"></div>
        </div>
      </div>
      <div class="relative flex flex-col rounded-xl bg-white bg-clip-border text-gray-700 shadow-md">
        <div
          class="relative mx-4 mt-4 flex flex-col gap-4 overflow-hidden rounded-none bg-transparent bg-clip-border text-gray-700 shadow-none md:flex-row md:items-center">
          <div class="w-max rounded-lg bg-green-400 p-5 text-white">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" aria-hidden="true" class="h-6 w-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M6.429 9.75L2.25 12l4.179 2.25m0-4.5l5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0l4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0l-5.571 3-5.571-3">
              </path>
            </svg>
          </div>
          <div>
            <h6
              class="block font-sans text-base font-semibold leading-relaxed tracking-normal text-blue-gray-900 antialiased">
              Present and Absent Comparison
            </h6>
            <p class="block max-w-sm font-sans text-sm font-normal leading-normal text-gray-700 antialiased">
              This chart shows the comparison of the number of absent and present students
            </p>
          </div>
        </div>
        <div class="pt-6 px-2 pb-0">
          <div id="line-chart"></div>
        </div>
      </div>
    </div>
    <!-- student -->
    <div id="student_calendar" class="px-8 py-4 hidden flex-col gap-4">
      <div class="flex flex-wrap justify-between items-center px-2">
        <div class="flex flex-wrap gap-4">
          <div>
            <p id="monthName" class="text-2xl font-semibold">May</p>
            <p id="year" class="text-gray-400 text-base">2024</p>
          </div>
          <button id="print_monthly_sub_attendance">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="size-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
            </svg>
          </button>
        </div>
        <div class="flex gap-4">
          <button id="prevMonth">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
          </button>
          <button id="nextMonth">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
          </button>
        </div>
      </div>
      <div class="rounded-xl p-4 overflow-x-auto shadow-xl">
        <table id="calendarTable" class="w-full text-sm rtl:text-right text-center border-separate">
          <thead class="text-xs bg-white">
            <tr class="text-center">
              <th scope="col" class="px-6 py-3">
                Sun
              </th>
              <th scope="col" class="px-6 py-3">
                Mon
              </th>
              <th scope="col" class="px-6 py-3">
                Tue
              </th>
              <th scope="col" class="px-6 py-3">
                Wed
              </th>
              <th scope="col" class="px-6 py-3">
                Thu
              </th>
              <th scope="col" class="px-6 py-3">
                Fri
              </th>
              <th scope="col" class="px-6 py-3">
                Sat
              </th>
            </tr>
          </thead>
          <tbody class="font-semibold text-xs">
            <!-- <tr>
              <td class="px-6 py-4"></td>
              <td class="px-6 py-4"></td>
              <td class="px-6 py-4"></td>
              <td class="px-6 py-4 bg-red-300 text-white">1</td>
              <td class="px-6 py-4 bg-red-300 text-white">2</td>
              <td class="px-6 py-4 bg-green-300 text-white">3</td>
              <td class="px-6 py-4 bg-gray-300 text-white">4</td>
            </tr>
            <tr>
              <td class="px-6 py-4 bg-green-300 text-white">5</td>
              <td class="px-6 py-4 bg-green-300 text-white">6</td>
              <td class="px-6 py-4 bg-green-300 text-white">7</td>
              <td class="px-6 py-4 bg-green-300 text-white">8</td>
              <td class="px-6 py-4 bg-green-300 text-white">9</td>
              <td class="px-6 py-4 bg-green-300 text-white">10</td>
              <td class="px-6 py-4 bg-green-300 text-white">11</td>
            </tr>
            <tr>
              <td class="px-6 py-4 bg-red-300 text-white">12</td>
              <td class="px-6 py-4 bg-red-300 text-white">13</td>
              <td class="px-6 py-4 bg-red-300 text-white">14</td>
              <td class="px-6 py-4 bg-red-300 text-white">15</td>
              <td class="px-6 py-4 bg-red-300 text-white">16</td>
              <td class="px-6 py-4 bg-green-300 text-white">17</td>
              <td class="px-6 py-4 bg-gray-300 text-white">18</td>
            </tr>
            <tr>
              <td class="px-6 py-4 bg-gray-300 text-white">19</td>
              <td class="px-6 py-4 bg-gray-300 text-white">20</td>
              <td class="px-6 py-4 bg-gray-300 text-white">21</td>
              <td class="px-6 py-4 bg-green-300 text-white">22</td>
              <td class="px-6 py-4 bg-green-300 text-white">23</td>
              <td class="px-6 py-4 bg-green-300 text-white">24</td>
              <td class="px-6 py-4 bg-green-300 text-white">25</td>
            </tr>
            <tr>
              <td class="px-6 py-4">26</td>
              <td class="px-6 py-4">27</td>
              <td class="px-6 py-4">28</td>
              <td class="px-6 py-4">29</td>
              <td class="px-6 py-4">30</td>
              <td class="px-6 py-4">31</td>
              <td class="px-6 py-4"></td>
            </tr> -->
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script>

    $(document).ready(function () {
      let userType = sessionStorage.getItem("loggedInType");
      if (!userType && userType === "" || userType === undefined) {
        window.location.href = "./login.php";
      }

      $("#current_username").text(sessionStorage.getItem("loggedInUserLastName"));

      $("#" + userType + "_summary").removeClass("hidden");
      $("#" + userType + "_summary").addClass("flex");

      if (userType === "admin") {
        $("#admin_teacher_overview").removeClass("hidden");
        $("#admin_teacher_overview").addClass("flex");
      }

      if (userType !== "student") {
        $("#admin_teacher_graph").removeClass("hidden");
        $("#admin_teacher_graph").addClass("flex");
      }

      if (userType === "student") {
        $("#" + userType + "_calendar").removeClass("hidden");
        $("#" + userType + "_calendar").addClass("flex");
      }

      if (userType !== "student") {

        if (userType === "admin") {
          $.ajax({
            url: "user_crud.php?admin_summary=true",
            method: 'GET',
            dataType: 'json',
            success: function (data) {
              $("#users_count").text(data[0].users_count);
              $("#admin_count").text(data[0].admin_count);
              $("#student_count").text(data[0].student_count);
              $("#teacher_count").text(data[0].teacher_count);
            },
            error: function (xhr, status, error) {
              console.error(xhr.responseText);
            }
          });
        }

        // * for teacher and admin
        let attendancePercentageData = [];
        let absentData = [];
        let presentData = [];
        let barChartConfig = null;
        let lineChartConfig = null;
        let barChart = null;
        let lineChart = null;

        function resetAndRunGraph() {
          if (barChart) {
            barChart.destroy(); // Removes the chart canvas and any associated event listeners
          }

          if (lineChart) {
            lineChart.destroy(); // Removes the chart canvas and any associated event listeners
          }
          barChartConfig = null;
          lineChartConfig = null;
          barChart = null;
          lineChart = null;

          barChartConfig = {
            series: [
              {
                name: "Attendance Percentage",
                data: attendancePercentageData,
              },
            ],
            chart: {
              type: "bar",
              height: 240,
              toolbar: {
                show: false,
              },
            },
            title: {
              show: "",
            },
            dataLabels: {
              enabled: false,
            },
            colors: ["#60A5FA"],
            plotOptions: {
              bar: {
                columnWidth: "40%",
                borderRadius: 2,
              },
            },
            xaxis: {
              axisTicks: {
                show: false,
              },
              axisBorder: {
                show: false,
              },
              labels: {
                style: {
                  colors: "#616161",
                  fontSize: "12px",
                  fontFamily: "inherit",
                  fontWeight: 400,
                },
              },
              categories: [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec",
              ],
            },
            yaxis: {
              labels: {
                style: {
                  colors: "#616161",
                  fontSize: "12px",
                  fontFamily: "inherit",
                  fontWeight: 400,
                },
              },
            },
            grid: {
              show: true,
              borderColor: "#dddddd",
              strokeDashArray: 5,
              xaxis: {
                lines: {
                  show: true,
                },
              },
              padding: {
                top: 5,
                right: 20,
              },
            },
            fill: {
              opacity: 0.8,
            },
            tooltip: {
              theme: "dark",
            },
          };

          barChart = new ApexCharts(document.querySelector("#bar-chart"), barChartConfig);

          lineChartConfig = {
            series: [
              {
                name: "Present",
                data: presentData,
              },
              {
                name: "Absent",
                data: absentData,
              },
            ],
            chart: {
              type: "line",
              height: 240,
              toolbar: {
                show: false,
              },
            },
            title: {
              show: "",
            },
            dataLabels: {
              enabled: false,
            },
            colors: ["#34D399", "#F87171"],
            stroke: {
              lineCap: "round",
              curve: "smooth",
            },
            markers: {
              size: 0,
            },
            xaxis: {
              axisTicks: {
                show: false,
              },
              axisBorder: {
                show: false,
              },
              labels: {
                style: {
                  colors: "#616161",
                  fontSize: "12px",
                  fontFamily: "inherit",
                  fontWeight: 400,
                },
              },
              categories: [
                "Jan",
                "Fev",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec",
              ],
            },
            yaxis: {
              labels: {
                style: {
                  colors: "#616161",
                  fontSize: "12px",
                  fontFamily: "inherit",
                  fontWeight: 400,
                },
              },
            },
            grid: {
              show: true,
              borderColor: "#dddddd",
              strokeDashArray: 5,
              xaxis: {
                lines: {
                  show: true,
                },
              },
              padding: {
                top: 5,
                right: 20,
              },
            },
            fill: {
              opacity: 0.8,
            },
            tooltip: {
              theme: "dark",
            },
          };

          lineChart = new ApexCharts(document.querySelector("#line-chart"), lineChartConfig);

          barChart.render();
          lineChart.render();
        }

        // * getting summary for teacher
        // if (userType === "teacher") {

        $("#teacher_subject").change(function () {
          getTeacherSummary(0, $("#teacher_subject>option:selected").val());
          getTeacherGraph($("#teacher_subject>option:selected").val());
        });

        $("#admin_subject").change(function () {
          getTeacherSummary(0, $("#admin_subject>option:selected").val());
          getTeacherGraph($("#admin_subject>option:selected").val());
        });

        // * getting teacher subjects
        getSubjects(sessionStorage.getItem("loggedInId"));

        function getTeacherGraph(subject) {
          console.log("URL FOR TEACHER GRAPH", 'attendance_crud.php?teacher_graph=true&subject=' + subject + "&year=" + new Date().getFullYear());

          $.ajax({
            url: 'attendance_crud.php?teacher_graph=true&subject=' + subject + "&year=" + new Date().getFullYear(),
            method: 'GET',
            dataType: 'json',
            success: function (data) {
              console.log(data);
              attendancePercentageData.length = 0;
              absentData.length = 0;
              presentData.length = 0;
              $.each(data, function (index, item) {
                attendancePercentageData.push(item.attendance_percentage);
                presentData.push(item.present_count);
                absentData.push(item.absent_count);
              });
              resetAndRunGraph();
            },
            error: function (xhr, status, error) {
              console.error(xhr.responseText);
            }
          });
        }

        function getTeacherSummary(id, subject) {
          let url = `attendance_crud.php?teacher_summary=true&id=${id}&subject=${subject}`;
          $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
              console.log(data);

              $(sessionStorage.getItem("loggedInType") === "admin"
                ? "#admin_total_students"
                : "#total_students").text(data.total);
              $(sessionStorage.getItem("loggedInType") === "admin"
                ? "#admin_present_today"
                : "#present_today").text(!data.present ? "0" : data.present);
              $(sessionStorage.getItem("loggedInType") === "admin"
                ? "#admin_absent_today"
                : "#absent_today").text(!data.absent ? "0" : data.absent);

            },
            error: function (xhr, status, error) {
              console.error(xhr.responseText);
            }
          });
        }

        // * entry function
        function getSubjects(id) {
          let url = 'subject_crud.php?teacher_subject=true&id=' + id;
          if (sessionStorage.getItem("loggedInType") === "admin") {
            url += "&isAdmin=true";
          }
          $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
              console.log(data);

              var select = sessionStorage.getItem("loggedInType") === "admin" ?
                $('#admin_subject') : $('#teacher_subject');

              select.empty();
              $.each(data, function (index, item) {
                select.append($('<option>', {
                  value: item.id,
                  text: item.name
                }));

              });
              // Select the first option outside of the $.each loop
              select.find('option:first').prop('selected', true);

              // * teacher summary
              getTeacherSummary(0,
                sessionStorage.getItem("loggedInType") === "admin"
                  ? $("#admin_subject>option:selected").val()
                  : $("#teacher_subject>option:selected").val()
              );

              // * teacher graph
              getTeacherGraph(
                sessionStorage.getItem("loggedInType") === "admin"
                  ? $("#admin_subject>option:selected").val()
                  : $("#teacher_subject>option:selected").val());
            },
            error: function (xhr, status, error) {
              console.error(xhr.responseText);
            }
          });
        }

        // }
      }

      // * getting the summary of student
      if (userType === "student") {

        $("#student_subject").change(function () {
          curMon = currentMonth + 1;
          curMon = curMon < 10 ? "0" + curMon : curMon;
          getAttendance(
            sessionStorage.getItem("loggedInId"),
            `${currentYear}-${curMon}-01`,
            `${currentYear}-${curMon}-${lastDayOfMonth}`,
            $(this).val()
          );
          getStudentSummary(
            sessionStorage.getItem("loggedInId"),
            $("#student_subject>option:selected").val()
          );
        });

        // * retrieving of subjects
        getSubjects(sessionStorage.getItem("loggedInId"));

        // * dynamic calendar
        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        let currentMonth = new Date().getMonth(); // May (0-indexed)
        let currentYear = new Date().getFullYear();
        let lastDayOfMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

        function updateCalendar() {
          const monthName = monthNames[currentMonth];
          $('#monthName').text(monthName);
          $('#year').text(currentYear);
          generateCalendar(currentMonth, currentYear);
        }

        function generateCalendar(month, year) {
          const firstDay = new Date(year, month, 1).getDay();
          const daysInMonth = new Date(year, month + 1, 0).getDate();
          let tableBody = '';
          let date = 1;

          for (let i = 0; i < 6; i++) { // Create 6 rows for the weeks
            let row = '<tr>';
            for (let j = 0; j < 7; j++) { // Create 7 columns for the days
              if (i === 0 && j < firstDay) {
                row += '<td class="px-6 py-4"></td>';
              } else if (date > daysInMonth) {
                row += '<td class="px-6 py-4"></td>';
              } else {
                row += `<td id='${date}' class="px-6 py-4">${date}</td>`;
                date++;
              }
            }
            row += '</tr>';
            tableBody += row;
          }

          $('#calendarTable tbody').html(tableBody);
        }

        $('#nextMonth').click(function () {
          if (currentMonth === 11) {
            currentMonth = 0;
            currentYear++;
          } else {
            currentMonth++;
          }
          updateCalendar();
          curMon = currentMonth + 1;
          curMon = curMon < 10 ? "0" + curMon : curMon;
          getAttendance(
            sessionStorage.getItem("loggedInId"),
            `${currentYear}-${curMon}-01`,
            `${currentYear}-${curMon}-${lastDayOfMonth}`,
            $("#student_subject>option:selected").val()
          );

        });

        $('#prevMonth').click(function () {
          if (currentMonth === 0) {
            currentMonth = 11;
            currentYear--;
          } else {
            currentMonth--;
          }
          updateCalendar();
          curMon = currentMonth + 1;
          curMon = curMon < 10 ? "0" + curMon : curMon;
          getAttendance(
            sessionStorage.getItem("loggedInId"),
            `${currentYear}-${curMon}-01`,
            `${currentYear}-${curMon}-${lastDayOfMonth}`,
            $("#student_subject>option:selected").val()
          );
        });

        updateCalendar(); // Initial calendar load

        // * printing attendance into csv
        $("#print_monthly_sub_attendance").click(function () {
          let subject = $("#student_subject>option:selected").val();
          let id = sessionStorage.getItem("loggedInId");
          let curMon = currentMonth + 1;
          curMon = curMon < 10 ? "0" + curMon : curMon;
          let firstDate = `${currentYear}-${curMon}-01`
          let lastDate = `${currentYear}-${curMon}-${lastDayOfMonth}`;
          $.ajax({
            url: "attendance_crud.php?student_attendance=true&for_printing=true&id=" + id
              + "&subject=" + subject + "&firstDate=" + firstDate + "&lastDate=" + lastDate,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
              console.log(data);
              const csvdata = csvmaker(
                data,
                `${$("#monthName").text()} ${$("#year").text()}`,
                $("#student_subject>option:selected").text()
              );
              let filename =
                `${sessionStorage.getItem("loggedInUserLastName")}_${$("#monthName").text()}_${$("#year").text()}_${$("#student_subject>option:selected").text()}`;
              download(csvdata, filename);
            },
            error: function (xhr, status, error) {
              // Handle errors
              console.error(xhr.responseText);
            }
          });
        })

        function getSubjects(id) {
          $.ajax({
            url: 'subject_crud.php?student_subject=true&id=' + id,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
              var select = $('#student_subject');
              select.empty();
              $.each(data, function (index, item) {
                select.append($('<option>', {
                  value: item.id,
                  text: item.name
                }));
              });

              // Select the first option outside of the $.each loop
              select.find('option:first').prop('selected', true);

              // * retrieve the attendance here after the id is set
              curMon = currentMonth + 1;
              curMon = curMon < 10 ? "0" + curMon : curMon;
              getAttendance(
                sessionStorage.getItem("loggedInId"),
                `${currentYear}-${curMon}-01`,
                `${currentYear}-${curMon}-${lastDayOfMonth}`,
                $("#student_subject>option:selected").val()
              );

              // * student summary
              getStudentSummary(
                sessionStorage.getItem("loggedInId"),
                $("#student_subject>option:selected").val()
              );

            },
            error: function (xhr, status, error) {
              console.error(error);
              console.error(xhr.responseText);
            }
          });
        }

        function getAttendance(id, firstDate, lastDate, subject) {

          $("table tr > td").removeClass("bg-green-300").removeClass("text-white");
          $("table tr > td").removeClass("bg-red-300").removeClass("text-white");

          $.ajax({
            url: "attendance_crud.php?student_attendance=true&id=" + id
              + "&subject=" + subject + "&firstDate=" + firstDate + "&lastDate=" + lastDate,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
              $.each(data, function (index, item) {
                console.log(item);
                console.log(item.status === "Present");

                // let dateId = item.date.split("-")[2] < 10
                //   ? item.date.split("-")[2][1] : item.date.split("-")[2];

                let dateId = item.date.split(" ")[0].split("-")[2];
                // $("#" + dateId).addClass("bg-green-300 text-white");

                console.log(dateId);

                $("#" + dateId).addClass(
                  item.status === "Present" ? "bg-green-300 text-white" : "bg-red-300 text-white"
                );
              });

            },
            error: function (xhr, status, error) {
              // Handle errors
              console.error(xhr.responseText);
            }
          });
        }

        function getStudentSummary(id, subject) {
          console.log("URL : ", `attendance_crud.php?student_summary=true&id=${id}&subject=${subject}`);
          $.ajax({
            url: `attendance_crud.php?student_summary=true&id=${id}&subject=${subject}`,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
              console.log("RETURNED : ",data);
              $("#totalAttendance").text(data.total);
              $("#attended").text(data.attended);
              $("#absences").text(data.absences);
            },
            error: function (xhr, status, error) {
              console.error(xhr.responseText);
            }
          });
        }
      }

      // * csv maker
      const download = (data, filename) => {
        // Create a Blob with the CSV data and type
        const blob = new Blob([data], { type: 'text/csv' });

        // Create a URL for the Blob
        const url = URL.createObjectURL(blob);

        // Create an anchor tag for downloading
        const a = document.createElement('a');

        // Set the URL and download attribute of the anchor tag
        a.href = url;
        a.download = filename + '.csv';

        // Trigger the download by clicking the anchor tag
        a.click();
      }

      const csvmaker = function (data, date, subject) {
        // Empty array for storing the values
        let csvRows = [];

        // Add details at the beginning of the CSV
        csvRows.push("MONTHLY ATTENDANCE RECORD");
        csvRows.push(''); // Add empty lines for spacing
        csvRows.push(`Date: ${date}`);
        csvRows.push(`For Student : ${sessionStorage.getItem("loggedInUserLastName")}`);
        csvRows.push(`Subject: ${subject}`);
        csvRows.push(''); // Add an empty line for spacing

        // Headers is basically a keys of an object which 
        // is id, name, and profession
        const headers = Object.keys(data[0]);

        // As for making csv format, headers must be
        // separated by comma and pushing it into array
        csvRows.push(headers.join(','));

        // Pushing Object values into the array with
        // comma separation

        // Looping through the data values and make
        // sure to align values with respect to headers
        for (const row of data) {
          const values = headers.map(e => {
            return row[e]
          })
          csvRows.push(values.join(','))
        }

        // const values = Object.values(data).join(',');
        // csvRows.push(values)

        // returning the array joining with new line 
        return csvRows.join('\n')
      }

    });

  </script>

</body>


</html>