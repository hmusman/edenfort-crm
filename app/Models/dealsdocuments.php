<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class dealsdocuments extends Model
{
    protected $table = 'dealsdocuments';

    protected $fillable = ['deal_id','file_path','file_name'];
    
}
