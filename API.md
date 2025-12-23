# 🚗 Car Marketplace API v1

Complete RESTful API for the car marketplace platform.

## 📖 Documentation

**Interactive API Documentation:** `/api/documentation` (Scramble-powered)

## 🔐 Authentication

The API uses Laravel Sanctum for token-based authentication.

### Get API Token

```bash
POST /api/v1/login
Content-Type: application/json

{
  "email": "user@example.com",
  "password": "password"
}
```

**Response:**
```json
{
  "message": "Login successful",
  "user": { ... },
  "token": "1|abc123...",
  "token_type": "Bearer"
}
```

### Use Token in Requests

```bash
GET /api/v1/user
Authorization: Bearer 1|abc123...
```

---

## 📚 Endpoints

### 🚘 Cars

#### List Cars (Public)
```http
GET /api/v1/cars?page=1&per_page=20
```

**Query Parameters:**
- `page` (integer): Page number (default: 1)
- `per_page` (integer): Results per page (default: 20, max: 100)
- `make_id` (integer): Filter by manufacturer
- `model_id` (integer): Filter by model
- `year` (integer): Filter by year
- `min_price` (integer): Minimum price
- `max_price` (integer): Maximum price
- `fuel_type_id` (integer): Filter by fuel type
- `city_id` (integer): Filter by city
- `state_id` (integer): Filter by state
- `sort_by` (string): Sort field (default: created_at)
- `sort_order` (string): asc or desc (default: desc)

**Response:**
```json
{
  "data": [
    {
      "id": 1,
      "make": { "id": 1, "name": "Toyota" },
      "model": { "id": 5, "name": "Camry" },
      "year": 2023,
      "price": {
        "amount": 25000,
        "currency": "USD",
        "formatted": "$25,000"
      },
      "mileage": 15000,
      "fuel_type": { "id": 1, "name": "Gasoline" },
      "location": {
        "city": "Los Angeles",
        "state": "California"
      },
      "images": [
        {
          "id": 1,
          "url": "https://car-hub.xyz/storage/images/car1.jpg",
          "position": 1,
          "is_primary": true
        }
      ],
      "owner": {
        "name": "John Doe"
      },
      "created_at": "2024-01-15T10:30:00Z",
      "links": {
        "self": "/api/v1/cars/1",
        "web": "/car/1"
      }
    }
  ],
  "meta": {
    "total": 150,
    "count": 20,
    "per_page": 20,
    "current_page": 1,
    "last_page": 8
  },
  "links": {
    "self": "/api/v1/cars?page=1",
    "first": "/api/v1/cars?page=1",
    "last": "/api/v1/cars?page=8",
    "prev": null,
    "next": "/api/v1/cars?page=2"
  }
}
```

#### Get Single Car (Public)
```http
GET /api/v1/cars/{id}
```

**Response:**
```json
{
  "id": 1,
  "make": { "id": 1, "name": "Toyota" },
  "model": { "id": 5, "name": "Camry" },
  "year": 2023,
  "price": { "amount": 25000, "currency": "USD", "formatted": "$25,000" },
  "mileage": 15000,
  "fuel_type": { "id": 1, "name": "Gasoline" },
  "car_type": { "id": 1, "name": "Sedan" },
  "location": {
    "city": "Los Angeles",
    "state": "California"
  },
  "description": "Well-maintained 2023 Toyota Camry...",
  "images": [...],
  "features": {
    "gps": true,
    "camera": true,
    "bluetooth": true,
    "air_conditioner": true,
    "abs": true,
    "leather_seats": false,
    "sunroof": false
  },
  "owner": {
    "name": "John Doe",
    "phone": "555-0123"
  },
  "is_favorite": false,
  "created_at": "2024-01-15T10:30:00Z",
  "updated_at": "2024-01-15T10:30:00Z",
  "links": {
    "self": "/api/v1/cars/1",
    "web": "/car/1"
  }
}
```

#### Search Cars (Public)
```http
GET /api/v1/cars/search?make_id=1&year=2023
```
(Same parameters and response as List Cars)

#### Create Car (Protected)
```http
POST /api/v1/cars
Authorization: Bearer {token}
Content-Type: application/json

{
  "maker_id": 1,
  "model_id": 5,
  "year": 2023,
  "price": 25000,
  "mileage": 15000,
  "fuel_type_id": 1,
  "car_type_id": 1,
  "city_id": 10,
  "state_id": 5,
  "description": "Well-maintained vehicle..."
}
```

