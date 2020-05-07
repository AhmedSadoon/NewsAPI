<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    protected $fillable=[
        'content','date_written','user_id','post_id',
    ];
}
