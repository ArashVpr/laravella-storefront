#!/usr/bin/env php
<?php

/**
 * GraphQL API Test Script
 * Tests all GraphQL queries and mutations
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Http;

class GraphQLTester
{
    private string $baseUrl = 'http://127.0.0.1:8000/graphql';
    private ?string $authToken = null;
    private array $results = [];
    private int $passed = 0;
    private int $failed = 0;

    public function run(): void
    {
        echo "🚀 GraphQL API Test Suite\n";
        echo str_repeat("=", 60) . "\n\n";

        // Test authentication
        $this->testRegister();
        $this->testLogin();
        $this->testLogout();
        $this->testLoginAgain();

        // Test queries
        $this->testStatsQuery();
        $this->testCarsQuery();
        $this->testSearchCars();
        
        // Test car mutations
        $this->testCreateCar();
        $this->testUpdateCar();
        
        // Test watchlist mutations
        $this->testAddToWatchlist();
        $this->testMyWatchlist();
        $this->testToggleWatchlist();
        $this->testRemoveFromWatchlist();
        
        // Test profile mutation
        $this->testUpdateProfile();
        
        // Test delete mutation
        $this->testDeleteCar();

        // Summary
        $this->printSummary();
    }

    private function query(string $query, array $variables = [], bool $requireAuth = false): array
    {
        $headers = ['Content-Type' => 'application/json'];
        
        if ($requireAuth && $this->authToken) {
            $headers['Authorization'] = 'Bearer ' . $this->authToken;
        }

        $response = Http::withHeaders($headers)->post($this->baseUrl, [
            'query' => $query,
            'variables' => $variables,
        ]);

        return $response->json();
    }

    private function assert(string $name, bool $condition, string $message = ''): void
    {
        if ($condition) {
            echo "✅ {$name}\n";
            $this->passed++;
        } else {
            echo "❌ {$name}";
            if ($message) {
                echo " - {$message}";
            }
            echo "\n";
            $this->failed++;
        }
    }

    private function testRegister(): void
    {
        echo "📝 Testing User Registration\n";
        
        $query = '
            mutation Register($input: RegisterInput!) {
                register(input: $input) {
                    user {
                        id
                        name
                        email
                    }
                    token
                    expiresAt
                }
            }
        ';

        $variables = [
            'input' => [
                'name' => 'GraphQL Test User',
                'email' => 'graphql-test-' . time() . '@example.com',
                'password' => 'Password123!',
                'passwordConfirmation' => 'Password123!',
            ],
        ];

        $result = $this->query($query, $variables);
        
        $this->assert(
            'Register returns user data',
            isset($result['data']['register']['user']),
            json_encode($result)
        );
        
        $this->assert(
            'Register returns auth token',
            isset($result['data']['register']['token']),
            'No token in response'
        );
        
        if (isset($result['data']['register']['token'])) {
            $this->authToken = $result['data']['register']['token'];
            $this->results['userId'] = $result['data']['register']['user']['id'];
        }
        
        echo "\n";
    }

    private function testLogin(): void
    {
        echo "🔐 Testing User Login\n";
        
        $query = '
            mutation Login($input: LoginInput!) {
                login(input: $input) {
                    user {
                        id
                        name
                        email
                    }
                    token
                    expiresAt
                }
            }
        ';

        // First, get the email from the previous registration
        $email = 'graphql-test-' . (time() - 1) . '@example.com';
        
        // Create a new user for login test
        $registerQuery = '
            mutation Register($input: RegisterInput!) {
                register(input: $input) {
                    user { email }
                    token
                }
            }
        ';
        
        $email = 'login-test-' . time() . '@example.com';
        $password = 'Password123!';
        
        $registerResult = $this->query($registerQuery, [
            'input' => [
                'name' => 'Login Test User',
                'email' => $email,
                'password' => $password,
                'passwordConfirmation' => $password,
            ],
        ]);

        $variables = [
            'input' => [
                'email' => $email,
                'password' => $password,
            ],
        ];

        $result = $this->query($query, $variables);
        
        $this->assert(
            'Login returns user data',
            isset($result['data']['login']['user']),
            json_encode($result)
        );
        
        $this->assert(
            'Login returns auth token',
            isset($result['data']['login']['token']),
            'No token in response'
        );
        
        echo "\n";
    }

    private function testLogout(): void
    {
        echo "🚪 Testing User Logout\n";
        
        $query = '
            mutation {
                logout {
                    message
                    success
                }
            }
        ';

        $result = $this->query($query, [], true);
        
        $this->assert(
            'Logout returns success',
            $result['data']['logout']['success'] ?? false,
            json_encode($result)
        );
        
        echo "\n";
    }

    private function testLoginAgain(): void
    {
        echo "🔐 Testing Login Again (for subsequent tests)\n";
        
        // Register a new user with phone for car creation
        $registerQuery = '
            mutation Register($input: RegisterInput!) {
                register(input: $input) {
                    user { id email }
                    token
                }
            }
        ';
        
        $email = 'main-test-' . time() . '@example.com';
        $password = 'Password123!';
        
        $result = $this->query($registerQuery, [
            'input' => [
                'name' => 'Main Test User',
                'email' => $email,
                'password' => $password,
                'passwordConfirmation' => $password,
                'phone' => '+1234567890',
            ],
        ]);
        
        if (isset($result['data']['register']['token'])) {
            $this->authToken = $result['data']['register']['token'];
            $this->results['userId'] = $result['data']['register']['user']['id'];
        }
        
        $this->assert(
            'Re-authenticated for tests',
            isset($this->authToken),
            'Failed to get new token'
        );
        
        echo "\n";
    }

    private function testStatsQuery(): void
    {
        echo "📊 Testing Stats Query\n";
        
        $query = '
            query {
                stats {
                    totalCars
                    totalUsers
                    averagePrice
                    newestListings {
                        id
                        make
                        model
                    }
                    popularMakes {
                        make
                        count
                    }
                }
            }
        ';

        $result = $this->query($query);
        
        $this->assert(
            'Stats query returns data',
            isset($result['data']['stats']),
            json_encode($result)
        );
        
        $this->assert(
            'Stats includes totalCars',
            isset($result['data']['stats']['totalCars']),
            'Missing totalCars'
        );
        
        echo "\n";
    }

    private function testCarsQuery(): void
    {
        echo "🚗 Testing Cars Query\n";
        
        $query = '
            query {
                cars(first: 10) {
                    data {
                        id
                        make
                        model
                        year
                        price
                    }
                    paginatorInfo {
                        total
                        currentPage
                        lastPage
                    }
                }
            }
        ';

        $result = $this->query($query);
        
        $this->assert(
            'Cars query returns data',
            isset($result['data']['cars']),
            json_encode($result)
        );
        
        $this->assert(
            'Cars query includes pagination info',
            isset($result['data']['cars']['paginatorInfo']),
            'Missing paginatorInfo'
        );
        
        echo "\n";
    }

    private function testSearchCars(): void
    {
        echo "🔍 Testing Search Cars Query\n";
        
        $query = '
            query SearchCars($search: String) {
                searchCars(search: $search, first: 10) {
                    data {
                        id
                        make
                        model
                    }
                }
            }
        ';

        $result = $this->query($query, ['search' => 'Toyota']);
        
        $this->assert(
            'Search query returns data',
            isset($result['data']['searchCars']),
            json_encode($result)
        );
        
        echo "\n";
    }

    private function testCreateCar(): void
    {
        echo "➕ Testing Create Car Mutation\n";
        
        $query = '
            mutation CreateCar($input: CreateCarInput!) {
                createCar(input: $input) {
                    id
                    make
                    model
                    year
                    price
                }
            }
        ';

        $variables = [
            'input' => [
                'make' => 'Tesla',
                'model' => 'Model 3',
                'year' => 2024,
                'price' => 45000,
                'mileage' => 100,
                'description' => 'Brand new Tesla Model 3',
                'transmission' => 'Automatic',
                'fuelType' => 'Electric',
                'color' => 'White',
                'location' => 'San Francisco, CA',
            ],
        ];

        $result = $this->query($query, $variables, true);
        
        $this->assert(
            'Create car returns data',
            isset($result['data']['createCar']),
            json_encode($result)
        );
        
        if (isset($result['data']['createCar']['id'])) {
            $this->results['carId'] = $result['data']['createCar']['id'];
        }
        
        echo "\n";
    }

    private function testUpdateCar(): void
    {
        echo "✏️ Testing Update Car Mutation\n";
        
        if (!isset($this->results['carId'])) {
            echo "⏭️  Skipping (no car created)\n\n";
            return;
        }
        
        $query = '
            mutation UpdateCar($input: UpdateCarInput!) {
                updateCar(input: $input) {
                    id
                    price
                    mileage
                }
            }
        ';

        $variables = [
            'input' => [
                'id' => $this->results['carId'],
                'price' => 44000,
                'mileage' => 150,
            ],
        ];

        $result = $this->query($query, $variables, true);
        
        $this->assert(
            'Update car returns data',
            isset($result['data']['updateCar']),
            json_encode($result)
        );
        
        $this->assert(
            'Update car modified price',
            ($result['data']['updateCar']['price'] ?? 0) == 44000,
            'Price not updated'
        );
        
        echo "\n";
    }

    private function testAddToWatchlist(): void
    {
        echo "⭐ Testing Add to Watchlist Mutation\n";
        
        if (!isset($this->results['carId'])) {
            echo "⏭️  Skipping (no car created)\n\n";
            return;
        }
        
        $query = '
            mutation AddToWatchlist($carId: ID!) {
                addToWatchlist(carId: $carId) {
                    message
                    success
                    car {
                        id
                    }
                    inWatchlist
                }
            }
        ';

        $result = $this->query($query, ['carId' => $this->results['carId']], true);
        
        $this->assert(
            'Add to watchlist returns success',
            $result['data']['addToWatchlist']['success'] ?? false,
            json_encode($result)
        );
        
        $this->assert(
            'Car is now in watchlist',
            $result['data']['addToWatchlist']['inWatchlist'] ?? false,
            'inWatchlist should be true'
        );
        
        echo "\n";
    }

    private function testMyWatchlist(): void
    {
        echo "📋 Testing My Watchlist Query\n";
        
        $query = '
            query {
                myWatchlist(first: 10) {
                    data {
                        id
                        make
                        model
                    }
                }
            }
        ';

        $result = $this->query($query, [], true);
        
        $this->assert(
            'Watchlist query returns data',
            isset($result['data']['myWatchlist']),
            json_encode($result)
        );
        
        echo "\n";
    }

    private function testToggleWatchlist(): void
    {
        echo "🔄 Testing Toggle Watchlist Mutation\n";
        
        if (!isset($this->results['carId'])) {
            echo "⏭️  Skipping (no car created)\n\n";
            return;
        }
        
        $query = '
            mutation ToggleWatchlist($carId: ID!) {
                toggleWatchlist(carId: $carId) {
                    success
                    inWatchlist
                }
            }
        ';

        // Toggle off (should remove)
        $result1 = $this->query($query, ['carId' => $this->results['carId']], true);
        
        $this->assert(
            'Toggle removes from watchlist',
            !($result1['data']['toggleWatchlist']['inWatchlist'] ?? true),
            json_encode($result1)
        );
        
        // Toggle on (should add)
        $result2 = $this->query($query, ['carId' => $this->results['carId']], true);
        
        $this->assert(
            'Toggle adds to watchlist',
            $result2['data']['toggleWatchlist']['inWatchlist'] ?? false,
            json_encode($result2)
        );
        
        echo "\n";
    }

    private function testRemoveFromWatchlist(): void
    {
        echo "🗑️ Testing Remove from Watchlist Mutation\n";
        
        if (!isset($this->results['carId'])) {
            echo "⏭️  Skipping (no car created)\n\n";
            return;
        }
        
        $query = '
            mutation RemoveFromWatchlist($carId: ID!) {
                removeFromWatchlist(carId: $carId) {
                    success
                    inWatchlist
                }
            }
        ';

        $result = $this->query($query, ['carId' => $this->results['carId']], true);
        
        $this->assert(
            'Remove from watchlist returns success',
            $result['data']['removeFromWatchlist']['success'] ?? false,
            json_encode($result)
        );
        
        $this->assert(
            'Car is removed from watchlist',
            !($result['data']['removeFromWatchlist']['inWatchlist'] ?? true),
            'inWatchlist should be false'
        );
        
        echo "\n";
    }

    private function testUpdateProfile(): void
    {
        echo "👤 Testing Update Profile Mutation\n";
        
        $query = '
            mutation UpdateProfile($input: UpdateProfileInput!) {
                updateProfile(input: $input) {
                    id
                    name
                    phone
                }
            }
        ';

        $variables = [
            'input' => [
                'currentPassword' => 'Password123!',
                'name' => 'Updated GraphQL User',
                'phone' => '+9876543210',
            ],
        ];

        $result = $this->query($query, $variables, true);
        
        $this->assert(
            'Update profile returns data',
            isset($result['data']['updateProfile']),
            json_encode($result)
        );
        
        $this->assert(
            'Profile name was updated',
            ($result['data']['updateProfile']['name'] ?? '') === 'Updated GraphQL User',
            'Name not updated'
        );
        
        echo "\n";
    }

    private function testDeleteCar(): void
    {
        echo "🗑️ Testing Delete Car Mutation\n";
        
        if (!isset($this->results['carId'])) {
            echo "⏭️  Skipping (no car created)\n\n";
            return;
        }
        
        $query = '
            mutation DeleteCar($id: ID!) {
                deleteCar(id: $id) {
                    message
                    success
                }
            }
        ';

        $result = $this->query($query, ['id' => $this->results['carId']], true);
        
        $this->assert(
            'Delete car returns success',
            $result['data']['deleteCar']['success'] ?? false,
            json_encode($result)
        );
        
        echo "\n";
    }

    private function printSummary(): void
    {
        echo str_repeat("=", 60) . "\n";
        echo "📊 Test Summary\n";
        echo str_repeat("=", 60) . "\n";
        echo "✅ Passed: {$this->passed}\n";
        echo "❌ Failed: {$this->failed}\n";
        echo "📝 Total:  " . ($this->passed + $this->failed) . "\n";
        echo str_repeat("=", 60) . "\n";
        
        if ($this->failed === 0) {
            echo "🎉 All tests passed!\n";
        } else {
            echo "⚠️  Some tests failed. Please review the output above.\n";
            exit(1);
        }
    }
}

// Run tests
$tester = new GraphQLTester();
$tester->run();
