<?php

$host = 'localhost';
$username = 'root';
$password = 'password';
$db_name = 'ironmed';

$conn = new mysqli($host, $username, $password, $db_name, 3306);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check for an active session before starting a new one
if (session_id() === '') {
  session_start();
}

CONST DEFAULT_PASSWORD = 'default123';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
