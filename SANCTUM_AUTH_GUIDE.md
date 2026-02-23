# Laravel Sanctum API Authentication Guide

## Setup Complete ✅

Your Laravel API now has complete authentication using Sanctum. Here's how to use it:

---

## 🔐 Authentication Flow

### Step 1: Register a New User
**POST** `http://localhost:8000/api/auth/register`

**Body (JSON):**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Response:**
```json
{
  "success": true,
  "message": "User registered successfully",
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "created_at": "2026-02-23T...",
      "updated_at": "2026-02-23T..."
    },
    "token": "1|abcdefghijklmnopqrstuvwxyz..."
  }
}
```

### Step 2: Login
**POST** `http://localhost:8000/api/auth/login`

**Body (JSON):**
```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "user": { ... },
    "token": "1|abcdefghijklmnopqrstuvwxyz..."
  }
}
```

---

## 🔑 Using Bearer Token in Thunder Client

1. Copy the token from the login/register response
2. In Thunder Client, go to the **Authorization** tab
3. Select **Bearer Token** from the dropdown
4. Paste the token
5. Now you can access protected routes!

### Header that will be sent:
```
Authorization: Bearer 1|abcdefghijklmnopqrstuvwxyz...
```

---

## 📋 Protected Routes (Requires Token)

### Get Current User
**GET** `http://localhost:8000/api/auth/me`
- **Headers:** Authorization: Bearer {token}

### Get All Users
**GET** `http://localhost:8000/api/users`
- **Headers:** Authorization: Bearer {token}

### Get Single User
**GET** `http://localhost:8000/api/users/1`
- **Headers:** Authorization: Bearer {token}

### Create User
**POST** `http://localhost:8000/api/users`
- **Headers:** Authorization: Bearer {token}
- **Body:**
```json
{
  "name": "Jane Doe",
  "email": "jane@example.com",
  "password": "password123"
}
```

### Update User
**PUT/PATCH** `http://localhost:8000/api/users/{id}`
- **Headers:** Authorization: Bearer {token}
- **Body:**
```json
{
  "name": "Updated Name",
  "email": "newemail@example.com"
}
```

### Delete User
**DELETE** `http://localhost:8000/api/users/{id}`
- **Headers:** Authorization: Bearer {token}

### Logout
**POST** `http://localhost:8000/api/auth/logout`
- **Headers:** Authorization: Bearer {token}

---

## 🧪 Testing Steps in Thunder Client

1. **Register**: POST to `/api/auth/register` → Copy the token
2. **Set Bearer Token**: In Authorization tab
3. **Test Protected Routes**: GET `/api/users` (should work now)
4. **Create User**: POST `/api/users` with token
5. **Update User**: PUT `/api/users/1` with token
6. **Get User**: GET `/api/users/1` with token
7. **Delete User**: DELETE `/api/users/1` with token
8. **Logout**: POST `/api/auth/logout` with token (revokes the token)

---

## ⚠️ Error Handling

The API now catches all exceptions and returns JSON responses:

- **401 Unauthenticated**: No token or invalid token
- **403 Unauthorized**: Authentication fails
- **404 Not Found**: Resource not found
- **422 Validation Error**: Invalid input
- **405 Method Not Allowed**: Wrong HTTP method
- **500 Server Error**: Internal error

---

## 🚀 Start Your Server

```bash
php artisan serve
```

Then access: `http://localhost:8000`

---

## 📝 Notes

- All protected routes require a valid Bearer token
- Tokens are stored in the `personal_access_tokens` table
- When you logout, your token is revoked
- You can create multiple tokens per user
- Passwords are hashed using bcrypt

