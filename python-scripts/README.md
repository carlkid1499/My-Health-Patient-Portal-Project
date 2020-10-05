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

-a amount of records to generate
-v for verbose output
-patients to insert into the patient table
-host host address for a MySQL instance
-user user name for MySQL instance
-pass password for the MySQL instnace
-db database for MySQL instance

### Usage

The following example will generate 10 items and insert them into the patients table.

``` python
pyton3 generator.py -a 10 -patients -host localhost -user root -pass 1234 -db testDB
```
