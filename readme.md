# Niche Stack - Laravel Dev Test
![Screen Shot 2019-12-01 at 19 36 56](https://user-images.githubusercontent.com/14433159/69914087-92cda780-1472-11ea-8728-9a0da5bc5b2f.png)

## Overview
CRUD App is a basic CRUD options for Contacts without authorization and authentication.

## Features
Now, let’s describe the features:
* Create Contact
* Edit Contact
* Delete Contact
* Simple Table Toolbar for grouping, searching, and pagination

## Installation
* First, clone the repository.
```bash
git clone https://github.com/ferdinand12345/laravel-dev-test.git
```
- Second, go to the clone directory
```bash
cd /path/to/the-clone-directory/of/laravel-dev-test
```
- Then edit "env" file to setup your database config (line 9-14)

![Screen Shot 2019-12-01 at 15 59 20](https://user-images.githubusercontent.com/14433159/69914106-c27caf80-1472-11ea-9948-5b44240fffd8.png)

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_dev_test
DB_USERNAME=root
DB_PASSWORD=
```
- For MacOS, Centos, Ubuntu, and more UNIX OS, just simply run Shellscript for installation (Including all Laravel setup, test, and etc)
    ```bash
    ./install.sh
    ```
- If you're using Windows, this is the step for installation with windows
	- Run command for install composer
	```bash
	composer install
	```
	- Move/Rename file "env" to ".env"
	- Run PHP Artisan
	```bash
	php artisan key:generate
	php artisan cache:clear
	php artisan config:clear
	php artisan migrate
	composer dump-autoload
	php artisan db:seed --class=tm_contact_seeder
	```
	- Change mode folder ./vendor ./bootstrap ./database, ./storage, and ./public to 777 (Recursive)
	- Done
    
## Video Tutorial
How to install and use the program
[Video Tutorial Installation & Review.mp4](https://drive.google.com/file/d/1qADtVK19V1SoeAGB0ZXB9f8q7T7ZfR8m/view?usp=sharing)

## Project Information
Title | Description
--- | ---
Laravel Version | 5.8
PHP Version | 7.2.18
Database | MySQL

## Screenshoot
![Screen Shot 2019-12-01 at 19 37 44](https://user-images.githubusercontent.com/14433159/69914124-08397800-1473-11ea-9154-e24886763242.png)
![Screen Shot 2019-12-01 at 19 37 19](https://user-images.githubusercontent.com/14433159/69914125-08d20e80-1473-11ea-9bc4-f064e257f31c.png)
![Screen Shot 2019-12-01 at 19 37 07](https://user-images.githubusercontent.com/14433159/69914126-096aa500-1473-11ea-9207-c209701005de.png)

## Author

Ferdinand [<ferdshinodas@gmail.com>]
