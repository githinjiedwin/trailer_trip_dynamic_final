<?php
$host = 'localhost';
$db = 'trailer_trips';
$user = 'root';
$pass = '';

// Connect to database
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch all trip logs
$sql = "SELECT * FROM trip_logs ORDER BY month_year DESC, godown, trips DESC";
$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $godown = $row['godown'];
    $data[$godown][] = $row;
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Trips - Maguna Andu</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f7faff;
      margin: 0;
      padding: 0;
    }

    h1 {
      background: #003f5c;
      color: white;
      margin: 0;
      padding: 20px;
      text-align: center;
    }

    h2 {
      color: #003f5c;
      margin: 30px 0 10px 20px;
    }

    table {
      width: 95%;
      margin: 10px auto 40px auto;
      border-collapse: collapse;
      background: white;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 12px;
      border: 1px solid #ccc;
      text-align: left;
      font-size: 14px;
    }

    th {
      background-color: #e3f2fd;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .footer {
      text-align: center;
      font-size: 12px;
      padding: 20px;
      background: #f1f1f1;
      color: #777;
    }
  </style>
</head>
<body>

<h1>View Trips - Maguna Andu Trailer Tracker</h1>

<?php if (!empty($data)): ?>
  <?php foreach ($data as $godown => $rows): ?>
    <h2><?= htmlspecialchars($godown) ?></h2>
    <table>
      <thead>
        <tr>
          <th>Number Plate</th>
          <th>Driver</th>
          <th>Trips</th>
          <th>Comment</th>
          <th>Month</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $row): ?>
        <tr>
          <td><?= htmlspecialchars($row['number_plate']) ?></td>
          <td><?= htmlspecialchars($row['driver_name']) ?></td>
          <td><?= htmlspecialchars($row['trips']) ?></td>
          <td><?= htmlspecialchars($row['comment']) ?></td>
          <td><?= htmlspecialchars($row['month_year']) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endforeach; ?>
<?php else: ?>
  <p style="padding: 20px; text-align: center;">No trip records found.</p>
<?php endif; ?>

<div class="footer">
  &copy; <?= date('Y') ?> Maguna Andu Logistics. All rights reserved.
</div>

</body>
</html>
