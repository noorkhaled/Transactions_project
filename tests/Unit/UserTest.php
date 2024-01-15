<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;
    public function test_Index()
    {
        $users = [
            [
                'name' => 'ali',
                'email' => 'ali@eg.com',
                'password' => '1234',
                'account_id' => 3,
                'account_type' => 'customer',
                'balance' => '1650.00'
            ],
            [
                'name' => 'kareem',
                'email' => 'kareem@eg.com',
                'password' => '1234',
                'account_id' => 4,
                'account_type' => 'customer',
                'balance' => '1750.00'
            ],
            [
                'name' => 'mariam',
                'email' => 'mariam@eg.com',
                'password' => '1234',
                'account_id' => 5,
                'account_type' => 'customer',
                'balance' => '3240.00'
            ],
            [
                'name' => 'h&m',
                'email' => 'HM@eg.com',
                'password' => '1234',
                'account_id' => 6,
                'account_type' => 'merchant',
                'balance' => '12500.00'
            ],
            [
                'name' => 'bosta',
                'email' => 'bosta@eg.com',
                'password' => '1234',
                'account_id' => 7,
                'account_type' => 'delivery',
                'balance' => '7650.00'
            ]
        ];
        foreach ($users as $user) {
            User::create($user);
        }

        $response = $this->get('http://localhost:8000/api/users');

        $response->assertStatus(201);
        foreach ($users as $key => $myuser) {
            $expectedUserWithoutPassword = array_diff_key($myuser, ['password' => '']);
            $response->assertJson([
                'success' => true,
                'users' => [
                    $key => array_merge(['id' => $key + 1], $expectedUserWithoutPassword)
                ]
            ]);
        }
        $response->assertJsonMissing([
            'success' => false,
            'message' => 'not users found',
        ]);
    }
    public function test_Store()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => '2222',
            'account_id' => 1,
            'account_type' => 'customer',
            'balance' => '1000.00',
        ];

        $response = $this->json('POST', 'http://localhost:8000/api/users', $userData);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'user Created successfully',
                'user' => [
                    'name' => 'John Doe',
                    'email' => 'john@example.com',
                    'account_id' => 1,
                    'account_type' => 'customer',
                    'balance' => '1000.00',
                ],
            ]);

        // Optionally, you can assert that the user exists in the database
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'account_id' => 1,
            'account_type' => 'customer',
            'balance' => '1000.00',
        ]);
    }
    public function test_Show()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => '2222',
            'account_id' => 1,
            'account_type' => 'customer',
            'balance' => '1000.00',
        ]);
        $response = $this->json('GET', "http://localhost:8000/api/users/{$user->id}");

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'user' => [
                    'name' => 'John Doe',
                    'email' => 'john@example.com',
                    'account_id' => 1,
                    'account_type' => 'customer',
                    'balance' => '1000.00',
                ],
            ]);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'account_id' => 1,
            'account_type' => 'customer',
            'balance' => '1000.00',
        ]);
    }
    public function test_Update()
    {
        // 1. Create a user in the database
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => '2222',
            'account_id' => 1,
            'account_type' => 'customer',
            'balance' => '1000.00',
        ]);

        // 2. Make a PUT request to the user update endpoint with the user's ID
        $updatedData = [
            'name' => 'Updated John Doe',
            'email' => 'updated_john@example.com',
            'balance' => '1500.00',
            'password' => '2222',
            'account_id' => 1,
            'account_type' => 'customer'
        ];

        $response = $this->json('PUT', "http://localhost:8000/api/users/{$user->id}", $updatedData);

        // 3. Assert HTTP status code 201 (OK)
        $response->assertStatus(201)
            // 4. Assert the JSON structure of the response
            ->assertJson([
                'success' => true,
                'user' => [
                    'name' => 'Updated John Doe',
                    'email' => 'updated_john@example.com',
                    'balance' => '1500.00',
                ],
                'message' => 'User Updated successfully',
            ]);

        // 5. Optionally, assert that the user's data in the database has been updated
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated John Doe',
            'email' => 'updated_john@example.com',
            'balance' => '1500.00',
        ]);
    }
    public function test_Delete()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => '2222',
            'account_id' => 1,
            'account_type' => 'customer',
            'balance' => '1000.00',
        ]);

        // 2. Make a DELETE request to the user delete endpoint with the user's ID
        $response = $this->json('DELETE', "http://localhost:8000/api/users/{$user->id}");

        // 3. Assert HTTP status code 201 (OK)
        $response->assertStatus(201)
            // 4. Assert the JSON structure of the response
            ->assertJson([
                'success' => true,
                'message' => "user with id: '{$user->id}' deleted",
            ]);

        // 5. Optionally, assert that the user has been deleted from the database
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

}
