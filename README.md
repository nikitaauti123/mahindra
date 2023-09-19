# Mahindra Press Bed System

This application is build for display press bed live views

## Platforms used for development

1. Codeigniter 4 - https://www.codeigniter.com/user_guide/index.html
2. MySQL - 5.7.36
3. Apache -
4. PHP - 7.4 >= and <= 8.1
5. Theme - Admin LTE - https://adminlte.io/docs/3.2/

## Checkout git development branch

- cd existing_folder
- git init
- git remote add origin https://gitlab.com/shriramw/mahindra_press_bed.git
- git fetch
- git branch --set-upstream-to=origin/development development
- git checkout -b development origin/development
- git pull

## Run Project Locally

- composer install
- php spark serve

## Developemt Guidelines

- Read development guideline if you are new in this project before starting any development.


## Project Installation Instructions

- Download development branch from git repo 
- run composer command - "composer install"
- Create new .env file.
- Copy content from env file available in the repository.
- Change .env file application variables e.g app.baseURL, database configurations etc.
- Run - "php spark serve" commands to start project