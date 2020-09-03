# /bin/sh python3

'''
Title: random-id-gen.py
Description: This script will generate random identification numbers of length 20.
Usage: To be used in creating new patient identification numbers.
import documentation: 
   https://docs.python.org/3/library/random.html#module-random
   https://docs.python.org/3/library/argparse.html?highlight=argparse#module-argparse
'''

# imports
import random
import argparse

# main like in C/C++
if __name__ == "__main__":
    parser = argparse.ArgumentParser(description="random-id-gen.py")
    parser.add_argument("-a", type=int, required=True, dest="amount", help="number of ID's to generate")
    args = parser.parse_args()
    random.seed()

    # Print ID's
    for i in range (0, args.amount):
        # Must be a string to Zero Pad
        ran_ID = str(random.randint(0,1e20))
        # Print and Zero Pad if needed.
        print(ran_ID.zfill(20))