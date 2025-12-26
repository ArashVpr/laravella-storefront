import { test, expect } from '@playwright/test';

/**
 * GraphQL API End-to-End Tests
 * Tests the /graphql endpoint with various queries and mutations
 */

const GRAPHQL_URL = 'http://127.0.0.1:8000/graphql';

// Helper function to execute GraphQL queries
async function graphqlRequest(request: any, query: string, variables: any = {}, token?: string) {
    const headers: any = {
        'Content-Type': 'application/json',
    };

    if (token) {
        headers['Authorization'] = `Bearer ${token}`;
    }

    const response = await request.post(GRAPHQL_URL, {
        headers,
        data: {
            query,
            variables,
        },
    });

    return response;
}

test.describe('GraphQL API', () => {
    let authToken: string;
    let userId: string;
    let carId: string;
    const testEmail = `graphql-e2e-${Date.now()}@example.com`;
    const testPassword = 'Password123!';

    test('should handle user registration', async ({ request }) => {
        const query = `
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
    `;

        const variables = {
            input: {
                name: 'E2E Test User',
                email: testEmail,
                password: testPassword,
                passwordConfirmation: testPassword,
                phone: '+1234567890',
            },
        };

        const response = await graphqlRequest(request, query, variables);
        expect(response.ok()).toBeTruthy();

        const data = await response.json();
        expect(data.data.register).toBeDefined();
        expect(data.data.register.user.email).toBe(testEmail);
        expect(data.data.register.token).toBeDefined();

        authToken = data.data.register.token;
        userId = data.data.register.user.id;
    });

    test('should handle user login', async ({ request }) => {
        const query = `
      mutation Login($input: LoginInput!) {
        login(input: $input) {
          user {
            id
            email
          }
          token
        }
      }
    `;

        const variables = {
            input: {
                email: testEmail,
                password: testPassword,
            },
        };

        const response = await graphqlRequest(request, query, variables);
        expect(response.ok()).toBeTruthy();

        const data = await response.json();
        expect(data.data.login).toBeDefined();
        expect(data.data.login.token).toBeDefined();
    });

    test('should fetch marketplace stats', async ({ request }) => {
        const query = `
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
    `;

        const response = await graphqlRequest(request, query);
        expect(response.ok()).toBeTruthy();

        const data = await response.json();
        expect(data.data.stats).toBeDefined();
        expect(typeof data.data.stats.totalCars).toBe('number');
        expect(typeof data.data.stats.totalUsers).toBe('number');
    });

    test('should fetch paginated cars', async ({ request }) => {
        const query = `
      query {
        cars(first: 10) {
          data {
            id
            make
            model
            year
            price
            mileage
          }
          paginatorInfo {
            total
            currentPage
            lastPage
            hasMorePages
          }
        }
      }
    `;

        const response = await graphqlRequest(request, query);
        expect(response.ok()).toBeTruthy();

        const data = await response.json();
        expect(data.data.cars).toBeDefined();
        expect(data.data.cars.paginatorInfo).toBeDefined();
        expect(Array.isArray(data.data.cars.data)).toBeTruthy();
    });

    test('should search cars by query', async ({ request }) => {
        const query = `
      query SearchCars($search: String) {
        searchCars(search: $search, first: 10) {
          data {
            id
            make
            model
          }
          paginatorInfo {
            total
          }
        }
      }
    `;

        const variables = {
            search: 'Toyota',
        };

        const response = await graphqlRequest(request, query, variables);
        expect(response.ok()).toBeTruthy();

        const data = await response.json();
        expect(data.data.searchCars).toBeDefined();
    });

    test('should create a car (authenticated)', async ({ request }) => {
        const query = `
      mutation CreateCar($input: CreateCarInput!) {
        createCar(input: $input) {
          id
          make
          model
          year
          price
          mileage
        }
      }
    `;

        const variables = {
            input: {
                make: 'BMW',
                model: 'M3',
                year: 2024,
                price: 75000,
                mileage: 50,
                description: 'Brand new BMW M3 Competition',
                transmission: 'Automatic',
                fuelType: 'Gasoline',
                color: 'Black',
                location: 'Los Angeles, CA',
            },
        };

        const response = await graphqlRequest(request, query, variables, authToken);
        expect(response.ok()).toBeTruthy();

        const data = await response.json();
        expect(data.data.createCar).toBeDefined();
        expect(data.data.createCar.make).toBe('BMW');
        expect(data.data.createCar.model).toBe('M3');

        carId = data.data.createCar.id;
    });

    test('should update a car (authenticated)', async ({ request }) => {
        const query = `
      mutation UpdateCar($input: UpdateCarInput!) {
        updateCar(input: $input) {
          id
          price
          mileage
        }
      }
    `;

        const variables = {
            input: {
                id: carId,
                price: 74000,
                mileage: 100,
            },
        };

        const response = await graphqlRequest(request, query, variables, authToken);
        expect(response.ok()).toBeTruthy();

        const data = await response.json();
        expect(data.data.updateCar).toBeDefined();
        expect(data.data.updateCar.price).toBe(74000);
        expect(data.data.updateCar.mileage).toBe(100);
    });

    test('should add car to watchlist (authenticated)', async ({ request }) => {
        const query = `
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
    `;

        const variables = {
            carId,
        };

        const response = await graphqlRequest(request, query, variables, authToken);
        expect(response.ok()).toBeTruthy();

        const data = await response.json();
        expect(data.data.addToWatchlist.success).toBeTruthy();
        expect(data.data.addToWatchlist.inWatchlist).toBeTruthy();
    });

    test('should fetch user watchlist (authenticated)', async ({ request }) => {
        const query = `
      query {
        myWatchlist(first: 10) {
          data {
            id
            make
            model
          }
          paginatorInfo {
            total
          }
        }
      }
    `;

        const response = await graphqlRequest(request, query, {}, authToken);
        expect(response.ok()).toBeTruthy();

        const data = await response.json();
        expect(data.data.myWatchlist).toBeDefined();
        expect(Array.isArray(data.data.myWatchlist.data)).toBeTruthy();
    });

    test('should toggle watchlist (authenticated)', async ({ request }) => {
        const query = `
      mutation ToggleWatchlist($carId: ID!) {
        toggleWatchlist(carId: $carId) {
          success
          inWatchlist
        }
      }
    `;

        const variables = {
            carId,
        };

        // First toggle (remove)
        const response1 = await graphqlRequest(request, query, variables, authToken);
        expect(response1.ok()).toBeTruthy();
        const data1 = await response1.json();
        expect(data1.data.toggleWatchlist.success).toBeTruthy();
        expect(data1.data.toggleWatchlist.inWatchlist).toBeFalsy();

        // Second toggle (add back)
        const response2 = await graphqlRequest(request, query, variables, authToken);
        expect(response2.ok()).toBeTruthy();
        const data2 = await response2.json();
        expect(data2.data.toggleWatchlist.success).toBeTruthy();
        expect(data2.data.toggleWatchlist.inWatchlist).toBeTruthy();
    });

    test('should remove car from watchlist (authenticated)', async ({ request }) => {
        const query = `
      mutation RemoveFromWatchlist($carId: ID!) {
        removeFromWatchlist(carId: $carId) {
          success
          inWatchlist
        }
      }
    `;

        const variables = {
            carId,
        };

        const response = await graphqlRequest(request, query, variables, authToken);
        expect(response.ok()).toBeTruthy();

        const data = await response.json();
        expect(data.data.removeFromWatchlist.success).toBeTruthy();
        expect(data.data.removeFromWatchlist.inWatchlist).toBeFalsy();
    });

    test('should update user profile (authenticated)', async ({ request }) => {
        const query = `
      mutation UpdateProfile($input: UpdateProfileInput!) {
        updateProfile(input: $input) {
          id
          name
          phone
        }
      }
    `;

        const variables = {
            input: {
                currentPassword: testPassword,
                name: 'Updated E2E User',
                phone: '+9876543210',
            },
        };

        const response = await graphqlRequest(request, query, variables, authToken);
        expect(response.ok()).toBeTruthy();

        const data = await response.json();
        expect(data.data.updateProfile).toBeDefined();
        expect(data.data.updateProfile.name).toBe('Updated E2E User');
        expect(data.data.updateProfile.phone).toBe('+9876543210');
    });

    test('should delete a car (authenticated)', async ({ request }) => {
        const query = `
      mutation DeleteCar($id: ID!) {
        deleteCar(id: $id) {
          message
          success
        }
      }
    `;

        const variables = {
            id: carId,
        };

        const response = await graphqlRequest(request, query, variables, authToken);
        expect(response.ok()).toBeTruthy();

        const data = await response.json();
        expect(data.data.deleteCar.success).toBeTruthy();
    });

    test('should logout user (authenticated)', async ({ request }) => {
        const query = `
      mutation {
        logout {
          message
          success
        }
      }
    `;

        const response = await graphqlRequest(request, query, {}, authToken);
        expect(response.ok()).toBeTruthy();

        const data = await response.json();
        expect(data.data.logout.success).toBeTruthy();
    });

    test('should handle authentication errors', async ({ request }) => {
        const query = `
      mutation CreateCar($input: CreateCarInput!) {
        createCar(input: $input) {
          id
        }
      }
    `;

        const variables = {
            input: {
                make: 'Test',
                model: 'Car',
                year: 2024,
                price: 10000,
                mileage: 0,
            },
        };

        // Attempt without auth token
        const response = await graphqlRequest(request, query, variables);
        const data = await response.json();

        // Should have errors
        expect(data.errors).toBeDefined();
    });

    test('should handle validation errors', async ({ request }) => {
        const query = `
      mutation Register($input: RegisterInput!) {
        register(input: $input) {
          token
        }
      }
    `;

        const variables = {
            input: {
                name: 'Test',
                email: 'invalid-email',
                password: '123',
                passwordConfirmation: '456',
            },
        };

        const response = await graphqlRequest(request, query, variables);
        const data = await response.json();

        // Should have errors
        expect(data.errors).toBeDefined();
    });

    test('should handle not found errors', async ({ request }) => {
        const query = `
      query {
        car(id: "99999999") {
          id
        }
      }
    `;

        const response = await graphqlRequest(request, query);
        const data = await response.json();

        // Should return null or error
        expect(data.data?.car === null || data.errors).toBeTruthy();
    });
});
