

## 👨🏼‍💻 Laravel Spot Test Project

### Objective

This project is a PHP-based application designed to demonstrate the creation of a REST API for processing new orders, integrating with a third-party API, and handling high demand for API requests efficiently. The project is implemented using the Laravel framework, adhering to the MVC design pattern, and includes both backend and frontend components.

### Features

#### REST API for New Orders:

- The API endpoint processes new orders and includes authentication.
- The API request body contains at least two parameters: Customer Name and Order Value.
- The API response includes Order ID, Process ID, and Status parameters.
- The data is stored in a MySQL database.
 
 #### Third-Party API Integration:

- Upon successful order processing, the order details are submitted to a specified third-party API endpoint via a POST request in JSON format.

#### API Request Queueing:

- To handle high demand, a method is suggested to queue API requests, ensuring new orders wait until the configured number of parallel requests are processed.

#### Web Form with IndexedDB:

- A simple web form is created with three input parameters.
- The submitted form values are stored in the browser-based IndexedDB.
- A data table is provided to view the stored information from IndexedDB.

### Table of Contents

- Requirements
- Installation
- Configuration
- Running the Project
- API Endpoints

### Requirements

- PHP 8.x
- Composer
- MySQL
- Laravel 9.x

### Installation

#### 1.Clone the repository:

- git clone https://github.com/dineshabey/php-order-api.git

- cd php-order-api

#### 2.Install dependencies:

composer install

#### 3.Create a .env file:

cp .env.example .env

#### 4.Generate an application key:

php artisan key:generate

#### 5.Set up your database in the .env file:

- Update .env 

DB_CONNECTION=mysql

DB_HOST=127.0.0.1

DB_PORT=3306

DB_DATABASE=your_database_name

DB_USERNAME=your_database_username

DB_PASSWORD=your_database_password

REDIS_CLIENT=redis

#### 6.Run the migrations to create the required tables:

php artisan migrate

### Running the Project

#### 1.Start the Laravel development server:

php artisan serve

#### 2.Run the queue worker:

php artisan queue:work

#### 3.Access the Web Form:

 Open your browser and navigate to http://localhost:8000.
 Use the simple web form to add data.
 The submitted data will be stored in the browser's IndexedDB.

### API Endpoints

- Refer to API full document and Json API cpllection (Attached with email)

### Steps to Import the Collection:

1. Open Postman. https://www.postman.com/
2. Click on the `Import` button in the top left corner.
3. Select the `Upload Files` tab.
4. Choose the attached JSON file and click `Open`.
5. The collection will be imported into your Postman.


