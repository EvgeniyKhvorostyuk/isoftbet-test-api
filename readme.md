## Installation

1. Clone the repository
2. Create .env file (could be copied from .env.example)
3. composer install
4. php artisan key:generate
5. php artisan migrate
6. php artisan passport:install
7. npm install

## Usage

1. Register as a new user
2. Login with your credentials
3. Create the new oauth client
4. Create your personal access token (every time you will try to get the transactions page you will need a token)
5. Go to the transactions page with your access token 

## Api

Every request has to be sent with auth token and (Content-Type: application/json) header

1. Postman Authorization type: Bearer Token
2. Paste token into specialised field

Routes:

1. Add customer:
    <br />request -> {
        url: APP_URL/api/customers/store,
        method: POST,
        params: name, cnp
    }
2. Customer's transaction:
    <br />request -> {
        url: APP_URL/api/customers/{customerId}/transactions/{transactionId},
        method: GET
    }
3. Transactions by filters:
    <br />request -> {
        url: APP_URL/api/transactions,
        method: GET,
        params: customerId, amount, date, offset, limit
    }
4. Add transaction:
    <br />request -> {
        url: APP_URL/api/transactions/store,
        method: POST,
        params: customerId, amount
    }
5. Update transaction:
    <br />request -> {
        url: APP_URL/api/transactions/{transactionId},
        method: PUT
    }
6. Delete transaction:
    <br />request -> {
        url: APP_URL/api/transactions/{transactionId},
        method: DELETE
    }
