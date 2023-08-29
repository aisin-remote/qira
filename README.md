# QAU Application Installation Guide

This guide will walk you through the steps to install the QAU (Quality Assessment Utility) application.

## Prerequisites

Before you begin, make sure you have the following software installed:

- Git
- Composer
- Node.js

## Installation Steps

1. Clone this GitHub repository:

    ```sh
    git clone https://github.com/naufalamr17/quality.git
    ```

2. Install Composer and Node.js dependencies:

    ```sh
    composer install
    npm install
    ```

3. Generate the .env file and application key:

    ```sh
    cp .env.example .env
    php artisan key:generate
    ```

4. For icons, use the "blade-css-icons" package:

    ```sh
    composer require khatabwedaa/blade-css-icons
    ```

5. Migrate the database:

    ```sh
    php artisan migrate
    ```

6. Run the web application:

    ```sh
    php artisan serve
    ```

7. Additionally, compile assets for development:

    ```sh
    npm run dev
    ```

The QAU application should now be up and running. You can access it by opening a web browser and navigating to the address provided by the php artisan serve command.
