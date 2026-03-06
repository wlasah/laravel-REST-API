# Spatie Laravel Permissions - Authorization Setup

## ✅ Re-implemented Successfully!

Your Laravel API now has complete role-based authorization using Spatie Laravel Permissions with:

### 3 Default Roles:
- `admin` - Full access (view, create, edit, delete)
- `editor` - Can view, create, and edit
- `viewer` - Can only view

### 4 Default Permissions:
- `view users`
- `create users`
- `edit users`
- `delete users`

---

## 🔑 How to Use

### Step 1: Get a Token

**Register:**
```
POST http://localhost:8000/api/auth/register
Body:
{
  "name": "John Admin",
  "email": "admin@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

Or **Login:**
```
POST http://localhost:8000/api/auth/login
Body:
{
  "email": "admin@example.com",
  "password": "password123"
}
```

### Step 2: Copy Token & Set in Thunder Client

In Authorization tab → Select **Bearer Token** → Paste your token

### Step 3: Assign Role to User

```
POST http://localhost:8000/api/roles/assign/1
Authorization: Bearer {your-token}
Body:
{
  "role": "admin"
}
```

Available roles: `admin`, `editor`, `viewer`

---

## 📋 Available Endpoints

### Authentication (No Token Required)
- `POST /api/auth/register` - Register new user
- `POST /api/auth/login` - Login user

### User Management (Requires Token)
- `GET /api/users` - Get all users
- `POST /api/users` - Create user
- `GET /api/users/{id}` - Get single user
- `PUT /api/users/{id}` - Update user
- `DELETE /api/users/{id}` - Delete user

### Role Management (Requires Token)
- `GET /api/roles` - Get all roles with permissions
- `POST /api/roles/assign/{userId}` - Assign role to user
  ```json
  {
    "role": "admin"
  }
  ```
- `POST /api/roles/remove/{userId}` - Remove role from user
  ```json
  {
    "role": "admin"
  }
  ```
- `GET /api/permissions` - Get all permissions

### User Roles (Requires Token)
- `GET /api/users/{userId}/roles` - Get user's roles and permissions

---

## 💡 Example Workflow

1. **Register:**
   ```
   POST /api/auth/register
   {
     "name": "Admin User",
     "email": "admin@test.com",
     "password": "password123",
     "password_confirmation": "password123"
   }
   ```

2. **Copy token from response** → Set in Authorization

3. **Assign admin role:**
   ```
   POST /api/roles/assign/1
   {
     "role": "admin"
   }
   ```

4. **Check user's roles:**
   ```
   GET /api/users/1/roles
   ```
   
   Response:
   ```json
   {
     "success": true,
     "data": {
       "user_id": 1,
       "user_name": "Admin User",
       "roles": ["admin"],
       "permissions": [
         "view users",
         "create users",
         "edit users",
         "delete users"
       ]
     }
   }
   ```

---

## 🔐 How to Check Permissions in Code

In your controllers:

```php
// Check if user has a specific permission
if ($user->can('delete users')) {
    // Allow deletion
}

// Check if user has a role
if ($user->hasRole('admin')) {
    // Admin-only logic
}
```

---

## 📝 Key Points

✅ All role/permission endpoints require authentication  
✅ Roles and permissions are cached - use `php artisan cache:clear` if issues  
✅ Users can have multiple roles  
✅ Permissions are inherited from roles  
✅ Use `$user->getRoleNames()` to get user's roles  
✅ Use `$user->getAllPermissions()` to get all user permissions  

