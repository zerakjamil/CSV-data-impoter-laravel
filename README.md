<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>
# User Import Project

This project is designed to import user data from CSV files into a database using Laravel. It processes the CSV file in chunks and dispatches jobs to handle the import asynchronously.

## Setup Instructions

1. Clone the repository:
    ```bash
    git clone [<repository-url>](https://github.com/zerakjamil/CSV-data-impoter-laravel.git)
    cd CSV-data-impoter-laravel
    ```

2. Install dependencies:
    ```bash
    composer install
    ```

3. Run the database migrations:
    ```bash
    php artisan migrate
    ```

4. Start the development server:
    ```bash
    php artisan serve
    ```

## Usage

To import users from a CSV file, send a POST request to the `v1/import-users` endpoint. The application will read the CSV file, process it in chunks, and dispatch jobs to handle the import.

### Postman Collection

You can find the Postman collection for this project [here](https://api.postman.com/collections/28087875-2529e734-7502-440d-a5aa-6bdbb587da32?access_key=PMAT-01J3TYK0TVWDP06XV9PWARXVJZ).

## Additional Information

There are multiple CSV file demos available in the `database` directory, each containing a different number of user records. You can use these files to test the import functionality with various data sizes.

- `users-100.csv` - 100 user records
- `users-10,000.csv` - 10,000 user records

Make sure to update the file path in the `UserController` if you want to use a different CSV file for import.

## Database

This project uses SQLite as the database. Ensure your `.env` file is configured to use SQLite:

```env
DB_CONNECTION=sqlite
DB_DATABASE=/path/to/database.sqlite
