# Niche Stack - Laravel Dev Test
## Installation
- First, clone the repository.
```bash
git clone https://github.com/ferdinand12345/laravel-dev-test.git
```
- Second, go to the clone directory
```bash
cd /path/to/the-clone-directory/of/laravel-dev-test
```
- Then edit "env" file to setup your database config (line 9-14)
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_dev_test
DB_USERNAME=root
DB_PASSWORD=
```
- If you're use MacOS, Linux, Ubuntu, Centos or UNIX OS, just simply run Shellscript for installation (Including all Laravel setup, test, and etc)
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
[Interview Niche Stack.mp4](https://drive.google.com/file/d/1qADtVK19V1SoeAGB0ZXB9f8q7T7ZfR8m/view?usp=sharing)
## Project Information
Title | Description
--- | ---
Laravel Version | 5.8
PHP Version | 7.2.18
Database | MySQL
