# Mini Aspire Api

The project focuses on creating a mini version of Aspire so that the candidate can think about the systems and architecture the real project would have.

The task is defined below:

-   Register new customer, admin & Login
-   Get loan details for status check
-   Approve loan by admin
-   Create repayment for a loan

## Installation and setup

Clone the repo:

```sh
git clone https://github.com/Parthfaladu/mini-aspire-api.git
```

To setup and start project run following commands:

```sh
cd mini-aspire-api
composer install
cp .env.example .env
php artisan key:generate
php aritsan migrate
php artisan serve
```

Note: in env file sqlite database connection defined so you can easily connect with database

### Documentation

Build a simple API that allows to handle user loans.
Necessary entities will have to be (but not limited to): admins, customers, loans, and repayments.
The API should allow simple use cases, which include (but are not limited to): creating a new customer and admin, customer can create a new loan with different attributes and allowing a user to make repayments for the loan.

-   loan application request can be made by customer or admin
-   loan approve only by admin
-   customer only can repayment after their loan approve

### Postman api documentation

```sh
https://documenter.getpostman.com/view/1790915/UVeNkhT7
```
