<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class MsNocReport extends Model
{
    protected $guarded = [];

    // Untuk relasi ke tb ms_users
    public function jnsuser(){
        return $this->belongsTo(User::class,'id_user_rel','id');
    }

    // Untuk relasi ke tb_links
    public function jnslink(){
        return $this->belongsTo(MsLink::class,'id_link_rel','id');
    }

}