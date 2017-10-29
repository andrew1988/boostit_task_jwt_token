<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    protected $table = 'cities';
    protected $fillable = ['city','user_id','measuring_uni'];

    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
}
