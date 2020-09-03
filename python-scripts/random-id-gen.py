# /bin/sh python3

'''
Title: random-id-gen.py
Description: This script will generate random identification numbers of length 20.
Usage: To be used in creating new patient identification numbers.
'''

# imports
import random

print(random.randint(0,1e20))