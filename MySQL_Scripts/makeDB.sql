DROP SCHEMA IF EXISTS workorder;
CREATE SCHEMA workorder;
USE workorder;
GRANT ALL PRIVILEGES ON workorder.* TO 'rootWO'@'localhost' IDENTIFIED BY '';
FLUSH PRIVILEGES;

CREATE TABLE tickets (
ticketNumber INT NOT NULL AUTO_INCREMENT, dateCreated date, 
problemDescription varchar(100), problemCode enum(''), assignedTo enum(''),
dateClosed date, status enum('OPEN', 'CLOSED'), PRIMARY KEY(ticketNumber)
);

ALTER TABLE workorder.tickets AUTO_INCREMENT = 1000;
