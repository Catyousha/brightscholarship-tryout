# UTBK Brightscholarship Tryout UM

UTBK Brightscholarship Tryout UM

UTBK Brightscholarship Tryout UM is a platform used to carry out tryout exam and ranking activities followed by more than 130 participants on March 27, 2021 in rumbelbsum.com. The platform's feature is that it allows participants to work on a tryout exam within a period of time divided by section, view ranking, as well as the management of weight value for scoring and making questions on the admin side. All systems on this platform including database design are done by myself.

| Laravel Version | Branch |
|-----------------|--------|
| 8.0             | main   |

## Requirements

- PHP >= 7.3.0
- BCMath PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

## Installation

- Clone the repo and `cd` into it
- Run `composer install`
- Rename or copy `.env.example` file to `.env`
- Run `php artisan key:generate`
- Set your database credentials in your `.env` file
- Run migration `php artisan migrate:fresh --seed`


## Credits

Special thanks to:

- Laravel - Open source framework.
- Laravel 8 + SB Admin 2 boilerplate (https://github.com/aleckrh/laravel-sb-admin-2)

## License

Licensed under the MIT license.
