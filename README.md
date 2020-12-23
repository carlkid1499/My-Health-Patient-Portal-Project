# My Health Patient Portal UI &#39;20, Aug-December 2020, Santos, Lawson

## My Health Patient Portal (MHPP)∗

| Carlos SantosDepartment of Computer EngineeringUniversity of Idaho, USAPort3116@vandals.uidaho.edu | Keller LawsonDepartment of Computer ScienceUniversity of Idaho, USALaws1689@vandals.uidaho.edu |
| --- | --- |
|
 |
 |

## ABSTRACT

SQL is a formal relational database management language. In this document, we focus on the creation of a My Health Patient Portal project given to us in CS360 (Database Management) at the University of Idaho. The project goal was to design a system from the ground up that uses MySQL as the backbone, a front-end web system, and a middle-end system to query the MySQL database.

## MHPP CONCEPTS

• MySQL; Web-Based _Graphical user interface (GUI); RDMS -\&gt; Relation Database Management System_; Faker Data Generation Tool

## KEYWORDS

SQL; PHP; MySQL; JavaScript; HTML; Database; Faker; Python;

## 1 INTRODUCTION

The scope of this paper is to describe the major components of our My Health Patient Portal. From here on out MHPP will refer to My Health Patient Portal. The MHPP project has three major pieces to it. The front end or what is referred to as the user interface. This is talked about in section 3. It also has a back end or typically referred to as the RDMS which stands for Relation Database Management System. The RDMS is mentioned in section 1.1, 2, and 5. Finally, we have a third component which is test data generation in section 4.

  1.
### RDMS using MySQL

For our RDMS, we are using MySQL to host our main schema myhealth2 which contains all of our tables. MySQL is one of the most popular open-source SQL databases and because of this has a lot of forum and community support to assist us when creating our database. While MySQL can lack in speed when scaled to massive databases, it was the proper choice to support our project in its current state.

### 1.2 Tools used in Development

To aid in the development of this project, many tools were utilized for each team member. Most of these tools required us to create a settings file that allowed the team to have matching settings, so errors were not present when branching and reviewing other&#39;s code. The tools used in our development were Visual Studio Code (VS code), phpMyAdmin, MySQL Workbench, Github and Github Desktop, Discord, Zoom, and FileZilla. VS Code was our main tool for writing and reviewing code. We had installed the PHP and HTML extensions that enabled the code we wrote to be automatically checked for errors and made debugging easier. We used both phpMyAdmin and MySQL Workbench to create and run scripts that filled our database with the fake data created from our Faker Python script. These two programs allowed us to quickly access our databases between our live database and our local database to sync them resulting in both databases having the same records for testing. To manage our code, we chose to use Github for our code repository and opted to use Github Desktop instead of a command prompt for pulling and pushing code to the repository. Using Github allowed us to create a project and then create issues and branches for our code for development. This was our most important tool since it allowed us to run experimental code we had been developing on a safe branch without affecting the live(master) branch. We also were able to create tickets for the project and assign different tasks to our team and then create pull requests when a feature or bug fix had been finished, allowing for a different team member to review the code and then merge it to our master branch. Managing team communications and meetings were done through Discord and Zoom. We would regularly post references, meeting times, and questions in Discord under different channels which allowed us to be able to refer to them at later dates. Most of our team meetings and group work sessions were on Zoom since it had better audio and video reliability than Discord did. Transferring files from the master branch of our code to our live server was done via file transfer protocol (FTP) using FileZilla. We had a unique login to the server that granted us access to the files so that we could copy our files to the live web page.

### 1.3 Languages used in Development

To create this project, we chose to use PHP, HTML, MySQL, Python3 as our main programming languages. JavaScript (JS) and Cascading Style Sheets (CSS) were used alongside PHP and HTML. With having to access a database many times and then display the returned results on a web page, the obvious choice was to use MySQL along with PHP. PHP allowed us to easily make a connection to the MySQL database and query it for information that we need. Since we were using PHP, using HTML inside a PHP page is as simple as declaring the document type as HTML. One of the biggest issues we ran into was having to learn the correct syntax for both PHP and HTML. Especially when we were using both inside one statement. No one on the team had used both languages together before so there was a learning curve to researching the specific syntax of each language and how to mix them properly. The JS and CSS were used alongside the HTML code to style and create effects for certain functions. We used the JS to allow windows to be shown &quot;inside&quot; our webpage without having to redirect to another page. CSS was used in a couple of ways: 1) inline CSS was added to specific elements of code that we did not want to have universal changes for. 2) CSS stylesheets were created to change the entire elements of a webpage so that there would be a universal theme across webpages.

