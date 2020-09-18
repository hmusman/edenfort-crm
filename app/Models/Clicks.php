<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clicks extends Model
{
    protected $table="clicks_history";

    protected $fillable = ['user_id', 'user_name','page_name','description'];
}
