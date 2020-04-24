<?php

namespace App\Http\Controllers\Backend;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\TicketMessage;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{
    public function index()
    {
        return view('backend.ticket.index');
    }

    public function data(Request $request)
    {
        $data = Ticket::with('user');
        return datatables()->of($data)
            ->make(true);
    }

    public function messages($id)
    {
        $ticket = Ticket::findOrFail($id);
        $messages = $ticket->messages()
                           ->latest()
                           ->with([
                                'user' => function($query) {
                                   $query->select('id', 'name');
                                }
                           ])
                           ->paginate(20)
                           ->reverse();
        $last_message = $messages->first();
        $user = auth()->user();

        return view('backend.ticket.messages', compact(
            'ticket',
            'messages',
            'last_message',
            'user'
        ));
    }

    /**
     * Send Message from admin account
     *
     * @return void
     */
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
}