## 2 MYHEALTH2 DATABASE

The core functionality is baked into the _myhealth2_ database schema. This schema consists of fourteen different tables. Those tables will be discussed in this section. Each table has some between the other tables. The _myhealth2_ schema was created from the MHPP requirements. [14]

### 2.1 Appointments Table

![](RackMultipart20201223-4-1k5pyf6_html_459c9f38f5c7379.png)

_Figure 1: Appointments Table_

From figure 1 the _Appointments_ table has five columns defined. The _PID_ column is for the patients&#39; unique max 20-digit ID number. The _Date_ column is for the date of the appointment and likewise, the column _Time_ is for the appointments time. A key thing to note here is that the _Time_ and _Date_ fields are unique meaning a patient cannot create an appointment with the same time and date twice.

### 2.2 Costs Table

![](RackMultipart20201223-4-1k5pyf6_html_f7e1c5f4f94704ee.png)

_Figure 2: Costs Table_

In figure 2 the _Costs_ table has six columns. First, the _CompanyID_ column has a unique ID associated with an insurance provider in the _InsProvider_ table. _TCatID_ points to a unique treatment category reference in the _TreatmentCategory_ table. The next four columns describe the typical costs associated with insurance companies. It is safe to say that their names describe their usage.

### 2.3 Coverage Table

![](RackMultipart20201223-4-1k5pyf6_html_17b28b0167b4a1af.png)

_Figure 3: Coverage Table_

This table contains a list of IDs that correspond to the following things. _PlanID_ references a plan inside the _InsPlans_ table. Meanwhile, the _CompanyID_ references an insurance provider in the _InsProvider_ table. Lastly, _TCatID_ references a treatment category in the _TreatmentCategory_ table.

### 2.4 Enrolled Table

![](RackMultipart20201223-4-1k5pyf6_html_fe23d5f187487b9e.png)

_Figure 4: Enrolled Table_

The enrolled table consists of 3 columns that reference 3 different IDs. If a patient ID (_PID_) is in this table then the patient is enrolled in an insurance plan. _PlanID_ references a plan inside the _InsPlans_ table and _CompanyID_ references an insurance provider in the _InsProvider_ table.

### 2.5 HealthProvider Table

![](RackMultipart20201223-4-1k5pyf6_html_cda4be01139d4d45.png)

_Figure 5: HealthProvider Table_

This table has all health provider information. Each health provider gets assigned a unique auto-increment value called, _ProvID_. The health provider name gets put under _ProvName_ and its&#39; address in _ProvAddr_.

### 2.6 InsPlans Table

![](RackMultipart20201223-4-1k5pyf6_html_33b855c3ee6a7b35.png)

_Figure 6: InsPlans Table_

_InsPlans_ houses information pertaining to an insurance plan. Like most tables, each insurance plan gets assigned a unique _PlanID_. The _CompanyID_ points to an insurance provider in the _InsProvider_ table. _Network_ is the name of the network the plan belongs to. An ID for the network can be looked up inside the _Network_ table. Lastly, the last four columns all contain information related to insurance plans. It is safe to assume that the titles describe their contents.

### 2.7 InsProvider Table

![](RackMultipart20201223-4-1k5pyf6_html_84f6dac3fcf18315.png)

_Figure 7: InsProvider Table_

This table was designed to hold all information someone would need to know about an insurance provider. _PlanID_ is a reference to the _InsPlans table. Each company gets a unique CompanyID_ and a field for its name, _Company._ Moving forward _Category_ is a field for the different types of insurance that exist. The rest of the fields _Address, Email,_ and _Phone._

### 2.8 Membership Table

![](RackMultipart20201223-4-1k5pyf6_html_5a702aa29e8249b0.png)

_Figure 8: Membership Table_

If a health provider ID (_ProvID)_ is in this table then they belong to a network with the given _NetworkID_. _ProvID_ is a reference to the _HealthProvider_ table and _NetworkID_ is a reference to the _Network_ table.

### 2.9 Network Table

![](RackMultipart20201223-4-1k5pyf6_html_bbd7ae28c0d984cc.png)

_Figure 9: Network Table_

