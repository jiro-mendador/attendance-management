<?php

// workaround without composer to access .env file
$env = parse_ini_file('../.env');

// configs for PostgreSQL
$host = gethostbyname($env['DB_HOST']);
$port = $env['DB_PORT'];
$dbName = $env['DB_NAME'];
$dbUser = $env['DB_USER'];
$dbPass = $env['DB_PASSWORD'];
$connectionString = "pgsql:host=$host;port=$port;dbname=$dbName;";

// Database connection parameters
// $dbHost = 'localhost'; // Change this to your database host
// $dbName = 'attendance'; // Change this to your database name
// $dbUser = 'root'; // Change this to your database username
// $dbPass = ''; // Change this to your database password

// Establish a connection to the database
try {
  $conn = new PDO($connectionString, $dbUser, $dbPass);
  // $conn = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
  // Set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  // If connection fails, display an error message
  die("Connection failed: " . $e->getMessage());
}