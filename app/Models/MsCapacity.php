<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MsCapacity extends Model
{
    protected $guarded = [];

    // Untuk relasi ke tb ms_vendors
    public function jnsvendor(){
        return $this->belongsTo(MsVendor::class,'id_vendor_rel','id');
    }

}