Here every network gets assigned a unique ID called _NetworkID._ The _NetworkName_ is the name of the network. A network is a collection of health providers that all accept similar insurance plans.

### 2.10 PatientInfo Table

![](RackMultipart20201223-4-1k5pyf6_html_48a0385500b65a7e.png)

_Figure 10: PatientInfo Table_

The _PatientInfo_ table holds all information about patients and users of the system. Each patient gets assigned a unique _PID_ that is used to index into this table. The rest of the fields contain pertinent information about each patient.

### 2.11 PatientNotes Table

![](RackMultipart20201223-4-1k5pyf6_html_86c20d7f02037a4b.png)

_Figure 11: PatientNotes Table_

This table stores all the doctors&#39; notes and relative information to identify who the note is about. The _PID_ references the _PatientInfo_ table. _ProvID_ references the _HealthProvider_ table. _NoteTime_ is a DateTime field that has the creation time for the note. _Treatment_ is a binary field that indicates if a patient received treatment. Lastly, _DiagnosisNotes_ and Dr_Recommendations_ are fields where a doctor can input information about prescriptions, treatment, or just notes for future reference.

### 2.12 PatientRecords Table

![](RackMultipart20201223-4-1k5pyf6_html_5030b18b911cfc3.png)

_Figure 12: PatientRecords Table_

This table holds financial information about a patient visit. _PID_ reference the _PatientInfo_ table. Each record gets a unique autoincrement ID called _PRI_. _RecordTime_ is a DateTime field that should also match _NoteTime_ in the _PatientNotes_ table. _TCatID_ points to a category in the _TreatmentCategory_ table. In short, the remainder fields hold monetary values with the following meanings:

1. _CostToIns_: how much the insurance company was charged
2. _CostToPatient_: how much the insurance company charged the patient.
3. _InsPayment_: how much the insurance company paid.
4. _PatientPayment_: how much the patient needs to pay.

Please note since these values were randomly generated there may be inconsistencies in the data. Typically speaking, _CostToIns – CostToPatient_ = _InsPayment_ and _CostToPatient – PatientPayment_ is what the patient still owes.

### 2.13 TreatmentCategory Table

![](RackMultipart20201223-4-1k5pyf6_html_66372afea174ad5d.png)

_Figure 13: TreatmentCategory Table_

This table holds all the possible treatment categories with a unique autoincrement ID called, _TCatID. TreatmentCategory_ is the name for a treatment type. The treatment categories were grab of off [15].

### 2.14 Users Table

![](RackMultipart20201223-4-1k5pyf6_html_469466346915dff5.png)

_Figure 14: Users Table_

Finally, the _Users_ table. This table is how the login page authentication works. Each user is assigned a unique random _UserID_ and with that _PID_ references the _PatientInfo_ table. _Username_ is the login name for a user. _Password_ is a users&#39; password. Lastly, _EmployeeType_ is a tiny int value that distinguishes what type of user a _UserID_ is. 0 is patient, 1 is doctor or nurse, and 2 is a pharmacist.

## 3 MHPP USER INTERFACE

The My Health Patient Portal user interface was created by using a wider variety of languages. The primary language used was PHP. PHP was used for querying the database and populating information tables. For visuals, we used a combination of CSS and HTML. We also used some JavaScript (JS) to create what are called _modals._ A modal is what pops up when a user first logs in or uses various forms across the site. Some of those forms are the Create Account, Update Information, View Records, and Make Appointment. The user interface is separated into three major components. Those components are the Patient Portal, HealthCare Worker Portal, and the Pharmacy Portal.

### 3.1 MHPP Landing Page

Upon navigating to the webpage that hosts MHPP, users are directed to the landing page. The landing page consists of a simple blue and grey theme universal to all the webpages inside the site with a home button at the top right and two large buttons in the middle of the page allowing the user to select which will allow them to either login or create an account. If the user does not have an account but has received their patient identification number (PID) from their healthcare provider, then they can create an account. When they click the _Create Account_ button, the following form will appear:

![](RackMultipart20201223-4-1k5pyf6_html_4fb4da4f25d186a4.png)

_Figure 15: Create Account Form_

Every field in the form is set to be required and will not allow the user to submit the form until there is data in every field. After the user clicks the submit button, the following process will execute:

