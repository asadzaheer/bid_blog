# Requirements

 - PHP 8.x.x (for native attributes to configure routes)
 - https://symfony.com/doc/current/setup.html
 - MySQL databse server
 - https://getcomposer.org/download/

# How to run on local

Clone repository from https://github.com/asadzaheer/bid_blog

Go into project folder

`cd bid_blog`

Install required packages using composer

`composer install` or `composer update` (in case of some dependency isues)

Create `.env.local` file and copy content from `.env` file

Update `DATABASE_URL` as per you need, in this example I used MySQL so for that update

`DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=server_version"`

Replace `db_user`, `db_password`, `db_name`, `server_version` with correct values as per DB/server you created

run migrations

`php bin/console doctrine:migrations:migrate`

run fixtures

`php bin/console doctrine:fixtures:load`

run (you might need to install symfony binay for this https://symfony.com/download)

`symfony server:start`

site should be up on http://127.0.0.1:8000

# Accessing the site

As anonymous user you have access to following routes

| Route | Description |
| ------ | ------ |
| / | Show all posts |
| /post/{id} | Show details of specific post and option to leave a comment |
| /login | To login into application |
| /logout | To logout of application |

You can login as admin using following credentials

email: admin@example.com
password: 123456789

Admin have access to all anonymous routes plus following routes

| Route | Description |
| ------ | ------ |
| /post/new | Create new post |
| /post/{id}/edit | Edit existing post |
| /post/{id} | Delete an existing post (Method Delete) |
| /comment | Show all comments |
| /comment/new | Create new comment |
| /comment/{id} | Show details of specific comment |
| /comment/{id}/edit | Edit existing comment |
| /{id} | Delete an existing comment (Method Delete) |