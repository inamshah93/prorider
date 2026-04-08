# ProRider API Documentation (v1)

Base URL (local from `.env`): `http://prorider.test/`

All endpoints below are prefixed with:

- `{{BASE_URL}}/api/v1`

Example:

- `http://prorider.test/api/v1/login`

## Authentication

This API uses **Laravel Sanctum** personal access tokens.

- **Send token in header**: `Authorization: Bearer <token>`
- **Content-Type**: `application/json`

### Common response envelope

Most endpoints return:

- `status`: boolean
- `message`: string
- `data`: object/array (when applicable)

Validation errors are typically `422` with Laravel’s default validation body.

## Endpoints

### Auth

#### Register

- **POST** `/register`
- **Auth**: No

**Request body**

```json
{
  "name": "Sender One",
  "email": "sender1@example.com",
  "phone": "+923001112233",
  "password": "secret123",
  "password_confirmation": "secret123",
  "role": "sender"
}
```

**Validation rules (from `RegisterRequest`)**

- `name`: required, string, max 100
- `email`: required, email, unique `users.email`
- `phone`: required, string, max 20, unique `users.phone`
- `password`: required, min 6, confirmed
- `role`: optional, in `sender,rider,reciver,admin` *(note: `reciver` spelling is as in code)*

**201/200 success (actual controller returns 200)**

```json
{
  "status": true,
  "message": "Registration successful",
  "token": "1|<sanctum_token_here>",
  "user": {
    "id": 1,
    "name": "Sender One",
    "email": "sender1@example.com",
    "phone": "+923001112233",
    "role": "sender",
    "created_at": "2026-04-08T10:00:00.000000Z",
    "updated_at": "2026-04-08T10:00:00.000000Z"
  }
}
```

#### Login

- **POST** `/login`
- **Auth**: No

**Request body**

```json
{
  "email": "sender1@example.com",
  "password": "secret123"
}
```

**200 success**

```json
{
  "status": true,
  "message": "Login successful",
  "token": "1|<sanctum_token_here>",
  "user": {
    "id": 1,
    "name": "Sender One",
    "email": "sender1@example.com",
    "phone": "+923001112233",
    "role": "sender",
    "created_at": "2026-04-08T10:00:00.000000Z",
    "updated_at": "2026-04-08T10:00:00.000000Z"
  }
}
```

**401 invalid credentials**

```json
{
  "status": false,
  "message": "Invalid credentials"
}
```

#### Logout

- **POST** `/logout`
- **Auth**: Yes (Bearer token)

**200 success**

```json
{
  "status": true,
  "message": "Logged out successfully"
}
```

#### Profile (current user)

- **GET** `/profile`
- **Auth**: Yes

**200 success**

```json
{
  "status": true,
  "message": "Login successful",
  "user": {
    "id": 1,
    "name": "Sender One",
    "email": "sender1@example.com",
    "phone": "+923001112233",
    "role": "sender"
  }
}
```

---

### Sender

#### Get sender profile

- **GET** `/sender/profile`
- **Auth**: Yes

**200 success**

```json
{
  "status": true,
  "message": "Sender profile retrieved",
  "data": {
    "user": { "id": 1, "name": "Sender One", "email": "sender1@example.com", "phone": "+923001112233", "role": "sender" },
    "profile": {
      "id": 10,
      "user_id": 1,
      "business_name": "Sender One Store",
      "pickup_address": "Shop #12, Main Boulevard",
      "contact_person": "Ali",
      "default_pickup_location_id": 55
    }
  }
}
```

#### Update sender profile

- **PUT** `/sender/profile`
- **Auth**: Yes

**Request body**

```json
{
  "name": "Sender One Updated",
  "phone": "+923009999999",
  "business_name": "Sender One Store",
  "pickup_address": "Shop #12, Main Boulevard",
  "contact_person": "Ali",
  "password": "newsecret123",
  "password_confirmation": "newsecret123"
}
```

**Validation rules (from `UpdateSenderProfileRequest`)**

- `name`: sometimes|required, string, max 255
- `phone`: sometimes|required, string, max 20
- `business_name`: nullable|string|max 255
- `pickup_address`: nullable|string|max 1000
- `contact_person`: nullable|string|max 1000
- `password`: nullable|string|min 6|confirmed

**200 success**

```json
{
  "status": true,
  "message": "Profile updated",
  "data": {
    "user": { "id": 1, "name": "Sender One Updated", "email": "sender1@example.com", "phone": "+923009999999", "role": "sender" },
    "profile": { "id": 10, "user_id": 1, "business_name": "Sender One Store", "pickup_address": "Shop #12, Main Boulevard", "contact_person": "Ali" }
  }
}
```

---

### Orders (Sender)

#### List my orders

- **GET** `/orders`
- **Auth**: Yes

Returns a **paginated** response (`paginate(12)`), so `data` will include `data`, `links`, `meta` keys typical to Laravel pagination.

**200 success (shape)**

