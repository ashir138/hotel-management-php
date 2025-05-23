-- Create database
CREATE DATABASE IF NOT EXISTS hotelmanage_system;
USE hotelmanage_system;

-- emp_login table
CREATE TABLE emp_login (
  empid INT AUTO_INCREMENT PRIMARY KEY,
  Emp_Email VARCHAR(100),
  Emp_Password VARCHAR(100)
);

INSERT INTO emp_login (Emp_Email, Emp_Password) VALUES
('admin@hotel.com', '123'),
('staff@hotel.com', '123');

-- signup table
CREATE TABLE signup (
  UserID INT AUTO_INCREMENT PRIMARY KEY,
  Username VARCHAR(100),
  Email VARCHAR(100),
  Password VARCHAR(100)
);

INSERT INTO signup (Username, Email, Password) VALUES
('Ali Ashir', 'ali@example.com', '123456'),
('Sara Khan', 'sara@example.com', 'abcdef'),
('Test User', 'test@example.com', 'test123');

-- staff table
CREATE TABLE staff (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  work VARCHAR(50)
);

INSERT INTO staff (name, work) VALUES
('John Doe', 'Manager'),
('Ahmed Ali', 'Cook'),
('Sara Yousaf', 'Cleaner'),
('Waqas Khan', 'Helper');

-- room table
CREATE TABLE room (
  id INT AUTO_INCREMENT PRIMARY KEY,
  type VARCHAR(50),
  bedding VARCHAR(50),
  place VARCHAR(50),
  status VARCHAR(50)
);

INSERT INTO room (type, bedding, place, status) VALUES
('Superior Room', 'Single', '1st Floor', 'Free'),
('Deluxe Room', 'Double', '2nd Floor', 'Occupied'),
('Guest House', 'Triple', '3rd Floor', 'Free'),
('Single Room', 'Single', 'Ground Floor', 'Occupied');

-- roombook table
CREATE TABLE roombook (
  id INT AUTO_INCREMENT PRIMARY KEY,
  Name VARCHAR(100),
  Email VARCHAR(100),
  Country VARCHAR(50),
  Phone VARCHAR(20),
  RoomType VARCHAR(50),
  Bed VARCHAR(50),
  NoofRoom INT,
  Meal VARCHAR(50),
  cin DATE,
  cout DATE,
  stat VARCHAR(50),
  nodays INT
);

INSERT INTO roombook (Name, Email, Country, Phone, RoomType, Bed, NoofRoom, Meal, cin, cout, stat, nodays)
VALUES
('Ali Ashir', 'ali@example.com', 'Pakistan', '03001234567', 'Superior Room', 'Single', 1, 'Breakfast', '2025-05-25', '2025-05-27', 'Confirm', 2);

-- payment table
CREATE TABLE payment (
  id INT PRIMARY KEY,
  Name VARCHAR(100),
  Email VARCHAR(100),
  RoomType VARCHAR(50),
  Bed VARCHAR(50),
  NoofRoom INT,
  cin DATE,
  cout DATE,
  noofdays INT,
  roomtotal INT,
  bedtotal INT,
  meal VARCHAR(50),
  mealtotal INT,
  finaltotal INT
);

INSERT INTO payment (id, Name, Email, RoomType, Bed, NoofRoom, cin, cout, noofdays, roomtotal, bedtotal, meal, mealtotal, finaltotal)
VALUES
(1, 'Ali Ashir', 'ali@example.com', 'Superior Room', 'Single', 1, '2025-05-25', '2025-05-27', 2, 6000, 60, 'Breakfast', 120, 6180);
