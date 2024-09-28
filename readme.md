# Credit Report Service

## Manual Installation Requirements
- PHP Latest Version
- Git
- Composer
- MySQL
  
## Manua Installation

1. Clone the repository.
2. Create a MySQL database named `credit_report_service`.
3. Run the SQL schema commands to create the required tables.
4. Run `composer install` to install dependencies.
5. Rename `.env.example` to `.env`.
6. Update `.env` with your MySQL credentials.
7. Run `php cli roomVu` to run console command


## Docker Requirements
- Docker
  
## Docker Installation

1. Rename `.env.example` to `.env`.
2. Run `docker composer up --build` to start project

## Testing

Run `vendor/bin/phpunit tests` to execute the test cases.