1. An if statement will check if the two password fields are the same. If they are the same, then the process will continue. If not, the process will produce an error and stop.
2. After password verification, we query the database and check the PatientInfo table to make sure the PID, first name and last name provided match the records. If a result is returned that is not null, we proceed.
3. The next process to execute will assign a random unique use rid. We then query the database again to insert the user ID, PID, username, password, and account type into the Users table.
4. If these queries all succeed, the page will be refreshed, and a new user will be added. If not, there will be an error that is presented at the bottom of the page.

If the user has already created an account, then they can log in to their account by clicking the login button. This button displays a form with two fields asking for their username and password. Upon clicking submit, the following process is executed.

1. Connect to the database and query the table Users for the username and password entered. If the number of rows is greater than 0, then proceed.
2. Next, session variables are fetched that will stay set and accessible across all portal pages.
3. After the variables are set, a switch statement checks the account type and then directs the user to the proper portal page (Patient, Healthcare worker, or Pharmacy).

### 3.2 MHPP Healthcare Worker Portal

If the user that logged in had an EmployeeType of 1, then their account was set to be a healthcare worker account and they are directed to the Healthcare Worker Portal.

![](RackMultipart20201223-4-1k5pyf6_html_78f831f0c5aebd6f.png)

_Figure 16: Healthcare Worker Portal Search Page_

_Figure 17: Patient Search Results_

This portal allows the user that logged in as a healthcare worker to search for patients from the three methods shown in figure 16. We used a switch case to generate three different pathways for the search to execute depending on which search parameter is selected. After the user inputs the search criteria and executes the search, a table containing the patient info as well as a table containing any appointments the patient has is displayed. Below the tables are 4 buttons that allow the user to update the patients&#39; info, view their records, make an appointment, or make a note in the patient&#39;s record. Each button is linked to a modal ![](RackMultipart20201223-4-1k5pyf6_html_b85203a9138199c5.png)inside the PHP code that will display a window containing either a form or a table displaying the pertinent information. Since a healthcare worker is considered a privileged user, they can update any information of the patient including their name, date of birth, and gender which the patient portal does not allow. When a doctor wants to make a note to add to the patient&#39;s record, he presented with the form in figure 18.

![](RackMultipart20201223-4-1k5pyf6_html_87b26da73b958b6e.png)

_Figure 18: Make Note Form_

The fields for the patient are prefilled for the doctor and disabled so that the information is not accidentally changed resulting in a note that is not linked to the patient. Refer to section 5 for a detailed structure of the queries used.

### 3.3 MHPP Patient Portal

If a user logs in and has an _EmployeeType_ of 0 then the user is considered a patient. The patient will then be redirected to the patient portal page. Figure 19 shows the patient portal landing page. Please note that all queries and their functionality will be described in section 5 of this document.

![](RackMultipart20201223-4-1k5pyf6_html_4af65f94fd9ce3fc.png)

_Figure 19: Patient Portal Landing Page_

Once the patient gets redirect the patient will see any upcoming appointments and the patient information on file. In figure 20 _Carlos Kelly_ can update his information by hitting the _update information_ button which will bring up the form also shown in figure 20.

![](RackMultipart20201223-4-1k5pyf6_html_e2dc628d061744c4.png)

_Figure 20: Update Information Form_

At first glance notice how the patients&#39; name, date of birth, and gender fields are greyed out. This is because a patient should not be able to change that information unless they provide proof via state ID, marriage license, or any other valid ID forms to their health provider. The patient can also hit the _view records_ button to see a list of patient records associated with the patient. In this case _Carlos Kelly_. Refer to figure 21 for an example of _Carlos Kelly&#39;s&#39;_ records.

![](RackMultipart20201223-4-1k5pyf6_html_34bad09a0b66f27.png)

_Figure 21: Patient Records for Carlos Kelly_

Another action a user takes is the ability to create appointments via the _Make Appointment_ button. The action of hitting the button brings up the form shown in figure 22.

![](RackMultipart20201223-4-1k5pyf6_html_e1c4526e984dff15.png)

_Figure 22: Make Appointment Form_

In this form, the patient can select a date and time for an appointment. The patient can also input a text description of the reason. Once again, the patient can take another action and this time it is viewing their billing information. If the patient hits the _View Billing_ button, they will see the following figure #.

![](RackMultipart20201223-4-1k5pyf6_html_9205f6cde2fd4fbf.png)

_Figure 23: Patient Billing Information_

