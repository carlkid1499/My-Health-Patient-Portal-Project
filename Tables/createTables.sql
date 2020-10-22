use myhealth2fulltest;

# Create the Patient Information Table
CREATE TABLE PatientInfo (
  PID bigint unsigned UNIQUE PRIMARY KEY NOT NULL,
  name_first varchar(45) NOT NULL,
  name_last varchar(45) NOT NULL,
  DOB date NOT NULL,
  Gender varchar(10) DEFAULT NULL,
  address varchar(200) NOT NULL,
  email varchar(45) DEFAULT NULL,
  phone varchar(45) NOT NULL,
  Emergency_name varchar(45) DEFAULT NULL,
  Emergency_phone varchar(45) DEFAULT NULL
);

# Create the Patient Notes table
CREATE TABLE PatientNotes (
	# We can have multiple notes so we give each note a PNI (Patient Note ID)
	PNI INT UNIQUE PRIMARY KEY NOT NULL AUTO_INCREMENT,
    PID BIGINT UNSIGNED NOT NULL,
    FOREIGN KEY (PID) REFERENCES PatientInfo(PID),
    ProvID INT NOT NULL,
    NoteTime DATE,
    DiagnosisNotes VARCHAR(255),
    DrRecommendations VARCHAR(255),
    Treatment BINARY
);

# Create the Patient Records table
CREATE TABLE PatientRecords (
	# We can have multiple records so we give each a PRI (Patient Record ID)
	PRI INT UNIQUE PRIMARY KEY NOT NULL AUTO_INCREMENT,
    PID BIGINT UNSIGNED NOT NULL,
    FOREIGN KEY (PID) REFERENCES PatientInfo(PID),
	# PROV ID GOES HERE its an FK
	RecordTime DATE,
    Treatment VARCHAR(255),
    CostToIns INT,
    CostToPayment  INT,
    InsPayment INT,
    PatientPayment INT
);

#