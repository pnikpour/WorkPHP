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

CREATE TABLE users (
	username VARCHAR(25) NOT NULL, groups ENUM('User', 'Administrator') NOT NULL
);

UPDATE users SET groups = 'Administrator' WHERE username LIKE 'root' AND username LIKE 'rootWO';

ALTER TABLE workorder.tickets AUTO_INCREMENT = 1000;
