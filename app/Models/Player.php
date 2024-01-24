<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'position', 'back_number', 'created_by', 'modified_by', 'updated_at', 'created_at'
    ];

    public $timestamps = false;
}
