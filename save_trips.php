<?php
// Set content type for the response
header('Content-Type: application/json');

// Database credentials (adjust if needed)
$host = "localhost";
$user = "root"; // or your InfinityFree username
$password = ""; // use actual password
$database = "trailer_trips";

// Connect to the database
$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

// Read raw JSON input from fetch request
$data = json_decode(file_get_contents("php://input"), true);

// Validate JSON structure
if (!is_array($data)) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input data format."]);
    exit();
}

$successCount = 0;
$failures = [];

// Insert each row of trip data
foreach ($data as $trip) {
    $godown = $conn->real_escape_string($trip['godown']);
    $number_plate = $conn->real_escape_string($trip['number_plate']);
    $driver_name = $conn->real_escape_string($trip['driver_name']);
    $trips = (int) $trip['trips'];
    $comment = $conn->real_escape_string($trip['comment']);
    $month_year = $conn->real_escape_string($trip['month_year']);

    $sql = "INSERT INTO trip_logs (godown, number_plate, driver_name, trips, comment, month_year)
            VALUES ('$godown', '$number_plate', '$driver_name', $trips, '$comment', '$month_year')";

    if ($conn->query($sql) === TRUE) {
        $successCount++;
    } else {
        $failures[] = [
            "number_plate" => $number_plate,
            "error" => $conn->error
        ];
    }
}

$conn->close();

// Send JSON response
echo json_encode([
    "success" => $successCount,
    "failed" => $failures,
    "message" => "$successCount trips saved successfully."
]);
?>
