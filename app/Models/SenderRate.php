<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SenderRate extends Model
{
    use HasFactory;

    protected $fillable = ['sender_id', 'delivery_rate', 'return_rate'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
