<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikePost extends Model
{
    use HasFactory;

    protected $table = "post_likes";

    protected $fillable = [
        'id_owner',
        'id_post'
    ];
}
