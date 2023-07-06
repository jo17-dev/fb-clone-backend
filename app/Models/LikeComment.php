<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeComment extends Model
{
    use HasFactory;

    protected $table = 'comment_likes';

    protected $fillable = [
        'id_owner',
        'id_comment'
    ];
}
