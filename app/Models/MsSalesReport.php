<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;


class MsSalesReport extends Model
{
    protected $guarded = [];

    // Untuk relasi ke tb ms_users
    public function jnsuser(){
        return $this->belongsTo(User::class,'id_user_rel','id');
    }

    // Untuk relasi ke tb ms_clients
    public function jnsclient(){
        return $this->belongsTo(MsClient::class,'id_client_rel','id');
    }

    // Untuk relasi ke tb ms_capacities
    public function jnscapacity(){
        return $this->belongsTo(MsCapacity::class,'id_capacity_rel','id');
    }

    // Untuk relasi ke tb ms_sites
    public function jnssite(){
        return $this->belongsTo(MsSite::class,'id_site_rel','id');
    }



   
    
}
