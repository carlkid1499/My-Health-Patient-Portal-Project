# /bin/sh python3

'''
Title: generator.py
Description: This script will generate random data we need for testing purposes
Usage: To be used in creating new patient identification numbers, DOB's, and names.
import documentation: random - https://docs.python.org/3/library/random.html#module-random
argparse - https://docs.python.org/3/library/argparse.html?highlight=argparse#module-argparse
faker - https://faker.readthedocs.io/en/master/index.html
'''

# imports
import mysql.connector as mysql
import random
import argparse
from faker import Faker
from dateutil.relativedelta import relativedelta
import datetime as date

# main like in C/C++
if __name__ == "__main__":
    parser = argparse.ArgumentParser(description="random-id-gen.py")
    parser.add_argument("-a", type=int, required=True,
                        dest="amount", help="number of ID's to generate")
    parser.add_argument("-v", default=False, action="store_true",
                        dest="verbose", help="verbose output flag")
    parser.add_argument("-patients", default=False, action="store_true",
                        dest="patients", help="Set if you need to insert into  Patients table")
    parser.add_argument("-provider", default=False, action="store_true",
                        dest="provider", help="Set if you need to insert into Insurance Provider table")
    parser.add_argument("-plans", default=False, action="store_true",
                        dest="plans", help="Set if you need to insert into InsPlans table")
    parser.add_argument("-precs", default=False, action="store_true",
                        dest="patient_records", help="Set if you need to insert into the PatientRecords table")
    parser.add_argument("-host", type=str, required=False, default=None,
                        dest="host", help="Hostname for DB")
    parser.add_argument("-port", type=int, required=False, default=None,
                        dest="port", help="Port number for DB")
    parser.add_argument("-user", type=str, required=False, default=None,
                        dest="user", help="Username for DB")
    parser.add_argument("-pass", type=str, required=False, default=None,
                        dest="password", help="Password for DB")
    parser.add_argument("-db", type=str, required=False, default=None,
                        dest="database", help="Database to connect too")
    args = parser.parse_args()

    if args.host:
        # Connect to our MySQL server.
        mydb = mysql.connect(host=args.host, port=args.port, user=args.user,
                             password=args.password, database=args.database)

        # Any query results will be returned as a named dictionary
        mycursor = mydb.cursor(dictionary=True)

    # SQL Statements for tables
    insert_patients = """INSERT INTO PatientInfo(PID, name_first, name_last, DOB, gender, address, email, phone, Emergency_name, Emergency_phone) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"""
    insert_insprovider = """INSERT INTO InsProvider(CompanyID, Company, PlanID, Category, Address, Email, Phone) VALUES (%s, %s, %s, %s, %s, %s, %s)"""
    insert_insplans = """Update myhealth2.InsPlans SET AnnualPrem=%s, AnnualDeductible=%s, AnnualCoverageLimit=%s, LifetimeCoverage=%s WHERE InsPlans.PlanID=%s"""
    insert_patientrecords = """INSERT INTO PatientRecords(PID, RecordTime, TCatID, CostToIns, CostToPatient, InsPayment, PatientPayment) VALUES (%s, %s, %s, %s, %s, %s, %s)"""

    # Start the Faker instance
    random.seed()
    fake = Faker()

    for i in range(0, args.amount):
        try:

            # Insert data into Patients
            if args.patients:

                # Let's generate all the data first
                # Must be a string to Zero Pad, 9223372036854775807 is bigint unsided MySQL max value
                ran_ID = str(random.randint(0, 9223372036854775807))
                # Print and Zero Pad if needed.
                ran_ID = ran_ID.zfill(20)
                # Birthdays. Lets make them in MySQL format
                ran_DOB = fake.date(pattern='%Y-%m-%d', end_datetime=None)
                # Calculate the Age
                today = date.datetime.today()
                age = relativedelta(
                    today, date.datetime.strptime(ran_DOB, "%Y-%m-%d"))
                ran_AGE = age.years
                if i % 2 == 0:
                    ran_FNAME = fake.first_name_male()
                    ran_LNAME = fake.last_name_male()
                    ran_GENDER = "male"
                else:
                    ran_FNAME = fake.first_name_female()
                    ran_LNAME = fake.last_name_female()
                    ran_GENDER = "female"

                ran_ENAME = fake.name()
                ran_PHONE = fake.phone_number()
                ran_EPHONE = fake.phone_number()
                ran_ADDRESS = fake.address()
                ran_EMAIL = fake.email()

                if args.verbose:
                    print(ran_ID)
                    print(ran_DOB)
                    print(ran_AGE)
                    print(ran_FNAME)
                    print(ran_LNAME)
                    print(ran_GENDER)
                    print(ran_PHONE)
                    print(ran_ADDRESS)
                    print(ran_EMAIL)

                # Check to make sure the connection stuff is present
                if args.host and args.port and args.user and args.password and args.database:
                    mycursor.execute(insert_patients,
                                     (int(ran_ID),
                                         ran_FNAME,
                                         ran_LNAME,
                                         ran_DOB,
                                         ran_GENDER,
                                         ran_ADDRESS,
                                         ran_EMAIL,
                                         ran_PHONE,
                                         ran_ENAME,
                                         ran_EPHONE))
                    mydb.commit()

                else:
                    print(
                        "Error Inserting into PatientInfo: One of hostname, username, password, database name, or patients flag is missing!")
                    break

            # Insert into the Insurance Provider table
            elif args.provider:

                # Generate the Data first
                ran_CompanyID = random.randint(1, 4294967295)
                ran_PlanID = random.randint(1, 4294967295)
                ran_CompanyPhone = fake.phone_number()
                ran_CompanyAddress = fake.address()
                ran_CompanyName = fake.company()
                ran_CompanyEmail = fake.company_email()
                # This is a list of different types of health insurance https://www.webmd.com/health-insurance/types-of-health-insurance-plans#1
                cat_list = ['HMO', 'PPO', 'EPO', 'POS', 'HDHP', 'HSA']
                ran_Category = fake.word(ext_word_list=cat_list)

                if args.verbose:
                    print(ran_CompanyID)
                    print(ran_CompanyName)
                    print(ran_PlanID)
                    print(ran_Category)
                    print(ran_CompanyAddress)
                    print(ran_CompanyEmail)
                    print(ran_CompanyPhone)

                # Check to make sure the connection stuff is present
                if args.host and args.port and args.user and args.password and args.database:

                    mycursor.execute(insert_insprovider,
                                     (ran_CompanyID,
                                         ran_CompanyName,
                                         ran_PlanID,
                                         ran_Category,
                                         ran_CompanyAddress,
                                         ran_CompanyEmail,
                                         ran_CompanyPhone))
                    mydb.commit()
            # Insert into the Plans table
            elif args.plans:
                ''' Please note that upto this point we have already generated PlanID's and CompanyID's in 
                the "elif args.provider:" condition. Therefore we don't need to generate those again.
                Instead all we need to generate are: AnnualPrem, AnnualDeductible, AnnualCoverageLimit, 
                LifetimeCoverage and Network for the InsPlans table.
                '''

                # First grab all CompanyID's and PlanID's and insert into InsPlans table
                sqlquery1 = """INSERT INTO InsPlans(PlanID,CompanyID) SELECT CompanyID,PlanID FROM InsProvider"""
                mycursor.execute(sqlquery1)

                # First grab all the PlanID's from the InsProvider table.
                sqlquery2 = """SELECT PlanID FROM InsPlans"""

                mycursor.execute(sqlquery2)
                results = mycursor.fetchall()

                # Check the results
                if results:
                    for row in results:
                        # AnnualPrem, AnnualDeductible, AnnualCoverageLimit, LifetimeCoverage
                        ran_AnnualPrem = random.randint(2500, 15000)
                        ran_AnnualDeductible = random.randint(1000, 10000)
                        ran_CoverageLimit = random.randint(25000, 150000)
                        ran_LifetimeCoverage = random.randint(5e5, 2e6)

                        if args.verbose:
                            print("ran_AnnualPrem", ran_AnnualPrem)
                            print("ran_AnnualDeductible", ran_AnnualDeductible)
                            print("ran_CoverageLimit", ran_CoverageLimit)
                            print("ran_LifetimeCoverage", ran_LifetimeCoverage)
                            print(row['PlanID'])

                        # Insert into  InsPlans table
                        mycursor.execute(insert_insplans, (ran_AnnualPrem, ran_AnnualDeductible,
                                                           ran_CoverageLimit, ran_LifetimeCoverage,
                                                           row["PlanID"]
                                                           ))
                        mydb.commit()
                else:
                    print("Error: No CompanyID, PlanID found in InsProvider")
                    print("Please insert into Provider table first!")

            # Are we inserting into Patient Records
            elif args.patient_records:
                ''' Please note that PID and Treatment have been aleady generated '''

                # PID, RecordTime, TCatID, CostToIns, CostToPatient, InsPayment, PatientPayment

                # First we get a current list of PID's and TCatID's
                sqlquery1 = """SELECT PID,DOB FROM PatientInfo"""
                mycursor.execute(sqlquery1)
                resultsq1 = mycursor.fetchall()

                # Now we get a current list of TCatID's from TreatmentCategory
                sqlquery2 = """SELECT TCatID FROM TreatmentCategory"""
                mycursor.execute(sqlquery2)
                resultsq2 = mycursor.fetchall()

                for row in resultsq1:
                    # Generate random RecordTime, CostToIns, CostToPatient, InsPayment, PatientPayment
                    
                    # Calculate a random RecordTime
                    today = date.datetime.today()
                    DOB = date.datetime.strptime(str(row["DOB"]), "%Y-%m-%d")                  
                    rtimedelta = relativedelta(
                        today, DOB)
                    # We add 2 in case any rtimedelta values are 0
                    ran_days = random.randint(1,rtimedelta.years*365 + rtimedelta.days + 2)
                    ran_seconds = random.randint(1,rtimedelta.seconds + 2)
                    ran_minutes = random.randint(1,rtimedelta.minutes + 2)
                    ran_hours = random.randint(1,rtimedelta.hours + 2)
                    timedelta = date.timedelta(days=ran_days, seconds=ran_seconds, minutes=ran_minutes, hours=ran_hours)
            
                    # datetime object: year, month, day, hour, minute, seconds
                    ran_recordtime = DOB + timedelta
                    ran_costtoins = random.randint(10,10000)
                    ran_costtopatient = random.randint(1,ran_costtoins)
                    ran_inspayment = ran_costtoins - ran_costtopatient
                    ran_patientpayment = random.randint(1,ran_costtopatient)
                    ran_tcatid = random.randint(2,len(resultsq2))

                    if args.verbose:
                        print("ran_recordtime", ran_recordtime)
                        print("ran_costtoins", ran_costtoins)
                        print("ran_costtopatient", ran_costtopatient)
                        print("ran_inspayment", ran_inspayment)
                        print("ran_patientpayment", ran_patientpayment)
                        print("ran_tcatid", ran_tcatid)

                    # Check to make sure the connection stuff is present
                    if args.host and args.port and args.user and args.password and args.database:
                        mycursor.execute(insert_patientrecords,
                                     (row['PID'], ran_recordtime, ran_tcatid, ran_costtoins, ran_costtopatient, ran_inspayment, ran_patientpayment))
                        mydb.commit()

        except KeyboardInterrupt:
            mydb.commit()
            mydb.close()
