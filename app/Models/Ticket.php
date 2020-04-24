<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function messages()
    {
        return $this->hasMany(TicketMessage::class, 'ticket_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
