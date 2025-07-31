<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarrantyRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'dealer_name',
        'dealer_city',
        'place_of_purchase',
        'invoice_number',
        'upload_invoice',
    ];

    /**
     * A warranty registration has many products.
     */
    public function products()
    {
        return $this->hasMany(WarrantyProduct::class, 'warranty_registration_id');
    }

    public function remarks()
    {
        return $this->hasMany(WarrantyRemark::class);
    }

    public function logs()
    {
        return $this->hasMany(WarrantyLog::class, 'warranty_id')->latest();
    }



    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
