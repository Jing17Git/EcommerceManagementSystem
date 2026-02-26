<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The roles available in the application.
     */
    const ROLE_ADMINISTRATOR = 'administrator';
    const ROLE_BUYER = 'buyer';
    const ROLE_SELLER = 'seller';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'current_role',
        // Store Profile Fields
        'store_name',
        'store_email',
        'store_description',
        'store_phone',
        'store_address',
        'store_logo',
        // Business Settings
        'auto_accept_orders',
        'low_stock_alerts',
        'email_notifications',
        // Shipping Preferences
        'default_shipping_carrier',
        'processing_time',
        'free_shipping_threshold',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'roles' => 'array',
            'auto_accept_orders' => 'boolean',
            'low_stock_alerts' => 'boolean',
            'email_notifications' => 'boolean',
            'free_shipping_threshold' => 'decimal:2',
        ];
    }

    /**
     * Check if the user is an administrator.
     */
    public function isAdministrator(): bool
    {
        return $this->role === self::ROLE_ADMINISTRATOR;
    }

    /**
     * Check if the user has a specific role.
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Get all roles for the user (from both role and roles columns).
     */
    public function getAllRoles(): array
    {
        $roles = [];
        
        // Always include the primary role
        if ($this->role) {
            $roles[] = $this->role;
        }
        
        // Include additional roles from JSON column
        if ($this->roles) {
            $additionalRoles = is_array($this->roles) ? $this->roles : json_decode($this->roles, true);
            if (is_array($additionalRoles)) {
                $roles = array_merge($roles, $additionalRoles);
            }
        }
        
        return array_unique($roles);
    }

    /**
     * Check if user has a specific role (including from roles JSON).
     */
    public function hasAnyRole(string|array $roles): bool
    {
        $userRoles = $this->getAllRoles();
        
        if (is_array($roles)) {
            return count(array_intersect($userRoles, $roles)) > 0;
        }
        
        return in_array($roles, $userRoles);
    }

    /**
     * Check if user is a buyer.
     */
    public function isBuyer(): bool
    {
        return $this->hasAnyRole(self::ROLE_BUYER);
    }

    /**
     * Check if user is a seller.
     */
    public function isSeller(): bool
    {
        return $this->hasAnyRole(self::ROLE_SELLER);
    }

    /**
     * Add a role to the user.
     */
    public function addRole(string $role): void
    {
        $roles = $this->roles ? (is_array($this->roles) ? $this->roles : json_decode($this->roles, true)) : [];
        
        if (!in_array($role, $roles)) {
            $roles[] = $role;
            $this->roles = $roles;
        }
    }

    /**
     * Remove a role from the user.
     */
    public function removeRole(string $role): void
    {
        $roles = $this->roles ? (is_array($this->roles) ? $this->roles : json_decode($this->roles, true)) : [];
        
        $roles = array_filter($roles, function($r) use ($role) {
            return $r !== $role;
        });
        
        $this->roles = array_values($roles);
    }

    /**
     * Get the current role to display (for UI purposes).
     */
    public function getCurrentRoleDisplay(): string
    {
        return $this->current_role ?? $this->role;
    }

    /**
     * Check if user can switch to a specific role.
     */
    public function canSwitchToRole(string $role): bool
    {
        // Any authenticated user can switch to buyer mode.
        if ($role === self::ROLE_BUYER) {
            return true;
        }

        return $this->hasAnyRole($role);
    }
}
