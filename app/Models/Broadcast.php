<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Broadcast extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'title',
        'description',
        'category',
        'token',
        'stream_key'
    ];

    protected $hidden = [
         'created_at', 'updated_at', 'remember_token', 'id'
    ];
}
