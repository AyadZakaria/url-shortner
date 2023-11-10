<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Short extends Model
{
    use HasFactory;

    protected $table = 'shorts';

    protected $fillable = ['hash', 'original_url', 'expiration_date'];

    protected $cast = [
        'expiration_date' => 'date',
    ];
}
