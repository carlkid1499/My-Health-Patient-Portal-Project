# Create the Patient Information Table
CREATE TABLE IF NOT EXISTS PatientInfo (
  PID BIGINT unsigned UNIQUE PRIMARY KEY NOT NULL,
  name_first VARCHAR(45) NOT NULL,
  name_last VARCHAR(45) NOT NULL,
  DOB DATE NOT NULL,
  Gender VARCHAR(10) DEFAULT NULL,
  address VARCHAR(200) NOT NULL,
  email VARCHAR(45) DEFAULT NULL,
  phone VARCHAR(45) NOT NULL,
  Emergency_name VARCHAR(45) DEFAULT NULL,
  Emergency_phone VARCHAR(45) DEFAULT NULL
);

# Create the Patient Notes table
CREATE TABLE IF NOT EXISTS PatientNotes (
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
CREATE TABLE IF NOT EXISTS PatientRecords (
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

#Create InsPlans table
CREATE TABLE IF NOT EXISTS InsPlans(
    PlanID INT UNSIGNED PRIMARY KEY,
    Company VARCHAR(255) UNIQUE,
    AnnualPrem BIGINT,
    AnnualDeductible BIGINT,
    AnnualCoverageLimit BIGINT,
    LifetimeCoverage BIGINT,
    Network VARCHAR(255) UNIQUE
);

# Create the Insurance Providers table
CREATE TABLE IF NOT EXISTS InsProvider (
	CompanyID INT UNSIGNED UNIQUE PRIMARY KEY NOT NULL,
    Company VARCHAR(255) UNIQUE,
    # This will reference InsPlans PlanID eventually
    PlanID INT UNSIGNED,
    FOREIGN KEY(PlanID) REFERENCES InsPlans(PlanID),
    Category VARCHAR(255),
	Address VARCHAR (255),
    Email VARCHAR (255),
    Phone VARCHAR (45)
);

#Create Coverage table
CREATE TABLE IF NOT EXISTS Coverage(
    PlanID INT UNSIGNED,
    Company VARCHAR(255) UNIQUE,
    TreatmentCategory VARCHAR(255) UNIQUE,
    FOREIGN KEY(PlanID) REFERENCES InsPlans(PlanID),
    FOREIGN KEY(Company) REFERENCES InsPlans(Company)
);

#Create Membership table
CREATE TABLE IF NOT EXISTS Membership(
    ProvID BIGINT UNSIGNED UNIQUE PRIMARY KEY NOT NULL,
    Network VARCHAR(255),
    FOREIGN KEY(Network) REFERENCES InsPlans(Network)
);

#Create InsCategories Table
CREATE TABLE IF NOT EXISTS InsCategories(
    Company VARCHAR(255),
    TreatmentCategory VARCHAR(255) UNIQUE,
    Subcategory VARCHAR(255),
    FOREIGN KEY(TreatmentCategory) REFERENCES Coverage(TreatmentCategory)
);

#Create Costs Table
CREATE TABLE IF NOT EXISTS Costs(
    Company VARCHAR(255) UNIQUE,
    Treament VARCHAR(255),
    AllowedCost BIGINT,
    InNetworkCoverage BIGINT,
    OutNetworkCoverage BIGINT,
    FullDeductible BIGINT,
    FOREIGN KEY(Company) REFERENCES InsPlans(Company)
);

#Create Enrolled table
CREATE TABLE IF NOT EXISTS Enrolled(
    PlanID INT UNSIGNED,
    PID BIGINT UNSIGNED,
    Company VARCHAR(255) UNIQUE,
    FOREIGN KEY(PlanID) REFERENCES InsPlans(PlanID),
    FOREIGN KEY(PID) REFERENCES PatientInfo(PID),
    FOREIGN KEY(Company) REFERENCES InsPlans(Company)
);

# Create the Patient Information Table
CREATE TABLE IF NOT EXISTS Users (
	UserID INT UNSIGNED PRIMARY KEY UNIQUE NOT NULL,
    PID BIGINT UNSIGNED UNIQUE,
    FOREIGN KEY(PID) REFERENCES PatientInfo(PID),
    UserName VARCHAR(25) UNIQUE,
    UserPassword VARCHAR(25),
    IsEmployee BOOL
);