# Storyclash Notes App

## Automatic Setup
to set up the app you can use a **setup.sh** script in the root directory
the prerequisites for the script are:
 * docker desktop
 * composer
 * symfony CLI
 * node


## Manual Setup

### Backend
in the **/api** folder

run \
`composer install`

change the **.env** `DATABASE_URL` configuration to connect to your database
or run `docker-compose up -d --build` to use the Symfony's default one

run\
`bin/console doctrine:database:create`\
`bin/console doctrine:migrations:migrate`\
`bin/console doctrine:fixtures:load`

use Symfony CLI to run the local web server (https://symfony.com/download#step-1-install-symfony-cli)

run `symfony serve`

### Frontend

in the **/client** folder

run \
`npm install`\
`npm run serve`

and open the url in a browser

#### Troubleshooting

make sure that the API's url is correct in **/client/.env**
