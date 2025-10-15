<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierProfile extends Model
{
    use HasFactory;
     protected $fillable = ['user_id','company_name','nid','phone','address','logo_path'];
    public function user(){ return $this->belongsTo(\App\Models\User::class,'user_id'); }
}
