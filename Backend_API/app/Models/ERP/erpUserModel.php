<?php

namespace App\Models\ERP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class erpUserModel extends Model
{
    use HasFactory;
    protected $table='erp.gmtmaster.tbl_user_info_hdr';
    protected $primarykey='User_id_user_hdr';

    protected $hidden=[
        'Password_user_hdr'
    ];
}
