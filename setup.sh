#!/bin/bash

API_DIR="./api"
CLIENT_DIR="./client"

setup_backend() {
  echo "Setting up the backend (Symfony)..."
  cd $API_DIR

  echo "Running composer install..."
  composer install

  echo "Please make sure your DATABASE_URL is correctly set in the .env file."

  read -p "Do you want to run Docker for the database? (y/n): " docker_choice
  if [ "$docker_choice" == "y" ]; then
    echo "Starting Docker..."
    docker-compose up -d --build
  fi

  echo "Creating database..."
  bin/console doctrine:database:create

  echo "Running migrations..."
  bin/console doctrine:migrations:migrate

  echo "Loading fixtures..."
  bin/console doctrine:fixtures:load

  echo "Running Symfony server..."
  symfony serve -d

  echo "Please set the API Local Web Server URL in the /client/.env"
  read -p "Press [Enter] to continue..."

  cd -
}

setup_frontend() {
  echo "Setting up the frontend (Vue)..."

  cd $CLIENT_DIR

  echo "Running npm install..."
  npm install

  echo "Running npm run serve..."
  npm run serve

  cd -
}

troubleshooting() {
  echo "Troubleshooting: Make sure the API URL is correct in /client/.env"
  echo "Make sure you installed docker"
  echo "Make sure you installed symfony CLI"
  echo "Make sure you installed composer"
  echo "Make sure you are using the latest node version and npm"
  read -p "Press enter to continue..."
}

# Main script execution
echo "Starting the setup process..."

setup_backend
setup_frontend
troubleshooting