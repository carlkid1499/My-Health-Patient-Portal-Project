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

# main like in C/C++
if __name__ == "__main__":
    parser = argparse.ArgumentParser(description="random-id-gen.py")
    parser.add_argument("-a", type=int, required=True,
                        dest="amount", help="number of ID's to generate")
    parser.add_argument("-id", default=False, action="store_true",
                        dest="id", help="Set if you need ID's generated")
    parser.add_argument("-b", default=False, action="store_true",
                        dest="birthday", help="Set if you need birthdays generated")
    parser.add_argument("-n", default=False, action="store_true",
                        dest="name", help="Set if you need names generated")
    parser.add_argument("-p", default=False, action="store_true",
                        dest="phone", help="Set if you need phone numbers generated")
    parser.add_argument("-c", default=False, action="store_true",
                        dest="company_name", help="Set if you need company names generated")
    parser.add_argument("-e", default=False, action="store_true",
                        dest="email", help="Set if you need emails generated")
    parser.add_argument("-patients", default=False, action="store_true",
                        dest="patients", help="Set if you need to insert into Patients table")
    parser.add_argument("-addr", default=False, action="store_true",
                        dest="address", help="Set if you need addresses generated")
    parser.add_argument("-host", type=str, required=False, default=None,
                        dest="host", help="Hostname for DB")
    parser.add_argument("-user", type=str, required=False, default=None,
                        dest="user", help="Username for DB")
    parser.add_argument("-pass", type=str, required=False, default=None,
                        dest="password", help="Password for DB")
    parser.add_argument("-db", type=str, required=False, default=None,
                        dest="database", help="Database to connect too")
    args = parser.parse_args()

    if args.host:
        # Connect to our MySQL server.
        mydb = mysql.connect(host=args.host, user=args.user,
                             password=args.password, database=args.database)
        mycursor = mydb.cursor()

    # SQL Statements for tables
    insert_patients = "INSERT INTO patients(PID, Name, Age, DOB, Address, PEmail, TelNo, EContactName, EContactPhone) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)"

    random.seed()
    fake = Faker()

    for i in range(0, args.amount):
        # Init variables to insert
        ran_ID = ""
        ran_DOB = ""
        ran_NAME = ""
        ran_ENAME = ""
        ran_PHONE = ""
        ran_EPHONE = ""
        ran_ADDRESS = ""
        ran_COMPANY_NAME = ""
        ran_EMAIL = ""
        ran_AGE = 0

        if args.id:
            # Print IDs
            # Must be a string to Zero Pad
            ran_ID = str(random.randint(0, 1e19))
            # Print and Zero Pad if needed.
            ran_ID = ran_ID.zfill(20)
            print(ran_ID)

        if args.birthday:
            # Print Birthdays
            ran_DOB = fake.date(pattern='%d-%m-%Y', end_datetime=None)
            print(ran_DOB)

        if args.name:
            # Print Names
            ran_NAME = fake.name()
            ran_ENAME = fake.name()
            print(ran_NAME)

        if args.phone:
            # Print Phone Numbers
            ran_PHONE = fake.phone_number()
            ran_EPHONE = fake.phone_number()
            print(ran_PHONE)

        if args.address:
            # Print Address
            ran_ADDRESS = fake.address()
            print(ran_ADDRESS)

        if args.company_name:
            # Print Company Names
            ran_COMPANY_NAME = fake.company()
            print(ran_COMPANY_NAME)

        if args.email:
            # Print Emails
            ran_EMAIL = fake.email()
            print(ran_EMAIL)

        if args.host and args.patients:
            # Insert data into Patients
            mycursor.execute(insert_patients,
                             (int(ran_ID),
                             ran_NAME,
                             ran_AGE,
                             ran_DOB,
                             ran_ADDRESS,
                             ran_EMAIL,
                             ran_PHONE,
                             ran_ENAME,
                             ran_EPHONE))
            
    if args.host:
        mydb.commit()
        mydb.close()
