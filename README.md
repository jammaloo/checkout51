<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://www.checkout51.com/assets/img/newhome/Checkout51_Logo_Screen_White.svg" width="400"></a></p>

## Instructions

This app is fully dockerized, so just run

`./vendor/bin/sail up`


That will bring up the local environment.

Once that is running, you can build the database structure and add seed data with

`./vendor/bin/sail artisan migrate && ./vendor/bin/sail artisan db:seed`

Tests can be run with `./vendor/bin/sail test`

The application will be served from http://localhost
