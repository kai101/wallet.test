# Quiz #
Create a wallet with RESTful api and simple web frontend.
## Live Demo ##
Add to host file.
## Backend ##
admin key authorize [AdminMiddleware](./app/Http/Middleware/AdminMiddleware.php)


Some setup for the quiz. Skiping some proper method to save time.
User injected into data directly from migration script instead of using factory/seed.[UserMigration](./database/migration/2014_10_12_000000_create_users_table.php)
john@wallet.io injected from middleware [JohnMiddleware](./app/Http/Middleware/JohnMiddleware.php)
Most exception throwing http code 500 but a more proper error message is provided.