```json
{
  "status": true,
  "message": "Orders fetched",
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 123,
        "sender_id": 1,
        "receiver_id": 9,
        "pickup_location_id": 55,
        "tracking_number": "PR-AB12CD34",
        "status": "created",
        "cod_amount": 250,
        "total_amount": 1500,
        "pickup_address": "Shop #12, Main Boulevard",
        "delivery_address": "Street 3, House 10",
        "weight_kg": 1.5,
        "items": [
          { "id": 1, "order_id": 123, "name": "T-Shirt", "quantity": 2, "price": 500 }
        ],
        "receiver": { "id": 9, "name": "Receiver One", "phone": "+923001234567" },
        "pickup_location": { "id": 55, "address": "Shop #12, Main Boulevard", "city": "Lahore" }
      }
    ],
    "last_page": 1,
    "per_page": 12,
    "total": 1
  }
}
```

#### Create order

- **POST** `/orders`
- **Auth**: Yes

**Request body (example)**

```json
{
  "pickup_location_id": 55,
  "receiver_id": 9,
  "items": [
    { "name": "T-Shirt", "quantity": 2, "price": 500 },
    { "name": "Cap", "quantity": 1, "price": 300 }
  ],
  "cod_amount": 250,
  "pickup_address": "Shop #12, Main Boulevard",
  "delivery_address": "Street 3, House 10",
  "weight_kg": 1.5
}
```

**Validation rules (from `StoreOrderRequest`)**

- `pickup_location_id`: nullable|exists `pickup_locations.id`
- `receiver_id`: required|exists `receivers.id`
- `items`: required|array|min 1
- `items.*.name`: required|string
- `items.*.quantity`: required|integer|min 1
- `items.*.price`: required|numeric|min 0
- `cod_amount`: nullable|numeric|min 0
- `pickup_address`: nullable|string|max 1000
- `delivery_address`: nullable|string|max 1000
- `weight_kg`: nullable|numeric|min 0

**201 success**

```json
{
  "status": true,
  "message": "Order created successfully",
  "data": {
    "id": 123,
    "sender_id": 1,
    "pickup_location_id": 55,
    "receiver_id": 9,
    "tracking_number": "PR-AB12CD34",
    "status": "created",
    "cod_amount": 250,
    "pickup_address": "Shop #12, Main Boulevard",
    "delivery_address": "Street 3, House 10",
    "weight_kg": 1.5,
    "total_amount": 1300,
    "created_at": "2026-04-08T10:00:00.000000Z",
    "updated_at": "2026-04-08T10:00:00.000000Z"
  }
}
```

#### Get order detail

- **GET** `/orders/{id}`
- **Auth**: Yes

**200 success**

```json
{
  "status": true,
  "message": "Order detail",
  "data": {
    "id": 123,
    "sender_id": 1,
    "receiver_id": 9,
    "tracking_number": "PR-AB12CD34",
    "status": "created",
    "items": [
      { "id": 1, "order_id": 123, "name": "T-Shirt", "quantity": 2, "price": 500 }
    ],
    "receiver": { "id": 9, "name": "Receiver One", "phone": "+923001234567" },
    "pickup_location": { "id": 55, "address": "Shop #12, Main Boulevard" },
    "tracking": [
      { "id": 88, "order_id": 123, "user_id": 1, "event": "created", "notes": null }
    ]
  }
}
```

**403 if you don’t own the order**

```json
{
  "status": false,
  "message": "Unauthorized"
}
```

#### Cancel order

- **POST** `/orders/{id}/cancel`
- **Auth**: Yes

**Request body (optional)**

```json
{
  "reason": "Customer requested cancellation"
}
```

**200 success**

```json
{
  "status": true,
  "message": "Order cancelled",
  "data": {
    "id": 123,
    "status": "cancelled"
  }
}
```

**422 cannot cancel when in progress**

```json
{
  "status": false,
  "message": "Cannot cancel. Order already in progress."
}
```

---

### Receivers (Address Book)

All receiver routes are mounted via `Route::apiResource('receivers', ...)` with:

- `index`, `store`, `show`, `update`, `destroy`

#### List receivers

- **GET** `/receivers`
- **Auth**: Yes

Returns a **paginated** list (`paginate(20)`).

**200 success (shape)**

```json
{
  "status": true,
  "message": "Receivers list",
  "data": {
    "current_page": 1,
    "data": [
      { "id": 9, "user_id": 1, "name": "Receiver One", "phone": "+923001234567", "address": "Street 3, House 10", "zone_id": 2 }
    ],
    "per_page": 20,
    "total": 1
  }
}
```

#### Create receiver

- **POST** `/receivers`
- **Auth**: Yes

**Request body**

```json
{
  "name": "Receiver One",
  "phone": "+923001234567",
  "address": "Street 3, House 10",
  "zone_id": 2
}
```

**Validation rules (from `StoreReceiverRequest`)**

- `name`: required|string|max 150
- `phone`: required|string|max 20
- `address`: nullable|string|max 1000
- `zone_id`: nullable|exists `zones.id`

**201 success**

```json
{
  "status": true,
  "message": "Receiver created",
  "data": { "id": 9, "user_id": 1, "name": "Receiver One", "phone": "+923001234567", "address": "Street 3, House 10", "zone_id": 2 }
}
```

#### Get receiver detail

