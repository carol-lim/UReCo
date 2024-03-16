

UReCo ~ UTeM Residential College Management System


Database:
create table "ureco"
import "ureco.sql" file


Follow path to locate the source code:
C:\Xampp\htdocs\UReCo


Change server port (if applicable):
UReCo/config.php - line 2
UReCo/forgetPass.php - line 231


Login:
http://localhost/UReCo/public
or
http://localhost/UReCo/public/index.php


Credential:
refer database "ureco" table "user" *passwords are md5 encrypted*

[Admin]
username: admin
password: admin101

[Staff]
username: S0001
password: staffs98

username: S0004
password: staffs98

[Student]
username: B032010342
password: studs98

[Maintenance Team]
username: M0003
password: maint98


Visitor page:
http://localhost/UReCo/public/visitor.php


Contents:-
UReCo\asset				: favicon, background images, default profile picture
UReCo\css				: stylesheets for each module
UReCo\fullcalendar-5.10.1		: calendar plugin
UReCo\js				: javascripts (datatable pagination, profile edit, and sidebar)
UReCo\public				: all HTML and PHP codes of the system
UReCo\public\admin			: admin module codes
UReCo\public\maint			: maintenance team module codes
UReCo\public\phpmailer			: php email plugin
UReCo\public\staff			: staff module codes
UReCo\public\student			: student module codes
UReCo\public\uploaded_files		: pictures (profile , helpdesk, announcement, and activity)
UReCo\public\botID			: Telegram Bot plugin
UReCo\public\config.php			: server and database configurations
UReCo\public\credential.php		: php email plugin (email and password)
UReCo\public\forgetPass.php		: forgot password page code
UReCo\public\index.php			: login page code
UReCo\public\PHPMailerAutoload.php	: php email plugin
UReCo\public\reset_pass.php		: reset password page code
UReCo\public\visitor.php		: visitor page code

