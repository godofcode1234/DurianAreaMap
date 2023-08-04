<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diadiemsatlo extends Model
{
    public $timestamps = false;

    protected $table = 'diadiemsatlo';

    protected $primaryKey = 'madiadiem';

    protected $cascadeDeletes = ['hinhanh', 'video'];

    public function hinhanh()
    {
        return $this->hasMany(HinhAnh::class, 'madiadiem');
    }

    public function video()
    {
        return $this->hasMany(Video::class, 'madiadiem');
    }
}
