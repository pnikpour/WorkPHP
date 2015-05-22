DROP SCHEMA IF EXISTS workorderTest;
CREATE SCHEMA workorderTest;
USE workorderTest;
CREATE TABLE tickets (
ticketNumber INT AUTO_INCREMENT PRIMARY KEY, dateCreated date, 
problemDescription varchar(100), problemCode enum(''), assignedTo enum(''),
dateClosed date, status enum('OPEN', 'CLOSED')
) AUTO_INCREMENT = 1000;
