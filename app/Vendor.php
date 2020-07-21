<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $table = 'tbMatVendor';
    protected $primaryKey = 'MAT_CODE';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';
    protected $fillable = ['MAT_CODE','PLANT_CODE','VENDOR_ID','VENDOR_NAME'];
}
