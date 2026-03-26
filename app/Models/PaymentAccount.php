<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class PaymentAccount extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'account_number',
        'account_type',
        'account_name',
        'status',
        'description',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Scope for active accounts
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Scope for mobile money accounts
    public function scopeMobileMoney($query)
    {
        return $query->where('account_type', 'mobile_money');
    }

    // Scope for bank accounts
    public function scopeBank($query)
    {
        return $query->where('account_type', 'bank');
    }

    // Relationship with admin who created
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relationship with admin who updated
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
