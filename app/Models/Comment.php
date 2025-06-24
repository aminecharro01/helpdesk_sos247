<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'ticket_id',
        'user_id',
    ];

    // Le ticket concerné
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    // L'auteur du commentaire
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
