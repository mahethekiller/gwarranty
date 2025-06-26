<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProduct extends Model
{
    //
    protected $table = 'user_product';

    protected $fillable = [
        'user_id',
        'product_id',
    ];

    public function product()
{
    return $this->belongsTo(Product::class);
}

}
