
CREATE DATABASE IF NOT EXISTS trailer_trips;
USE trailer_trips;

CREATE TABLE IF NOT EXISTS trip_logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  godown VARCHAR(50),
  number_plate VARCHAR(20),
  driver_name VARCHAR(100),
  trips INT,
  comment TEXT,
  month_year VARCHAR(20)
);
