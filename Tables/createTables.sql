# Step 1. Create all the tables first
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
    CompanyID INT UNSIGNED UNIQUE DEFAULT NULL,
    AnnualPrem BIGINT,
    AnnualDeductible BIGINT,
    AnnualCoverageLimit BIGINT,
    LifetimeCoverage BIGINT,
    Network VARCHAR(255) UNIQUE
);

# Create the Insurance Providers table
CREATE TABLE IF NOT EXISTS InsProvider (
	CompanyID INT UNSIGNED UNIQUE PRIMARY KEY NOT NULL,
    Company VARCHAR(255),
    # This will reference InsPlans PlanID eventually
    PlanID INT UNSIGNED,
    Category VARCHAR(255),
	Address VARCHAR (255),
    Email VARCHAR (255),
    Phone VARCHAR (45)
);

#Create Coverage table
CREATE TABLE IF NOT EXISTS Coverage(
    PlanID INT UNSIGNED,
    CompanyID INT UNSIGNED,
    TreatmentCategory VARCHAR(255) UNIQUE
);

#Create Membership table
CREATE TABLE IF NOT EXISTS Membership(
    ProvID BIGINT UNSIGNED UNIQUE PRIMARY KEY NOT NULL,
    Network VARCHAR(255)
);

#Create InsCategories Table
CREATE TABLE IF NOT EXISTS InsCategories(
    CompanyID INT UNSIGNED,
    TreatmentCategory VARCHAR(255) UNIQUE,
    Subcategory VARCHAR(255)
);

#Create Costs Table
CREATE TABLE IF NOT EXISTS Costs(
    CompanyID INT UNSIGNED,
    Treament VARCHAR(255),
    AllowedCost BIGINT,
    InNetworkCoverage BIGINT,
    OutNetworkCoverage BIGINT,
    FullDeductible BIGINT
);

#Create Enrolled table
CREATE TABLE IF NOT EXISTS Enrolled(
    PlanID INT UNSIGNED,
    PID BIGINT UNSIGNED,
    CompanyID INT UNSIGNED
);

# Create the Patient Information Table
CREATE TABLE IF NOT EXISTS Users (
	UserID INT UNSIGNED PRIMARY KEY UNIQUE NOT NULL,
    PID BIGINT UNSIGNED UNIQUE,
    UserName VARCHAR(25) UNIQUE,
    UserPassword VARCHAR(25),
    IsEmployee BOOL
);

# Step 2 Add in constraints and such
ALTER TABLE Costs
  ADD CONSTRAINT FOREIGN KEY (CompanyID) REFERENCES InsProvider (CompanyID);

ALTER TABLE Coverage
  ADD CONSTRAINT FOREIGN KEY (CompanyID) REFERENCES InsProvider (CompanyID),
  ADD CONSTRAINT FOREIGN KEY (PlanID) REFERENCES InsPlans (PlanID);

ALTER TABLE Enrolled
  ADD CONSTRAINT FOREIGN KEY (CompanyID) REFERENCES InsProvider (CompanyID),
  ADD CONSTRAINT FOREIGN KEY (PlanID) REFERENCES InsPlans (PlanID),
  ADD CONSTRAINT FOREIGN KEY (PID) REFERENCES PatientInfo (PID);

ALTER TABLE InsCategories
  ADD CONSTRAINT FOREIGN KEY (CompanyID) REFERENCES InsProvider (CompanyID),
  ADD CONSTRAINT FOREIGN KEY (TreatmentCategory) REFERENCES Coverage (TreatmentCategory);

ALTER TABLE InsProvider
  ADD CONSTRAINT FOREIGN KEY (PlanID) REFERENCES InsPlans (PlanID),
  ADD CONSTRAINT FOREIGN KEY (CompanyID) REFERENCES InsPlans (CompanyID);

ALTER TABLE Membership
  ADD CONSTRAINT FOREIGN KEY (Network) REFERENCES Insplans (Network);

ALTER TABLE PatientNotes
  ADD CONSTRAINT FOREIGN KEY (PID) REFERENCES PatientInfo (PID);

ALTER TABLE PatientRecords
  ADD CONSTRAINT FOREIGN KEY (PID) REFERENCES PatientInfo (PID);

ALTER TABLE Users
  ADD CONSTRAINT FOREIGN KEY (PID) REFERENCES PatientInfo (PID);
 
 #  Step 3. Save your changes
COMMIT;