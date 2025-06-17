<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Attendance</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="../styles/main.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <style>
    #reader {
      overflow: hidden;
      border: none;
      font-size: 0.75rem;
    }

    #reader div {
      border: none;
    }

    #reader span:nth-of-type(1) {
      margin-left: 1rem;
    }

    #reader button {
      background-color: #4ADE80;
      color: white;
      padding: 0.5rem 1rem;
      border-radius: 0.75rem;
      margin-right: 1rem;
    }

    #reader select {
      border-radius: 0.75rem;
      padding: 0.5rem 1rem;
      margin: 1rem;
      border: 1px solid gray;
    }

    #reader a {
      padding: 0.5rem 1rem;
      margin: 1rem 0;
      color: #60A5FA;
      font-weight: bold;
    }

    #reader a {
      display: none !important;
    }

    .max-height {
      max-height: 44rem;
    }

    .current-selected-row {
      border: 2px solid #34D399;
    }

    .print-picker {
      position: fixed;
      top: 50%;
      left: 50%;
      z-index: 40;
      transform: translate(-50%, -50%);
    }
  </style>
</head>

<body>
  <div class="wrapper px-8 text-sm">
    <?php include ("navbar.php"); ?>
    <!-- * notif -->
    <div id="notif" class="hidden my-4 p-4 bg-green-100 rounded-xl">
      <p class="text-green-400 font-semibold text-base">
        HEHEHEHEHE
      </p>
    </div>
    <div class="flex flex-wrap gap-4">
      <div class="shadow-xl max-height rounded-xl sm:flex-1 p-4 w-full flex items-center justify-center">
        <div id="reader" class="rounded-xl"></div>
      </div>
      <div class="flex flex-col gap-4 w-full sm:flex-1">
        <!-- QR CODE -->
        <div class="flex flex-col gap-4">
          <div class="flex items-center gap-4 border rounded-xl p-4 bg-blue-400 text-white shadow-lg">
            <div class="border border-white p-4 rounded-xl">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
              </svg>
            </div>
            <div>
              <div>
                <span>Name: </span>
                <span class="font-semibold" id="studentName">No data available...</span>
              </div>
              <div>
                <span>ID : </span>
                <span class="font-semibold" id="studentId">No data available...</span>
              </div>
            </div>
          </div>
          <div class="flex justify-center border rounded-xl bg-green-400 py-8 shadow-lg">
            <img id="student_qr" class="rounded-xl w-40 h-40" src="../images/no-qr-code.jpg" alt="qr code">
            <!-- <img class="w-full border rounded-xl" src="../images/another-sample-qr.png" alt="qr code"> -->
          </div>
          <select name="subject" id="subject"
            class="p-4 font-semibold border rounded-xl w-full sm:w-auto border-gray-400 bg-gray-100">
            <!-- <option value="17">CCS-103</option>
            <option value="18">CCS-102</option> -->
          </select>
        </div>
        <!-- table -->
        <div class="flex flex-col gap-4 shadow-xl rounded-xl p-4 overflow-x-auto mb-8">
          <div class="sm:place-self-end flex flex-wrap gap-4 items-center border w-fit px-4 py-2 rounded-xl">
            <svg id="printAttendance" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
              stroke-width="1.5" stroke="currentColor" class="size-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
            </svg>
            <label for="date" class="font-semibold">Attendance Date</label>
            <input type="date" name="date" id="date" />
          </div>
          <table id="table" class="min-w-20 w-full rtl:text-right text-center text-xs font-semibold max-h-96">
            <thead class="bg-gray-50">
              <tr class="text-center">
                <th scope="col" class="px-6 py-3">
                  ID
                </th>
                <th scope="col" class="px-6 py-3">
                  First Name
                </th>
                <th scope="col" class="px-6 py-3">
                  Last Name
                </th>
                <th scope="col" class="px-6 py-3">
                  Attendance
                </th>
                <th scope="col" class="px-6 py-3">
                  Actions
                </th>
                <th scope="col" class="px-6 py-3">
                  qrcode
                </th>
              </tr>
            </thead>
            <tbody class="text-sm">
              <!-- <tr class="hover:bg-green-100">
                <td class="px-6 py-4">20210548-M</td>
                <td class="px-6 py-4">Mendador</td>
                <td class="px-6 py-4">Jiro</td>
                <td class="px-6 py-4 text-green-400">Present</td>
                <td class="px-6 py-4 flex justify-center gap-2 text-white">
                  <button class="bg-green-400 p-2 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                      stroke="currentColor" class="w-4 h-4s">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                  </button>
                  <button class="bg-red-400 p-2 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                      stroke="currentColor" class="w-4 h-4">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                  </button>
                </td>
              </tr>
              <tr class="hover:bg-green-100">
                <td class="px-6 py-4">201230548-M</td>
                <td class="px-6 py-4">Doe</td>
                <td class="px-6 py-4">John</td>
                <td class="px-6 py-4 text-red-400">Absent</td>
                <td class="px-6 py-4 flex justify-center gap-2 text-white">
                  <button class="bg-green-400 p-2 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                      stroke="currentColor" class="w-4 h-4s">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                  </button>
                  <button class="bg-red-400 p-2 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                      stroke="currentColor" class="w-4 h-4">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                  </button>
                </td>
              </tr> -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- * datepicker for printing to csv -->
    <div id="printInputs" class="hidden print-picker bg-white shadow-xl p-8 rounded-xl w-4/5 sm:max-w-sm">
      <h3 class="text-lg font-semibold mb-8">Attendance to CSV</h3>
      <form id="printForm" class="flex flex-col gap-4">
        <div class="flex flex-wrap gap-4 border border-green-400 rounded-xl px-4 py-2">
          <label for="fromDate" class="font-semibold">From</label>
          <input type="date" name="fromDate" id="fromDate" required>
        </div>
        <div class="flex flex-wrap gap-4 border border-green-400 rounded-xl px-4 py-2">
          <label for="toDate" class="font-semibold">To</label>
          <input type="date" name="toDate" id="toDate" required>
        </div>
        <div class="mt-4 flex flex-col gap-4">
          <input class="px-4 py-2 bg-green-100 text-green-400 rounded-xl" type="submit" name="print" id="print"
            value="Download CSV" />
          <a id="cancelPrint" class="text-center px-4 py-2 bg-gray-100 text-gray-400 rounded-xl">Cancel</a>
        </div>
      </form>
    </div>
  </div>
  </div>

  <script src=" https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.4/html5-qrcode.min.js"
    integrity="sha512-k/KAe4Yff9EUdYI5/IAHlwUswqeipP+Cp5qnrsUjTPCgl51La2/JhyyjNciztD7mWNKLSXci48m7cctATKfLlQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer">
    </script>

  <script>

    const CURRENT_USER_ID = sessionStorage.getItem("loggedInId");
    const CURRENT_USER_FULLNAME = sessionStorage.getItem("loggedInUserLastName")
      + " " + sessionStorage.getItem("loggedInUserFirstName");

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

    $(document).ready(function () {
      
      const scanner = new Html5QrcodeScanner('reader', {
        // Scanner will be initialized in DOM inside element with id of 'reader'
        qrbox: {
          width: 250,
          height: 250,
        },  // Sets dimensions of scanning box (set relative to reader element width)
        fps: 20, // Frames per second to attempt a scan
      });
      scanner.render(success);

      // Starts scanner
      let prevResult = "";
      function success(result) {
        if (prevResult !== result) {
          var currentRow = $('.current-selected-row');
          var currentStatus = currentRow.find('td:eq(3)').text(); // Get the status from column 4
          if (currentStatus.trim().toLowerCase() === 'present') {
            if (!confirm('This student already has "Present" status. Are you sure you want to override the previous attendance?')) {
              return;
            }
          }

          prevResult = result;

          setTimeout(() => {
            insertAttendance($("#subject").val(), $("#studentId").text(), "Present", $("#date").val());
          }, 500);
        }
      }

      function error(err) {
        console.error(err);
        // Prints any errors to the console
      }

      $('#printAttendance').click(function () {
        $("#fromDate").val(null);
        $("#toDate").val(null);
        $("#printInputs").removeClass("hidden");
      });

      $('#cancelPrint').click(function (e) {
        $("#printInputs").addClass("hidden");
      });

      $("#printForm").submit(function (e) {
        e.preventDefault();

        let formData = "fromDate=" + $("#fromDate").val();
        formData += "&toDate=" + $("#toDate").val();
        formData += "&subject=" + $("#subject").val();
        formData += "&print=true";

        $.ajax({
          type: 'POST',
          url: 'attendance_crud.php',
          data: formData,
          success: function (response) {
            console.log("respone : ", response);
            $("#printInputs").addClass("hidden");
            const csvdata = csvmaker(response, $("#fromDate").val(),
              $("#toDate").val(), $("#subject>option:selected").text());
            download(csvdata, $("#subject>option:selected").text());
          },
          error: function (xhr, status, error) {
            console.error(xhr.responseText);
          }
        });
      });

      $('#subject').change(function () {
        $("#date").val(getCurrentDate());
        var selectedOption = $(this).val();
        getAttendance($("#subject").val());
      });

      $("#date").val(getCurrentDate());
      $("#date").change(function () {
        if ($(this).val() === "") {
          $("#table tbody").empty();
          $('#table tbody').html('<tr><td colspan="7" class="p-4 w-full text-center text-gray-400">NO DATA AVAILABLE</td></tr>');
          $("#student_qr").prop("src", "../images/no-qr-code.jpg");
          $("#studentName").text("No data available..");
          $("#studentId").text("No data available");
        } else {
          getAttendance($("#subject").val());
        }
      })

      $(document).on("click", ".present", function () {
        insertAttendance($("#subject").val(), $("#studentId").text(), "Present", $("#date").val());
      });

      $(document).on("click", ".absent", function () {
        insertAttendance($("#subject").val(), $("#studentId").text(), "Absent", $("#date").val());
      });

      $(document).on("click", ".clear", function () {
        deleteAttendance($(this).data("id"));
      });

      // * starts the retrieving of data in database
      getSubjects(CURRENT_USER_ID);

      // Event handler for when a table row is clicked
      $('table').on('click', 'tr', function () {
        // Remove current-selected-row class from all rows
        $('table tr').removeClass('current-selected-row');
        // Add current-selected-row class to the clicked row
        $(this).addClass('current-selected-row');
        // Retrieve the column value of the clicked row
        getColumnValue($(this));
      });

      function getAttendance(subject) {
        $.ajax({
          type: 'GET',
          url: 'attendance_crud.php?attendance=true&subject=' + subject +
            // "&date=" + getCurrentDate(),
            "&date=" + $("#date").val(),
          success: function (response) {
            // Clear existing table rows
            $('#table tbody').empty();

            // Check if there are users returned from the server
            if (response.length > 0) {
              // Loop through each student and append a new row to the table
              $.each(response, function (index, student) {
                var row = "";
                if (index == 0) {
                  row = '<tr class="hover:bg-green-50 current-selected-row">';
                } else {
                  row = '<tr class="hover:bg-green-50">';
                }
                row += '<td class="px-6 py-2">' + student.id + '</td>' +
                  '<td class="px-6 py-2">' + student.firstName + '</td>' +
                  '<td class="px-6 py-2">' + student.lastName + '</td>' +
                  '<td class="px-6 py-2">' + student.status + '</td>' +
                  '<td class="px-6 py-2 flex flex-wrap justify-center gap-4">' +
                  '<button class="present underline text-blue-400" data-id=' + student.id + '">Present</button>' +
                  '<button class="absent underline text-red-400" data-id=' + student.id + '>Absent</button>' +
                  '<button class="clear underline text-orange-400" data-id=' + student.attendanceId + '>Clear</button>' +
                  '</td>' +
                  '<td class="px-6 py-2">' + student.qrcode + '</td>' +
                  '</tr>';

                // Append the new row to the table body
                $('#table tbody').append(row);
              });
            } else {
              // If no users are returned, display a message in the table
              $('#table tbody').html('<tr><td colspan="7" class="p-4 w-full text-center text-gray-400">NO DATA AVAILABLE</td></tr>');
            }
            retrieveColumnValue();
          },
          error: function (xhr, status, error) {
            // Handle errors
            console.error(xhr.responseText);
          }
        });
      }

      function getSubjects(id) {
        let url = 'subject_crud.php?teacher_subject=true&id=' + id;
        if (sessionStorage.getItem("loggedInType") === "admin") {
          url += "&isAdmin=true";
        }
        $.ajax({
          url: url, // Replace with your server endpoint
          method: 'GET', // Adjust the method as per your requirement
          dataType: 'json', // Specify the expected data type
          success: function (data) {
            var select = $('#subject');
            select.empty();
            $.each(data, function (index, item) {
              select.append($('<option>', {
                value: item.id,
                text: item.name
              }));
            });
            getAttendance($("#subject").val());
          },
          error: function (xhr, status, error) {
            // Handle errors
            console.error(xhr.responseText);
          }
        });
      }

      function insertAttendance(subject, id, status, date) {
        var formData = `insert=true&subject=${subject}&id=${id}&status=${status}&date=${date}`;
        formData += "&subject_name=" + $("#subject>option:selected").text() +
          "&student_name=" + $("#studentName").text();
        $.ajax({
          type: 'POST',
          url: 'attendance_crud.php',
          data: formData,
          dataType: 'json',
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
            $('#notif').fadeIn().delay(500).fadeOut();

            getAttendance($("#subject").val());

          },
          error: function (xhr, status, error) {
            console.error(xhr.responseText);
          }
        });
      }

      function deleteAttendance(attendanceId) {
        var formData = `delete=true&id=${attendanceId}`;
        $.ajax({
          type: 'POST',
          url: 'attendance_crud.php',
          data: formData,
          dataType: 'json',
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
            $('#notif').fadeIn().delay(500).fadeOut();

            getAttendance($("#subject").val());

          },
          error: function (xhr, status, error) {
            console.error(xhr.responseText);
          }
        });
      }
      // * utils

      function getCurrentDate() {
        const date = new Date();

        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-based
        const day = String(date.getDate()).padStart(2, '0');

        return `${year}-${month}-${day}`;
      }

      function getColumnValue(row) {
        var qrcode = row.find('td:eq(5)').text();
        var id = row.find('td:eq(0)').text();
        var firstName = row.find('td:eq(1)').text();
        var lastName = row.find('td:eq(2)').text();

        $("#student_qr").prop("src", qrcode === "" ? "../images/no-qr-code.jpg" : qrcode);
        $("#studentName").text(lastName === "" || firstName === "" ? "No data available.." : `${lastName} ${firstName}`);
        $("#studentId").text(id === "" ? "No data available" : `${id}`);

        console.log("qrcode:", qrcode);
      }

      function retrieveColumnValue() {
        var row = $('.current-selected-row');
        var status = row.find('td:eq(3)').text().trim();

        console.log("status:", status);

        // Loop through the next rows until you find a row where the 4th index is "No Record"
        while (status !== "No Record" && row.next().length > 0) {
          row = row.next();
          status = row.find('td:eq(3)').text().trim();
          console.log("next status:", status);
        }

        if (status === "No Record") {
          $('table tr').removeClass('current-selected-row');
          row.addClass('current-selected-row');
        } else {
          console.log("No row found with 'No Record' in the 4th column.");
          row = $('.current-selected-row');
          status = row.find('td:eq(3)').text().trim();
          console.log(row);
        }

        getColumnValue(row);
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

      const csvmaker = function (data, fromDate, toDate, subject) {

        // Empty array for storing the values
        csvRows = [];

        // Add details at the beginning of the CSV
        csvRows.push("ATTENDANCE RECORD");
        csvRows.push(''); // Add an empty line for spacing
        csvRows.push(''); // Add an empty line for spacing
        csvRows.push(`Date Range: ${fromDate} to ${toDate}`);
        csvRows.push(`By: ${CURRENT_USER_FULLNAME}`); // Add the name of the person generating the CSV here
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