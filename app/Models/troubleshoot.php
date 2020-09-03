<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TroubleShoot extends Model
{
    protected $table = 'troubleshoot';

    protected $fillable = ['heading','description','video'];
}