- **GET** `/receivers/{receiver}`
- **Auth**: Yes

**200 success**

```json
{
  "status": true,
  "message": "Receiver detail",
  "data": { "id": 9, "user_id": 1, "name": "Receiver One", "phone": "+923001234567", "address": "Street 3, House 10", "zone_id": 2 }
}
```

**403 if receiver belongs to another user**

```json
{
  "status": false,
  "message": "Unauthorized"
}
```

#### Update receiver

- **PUT/PATCH** `/receivers/{receiver}`
- **Auth**: Yes

**Request body**

```json
{
  "address": "Street 4, House 12"
}
```

**Validation rules (from `UpdateReceiverRequest`)**

- `name`: sometimes|required|string|max 150
- `phone`: sometimes|required|string|max 20
- `address`: nullable|string|max 1000
- `zone_id`: nullable|exists `zones.id`

**200 success**

```json
{
  "status": true,
  "message": "Receiver updated",
  "data": { "id": 9, "user_id": 1, "name": "Receiver One", "phone": "+923001234567", "address": "Street 4, House 12", "zone_id": 2 }
}
```

#### Delete receiver

- **DELETE** `/receivers/{receiver}`
- **Auth**: Yes

**200 success**

```json
{
  "status": true,
  "message": "Receiver deleted"
}
```

---

### Pickup Locations

#### List pickup locations

- **GET** `/pickup-locations`
- **Auth**: Yes

**200 success**

```json
{
  "status": true,
  "message": "Pickup locations fetched successfully",
  "data": [
    { "id": 55, "user_id": 1, "address": "Shop #12, Main Boulevard", "city": "Lahore", "latitude": 31.5204, "longitude": 74.3587, "is_default": true }
  ]
}
```

#### Create pickup location

- **POST** `/pickup-locations`
- **Auth**: Yes

**Request body**

```json
{
  "address": "Shop #12, Main Boulevard",
  "city": "Lahore",
  "latitude": 31.5204,
  "longitude": 74.3587,
  "is_default": true
}
```

**Validation rules (inline in controller)**

- `address`: required|string|max 255
- `city`: nullable|string|max 100
- `latitude`: nullable|numeric
- `longitude`: nullable|numeric
- `is_default`: nullable|boolean

Notes (from controller behavior):

- First pickup location for a user is forced to `is_default = true`
- If `is_default=true`, other pickup locations are set to `is_default=false`
- When default is set, it also updates `sender_profiles.default_pickup_location_id`

**201 success**

```json
{
  "status": true,
  "message": "Pickup location added successfully",
  "data": { "id": 55, "user_id": 1, "address": "Shop #12, Main Boulevard", "city": "Lahore", "latitude": 31.5204, "longitude": 74.3587, "is_default": true }
}
```

#### Update pickup location

- **PUT** `/pickup-locations/{id}`
- **Auth**: Yes

**Request body**

```json
{
  "address": "Shop #12, Main Boulevard (Gate B)",
  "is_default": true
}
```

**200 success**

```json
{
  "status": true,
  "message": "Pickup location updated successfully",
  "data": { "id": 55, "user_id": 1, "address": "Shop #12, Main Boulevard (Gate B)", "is_default": true }
}
```

#### Make default pickup location

- **POST** `/pickup-locations/{id}/make-default`
- **Auth**: Yes

**200 success**

```json
{
  "status": true,
  "message": "Default pickup location updated successfully",
  "data": { "id": 55, "user_id": 1, "address": "Shop #12, Main Boulevard", "is_default": true }
}
```

#### Delete pickup location

- **DELETE** `/pickup-locations/{id}`
- **Auth**: Yes

**200 success**

```json
{
  "status": true,
  "message": "Pickup location deleted successfully"
}
```

---

### Notifications (test)

#### Send push notification (test)

- **POST** `/test-notification`
- **Auth**: Yes

Controller expects these fields (no explicit validation currently):

- `fcm_token`: array of tokens (it uses `fcm_token[0]` and also supports multicast)
- `title`: string
- `message`: string

**Request body (example)**

```json
{
  "fcm_token": ["<FCM_DEVICE_TOKEN_1>", "<FCM_DEVICE_TOKEN_2>"],
  "title": "Hello",
  "message": "Test push from ProRider"
}
```

**200 success**

```json
{
  "status": true,
  "message": "Push notification sent successfully"
}
```

---

## Ready-to-copy curl examples

Set variables:

```bash
BASE_URL="http://prorider.test"
TOKEN="1|<sanctum_token_here>"
```

Login:

```bash
curl -sS "$BASE_URL/api/v1/login" \
  -H "Content-Type: application/json" \
  -d '{"email":"sender1@example.com","password":"secret123"}'
```

Create order:

```bash
curl -sS "$BASE_URL/api/v1/orders" \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "pickup_location_id": 55,
    "receiver_id": 9,
    "items": [
      { "name": "T-Shirt", "quantity": 2, "price": 500 }
    ],
    "cod_amount": 0,
    "pickup_address": "Shop #12, Main Boulevard",
    "delivery_address": "Street 3, House 10",
    "weight_kg": 1.2
  }'
```

