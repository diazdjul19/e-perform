<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MsLink extends Model
{
    protected $guarded = [];

    // Untuk relasi ke tb ms_capacities
    public function jnscapacity(){
        return $this->belongsTo(MsCapacity::class,'id_site_rel','id');
    }

    // Untuk relasi ke tb ms_capacities
    public function jnsclient(){
        return $this->belongsTo(MsClient::class,'id_client_rel','id');
    }

    // Untuk relasi ke tb ms_sites
    public function jnssite(){
        return $this->belongsTo(MsSite::class,'id_site_rel','id');
    }

    // Untuk relasi ke tb ms_vendors
    public function jnsvendor(){
        return $this->belongsTo(MsVendor::class,'id_vendor_rel','id');
    }

}
