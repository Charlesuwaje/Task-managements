<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Task extends Model
{
    use HasFactory, SoftDeletes, Notifiable, HasUlids;
    protected $table = 'task';

    protected $fillable = [
        'title',
        'description',
        'assigned_to',
        'status',
        'due_date'
    ];


    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
