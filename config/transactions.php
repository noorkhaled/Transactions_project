<?php

return
    [
        //Array of account types that will be reference to get from and to account types
        'accountTypes' => [
            'user' => ['model' => \App\Models\User::class, 'foreignKey' => 'account_id'],
        ]
    ];
