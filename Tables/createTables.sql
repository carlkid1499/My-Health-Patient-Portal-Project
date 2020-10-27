# Create the Patient Information Table
CREATE TABLE PatientInfo (
  PID BIGINT  unsigned UNIQUE PRIMARY KEY NOT NULL,
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

# Create the Insurance Providers table
CREATE TABLE IF NOT EXISTS InsProvier (
	CompanyID INT UNSIGNED UNIQUE PRIMARY KEY NOT NULL,
    Company VARCHAR(255),
    # This will reference InsPlans PlanID eventually
    PlanID INT UNSIGNED,
    Category VARCHAR(255),
	Address VARCHAR (255),
    Email VARCHAR (255),
    Phone VARCHAR (45)
);

#Create Enrolled table
CREATE TABLE Enrolled(
    PlanID INT UNSIGNED,
    PID BIGINT UNSIGNED NOT NULL,
    Company VARCHAR(255),
    FOREIGN KEY(PlanID) REFERENCES InsPlans,
    FOREIGN KEY(PID) REFERENCES PatientInfo,
    FOREIGN KEY(Company) REFERENCES InsPlans
);

#Create InsPlans table
CREATE TABLE InsPlans(
    PlanID INT UNSIGNED,
    Company VARCHAR(255),
    AnnualPrem BIGINT,
    AnnualDeductible BIGINT,
    AnnualCoverageLimit BIGINT,
    LifetimeCoverage BIGINT,
    Network VARCHAR(255),
    PRIMARY KEY(PlanID)
);

#Create Coverage table
CREATE TABLE Coverage(
    PlanID INT UNSIGNED,
    Company VARCHAR(255),
    TreatmentCategory VARCHAR(255),
    FOREIGN KEY(PlanID) REFERENCES InsPlans,
    FOREIGN KEY(Company) REFERENCES InsPlans
);

#Create Membership table
CREATE TABLE Membership(
    ProvID BIGINT UNSIGNED UNIQUE PRIMARY KEY NOT NULL,
    Network VARCHAR(255),
    FOREIGN KEY(Network) REFERENCES InsPlans
);

#Create InsCategories Table
CREATE TABLE InsCategories(
    Company VARCHAR(255),
    TreatmentCategory VARCHAR(255),
    Subcategory VARCHAR(255),
    FOREIGN KEY(TreatmentCategory) REFERENCES Coverage
);

#Create Costs Table
CREATE TABLE Costs(
    Company VARCHAR(255),
    Treament VARCHAR(255),
    AllowedCost BIGINT,
    InNetworkCoverage BIGINT,
    OutNetworkCoverage BIGINT,
    FullDeductible BIGINT,
    FOREIGN KEY(Company) REFERENCES InsPlans
);