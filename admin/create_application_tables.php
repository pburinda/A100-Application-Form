<?php

include "cred_ext.php";

//build connection
$con = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_APP_DATABASE);

//test connection
if(mysqli_connect_errno()){
	echo "Failed to connect to MySQL: ".mysqli_connect_error();
}

$sql = array(
	"CREATE TABLE identity(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	first_name VARCHAR(30) NOT NULL, 
	last_name VARCHAR(30) NOT NULL,
	email VARCHAR(50) NOT NULL,
	password VARCHAR(50) NOT NULL
	)",
	"CREATE TABLE applications(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	applicant_id INT UNSIGNED NOT NULL REFERENCES applicants(id),
	cohort_id INT UNSIGNED NOT NULL REFERENCES `forms_db`.cohorts(id),
	referral_id INT UNSIGNED NOT NULL REFERENCES referrals(id),
	schedule_id INT UNSIGNED NOT NULL REFERENCES schedcules(id),
	experience_id INT UNSIGNED NOT NULL REFERENCES experiences(id),
	material_id INT UNSIGNED NOT NULL REFERENCES materials(id),
	is_complete BIT NOT NULL,
	submit_timestamp TIMESTAMP NOT NULL
	)",
	"CREATE TABLE applicants(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	identity_id INT UNSIGNED NOT NULL REFERENCES identity(id),
	school_id INT UNSIGNED NOT NULL REFERENCES `forms_db`.schools(id),
	major VARCHAR(50),
	graduation_date VARCHAR(30),
	street_address VARCHAR(100) NOT NULL,
	city VARCHAR(50) NOT NULL,
	state VARCHAR(20) NOT NULL,
	zipcode CHAR(5) NOT NULL,
	phone_number VARCHAR(15) NOT NULL,
	linkedin VARCHAR(50) NOT NULL,
	portfolio VARCHAR (50) NOT NULL,
	age_check BIT NOT NULL,
	legal_status BIT NOT NULL
	)",
	"CREATE TABLE referrals(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	option_1 BIT,
	option_2 BIT,
	option_3 BIT,
	option_4 BIT,
	option_5 BIT,
	option_6 BIT,
	option_7 BIT,
	option_8 VARCHAR(100),
	option_9 VARCHAR(100),
	option_10 BIT,
	option_11 VARCHAR(100)
	)",
	"CREATE TABLE schedules(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	weekly_hours TINYINT UNSIGNED NOT NULL,
	commitments TEXT NOT NULL
	)",
	"CREATE TABLE experiences(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	programming_option VARCHAR(100) NOT NULL,
	work_option VARCHAR(100) NOT NULL,
	job_title VARCHAR(100),
	front_end_experience TEXT,
	lamp_stack_experience TEXT,
	mobile_experience TEXT,
	cms_experience TEXT,
	other_experience TEXT
	)",
	"CREATE TABLE materials(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	resume BLOB NOT NULL,
	cover_letter BLOB NOT NULL,
	reference_list TEXT NOT NULL,
	additional_info TEXT
	)"
	);


	foreach ($sql as $stmt) {
		if (mysqli_query($con, $stmt)){
			echo "Table created successfully. \n";
		}else{
			echo "Error executing: " . $stmt . "\nError produced: " . mysqli_error($con);
		}
	}

//cut connection
mysqli_close($con);

?>