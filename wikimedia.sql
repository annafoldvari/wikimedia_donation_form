CREATE TABLE personaldetails (
id INT AUTO_INCREMENT PRIMARY KEY, 
first_name VARCHAR(30) NOT NULL,
last_name VARCHAR(30) NOT NULL,
street_address VARCHAR(100) NOT NULL,
city VARCHAR(50) NOT NULL,
state VARCHAR(100),
country VARCHAR(100) NOT NULL,
postal_code VARCHAR(30) NOT NULL,
phone_number VARCHAR(50),
email VARCHAR(50) NOT NULL,
preferred_contact ENUM('phone', 'email') NOT NULL
);
CREATE TABLE donations (
id INT AUTO_INCREMENT PRIMARY KEY,
user_id INT NOT NULL,
currency ENUM('usd', 'eur', 'btc') NOT NULL,
frequency ENUM('monthly', 'yearly', 'onetime') NOT NULL,
amount FLOAT NOT NULL,
comments TEXT
);