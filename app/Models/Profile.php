<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $guarded = ['isBanned'];

    protected $hidden = ['created_at', 'updated_at', 'isBanned'];

}
