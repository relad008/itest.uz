<?php

namespace App\Http\Controllers\API;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\TicketMessage;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{
    public function list()
    {
        $type = request()->input('type', 'all');

        $tickets = Ticket::withCount(['messages' => function ($query) {
            $query->where('user_id', '!=', auth()->user()->id);
        }])->where('user_id', auth()->user()->id)
           ->latest();

        if ($type == 'open') {
            $tickets->where('status', 1);
        } elseif ($type == 'closed') {
            $tickets->where('status', 0);
        }
        return $tickets->paginate(request()->input('per_page', 20));
    }

    public function create()
    {
        $data = request()->validate([
            'theme'    => 'required|min:3',
            'message'  => 'required',
        ]);
        $user_id = auth()->user()->id;

        $ticket = Ticket::create([
            'theme'   => $data['theme'],
            'user_id' => $user_id
        ]);

        $ticket->messages()->saveMany([
            new TicketMessage([
                'user_id' => $user_id,
                'message' => $data['message']
            ])
        ]);

        return response()->json([
            'status'  => true,
            'id'      => $ticket->id,
            'message' => 'Успешно создан'
        ]);
    }

    public function close()
    {
        $ticket = Ticket::find(request()->input('id', 0));

        if (!$ticket) {
            return response()->json([
                'status' => false
            ]);
        }
        
        if ($ticket->status) {
            $ticket->status = 0;
            $ticket->closed_at = \Carbon\Carbon::now();
            $ticket->save();
        }
        
        return response()->json([
            'status' => true
        ]);
    }

    public function send()
    {
        $data = request()->validate([
            'message'   => 'required',
            'ticket_id' => 'required|exists:tickets,id'
        ]);
        $user_id = auth()->user()->id;

        $ticket = Ticket::find(request()->input('ticket_id', 0));

        if (!$ticket) {
            return response()->json([
                'status' => 0
            ]);
        }

        $ticket->messages()->saveMany([
            new TicketMessage([
                'user_id' => $user_id,
                'message' => $data['message']
            ])
        ]);

        return response()->json([
            'status' => 1,
            'message' => $ticket->messages()
                ->latest()
                ->with([
                    'user' => function($query) {
                        $query->select('id', 'name');
                    }
                ])->first()
        ]);
    }

    public function messages($id) 
    {
        $ticket = Ticket::find($id);

        if (!$ticket) {
            return response()->json([
                'status' => 0
            ]);
        }
        $messages = $ticket->messages()
                           ->latest()
                           ->with([
                                'user' => function($query) {
                                   $query->select('id', 'name');
                                }
                           ])
                           ->paginate(20);
        $last_message = $messages->first();
        return response()->json([
            'status'       => true,
            'theme'        => $ticket->theme,
            'created_at'   => $ticket->created_at->format('d-m-Y H:i:s'),
            'last_message' => $last_message ? $last_message->created_at->format('d-m-Y H:i:s') : '',
            'messages'     => $messages
        ]);
    }
}
