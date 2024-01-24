<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    use HasFactory;

    protected $fillable = [
        'username', 'password', 'token', 'created_at', 'updated_at'
    ];

    public $hidden = [
       'password', 'token'
    ];

    public $timestamps = false;
}

