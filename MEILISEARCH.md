# Meilisearch Integration

## Overview

This application uses [Meilisearch](https://www.meilisearch.com/) for fast, typo-tolerant full-text search across car listings. Meilisearch is integrated via Laravel Scout.

## Features

✅ **Instant Search** - Sub-50ms search responses  
✅ **Typo Tolerance** - Finds results even with misspellings (e.g., "Toyata" → "Toyota")  
✅ **Faceted Filtering** - Filter by maker, model, year, price, location, fuel type  
✅ **Sorting** - Sort by price, year, mileage, date created  
✅ **Pagination** - Efficient pagination for large result sets  
✅ **Real-time Indexing** - New/updated cars automatically indexed  

## Installation

### 1. Install Meilisearch Server

```bash
# Download and install
curl -L https://install.meilisearch.com | sh

# Start server
./meilisearch --master-key="YOUR_MASTER_KEY" --env="production"
```

### 2. Install Laravel Scout + Meilisearch SDK

```bash
composer require laravel/scout meilisearch/meilisearch-php http-interop/http-factory-guzzle
```

### 3. Publish Scout Configuration

```bash
php artisan vendor:publish --provider="Laravel\Scout\ScoutServiceProvider"
```

### 4. Configure Environment

Add to `.env`:

```env
SCOUT_DRIVER=meilisearch
MEILISEARCH_HOST=http://127.0.0.1:7700
MEILISEARCH_KEY=YOUR_MASTER_KEY
```

### 5. Import Existing Data

```bash
php artisan scout:import "App\Models\Car"
```

## Usage

### API Endpoint

**Endpoint:** `GET /api/v1/cars/search`

### Parameters

| Parameter | Type | Description | Example |
|-----------|------|-------------|---------|
| `q` | string | Search query (title, description, maker, model) | `BMW X5` |
| `maker` | string | Filter by car maker | `Toyota` |
| `model` | string | Filter by car model | `Camry` |
| `year` | integer | Filter by exact year | `2021` |
| `min_price` | integer | Minimum price | `10000` |
| `max_price` | integer | Maximum price | `50000` |
| `fuel_type` | string | Filter by fuel type | `Hybrid` |
| `car_type` | string | Filter by car type | `SUV` |
| `city` | string | Filter by city | `Phoenix` |
| `state` | string | Filter by state | `Arizona` |
| `is_featured` | boolean | Show only featured cars | `true` |
| `sort_by` | string | Sort field (price, year, mileage, created_at) | `price` |
| `sort_order` | string | Sort order (asc, desc) | `asc` |
| `per_page` | integer | Results per page (max 100) | `20` |
| `page` | integer | Page number | `1` |

### Example Requests

#### Basic Text Search
```bash
curl "http://localhost:8000/api/v1/cars/search?q=BMW"
```

#### Search with Filters
```bash
curl "http://localhost:8000/api/v1/cars/search?q=Toyota&year=2020&city=Phoenix"
```

#### Price Range Search
```bash
curl "http://localhost:8000/api/v1/cars/search?q=&min_price=10000&max_price=30000&sort_by=price&sort_order=asc"
```

#### Search by Location
```bash
curl "http://localhost:8000/api/v1/cars/search?q=&state=California&fuel_type=Electric"
```

### Response Format

```json
{
  "data": [
    {
      "id": 1,
      "make": {
        "id": 2,
        "name": "Toyota"
      },
      "model": {
        "id": 5,
        "name": "Camry"
      },
      "year": 2020,
      "price": {
        "amount": 22400,
        "currency": "USD",
        "formatted": "$22,400"
      },
      "mileage": 45000,
      "location": {
        "city": "Phoenix",
        "state": "Arizona"
      },
      "description": "Well maintained Toyota Camry...",
      "images": [...],
      "owner": {...},
      "links": {...}
    }
  ],
  "meta": {
    "current_page": 1,
    "per_page": 20,
    "total": 42,
    "last_page": 3
  }
}
```

## Management Commands

### Re-index All Cars
```bash
php artisan scout:import "App\Models\Car"
```

### Clear and Re-index
```bash
php artisan scout:flush "App\Models\Car"
php artisan scout:import "App\Models\Car"
```

### Index Statistics
```bash
curl -H "Authorization: Bearer YOUR_MASTER_KEY" \
  http://127.0.0.1:7700/indexes/cars_index/stats
```

## Model Configuration

The `Car` model is configured to automatically sync with Meilisearch:

```php
use Laravel\Scout\Searchable;

class Car extends Model
{
    use Searchable;

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->getTitle(),
            'year' => $this->year,
            'price' => $this->price,
            'mileage' => $this->mileage,
            'description' => $this->description,
            'maker' => $this->maker->name,
            'model' => $this->model->name,
            'fuel_type' => $this->fuelType->name,
            'car_type' => $this->carType->name,
            'city' => $this->city->name,
            'state' => $this->city->state->name,
            'location' => $this->city->name . ', ' . $this->city->state->name,
            'is_featured' => (bool) $this->is_featured,
            'created_at' => $this->created_at->timestamp,
        ];
    }

    public function searchableAs(): string
    {
        return 'cars_index';
    }
}
```

### Auto-indexing Behavior

- **Create:** New car automatically added to index
- **Update:** Car data automatically updated in index  
- **Delete:** Car automatically removed from index
- **Soft Delete:** Car removed from index (can be restored)

## Index Configuration

### Searchable Attributes
- `title` (car title: "2020 - Toyota Camry")
- `description`
- `maker` (Toyota, Honda, etc.)
- `model` (Camry, Civic, etc.)
- `location` (combined city + state)
- `fuel_type`
- `car_type`

### Filterable Attributes
- `maker`
- `model`
- `year`
- `fuel_type`
- `car_type`
- `city`
- `state`
- `is_featured`
- `price`
- `mileage`

### Sortable Attributes
- `price`
- `year`
- `created_at`
- `mileage`

## Performance

### Current Stats (399 cars indexed)
- **Index Size:** 160KB
- **Avg Document Size:** 402 bytes
- **Search Time:** 10-50ms
- **Indexing:** Real-time (on model save)

### Optimization Tips

1. **Use Filters** - More specific filters = faster results
2. **Limit Results** - Don't fetch more than needed
3. **Pagination** - Use offset-based pagination
4. **Caching** - Cache popular searches in Redis
5. **Monitoring** - Monitor index size and query performance

## Production Deployment

### Run as Service (systemd)

Create `/etc/systemd/system/meilisearch.service`:

```ini
[Unit]
Description=Meilisearch
After=network.target

[Service]
Type=simple
User=www-data
WorkingDirectory=/var/www/car-marketplace
ExecStart=/usr/local/bin/meilisearch --master-key="SECURE_KEY" --env="production"
Restart=on-failure

[Install]
WantedBy=multi-user.target
```

Enable and start:
```bash
sudo systemctl enable meilisearch
sudo systemctl start meilisearch
```

### Environment Variables

```env
# Production
SCOUT_DRIVER=meilisearch
MEILISEARCH_HOST=http://127.0.0.1:7700
MEILISEARCH_KEY=SECURE_RANDOM_KEY_HERE

# Enable queue for large imports
SCOUT_QUEUE=true
```

### Security

1. **Use strong master key** - Generate with `openssl rand -base64 32`
2. **Restrict network access** - Bind to localhost or use firewall
3. **Enable HTTPS** - Use reverse proxy (Nginx) for TLS
4. **API keys** - Create search-only API keys for frontend

### Monitoring

Check health:
```bash
curl http://127.0.0.1:7700/health
```

View stats:
```bash
curl -H "Authorization: Bearer YOUR_KEY" \
  http://127.0.0.1:7700/indexes/cars_index/stats
```

## Troubleshooting

### Index Not Updating

```bash
# Check Scout is enabled
php artisan tinker
>>> config('scout.driver')  // Should be 'meilisearch'

# Re-import manually
php artisan scout:flush "App\Models\Car"
php artisan scout:import "App\Models\Car"
```

### Connection Issues

```bash
# Check Meilisearch is running
curl http://127.0.0.1:7700/health

# Check env variables
php artisan config:clear
php artisan config:cache
```

### Slow Searches

```bash
# Check index settings
curl -H "Authorization: Bearer YOUR_KEY" \
  http://127.0.0.1:7700/indexes/cars_index/settings

# Optimize filters
# Use specific filters instead of broad text searches
```

## Resources

- [Meilisearch Documentation](https://www.meilisearch.com/docs)
- [Laravel Scout Documentation](https://laravel.com/docs/scout)
- [Meilisearch Laravel Guide](https://www.meilisearch.com/docs/guides/laravel_scout)
- [Meilisearch API Reference](https://www.meilisearch.com/docs/reference/api)

## Testing

Run search tests:
```bash
# Basic search
curl "http://localhost:8000/api/v1/cars/search?q=Toyota"

# Typo tolerance
curl "http://localhost:8000/api/v1/cars/search?q=Toyata"

# Complex filters
curl "http://localhost:8000/api/v1/cars/search?q=SUV&year=2020&city=Phoenix&sort_by=price&sort_order=asc"
```

## Statistics (Current)

- **Total Indexed:** 399 cars
- **Index Size:** 163.84 KB
- **Fields Indexed:** 15 attributes per car
- **Search Performance:** <50ms average response time
- **Typo Tolerance:** ✅ Enabled (1-2 character edits)
- **Auto-sync:** ✅ Enabled
