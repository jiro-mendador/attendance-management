<?php

function arrayToCsvDownload($array, $filename = "export.csv", $delimiter = ",")
{
  // Open a file in memory
  $f = fopen('php://memory', 'w');

  // If array has headers, write them first
  if (!empty($array) && is_array($array[0])) {
    fputcsv($f, array_keys($array[0]), $delimiter);
  }

  // Loop through the array and write each row to the file
  foreach ($array as $line) {
    fputcsv($f, $line, $delimiter);
  }

  // Rewind the file pointer
  fseek($f, 0);

  // Set headers to download the file rather than displaying it
  header('Content-Type: application/csv');
  header('Content-Disposition: attachment; filename="' . $filename . '";');

  // Output all remaining data on a file pointer
  fpassthru($f);
}

// Example data array
$data = [
  ["id" => 1, "name" => "John Doe", "email" => "john@example.com"],
  ["id" => 2, "name" => "Jane Smith", "email" => "jane@example.com"]
];

// Call the function to download CSV
arrayToCsvDownload($data);
exit();

require_once '../phpqrcode/qrlib.php';
$path = '../images/';
$qrcode = $path . time() . ".png";
$qrimage = time() . ".png";

$scannedText = "SCANNED QR CODE HERE";

if (
  $_SERVER['REQUEST_METHOD'] === "POST"
  && isset($_POST["generateQrCode"])
) {
  QRcode::png($_POST["qrCodeText"], $qrcode, 'H', 4, 4);
  echo "QR CODE GENERATED!";
}
?>





<!-- <!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <form action="./" method="POST">
    <input type="text" name="qrCodeText" />
    <input type="submit" value="GENERATE QR CODE" name="generateQrCode" />
  </form>
  <img src="<?php echo "images/" . $qrimage ?>" width="100" height="100">

  <br>
  <p id="result"><?php echo $scannedText ?></p>
  <div id="reader" style="width:500px;height: 500px;"></div>
</body>

<script src=" https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.4/html5-qrcode.min.js"
  integrity="sha512-k/KAe4Yff9EUdYI5/IAHlwUswqeipP+Cp5qnrsUjTPCgl51La2/JhyyjNciztD7mWNKLSXci48m7cctATKfLlQ=="
  crossorigin="anonymous" referrerpolicy="no-referrer">
  </script>
<script>
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
  function success(result) {
    document.getElementById('result').innerHTML = `
        <h2>Success!</h2>
        <p>${result}</p>
        `;
    // Prints result as a link inside result element
    scanner.clear();
    // Clears scanning instance
    // document.getElementById('reader').remove();
    // Removes reader element from DOM since no longer needed
  }

  function error(err) {
    console.error(err);
    // Prints any errors to the console
  }

</script>

</html> -->