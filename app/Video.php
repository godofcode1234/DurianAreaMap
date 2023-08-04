<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    public $timestamps = false;

    protected $table = 'video';
    protected $primaryKey = 'madiadiem';
    public function diadiemsatlo(){
        return $this->belongsTo(Diadiemsatlo::class, 'madiadiem');
      }
}
