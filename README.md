# Quiz #
Create a wallet with RESTful api and simple web frontend.
## Screen Shoot ##
![alt text](https://github.com/kai101/wallet.test/raw/master/screenshoots/wallet_1.png "Screenshot").
## Backend ##
Backend consists of 2 main controller [wallet](./app/Http/Controllers/wallet.php) and [transactions](./app/Http/Controllers/transactions.php).

Admin key authorize at [AdminMiddleware](./app/Http/Middleware/AdminMiddleware.php).

Duplicate wallets and unique email was handled on the admin api when creating wallets.

Postman configuration used for testing the api development is included  [quiz.postman_collection](./tools/quiz.postman_collection.json).

Logger is not written as off now and can be easily added on later stage into catch block on controllers or [Handler.php](./app/Http/Exceptions/Handler.php).

## Mysql ##

3 main tables can be found inside migration folder [migrations](./database/migrations/).

``email`` on user table is unique indexed for fast searching base on user email on public api and admin api. 

wallet table ``user_id`` is foreign key pointed to user table and automatic indexed by innodb so wallet record base on email can be retrive via index.

## Front End ##

Blade template was not used due to collision with AngularJS on ``{{}}`` double curly bracket style.

Main AngularJS HTML file is located at [index.php](./resources/views/index.php).

AngularJS javascript code can be found under [public/app](./public/app).

Custom filter mysql2unix for date conversion is added for conversion of mysql date to unix timestamp.

Due to vast different in style of writing angularJS and other angular version, the minimal code was written in this sections.

## Some setup in here is strictly for the quiz compare to production code. I am skiping some proper implementation to save time.

User injected into data directly from migration script instead of using factory/seed. See [UserMigration](./database/migration/2014_10_12_000000_create_users_table.php).

john@wallet.io injected from middleware [JohnMiddleware](./app/Http/Middleware/JohnMiddleware.php) as current user for all the api calls.

Most exception are thrown  with  base generic php exception http code 500 which might not be the actual case like "Wallet not found." that should be some 400x error code. However a proper error message is provided for each exception.