Now if the user wishes to their insurance info a patient can hit the _Insurance Plans_ an _In-Network Health Providers_ navigation buttons in the upper left-hand corner. Suppose the patient does not have insurance then in this case _Carlos Kelly_ can enroll in an insurance plan via the _Insurance Plans_ navigation buttons. _Carlos Kelly_ will see the following figure #.

![](RackMultipart20201223-4-1k5pyf6_html_ac717ed0587a8b50.png)

_Figure 24: Patient Portal No Insurance Page_

The patient can select a state and a list of insurance plan providers will be listed on the screen. Refer to figure 25 for a detailed view.

![](RackMultipart20201223-4-1k5pyf6_html_a47372ea2b46d6e5.png)

_Figure 25: Insurance Shopping_

From here the patient can select one or more plans to compare then. Once the patient is ready, they can hit the _Compare Providers_ button. Upon hitting the button, the patient will be shown a comparison of plans from which they can then enroll.

![](RackMultipart20201223-4-1k5pyf6_html_c2bc692cacc946a0.png)

_Figure 26: Insurance Shopping Compare Providers_

As seen in figure 26 the patient in this case _Carlos Kelly_ can either enroll right away into a plan by pressing the _enroll_ button. Or he can see a list of In-Network health providers for the plan by pressing the corresponding network button. If _Carlos Kelly_ decides to press the _network_ button the page will look like figure 27.

![](RackMultipart20201223-4-1k5pyf6_html_79490c29f49d0f40.png)

_Figure 27: Health Provider Network Page_

Lastly, if the patient decides this is the plan they want after hitting the _Enroll_ button the patient will be enrolled behind the scenes into a plan. Now when a patient has insurance the _Insurance Plans_ navigation button will take them to figure 28.

![](RackMultipart20201223-4-1k5pyf6_html_6bd6cf50bd679078.png)

_Figure 28: Insurance Plans Information_

And the patient can press the _In-Network Health Providers_ button to be shown in figure 29.

![](RackMultipart20201223-4-1k5pyf6_html_3417931653af7cee.png)

_Figure 29: Health Providers List_

### 3.4 MHPP Pharmacy Portal

If the user that logged in had an EmployeeType of 2, then their account was set to be a pharmacy account and they are directed to the Pharmacy Portal. The pharmacy portal has limited functionality compared to both the healthcare worker and patient portals. The lesser amount of functionality stems from the needs of the pharmacy which would be simply to be able to search for a patient and then display their information about the doctor&#39;s note and recommendations which would be a drug or prescription. Since a pharmacist would most likely not need to search for a patient until they come to the pharmacy to get a prescription, the only allowed search method is by last name, first name, date of birth shown in figure 30.

![](RackMultipart20201223-4-1k5pyf6_html_ba53e68fbb329fce.png)

_Figure 30: Pharmacy Search Method_

This method was decided upon since most patients do not have their PID memorized and these three fields would be unique enough to identify them. Once the search is submitted, the table displayed in figure 31 is what the pharmacist would need to fill the prescription.

![](RackMultipart20201223-4-1k5pyf6_html_3d8d97286abb63fd.png)

_Figure 31: Pharmacist Search Results_

## 4 FAKER PYTHON DATA GENERATION SCRIPT

One of the hurdles we had during the development of this project was test data. To test our codebase, we needed to generate test data that was:

1. Realistic
2. Randomly generated
3. Unique

The solution came through a popular programming language called Python. We used Python (version 3.9) and a package called Faker [1]. Faker [1] is a tool designed to generate realistic, random, and unique data. The development resulted in a script that we call, _generator.py_ [2]. The Faker [1] package can generate a wide variety of data. We used Faker to generate random text, names, addresses, emails, genders, company names, company emails, and company phone numbers. In figure 32, we see an example of what the python code looks like while using Faker.

![](RackMultipart20201223-4-1k5pyf6_html_ffa2a720e56e51a2.png)

_Figure 32: Faker Sample Code_

The data generation is as simple as calling a Faker module to do the generation for you. The scope of this is not to explain all the features of Faker nor the code details on how we used Faker in our project. If you would like to see the code details, please refer to our GitHub repository {3]. There you can glance at the code and deduct our usage of Faker. You can also reference the Faker documentation. [1]

### 4.1 Python Packages Used

The python script [2] uses a few python packages and those are:

1. mysql.connector [8]
2. random [9]
3. argparse [10]
4. Faker [11]
5. dateutil.relativedelta from relativedelta [12]
6. Datetime from date [13]

