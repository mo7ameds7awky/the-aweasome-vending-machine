<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    public const ROLES = [
        'SELLER' => 'seller',
        'BUYER' => 'buyer',
    ];
}
