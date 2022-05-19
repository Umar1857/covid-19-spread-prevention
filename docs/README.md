# About Covid-19 spread prevention

## Guidelines to run this project
Go to laravel-backend folder and run the following commands.

1) Clone this project to your local environment.
2) Copy .env.example to .env
3) Configure .env file
4) Run: composer install
5) Run: php artisan migrate
6) Run: php artisan db:seed
7) npm install
8) node node/index (To start socket server)

## Background job
Add this line to crontab file by typing the command cronetab -e. This will forcefully update the status of shoppers if they are active for last 2 yours.
'0 * * * *  cd /var/www/html/risk-theory/ && php artisan schedule:run >> /dev/null 2>&1'
