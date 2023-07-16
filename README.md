# Login Form

## Installation

1. Copy the `.env.example` file to `.env`:
   ```shell
   cp .env.example .env
   ```
2. Open the `.env` file and update the following values:
     * `DB_DATABASE`: Set the name of your database.
     * `DB_USERNAME`: Set the username for your database connection.
     * `DB_PASSWORD`: Set the password for your database connection.
     * `NOCAPTCHA_SITEKEY`: Set the site key for reCAPTCHA.
     * `NOCAPTCHA_SECRET`: Set the secret key for reCAPTCHA.

3. Run the database migration to create the necessary tables:
    ```shell
    php artisan migrate
    ```

## Usage
* Start the development server:
  ```shell
  php artisan serve
  ```
* Access the application in your web browser:
  ```shell
    http://localhost:8000
    ```
## License

This project is licensed under the [MIT License](https://opensource.org/license/mit).



