DROP SCHEMA IF EXISTS workorder;
CREATE SCHEMA workorder;
USE workorder;

-- Initially set privileges for secure user account
CREATE USER secureUser@localhost;
SET PASSWORD FOR secureUser@localhost = PASSWORD('BL3FFEE5WUsrJQnx');
GRANT SELECT, UPDATE, INSERT ON workorder.* TO 'secureUser'@'localhost' IDENTIFIED BY 'BL3FFEE5WUsrJQnx';
FLUSH PRIVILEGES;


-- Create tickets table
CREATE TABLE tickets (
	ticketNumber INT NOT NULL AUTO_INCREMENT, dateCreated date, 
	problemDescription varchar(100), requestor varchar(25), problemCode ENUM('BOOT ISSUE', 'NETWORK', 'HARDWARE', 'PHONE ISSUE'), assignedTo ENUM('pnikpour'),
	dateClosed DATE, status ENUM('OPEN', 'CLOSED'), PRIMARY KEY(ticketNumber)
);

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

-- Set temporary default passwords for root accounts
SET PASSWORD FOR root@localhost = PASSWORD('strawberryphp');

-- Insert root accounts in users table in the workorder database; set admin attributes
-- INSERT INTO users (username) VALUES ('root'), ('rootWO');
-- UPDATE users SET groups = 'Administrator' WHERE username LIKE 'root' OR username LIKE 'rootWO';

-- Set the default ticket number
ALTER TABLE workorder.tickets AUTO_INCREMENT = 1000;
