<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_lengkap',
        'username',
        'email',
        'password',
        'role',
        'status',
        'verification_token',
        'verification_expiry',
        'reset_pass_token',
        'reset_pass_token_expiry',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
        'reset_pass_token',
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
            'verification_expiry' => 'datetime',
            'reset_pass_token_expiry' => 'datetime',
        ];
    }

    /**
     * Check if user account is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'Active';
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if verification token is valid and not expired.
     */
    public function isVerificationTokenValid(): bool
    {
        if (!$this->verification_token || !$this->verification_expiry) {
            return false;
        }

        return now()->lessThan($this->verification_expiry);
    }

    /**
     * Check if reset password token is valid and not expired.
     */
    public function isResetTokenValid(): bool
    {
        if (!$this->reset_pass_token || !$this->reset_pass_token_expiry) {
            return false;
        }

        return now()->lessThan($this->reset_pass_token_expiry);
    }

    /**
     * Scope for active users only.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    /**
     * Scope for admin users only.
     */
    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope for regular users only.
     */
    public function scopeUser($query)
    {
        return $query->where('role', 'user');
    }
}
