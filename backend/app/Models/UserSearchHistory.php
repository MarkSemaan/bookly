<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSearchHistory extends Model
{
    protected $fillable = ['user_id', 'search_query'];

}