The packages were imported with the following code snippet: ![](RackMultipart20201223-4-1k5pyf6_html_b4f48daaeb8a34a.png)

_Figure 33: Code snippet from generator.py [2]_

The _mysql.connector_ is responsible for hooking up to the MySQL database instance that can be running either on localhost or on a different address. Meanwhile, the _random_ package is used to generate random numbers within a specified range. Next, the _argparse_ package is for parsing command line arguments and using those inside our script. Lastly, the _dateutil.relativedelta_ is used for the generation of random timestamps along with the _DateTime_ package.

### 4.2 Generation Script Usage

Since the generator script is a Python script that means that it is platform-independent and can be run on macOS, Linux, and Windows. Please note that during our development the tool was used within a Windows 10 Home 64-bit environment. Let us begin by talking about the command line parameters which are:

1. -a how many items do we want to generate
2. -v verbose/detailed script output
3. -patients insert into the PatientInfo table
4. -provider inserts into the InsProvider table
5. -plans insert into the InsPlans table
6. -precs insert into the PatientRecords table
7. -pnotes insert into the PatientNotes table
8. -hprovider insert into the HealthProvider table
9. -membership insert into the Membership table
10. -costs insert into the Costs table
11. -coverage insert into the Coverage table
12. -enrolled insert into the enrolled table
13. -host the hostname for the MySQL DB instance
14. -port the port number for the MySQL DB instance
15. -user the user for the MySQL DB instance
16. -pass the password for the MySQL DB instance
17. -db The database name for the MySQL DB instance

The only required parameter is the _-a_ which sets how many items we wish to generate. All the other parameters are optional. The reason being we do not always want to generate all the data or always insert it into the MySQL DB instance. To use the script first you will need to have a local Python 3 installation. In the examples, we will use Windows PowerShell. Please note that you must have the python packages listed in section 4.2 already installed for the examples to work.

### 4.2.1 Example 1

![](RackMultipart20201223-4-1k5pyf6_html_d530989d558a18a.png)

_Figure 34: Sample code running for example 1_

Running _py .\generator.py -a 1 -patients -v_ will generate 1 patient information record without inserting it into a database. If you add the database parameters make sure that the table PatientInfo already exists with the proper columns. The columns are specified in section 2. Adding the database connection parameters the new command is _py .\generator.py -a 1 -patients -v -host yourhosthere -port yourporthere -user youruserhere -pass yourpasswordhere -db yourdbnamehere_.

### 4.2.2 Example 2

![](RackMultipart20201223-4-1k5pyf6_html_d9c9f40c5a5de3f3.png)

_Figure 35: Sample code running for example 2_

Running _py .\generator.py -a 1 -provider -v_ will generate 1 insurance provider record. Once again you can specify the database connection parameters to insert the record into a database. Please note that once again the InsProvider table must exist. It is referenced in section 2.

### 4.3 Generation Script Issues

During the development of our project, we ran into multiple issues with the generator script. For one we were not able to successfully connect to a remote database connection, not on our localhost machines. To solve this, we created our database schema locally and inserted data into the local database instance. We later would export the localhost database as an SQL script and import that script into our live web server. Also, the script relies on the fact that:

1. All the database tables referenced in section 2 must be created ahead of time.
2. The data must be generated in a somewhat orderly manner to avoid issues

Thus, the script will not always work if the data defined within the insert statements aren&#39;t available. The script will fail if the database tables it tries to insert are not available. Lastly, another issue was dealing with time data generation. The time data for PatientNotes and PatientRecord tables had to be in a valid format that MySQL supports. This issue was solved by using the _date_ and _relativedelta_ python packages.

## 5 MYSQL QUERIES

For this project, we ended up creating 26 queries for our database that would be executed when called from different PHP pages and functions. To see detailed information on our queries, please see reference [4] for a link to the queries.php file hosted on our Github repository. One of the most used and important queries is shown in figure 36, the patient\_id\_query. This query was used a multitude of times in our pages to get all the information of a patient by knowing the PID.

![](RackMultipart20201223-4-1k5pyf6_html_65a31d68d2cb8098.png)

_Figure 36: PID query_

This query checks the table PatientInfo for the PID passed to it and returns all values from the table. To access these values, we are binding the parameters to variables inside our PHP page so that we can access them individually and reuse them later.

## 6 ADDITIONAL DATA FOR TESTING

