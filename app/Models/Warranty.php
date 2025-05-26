<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warranty extends Model
{
    //
    protected $table      = 'warrantyregistered';
    protected $primaryKey = 'id';

    public function user()
    {
        return $this->belongsTo(User::class);

    }

}
