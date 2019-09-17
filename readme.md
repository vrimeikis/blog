# Blog CMS

Blog system with comments and categories

## Requirements

- PHP **>= 7.1.3**
- BCMath PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

## Development run

- Clone repository.
- Run `composer install` command.
- Create MySQL database and login credentials to it.
- Run `cp .env.example .env` command.
- Run `php artisan key:generate` command.
- Fill `db` credentials on `.env` file.
- Run `php artisan migrate` command.
- Run `php artisan storage:link` command.

P.S.: If you dont use virtual machine, run `php artisan serve` command to run virtual server.

## Deploy

- For first admin user run `php artisan user:create` command.
