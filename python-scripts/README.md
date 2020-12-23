# Python Scripts

This is a place for all python scripts developed for this project.
It will mostly house data generation scripts or other python utilties we
as a team come up with. Documentation will be added as needed.

## Generator.py

The sole purpose of this script is to generate random data geared towards our project.
This script can easily be modifed to adapt to changing needs.
The generator script uses the python Faker package. The documentation link
is: <https://faker.readthedocs.io/en/master/> .

### Command Line Parameters

-a how many items do we want to generate
-v verbose/detailed script output
-patients insert into the PatientInfo table
-provider inserts into the InsProvider table
-plans insert into the InsPlans table
-precs insert into the PatientRecords table
-pnotes insert into the PatientNotes table
-hprovider insert into the HealthProvider table
-membership insert into the Membership table
-costs insert into the Costs table
-coverage insert into the Coverage table
-enrolled insert into the enrolled table
-host the hostname for the MySQL DB instance
-port the port number for the MySQL DB instance
-user the user for the MySQL DB instance
-pass the password for the MySQL DB instance
-db The database name for the MySQL DB instance

### Usage

The following example will generate 10 items and insert them into the patients table.

``` python
pyton3 generator.py -a 10 -patients -host localhost -port 3306 -user root -pass 1234 -db testDB
```
