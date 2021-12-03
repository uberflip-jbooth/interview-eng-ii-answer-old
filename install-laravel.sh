#!/bin/bash

# This script will install the Laravel Sail container and
# configure it for Gitpod.

# Create the app
docker info > /dev/null 2>&1

# Ensure that Docker is running...
if [ $? -ne 0 ]; then
    echo "Docker is not running."
    exit 1
fi

docker run --rm -v "$(pwd)":/opt -w /opt --platform=linux/amd64 laravelsail/php80-composer:latest bash -c "laravel new university && cd university && php ./artisan sail:install --with=redis,meilisearch,mailhog,selenium "

cd university

echo ""

sudo chown -R $USER: .

# Modify default .env.example to work in Gitpod
sed -i 's/APP_NAME=.*/APP_NAME=University/' .env.example
sed -i 's/APP_URL=.*/APP_URL="${GITPOD_WORKSPACE_URL}"/' .env.example
sed -i '/^APP_URL/a APP_PORT=9080' .env.example
sed -i 's/DB_HOST=.*/DB_HOST=0.0.0.0/' .env.example
sed -i 's/DB_USERNAME=.*/DB_USERNAME=uberflip/' .env.example
sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=pass123/' .env.example

cd ..

# Set up bash alias for Sail
echo "RUN echo \"alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'\" >> ~/.bashrc" >> .gitpod.Dockerfile

# Add the port config to .gitpod.yml
sed -i '/^ports:/a\  - port: 6379\n    onOpen: ignore' .gitpod.yml
sed -i '/^ports:/a\  - port: 1025\n    onOpen: ignore' .gitpod.yml
sed -i '/^ports:/a\  - port: 8025\n    onOpen: ignore' .gitpod.yml
sed -i '/^ports:/a\  - port: 7700\n    onOpen: ignore' .gitpod.yml
# Remove the default web browser preview and add one for Laravel
sed -i '/port: 8080/a\
    onOpen: ignore\
  - port: 9080' .gitpod.yml

# Add a terminal to run Sail
sed -i '/# Additional Terminals/a\
  - name: Laravel Sail\
    before: cd university\
    init: |\
      php -r \d34file_exists(\d39.env\d39) || copy(\d39.env.example\d39, \d39.env\d39);\d34\
      composer update\
      composer install\
      php artisan key:generate\
      sail up --no-start --build\
    command: sail up\
    openMode: tab-after' .gitpod.yml

echo -e "Laravel installed successfully.  Please continue with the challenge instructions."
