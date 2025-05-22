<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;

    // The table associated with the model (optional if the table is `otps`)
    protected $table = 'otps';

    // The attributes that are mass assignable
    protected $fillable = [
        'phone_number',
        'otp',
        'expires_at',
    ];

    // Cast the `expires_at` field to a Carbon (date-time) instance
    protected $casts = [
        'expires_at' => 'datetime',
    ];
}
