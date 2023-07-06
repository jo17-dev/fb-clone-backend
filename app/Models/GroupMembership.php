<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMembership extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_group'
    ];

    protected $table = 'group_memberships';

}
