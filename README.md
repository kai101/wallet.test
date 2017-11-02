# Quiz #
Create a wallet with RESTful api and simple web frontend.
## Screen Shoot ##
![alt text](https://github.com/kai101/wallet.test/raw/master/screenshoots/wallet_1.png "Screenshot")
## Backend ##
Backend consists of 2 main controller [wallet](./app/Http/Controllers/wallet.php) and [transactions](./app/Http/Controllers/transactions.php)

and 3 Main table which can be found inside migration folder [migration](./database/migration/)

Admin key authorize at [AdminMiddleware](./app/Http/Middleware/AdminMiddleware.php)

Logger are not written as off now and can be easily added on later stage into catch block on controllers or [Handler.php](./app/Http/Exceptions/Handler.php).



## Some setup in here is strictly for the quiz compare to production code. I am skiping some proper implementation to save time.

User injected into data directly from migration script instead of using factory/seed. See [UserMigration](./database/migration/2014_10_12_000000_create_users_table.php)

john@wallet.io injected from middleware [JohnMiddleware](./app/Http/Middleware/JohnMiddleware.php)

Most exception are thrown  with  base generic php exception http code 500 which might not be the actual case like "Wallet not found." which should be some 400x error code. However A more proper error message is provided.

