<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chat extends Model
{
    use HasFactory;
    protected $fillable = [
        'sender', 'receiver',  'massage' , 'status'
    ];
    public function Sender(){
        return $this->hasOne(User::class, 'id', 'sender');
    }
    public function Receiver(){
        return $this->hasOne(User::class, 'id', 'receiver');
    }
}
