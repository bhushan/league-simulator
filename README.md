# Premier League Simulator
In this project, a simulation is created in which there will be a group of football teams and the simulation will show match results and the league table.
Following are the functionalities covered:

- Simulation on clicking Next week button
- Simulation on clicking Play All
- Prediction for each team from 4th week (Configurable)
- Edit for match results for each week
- Reset of data
- PHPUnit tests
- Responsiveness application
- Implementation of translation for displaying data

For more information, check ```docs/Information.md```

## Prerequisites

- PHP >= 7.2
- PHP Extension - BCMath 
- PHP Extension - Ctype
- PHP Extension - Fileinfo
- PHP Extension - JSON
- PHP Extension - Mbstring
- PHP Extension - OpenSSL
- PHP Extension - PDO
- PHP Extension - Tokenizer
- PHP Extension - XML
- MySQL
- GIT
- Composer
- NPM

## How to install

- Do the git clone of the project

```
git clone https://github.com/b-gaykawad/league-simulator.git
```


- Navigate inside project directory

```
cd league-simulator
```

- Install composer dependencies

```
composer install
```

- Install NPM dependencies

```
npm install
```

- Create environment file by copying .env.example file to .env

- Generate App Key for the project

```
php artisan key:generate
```

- Change following configurations from .env file
  - DB_DATABASE=
  - DB_USERNAME=
  - DB_PASSWORD=

- Now create the database with the same name used in DB_DATABASE

- Migrate database and seed default data

```
php artisan migrate:fresh –seed
```


## How to run application

- Run below command from the project root directory, and run the provided url in browser

```
php artisan serve
```

## How to execute tests

- Run the below command from the project root directory

```
./vendor/bin/phpunit
```

## Few useful commands

- Compile the assets

```
npm run <env>
```
Note:

a. ```env``` can be ```prod``` or ```dev```

b. ```prod``` generates the minified assets


- Watch changes in the assets

```
npm run watch
```

- Stop the server

```
CTRL + C
```
