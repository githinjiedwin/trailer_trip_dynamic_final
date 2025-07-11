<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$db = 'trailer_trips';
$user = 'root';
$pass = '';  // leave empty if you haven't set a MySQL password

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Read incoming JSON
$data = json_decode(file_get_contents("php://input"), true);

if (!is_array($data)) {
  echo "Invalid data format.";
  exit;
}

foreach ($data as $entry) {
  $godown = $conn->real_escape_string($entry['godown']);
  $number_plate = $conn->real_escape_string($entry['number_plate']);
  $driver_name = $conn->real_escape_string($entry['driver_name']);
  $trips = intval($entry['trips']);
  $comment = $conn->real_escape_string($entry['comment']);
  $month_year = $conn->real_escape_string($entry['month_year']);

  $sql = "INSERT INTO trip_logs (godown, number_plate, driver_name, trips, comment, month_year)
          VALUES ('$godown', '$number_plate', '$driver_name', $trips, '$comment', '$month_year')";
  $conn->query($sql);
}

$conn->close();
echo "Data saved successfully.";
?>