**Response (201 Created):**
```json
{
  "message": "Car created successfully",
  "data": { ... }
}
```

#### Update Car (Protected)
```http
PUT /api/v1/cars/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
  "price": 24000,
  "mileage": 16000
}
```

**Response:**
```json
{
  "message": "Car updated successfully",
  "data": { ... }
}
```

#### Delete Car (Protected)
```http
DELETE /api/v1/cars/{id}
Authorization: Bearer {token}
```

**Response (204 No Content)**

---

### ⭐ Watchlist

#### Get Watchlist (Protected)
```http
GET /api/v1/watchlist
Authorization: Bearer {token}
```

**Response:**
```json
{
  "data": [ ... ],
  "meta": {
    "total": 5,
    "per_page": 20,
    "current_page": 1
  }
}
```

#### Toggle Car in Watchlist (Protected)
```http
POST /api/v1/watchlist/{car_id}
Authorization: Bearer {token}
```

**Response (Adding):**
```json
{
  "message": "Car added to watchlist",
  "in_watchlist": true
}
```

**Response (Removing):**
```json
{
  "message": "Car removed from watchlist",
  "in_watchlist": false
}
```

---

### 👤 User

#### Get Current User (Protected)
```http
GET /api/v1/user
Authorization: Bearer {token}
```

**Response:**
```json
{
  "id": 1,
  "name": "John Doe",
  "email": "john@example.com",
  "phone": "555-0123",
  "created_at": "2024-01-01T00:00:00Z"
}
```

#### Logout (Protected)
```http
POST /api/v1/logout
Authorization: Bearer {token}
```

**Response:**
```json
{
  "message": "Logged out successfully"
}
```

---

## 🚦 Rate Limiting

- **Authenticated requests:** 60 requests per minute
- **Public endpoints:** 60 requests per minute per IP

Rate limit headers are included in responses:
```
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
```

---

## 🔍 Error Responses

### Validation Error (422)
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "email": ["The email field is required."]
  }
}
```

### Unauthorized (401)
```json
{
  "message": "Unauthenticated."
}
```

### Forbidden (403)
```json
{
  "message": "Unauthorized"
}
```

### Not Found (404)
```json
{
  "message": "No query results for model [App\\Models\\Car]."
}
```

---

## 📦 Example: Full Workflow

### 1. Login
```bash
curl -X POST https://car-hub.xyz/api/v1/login \
  -H "Content-Type: application/json" \
  -d '{"email": "user@example.com", "password": "password"}'
```

### 2. Get Cars
```bash
curl https://car-hub.xyz/api/v1/cars?make_id=1&per_page=10
```

### 3. Create Car (with token)
```bash
curl -X POST https://car-hub.xyz/api/v1/cars \
  -H "Authorization: Bearer 1|abc123..." \
  -H "Content-Type: application/json" \
  -d '{
    "maker_id": 1,
    "model_id": 5,
    "year": 2023,
    "price": 25000,
    "mileage": 15000,
    "fuel_type_id": 1,
    "city_id": 10,
    "state_id": 5
  }'
```

### 4. Add to Watchlist
```bash
curl -X POST https://car-hub.xyz/api/v1/watchlist/1 \
  -H "Authorization: Bearer 1|abc123..."
```

---

## 🛠️ SDKs & Tools

### JavaScript/TypeScript
```javascript
const response = await fetch('https://car-hub.xyz/api/v1/cars', {
  headers: {
    'Authorization': 'Bearer ' + token,
    'Accept': 'application/json'
  }
});
const data = await response.json();
```

### PHP
```php
$client = new GuzzleHttp\Client();
$response = $client->get('https://car-hub.xyz/api/v1/cars', [
    'headers' => [
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json'
    ]
]);
$data = json_decode($response->getBody());
```

### Postman Collection
Import OpenAPI spec from `/api/documentation` into Postman

---

## 📊 Versioning

Current version: **v1**

Breaking changes will be released as new versions (v2, v3, etc.).  
Old versions remain supported for 12 months after deprecation notice.

---

## 🆘 Support

- **Documentation:** `/api/documentation`
- **Email:** support@car-hub.xyz
- **GitHub Issues:** [Report a bug](https://github.com/yourusername/laravella-storefront/issues)

---

## 📝 Changelog

### v1.0.0 (2024-12-18)
- Initial API release
- Car CRUD operations
- Watchlist management
- Search and filtering
- Sanctum authentication
- Rate limiting
