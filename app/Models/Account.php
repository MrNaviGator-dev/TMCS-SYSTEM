<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $table = 'accounts';
    
    public $timestamps = false;

    protected $fillable = [
        'account_type',
        'sender_name',
        'account_number',
        'account_name',
        'branch_name',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('M d, Y');
    }

    // Scope for active accounts
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Scope for mobile accounts
    public function scopeMobile($query)
    {
        return $query->where('account_type', 'mobile');
    }

    // Scope for bank accounts
    public function scopeBank($query)
    {
        return $query->where('account_type', 'bank');
    }
}
