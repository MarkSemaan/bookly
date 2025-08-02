<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecommendationLog extends Model
{
      protected $fillable = ['user_id', 'book_ids', 'reason'];

}
