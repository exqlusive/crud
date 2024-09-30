## About this project

A simple booking system API based CRUD in Laravel where 

- Admins can crud locations
- Admins can crud reservations for a location
- Guests can read their reservations

_All routes except `/apo/auth` are behind authorization. The authorization is based on a Bearer token, which you can get by calling the `/auth/login` endpoint with the correct credentials._

## Endpoints
### Locations
- `GET /api/locations` - Get all locations
- `POST /api/locations` - Create a location
- `GET /api/locations/{id}` - Get a location
- `PUT /api/locations/{id}` - Update a location
- `GET /api/locations/{id}/reservations` - Get all reservations for a location
### Reservations
- `GET /api/reservations` - Get all reservations
- `POST /api/reservations` - Create a reservation
- `GET /api/reservations/{id}` - Get a reservation
- `PUT /api/reservations/{id}` - Update a reservation
### Users & Guests
- `POST /api/auth/register` - Register a user
- `POST /api/auth/login` - Login a user
- `GET /api/users` - Get the authenticated user
- `GET /api/users/reservations` - Get all reservations of the authenticated user
## Changelog
### 1.0.0
- Initial release
