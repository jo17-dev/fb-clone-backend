<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discution extends Model
{
    use HasFactory;

    protected $table = 'discutions';

    protected $fillable = [
        'first_user',
        'second_user'
    ];
}
