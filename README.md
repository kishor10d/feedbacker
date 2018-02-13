# Feedbacker
> Project is currently under development.

Feedback system to record feedback of customers. This is for marketing purpose.

## Introduction
Small companies needs some software to keep track of their customers and provided services (communication purpose). This system is developed to fulfil their needs. The companies which are providing Software Services like Web Development, App Development, SEO, ERP, Desktop Software, Mobile Software - they can use this project for their internal purpose.

The executives of your company can call to customer from phone, and record their feedbacks and requirements in this portal.

## Requirements
1. PHP 5.6 or greater
2. MySQL 5
3. [Composer](https://getcomposer.org) - To install php libraries.
4. [Gulp](https://gulpjs.com/) - To minify and uglify assets, js, css. Not necessary and will remove in next version.

## Used PHP Framework & libraries
1. [CodeIgniter](https://codeigniter.com/) 3.1.6
2. [Microweber Screen](https://github.com/microweber/screen) : To capture screen-shot of website.
3. [Akeneo Spreadsheet Parser](https://github.com/akeneo-labs/spreadsheet-parser) : To import huge amount of records from excel sheet.
4. [TCPDF](https://github.com/tecnickcom/tcpdf) : To export as PDF.

## How to Install

1. Clone or download the repository in your webroot.
2. Goto ```application/third_party/``` folder and execute command ```composer install``` from command line (terminal on Linux).
3. Create database in mysql using phpmyadmin and import sql file ```feedbacker.sql``` available in repository.
4. Done!

## Login Credentials
Hit url in your web browser ```http://localhost/feedbacker/```, login screen will appear. Just login with following credentials.

Email : admin@example.com

Password : admin

Once you logged in using System Administrator credentials, you can change the credentials of others as you want.

## Features
1. Login, Logout, Change Password.
2. Create, Update, Delete Users.
3. Import the list of customers (who are having websites) from excel sheet.
4. Assign the customers to executives/telecaller.
5. Record the feedbacks for customers & Timeline.
6. Take *screenshot* (Desktop & Mobile version) of their websites within one click.
7. Get small *SEO Report* of their website.
8. Sending company profile/portfolio via email with pdf attachment.
9. Record *customers requirements* and export as pdf.
10. Generate *PDF reports for exectives/telecaller* for each day.
11. Automatic grabbing of screen-shot if you set cron job.
12. List of daily schedule for feedback/followup.

## TODO (Remaining Features : Yet to develop)
1. Versions of Requirements.
2. Customer assignment history in case the executive is change.
3. CRUD - serving companies 
4. CRUD - portfolio and profile attachements.
5. CRUD - HTML email templates.
6. Report - Summary
