# API Documentation
### Our API documentation provides comprehensive information on Users and Transactions Models, empowering developers to seamlessly integrate our platform into their applications. Explore our API endpoints."

<details><summary> <h1>Users</h1> 
This API is for managing and creating users</summary> 

### Base Url:
 ```”http://localhost:8000/api”```

#

<details><summary><h2>GET</h2><h3>/users</h3>"Retrieve all users"</summary>

```
GET http://localhost:8000/api/users  
```
### Params : None
### Success Response
1.Code:
```
201 OK
```
2.Content
```
{ 
  "success": true,
  "users": [
        {
            "id": 1,
            "name": "noor",
            "email": "noor@gmail.com",
            "email_verified_at": null,
            "account_id": 1,
            "account_type": "customer",
            "balance": "4750.00",
            "created_at": "2024-01-07T09:22:21.000000Z",
            "updated_at": "2024-01-07T12:22:13.000000Z"
        },
        {
            "id": 2,
            "name": "American Eagle",
            "email": "ae@gmail.com",
            "email_verified_at": null,
            "account_id": 2,
            "account_type": "merchant",
            "balance": "150150.00",
            "created_at": "2024-01-07T09:24:10.000000Z",
            "updated_at": "2024-01-07T09:38:31.000000Z"
        },
        {
            "id": 3,
            "name": "Jumia",
            "email": "jumia@gmail.com",
            "email_verified_at": null,
            "account_id": 3,
            "account_type": "admin",
            "balance": "250000.00",
            "created_at": "2024-01-07T09:32:00.000000Z",
            "updated_at": "2024-01-07T09:32:00.000000Z"
        },
        {
            "id": 4,
            "name": "Bosta",
            "email": "bosta@gmail.com",
            "email_verified_at": null,
            "account_id": 4,
            "account_type": "delivery",
            "balance": "65100.00",
            "created_at": "2024-01-07T09:32:54.000000Z",
            "updated_at": "2024-01-07T12:22:13.000000Z"
        },
        {
            "id": 5,
            "name": "ahmed",
            "email": "ahmed@gmail.com",
            "email_verified_at": null,
            "account_id": 5,
            "account_type": "customer",
            "balance": "8750.00",
            "created_at": "2024-01-07T13:50:14.000000Z",
            "updated_at": "2024-01-07T13:50:14.000000Z"
        }
    ]
}

}
```
### Error Response
1.Code:
```
‘404 Not Found’
```
2..Content:
```
"success": false,
"users": []
```
</details>

#

<details><summary><h2>POST</h2><h3>/users</h3> "Create New User"</summary>

```
POST http://localhost:8000/api/users 
```
### Required Params : 
```
[ 
            'name'=>'required|string|max:255',
            'email'=>'required|string|max:255',
            'password'=>'required|string',
            'account_id'=>'required|integer|min:1',
            'account_type'=>'required|string|max:255',
            'balance'=>'required|numeric'
];
```
### Params : 
```
[ 
            'name'=>'mariam',
            'email'=>'mariam@gmail.com',
            'password'=>'1234',
            'account_id'=>'6',
            'account_type'=>'customer',
            'balance'=>'6485'
];

```
### Success Response
1.Code:
```
201 OK
```
2.Content
```
 {
    "success": true,
    "message": "user Created successfully",
    "user": {
        "name": "mariam",
        "email": "mariam@gmail.com",
        "account_id": 6,
        "account_type": "customer",
        "balance": 6485,
        "updated_at": "2024-01-07T13:53:45.000000Z",
        "created_at": "2024-01-07T13:53:45.000000Z",
        "id": 6
    }
}

```
### Error Response
1.Code:
```
‘400 Bad Request’
```
2..Content:
```
"success": false,
"message": "cannot create user"
```
</details>

#

<details><summary><h2>PUT</h2><h3>/users/{id}</h3> "Update an existed User"</summary>

```
PUT http://localhost:8000/api/users/{id}
```
### Params : 
```
Required: 'id = [integer]';
```
### Data Params :
#### Fields to be Updated 
For Example: Update transaction amount
#### 
```
{
     "balance":"275.00",
}
```
### Success Response
1.Code:
```
201 OK
```
2.Content
```
 { 
    "success": true,
    "user": {
        "id": 5,
        "name": "ahmed",
        "email": "ahmed@gmail.com",
        "email_verified_at": null,
        "account_id": 5,
        "account_type": "customer",
        "balance": 7500,
        "created_at": "2024-01-07T13:50:14.000000Z",
        "updated_at": "2024-01-07T15:46:59.000000Z"
    },
    "message": "User Updated successfully",
    "updated attributes": {
        "password": "$2y$12$BUUyvl8hgOC2fZt6Up.0Ie9YDke.OUtMFKaeTwHK90jYEhuTeZNMy",
        "balance": 7500,
        "updated_at": "2024-01-07 15:46:59"
    }

}
```
### Error Response
1.Code:
```
‘400 Bad Request’
```
2..Content:
```
"success": false,
"message": "cannot update user"
```
</details>

