<div>
    @foreach($accountStatements as $accountStatement)
        <tr>
            <td>{{ $accountStatement['Transaction_Id'] }}</td>
            <td>{{ $accountStatement['Transaction_Date'] }}</td>
            <td>{{ $accountStatement['Transaction_Type'] }}</td>
            <td>{{ $accountStatement['Receiver_account'] }}</td>
            <td>{{ $accountStatement['Account_Balance_Before'] }}</td>
            <td>{{ $accountStatement['Transaction_Amount'] }}</td>
            <td>{{ $accountStatement['Account_Balance_After'] }}</td>
        </tr>
    @endforeach
</div>
