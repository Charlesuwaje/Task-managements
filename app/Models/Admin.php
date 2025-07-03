<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Model
{
    use HasApiTokens,HasFactory,HasUlids,Notifiable;

    protected $table = 'admins';
    
    protected $fillable = ['name', 'email', 'password', 'admin_role_id'];

    public function role()
    {
        return $this->belongsTo(Role::class, 'admin_role_id');
    }
}
