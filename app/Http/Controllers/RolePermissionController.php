<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    /**
     * Assign a role to a user.
     */
    public function assignRole(Request $request, $userId): JsonResponse
    {
        try {
            $request->validate([
                'role' => 'required|string|exists:roles,name',
            ]);

            $user = User::findOrFail($userId);
            $user->assignRole($request->role);

            return response()->json([
                'success' => true,
                'message' => "Role '{$request->role}' assigned to user successfully",
                'data' => [
                    'user' => $user->load('roles')
                ]
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error assigning role',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove a role from a user.
     */
    public function removeRole(Request $request, $userId): JsonResponse
    {
        try {
            $request->validate([
                'role' => 'required|string|exists:roles,name',
            ]);

            $user = User::findOrFail($userId);
            $user->removeRole($request->role);

            return response()->json([
                'success' => true,
                'message' => "Role '{$request->role}' removed from user successfully",
                'data' => [
                    'user' => $user->load('roles')
                ]
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error removing role',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's roles and permissions.
     */
    public function getUserRoles($userId): JsonResponse
    {
        try {
            $user = User::findOrFail($userId);

            return response()->json([
                'success' => true,
                'message' => 'User roles and permissions retrieved',
                'data' => [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'roles' => $user->getRoleNames(),
                    'permissions' => $user->getAllPermissions()->pluck('name')
                ]
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving roles',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all available roles.
     */
    public function getAllRoles(): JsonResponse
    {
        try {
            $roles = Role::with('permissions')->get();

            return response()->json([
                'success' => true,
                'message' => 'All roles retrieved',
                'data' => $roles
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving roles',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all available permissions.
     */
    public function getAllPermissions(): JsonResponse
    {
        try {
            $permissions = Permission::all();

            return response()->json([
                'success' => true,
                'message' => 'All permissions retrieved',
                'data' => $permissions
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving permissions',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
