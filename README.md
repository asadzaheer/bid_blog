pre-requsite 
 https://symfony.com/doc/current/setup.html
 https://getcomposer.org/download/
 optional https://symfony.com/download

clone repository from https://github.com/asadzaheer/bid_blog

cd bid_blog
composer install or composer update (in case of some dependency isues)

create .env.local file and copy content from .env file

update DATABASE_URL as per you need, in this example I used mysql so for that update

`DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=server_version"`

replace `db_user`, `db_password` `db_name` `server_version` with correct values as per DB/server you created

run migrations

`php bin/console doctrine:migrations:migrate`

run fixtures

`php bin/console doctrine:fixtures:load`

run 

`symfony server:start`

access

http://127.0.0.1:8000