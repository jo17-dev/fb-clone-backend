<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMessage extends Model
{
    use HasFactory;

    protected $table = 'group_messages';

    protected $fillable = [
        'id_group',
        'id_owner',
        'content'
    ];
}
