DROP SCHEMA IF EXISTS workorder;
CREATE SCHEMA workorder;
USE workorder;

-- Initially set privileges for secure user account
GRANT USAGE ON *.* to 'secureUser'@'localhost';
DROP USER secureUser@localhost;
CREATE USER secureUser@localhost;
SET PASSWORD FOR secureUser@localhost = PASSWORD('BL3FFEE5WUsrJQnx');
GRANT SELECT, UPDATE, INSERT, DELETE ON workorder.* TO 'secureUser'@'localhost' IDENTIFIED BY 'BL3FFEE5WUsrJQnx';
FLUSH PRIVILEGES;


-- Create tickets table
CREATE TABLE tickets (
	ticketNumber INT NOT NULL AUTO_INCREMENT, dateCreated date, 
	problemDescription varchar(256), requestor varchar(25), problemCode ENUM('BOOT ISSUE', 'NETWORK', 'HARDWARE', 'PHONE ISSUE'), assignedTo ENUM('tech'),
	dateClosed DATE, status ENUM('OPEN', 'CLOSED'), solutionDescription varchar(256), PRIMARY KEY(ticketNumber)
) ENGINE = InnoDB;

-- Create task list table
CREATE TABLE taskList (
	taskId INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	taskOwner VARCHAR(32) NOT NULL,
	taskName VARCHAR(32) NOT NULL,
	taskDescription VARCHAR(512),
	taskCompleted BOOLEAN NOT NULL
) ENGINE = InnoDB;

-- Create users table
CREATE TABLE users (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
	username VARCHAR(25) NOT NULL,
	hash CHAR(128) NOT NULL,
	groups ENUM('User', 'Administrator') NOT NULL,
	verifyKey VARCHAR(128) NULL,
	isVerified BOOLEAN NOT NULL
) ENGINE = InnoDB;

CREATE TABLE loginAttempts (
	userID INT(11) NOT NULL,
	attemptTime VARCHAR(30) NOT NULL
) ENGINE = InnoDB;

-- Set the default ticket number
ALTER TABLE workorder.tickets AUTO_INCREMENT = 1000;
