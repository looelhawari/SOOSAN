<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Owner extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'company',
        'address',
        'city',
        'country',
        'preferred_language',
        'company_image_url',
        'cloudinary_public_id',
    ];

    // Relationships
    public function soldProducts()
    {
        return $this->hasMany(SoldProduct::class);
    }
}
