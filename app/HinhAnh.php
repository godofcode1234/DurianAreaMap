<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HinhAnh extends Model
{
    public $timestamps = false;

    protected $table = 'hinhanh';
    protected $primaryKey = 'madiadiem';
    public function diadiemsatlo(){
        return $this->belongsTo(Diadiemsatlo::class, 'madiadiem');
      }
}