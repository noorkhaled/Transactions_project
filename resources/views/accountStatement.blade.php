<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Statements</title>
    <link rel="stylesheet" href="{{asset('css/account_statement.css')}}">
</head>
<body>
<header>
    <h1>{{trans('messages.Account_Statement')}}</h1>
</header>
<div class="card">
    <h3>{{trans('messages.Your_Current_Balance:')}} {{$user->balance}} {{trans('messages.currency')}}</h3>
</div>
<table>
    <thead>
    <tr>
        <th>{{trans('messages.Transaction_Id')}}</th>
        <th>{{trans('messages.Transaction_Date')}}</th>
        <th>{{trans('messages.Transaction_Type')}}</th>
        <th>{{trans('messages.Receiver_account')}}</th>
        <th>{{trans('messages.Account_Balance_Before')}}</th>
        <th>{{trans('messages.Transaction_Amount')}}</th>
        <th>{{trans('messages.Account_Balance_After')}}</th>
    </tr>
    </thead>
    <tbody>
    <x-account-statement :$accountStatements/>
    </tbody>
</table>

</body>
</html>
