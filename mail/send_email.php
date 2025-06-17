<?php
// workaround without composer to access .env file
$env = parse_ini_file('.././.env');

// * NOTE : phpmailer needs to be in the same directory to work properly
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email
{
  public $stud = null;

  public function sendEmail($name, $email, $subject)
  {

    // Load Composer's autoloader
    require 'phpmailer/phpmailer/vendor/autoload.php';
    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
      //Server settings
      $mail->SMTPDebug = 0; // Enable verbose debug output
      $mail->isSMTP(); // Set mailer to use SMTP
      $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
      $mail->SMTPAuth = true; // Enable SMTP authentication
      $mail->Username = $env['GMAIL_EMAIL']; // * CHANGE TO UR OWN EMAIL ADDRESS 
      $mail->Password = $env['GMAIL_APP_KEY']; // * CHANGE TO UR OWN GMAIL APP PASSWORD > SETUP BY Enabling 2FA first then Search App Password > Generate > paste it here
      $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
      $mail->Port = 587; // TCP port to connect to

      // * solution to this error => Message could not be sent. Mailer Error: SMTP Error: Could not connect to SMTP host
      $mail->SMTPOptions = array(
        'ssl' => array(
          'verify_peer' => false,
          'verify_peer_name' => false,
          'allow_self_signed' => true
        )
      );

      //Recipients
      $mail->setFrom('parokyanimayonnaise@gmail.com', 'Attendance Notification');
      $mail->addAddress($email, $name); // Add a recipient

      // Content
      $mail->isHTML(true); // Set email format to HTML
      $mail->Subject = $subject;
      // $mail->Body = '';
      $mail->Body = '
      <!DOCTYPE html>
        <html lang="en">
          <head>
            <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <title>Attendance Notification</title>
            <style>
      .header {
        background-color: #152136;
        padding: 20px;
        color: white;
        text-align: center;
      }

      .header > * {
        display: block;
        margin: 10px auto;
      }

      .header img {
        max-width: 85px;
        max-height: 85px;
      }

      .main {
        padding: 20px;
        color:black;
      }

      .section {
        border-top: 5px solid #152136;
        border-bottom: 5px solid #152136;
        padding: 10px 20px 20px 20px;
      }

      .label {
        text-align: center;
        color: white;
        background-color: #152136;
        padding: 12px;
      }

      .table {
        width: 100%;
        color: black;
      }

      .table th {
        text-align: left;
      }

      .table td {
        text-align: right;
      } 

      .footer {
        margin: 16px;
        background-color: gainsboro;
        padding: 16px;
      }

      .footer > * {
        display: block;
        margin: 5px auto;
        color: black;
      }
    </style>
          </head>

          <body style="max-width:800px; min-width:300px; overflow:auto; margin:0 auto;">
             <div class="header">
             <img
                src="https://i.imgur.com/TDVi2hS.png"
                alt="LLCCES logo"
              /> 
             <span style="font-size: 26px"
                ><strong>LLCCES-Special Needs Education Center</strong></span
              >
              <span style="font-size: 16px"
                ><strong>Attendance Notification</strong></span
              >
            </div>

            <div class="main">
              <p style="font-size: 32px"><strong>Good day!</strong></p>
              <p>
                The student  
                <strong> ' . $this->stud->student_name . ' </strong> has been marked as
                <strong> ' . $this->stud->status . ' </strong> at
                <strong> ' . $this->stud->time . ' </strong> in the 
                <strong> ' . $this->stud->subject . ' subject.</strong>.
              </p>
            </div>

            <div class="section">
              <p class="label">Below are the details of the student</p>
               <table class="table">
                <tr>
                  <th>Student ID :</th>
                  <td> ' . $this->stud->id . ' </td>
                </tr>
                <tr>
                  <th>Student Name :</th>
                  <td> ' . $this->stud->student_name . ' </td>
                </tr>
              </table>
            </div>

            <div class="footer">
              <span>Sincerely,</span>
              <span><strong>Attendance Management System</strong></span>
            </div>
          </body>
        </html>
        ';

      $mail->send();
    } catch (Exception $e) {
      echo json_encode(
        array(
          "message" => "Message could not be sent. Mailer Error:" . $mail->ErrorInfo,
          "color" => "red"
        )
      );
    }
  }
}