#

<details><summary><h2>DELETE</h2><h3>/users/{id}</h3> "Delete an existed User"</summary>

```
DELETE http://localhost:8000/api/users/{id}
```
### URL Params : 
```
Required: 'id = [integer]';
```
### Success Response
1.Code:
```
201 OK
```
2.Content
```
 { 
    "success": true,
    "message": “user with ID: ‘{id}’ deleted”
 }
```
### Error Response
1.Code:
```
‘404 Not Found’
```
2..Content:
```
"success": false,
"message": “user with ID: ‘{id}’ not found”.
```
</details>

#

</details>

#

<details>
<summary> <h1>Transactions   </h1> This API is for managing and handling financial transactions. </summary>

### Base Url:
```
”http://localhost:8000/api”
```

# 

<details><summary>
<h2>GET </h2> <h3>/transactions </h3> "Retrieve all transactions"
</summary>

```
GET http://localhost:8000/api/transactions    
```
### Params : None
### Success Response
1.Code:
```
201 OK
```
2.Content
```
{ 
"success": true,
"transactions": 
   [ 
       { 
         "id": 1,
         "user_id": 1,
         "order_id": 1, 
         "type": 1,
         "fromable_account_type": "customer",
         "fromable_account_id": 1,
         "toable_account_type": "merchant",
         "toable_account_id": 2,
         "amount": "150.00",
         "balance": "1000.00",
         "created_at": "2024-01-07T09:38:31.000000Z",
         "updated_at": "2024-01-07T09:38:31.000000Z"
       },
       { 
         "id": 2, 
         "user_id": 1,
         "order_id": 1, 
         "type": 4, 
         "fromable_account_type": "customer", 
         "fromable_account_id": 1,
         "toable_account_type": "delivery",
         "toable_account_id": 4,
         "amount": "50.00", 
         "balance": "1000.00", 
         "created_at": "2024-01-07T09:38:54.000000Z",
         "updated_at": "2024-01-07T09:38:54.000000Z" 
       } 
   ] 
}
```
### Error Response
1.Code:
```
‘404 Not Found’
```
2..Content:
```
"success": false,
"transactions": []
```
</details>

#

<details>

#
<summary>
<h2>POST</h2> <h3>/transactions</h3> "Create New Transaction"
</summary>

```
POST http://localhost:8000/api/transactions    "Create New Transaction"
```
### Params : 
```
[ 
  'user_id' => 'required', 
  'order_id' => 'required',
  'type' => 'required', 
  'fromable_account_type' => 'required|string|max:255', 
  'fromable_account_id' => 'required|integer|min:1',
  'toable_account_type' => 'required|string|max:255', 
  'toable_account_id' => 'required|integer|min:1',
  'amount' => 'required|numeric', 
  'balance'=>'required|numeric'
];
```
### Success Response
1.Code:
```
201 OK
```
2.Content
```
 { 
    "success": true,
    "message": "Transaction Created successfully", 
    "transaction":
 { 
    "user_id": 1,
    "order_id": 1,
    "type": 4, 
    "fromable_account_id": 1,
    "fromable_account_type": "customer", 
    "toable_account_id": 4, 
    "toable_account_type": "delivery",
    "amount": 50,
    "balance": 1000, 
    "updated_at": "2024-01-07T12:22:13.000000Z",
    "created_at": "2024-01-07T12:22:13.000000Z", 
    "id": 3,
    "fromable": null,
    "fromable_account": 
{
    "id": 1,
    "name": "noor",
    "email": "noor@gmail.com", 
    "email_verified_at": null,
    "account_id": 1,
    "account_type": "customer",
    "balance": 4750,
    "created_at": "2024-01-07T09:22:21.000000Z",
    "updated_at": "2024-01-07T12:22:13.000000Z" 
},
    "toable": null,
    "toable_account":
 { 
    "id": 4,
    "name": "Bosta",
    "email": "bosta@gmail.com",
    "email_verified_at": null, 
    "account_id": 4,
    "account_type": "delivery",
    "balance": 65100,
    "created_at": "2024-01-07T09:32:54.000000Z",
    "updated_at": "2024-01-07T12:22:13.000000Z"
      }
   }
}
```
### Error Response
1.Code:
```
‘400 Bad Request’
```
2..Content:
```
"success": false,
"message": "cannot create transaction"
```
</details>

#

</details>

#

