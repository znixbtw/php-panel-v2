<div align="center">
	<img src="https://img.shields.io/github/stars/znixbtw/php-panel-v2?style=for-the-badge&logo=appveyor" />
	<img src="https://img.shields.io/github/forks/znixbtw/php-panel-v2?style=for-the-badge&logo=appveyor" />
	<h1>:zap: User Management Panel</h1>
</div>

> Contribution is greatly appriciated. <br />
> Default login: `admin`:`admin` <br />
> Join our discord community: https://discord.io/codingbay

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

### Installation 
* Recommended PHP 8.0!
* Change DB info in core/Database.php <br>
* Import DB.sql file <br>
* Change Site info in core/Config.php

Installation Guide: https://www.youtube.com/watch?v=DwzP4ZSHwHw

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
* Sends user data in JSON format on call
```
 POST /api.php
```
| Parameter | Type     | Description                         |
| :-------- | :------- | :---------------------------------- |
| `user`    | `string` | **Required**. Username              |
| `pass`    | `string` | **Required**. Password              |
| `hwid`    | `string` | **Required**. Hwid                  |
| `key`     | `string` | **Required**. Key                  |
---

### Credits
* Awesome OOP tutorials: https://www.youtube.com/playlist?list=PL0eyrZgxdwhypQiZnYXM7z7-OTkcMgGPh
* Reference MVC model: https://github.com/Darynazar/login-register-script-mvc
