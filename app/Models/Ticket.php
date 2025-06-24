<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
        'priority',
        'status',
        'user_id',
        'agent_id',
    ];

    protected $dates = ['due_date'];

    // Le client qui a créé le ticket
    public function client()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // L'agent assigné au ticket
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    // Les commentaires du ticket
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}

