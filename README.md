# Slim Framework 4 Skeleton Application

[![Coverage Status](https://coveralls.io/repos/github/slimphp/Slim-Skeleton/badge.svg?branch=master)](https://coveralls.io/github/slimphp/Slim-Skeleton?branch=master)

Use this skeleton application to quickly setup and start working on a new Slim Framework 4 application. This application uses the latest Slim 4 with Slim PSR-7 implementation and PHP-DI container implementation. It also uses the Monolog logger.


## Install the Application
1) git clone https://github.com/SergM2014/slim.git

2) cd slim

3) docker-compose up -d

4) chmod -R 777 slim/logs

5) docker exec -i slim_db mysql -uroot -ppassword slim < slim.sql

6) docker-compose exec slim_app bash

7) composer install

8) visit http://localhost:8080/

for login - use email - weisse011@gmail.com password-111111



!!! Attention!!! the current docker set doesnot allow to send email. 
which is send to change password. in this email we send special link.
that's why the coresponding code is commented.
But anyway, you can test this link tipping http://localhost:8080/recover-password?token=bumbum
where value of token is taken from table users. mechanism of recovering password is following -> 
1) in forgot-password form - put the email of active user
2) aplication search the given email in db and init reset token and timestamp when the token was created.
3)  the above mentioned link is created and send to user by email
4)visit link . if token is wrong - redirect to index page with message that something went wrong with token. if token was created more then 1 hour ago - the same action -return to index page with message that token is more than 1 hour old. if token is ok - put new password and it redirects to admin page
