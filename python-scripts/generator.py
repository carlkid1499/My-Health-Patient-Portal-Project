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
from faker.providers.date_time import date
from faker.providers import phone_number
from faker.providers import address

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
        # Connect to our MySQL server
        mydb = mysql.connect(host=args.host, user=args.user,
                             password=args.password, database=args.database)
        mycursor = mydb.cursor()
        # Create the able if it alrady doesn't exist
        mycursor.execute(
            """CREATE TABLE IF NOT EXISTS patInfo(
                id INT AUTO_INCREMENT UNIQUE PRIMARY KEY, 
                pID VARCHAR(255) UNIQUE, 
                name VARCHAR(255),
                phone VARCHAR(255),
                DOB VARCHAR(255)),
                address VARCHAR(255)""")

    random.seed()
    fake = Faker()

    for i in range(0, args.amount):
        ran_ID = ""
        ran_DOB = ""
        ran_NAME = ""
        ran_PHONE = ""
        ran_ADDRESS = ""
        ran_COMPANY_NAME = ""

        if args.id:
            # Print IDs
            # Must be a string to Zero Pad
            ran_ID = str(random.randint(0, 1e20))
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
            print(ran_NAME)

        if args.host:
            # Insert data into table
            mycursor.execute("""INSERT INTO patInfo(pID, name, phone, DOB, address) 
                                VALUES (%s, %s, %s, %s, %s)""",
                             (ran_ID, ran_NAME, ran_PHONE, ran_DOB, ran_ADDRESS))
            mydb.commit()

        if args.phone:
            # Print Phone Numbers
            ran_PHONE = fake.phone_number()
            print(ran_PHONE)

        if args.address:
            # Print Address
            ran_ADDRESS = fake.address()
            print(ran_ADDRESS)

        if args.company_name:
            # Print Company Names
            ran_COMPANY_NAME = fake.company()
            print(ran_COMPANY_NAME)

    if args.host:
        mydb.close()