We have provided data below to create accounts for users when testing the functionality of the site. None of the data below have user accounts currently created so the only errors that will appear would be from a typo.

| **PID** | **First Name** | **Last Name** |
| --- | --- | --- |
| **50499226433296200** | Richard | Olsen |
| --- | --- | --- |
| **55360723697965000** | Shelly | Marshall |
| **56690834110352800** | April | Carter |
| **57344718296291400** | Erin | Bennett |

_Figure 37: Sample data to create accounts_

## 7 CONCLUSION AND FUTURE IMPROVEMENTS

After reflecting on this project and thinking about changes and improvements that could be made, there were a few large changes we noticed that could be implemented to improve it. A major change that could be made to the project would be to create functions to be called inside the PHP code when we have reusable code. There are many times that we repeat code inside of a switch case of while statement on different PHP pages that could have been delegated to a function that we could call instead. Another change we could make would be to link the patient notes and patient records together. As it stands, they must be queried separately and then displayed separately as well. The last improvement would be to link the user id to the make notes form in the Healthcare Worker Portal so when a note is added by a worker, the records will show what the user id of the worker is. This would allow for a separate search function to be added that returns the name of the doctor or nurse that added the note.

In conclusion, after completing this project, there were many challenges that we faced and overcame to produce a product we are happy with. Having to learn multiple languages we were not familiar with and communicating solely through online methods were the biggest challenges that we faced. However, after the completion of the project, we see that there are still aspects of this project that could be added, revised, modified, or optimized to improve the project past its current state.

## REFERENCES

1. 2020. Python Faker Package - [https://faker.readthedocs.io/en/master/](https://faker.readthedocs.io/en/master/) : August 1, 2020.
2. 2020. Generator Python Script - [https://github.com/carlkid1499/CS360/tree/master/python-scripts](https://github.com/carlkid1499/CS360/tree/master/python-scripts) : August 1, 2020.
3. 2020. GitHub Repository CS360- [https://github.com/carlkid1499/CS360](https://github.com/carlkid1499/CS360) : August 1, 2020.
4. 2020. GitHub Repository CS360, queries.php - [https://github.com/carlkid1499/CS360/blob/master/php/queries.php](https://github.com/carlkid1499/CS360/blob/master/php/queries.php) : August 1, 2020.
5. 2020. W3Schools CSS Templates - [https://www.w3schools.com/css/css\_templates.asp](https://www.w3schools.com/css/css_templates.asp) : August 1, 2020.
6. 2020. MySQL Workbench - [https://dev.mysql.com/downloads/installer/](https://dev.mysql.com/downloads/installer/) : August 1, 2020.
7. 2020. XAMPP - [https://www.apachefriends.org/download.html](https://www.apachefriends.org/download.html) : August 1, 2020.
8. 2020. Python 3.9 - [https://www.python.org/downloads/](https://www.python.org/downloads/) : August 1, 2020.
9. 2020 Mysql-connector Package - [https://pypi.org/project/mysql-connector-python/](https://pypi.org/project/mysql-connector-python/) : August 1, 2020.
10. 2020. Random Python Package - [https://docs.python.org/3/library/random.html](https://docs.python.org/3/library/random.html) : August 1, 2020.
11. 2020. Argparse Python Package - [https://docs.python.org/3/library/argparse.html](https://docs.python.org/3/library/argparse.html) : August 1, 2020.
12. 2020. Datetime Python Package - [https://docs.python.org/3/library/datetime.html](https://docs.python.org/3/library/datetime.html) : August 1, 2020.
13. 2020. Dateutil Python Package - [https://dateutil.readthedocs.io/en/stable/index.html](https://dateutil.readthedocs.io/en/stable/index.html) : August 1, 2020.
14. 2020. My Health Project Requirements - [https://github.com/carlkid1499/CS360/projects](https://github.com/carlkid1499/CS360/projects) : August 1, 2020.
15. 2020. Mayo Clinic Health System - [https://www.mayoclinichealthsystem.org/services-and-treatments?letter=All](https://www.mayoclinichealthsystem.org/services-and-treatments?letter=All) : August 1, 2020.

## XAMMP Project ZIP

1. Download and extract the XAMMP folder under C:\XAMMP
It is hosted on IPFS.
https://ipfs.io/ipfs/QmXhPRzRRvNHcZ1XBMVm4Y6tQckJFWrZCQ34PxDas3yc9p?filename=xampp.zip