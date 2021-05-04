# Wikimedia Donation Form Project

## Setting up the project

To set up the project download the project library.

You should have a web server with at least php 7 enabled.

Create a mysql database.

To create the tables in the database run the sql statements that wikimedia.sql contains.

In config.php file add the following:
- the seperately emailed access key to `$config['access-key']`,
- database name to `$config['dbname']`,
- database user name to `$config['user-name']`,
- database password to `$config['password']`,

## Running the tests

In the root directory of the project run `composer install` command,

To run tests, run in the root directory of the project `vendor/bin/phpunit tests/Tests.php` command