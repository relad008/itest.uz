<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketMessage extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function ticket()
    {
        return $this->hasOne(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
