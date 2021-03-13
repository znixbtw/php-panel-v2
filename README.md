<h1 align="center">Web Panel W.I.P</h1>
<p align="center">Web Panel for your CS:GO cheat.</p>

> Contribution is greatly appriciated. <br />
> Default login: `admin:admin` <br />
> Wanna talk? Join: https://discord.gg/9Ef5t2fMkk

---

### Overview
<p align="center">
  <img src="https://i.imgur.com/VB2ial8.png" />
</p>

###### TECHNOLOGIES
* OOP PHP
* HTML5
* Bootstrap
###### RDBMS
* PDO
* Prepared Statements
###### SECURITY
* SQL injection proof
* XSS proof
* User does not interact with DB directly. All requests are handled by Controllers before sending data to Models.

---

### Features
###### AUTH
* Login
* Register (Invite only)
###### USER
* Change password
* Activate subscription with code (32 days)
* Download loader (Needs a sub)
###### ADMIN PANEL
* Generate invite code
* Generate subscription code
* Ban/unban user
* Make user admin/non-admin
* Reset HWID
* Set cheat detected/undetected
* Set maintenance/non-maintenance
* Set cheat version
###### API
###### Note: User pass and hwid has to be sent in base64 format.
* Sends user data in JSON format on call
	* Usage: `api.php?user={username}&pass={password}&hwid={hwid}&key={key}`
	* Example: `api.php?user=admin&pass=YWRtaW4=&hwid=aHdpZA==&key=yes`

---

### Functions 
###### List of functions and methods which you should know, to modify
* SessionController
	* isLogged - `Returns true if user is logged, else false.` 
	* isAdmin - `Returns true if user is admin, else false.`
	* isBanned - `Returns true if user is banned, else false.`
* UtilController
	* navbar - `Calls include/navbar.inc.php in the page.`
	* footer - `Calls include/footer.inc.php in the page.`
	* head - `Calls include/head.inc.php in the page. Pass page title into this.` *Requires 1 parameter.*
	* redirect - `Redirects to paramter provided.` *Requires 1 parameter.*
	* display - `Sanitzes the parameter with htmlspecialchars.` *Requires 1 parameter.*

---

### Installation 
* Change DB info in core/Database.php <br>
* Import DB.sql file <br>
* Change Site info in core/Config.php 

---

### Credits
* Awesome OOP tutorials: https://www.youtube.com/playlist?list=PL0eyrZgxdwhypQiZnYXM7z7-OTkcMgGPh
* Reference MVC model: https://github.com/Darynazar/login-register-script-mvc
