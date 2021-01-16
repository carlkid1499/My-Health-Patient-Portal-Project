# My Health Patient Portal UI &#39;20, Aug-December 2020, Santos, Lawson

## My Health Patient Portal (MHPP)∗

| Carlos Santos Department of Computer Engineering University of Idaho, USA Port3116@vandals.uidaho.edu | Keller Lawson Department of Computer Science University of Idaho, USA Laws1689@vandals.uidaho.edu |
| --- | --- |

## ABSTRACT

SQL is a formal relational database management language. In this document, we focus on the creation of a My Health Patient Portal project given to us in CS360 (Database Management) at the University of Idaho. The project goal was to design a system from the ground up that uses MySQL as the backbone, a front-end web system, and a middle-end system to query the MySQL database.

## MHPP CONCEPTS

• MySQL; Web-Based _Graphical user interface (GUI); RDMS -\&gt; Relation Database Management System_; Faker Data Generation Tool

## KEYWORDS

SQL; PHP; MySQL; JavaScript; HTML; Database; Faker; Python;

## 1 INTRODUCTION

The scope of this paper is to describe the major components of our My Health Patient Portal. From here on out MHPP will refer to My Health Patient Portal. The MHPP project has three major pieces to it. The front end or what is referred to as the user interface. This is talked about in section 3. It also has a back end or typically referred to as the RDMS which stands for Relation Database Management System. The RDMS is mentioned in section 1.1, 2, and 5. Finally, we have a third component which is test data generation in section 4.1.

### RDMS using MySQL

For our RDMS, we are using MySQL to host our main schema myhealth2 which contains all of our tables. MySQL is one of the most popular open-source SQL databases and because of this has a lot of forum and community support to assist us when creating our database. While MySQL can lack in speed when scaled to massive databases, it was the proper choice to support our project in its current state.

### 1.2 Tools used in Development

To aid in the development of this project, many tools were utilized for each team member. Most of these tools required us to create a settings file that allowed the team to have matching settings, so errors were not present when branching and reviewing other&#39;s code. The tools used in our development were Visual Studio Code (VS code), phpMyAdmin, MySQL Workbench, Github and Github Desktop, Discord, Zoom, and FileZilla. VS Code was our main tool for writing and reviewing code. We had installed the PHP and HTML extensions that enabled the code we wrote to be automatically checked for errors and made debugging easier. We used both phpMyAdmin and MySQL Workbench to create and run scripts that filled our database with the fake data created from our Faker Python script. These two programs allowed us to quickly access our databases between our live database and our local database to sync them resulting in both databases having the same records for testing. To manage our code, we chose to use Github for our code repository and opted to use Github Desktop instead of a command prompt for pulling and pushing code to the repository. Using Github allowed us to create a project and then create issues and branches for our code for development. This was our most important tool since it allowed us to run experimental code we had been developing on a safe branch without affecting the live(master) branch. We also were able to create tickets for the project and assign different tasks to our team and then create pull requests when a feature or bug fix had been finished, allowing for a different team member to review the code and then merge it to our master branch. Managing team communications and meetings were done through Discord and Zoom. We would regularly post references, meeting times, and questions in Discord under different channels which allowed us to be able to refer to them at later dates. Most of our team meetings and group work sessions were on Zoom since it had better audio and video reliability than Discord did. Transferring files from the master branch of our code to our live server was done via file transfer protocol (FTP) using FileZilla. We had a unique login to the server that granted us access to the files so that we could copy our files to the live web page.

### 1.3 Languages used in Development

To create this project, we chose to use PHP, HTML, MySQL, Python3 as our main programming languages. JavaScript (JS) and Cascading Style Sheets (CSS) were used alongside PHP and HTML. With having to access a database many times and then display the returned results on a web page, the obvious choice was to use MySQL along with PHP. PHP allowed us to easily make a connection to the MySQL database and query it for information that we need. Since we were using PHP, using HTML inside a PHP page is as simple as declaring the document type as HTML. One of the biggest issues we ran into was having to learn the correct syntax for both PHP and HTML. Especially when we were using both inside one statement. No one on the team had used both languages together before so there was a learning curve to researching the specific syntax of each language and how to mix them properly. The JS and CSS were used alongside the HTML code to style and create effects for certain functions. We used the JS to allow windows to be shown &quot;inside&quot; our webpage without having to redirect to another page. CSS was used in a couple of ways: 1) inline CSS was added to specific elements of code that we did not want to have universal changes for. 2) CSS stylesheets were created to change the entire elements of a webpage so that there would be a universal theme across webpages.

If you would like to continue the full PDF report can be found under the Reports directory. <https://github.com/carlkid1499/CS360/blob/documentation-updates/Reports/myhealthportal-02-final-report.pdf>

## XAMMP Project ZIP

1. Download and extract the XAMMP folder under C:\XAMMP
It is hosted on IPFS.
<https://ipfs.io/ipfs/QmXhPRzRRvNHcZ1XBMVm4Y6tQckJFWrZCQ34PxDas3yc9p?filename=xampp.zip>
