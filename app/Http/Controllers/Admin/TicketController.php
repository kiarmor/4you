<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Purchased;
use App\User;
use App\Ticket;
use Config;
use DB;

class TicketController extends BaseController
{
    function index() {
        return view('admin.tickets.index', ['tickets' => DB::table('tickets')->orderBy('status', 'desc')->paginate(15)]);
    }

    function more($id) {
        $ticket = Ticket::find($id);
        
        if ($ticket) {
            if ($ticket->isnew) {
                $ticket->isnew = false;
                $ticket->save();
            }
            
            return view('admin.tickets.more', ['user' => User::where('id', $ticket->user)->first(), 'ticket' => $ticket, 'messages' => DB::table('messages')->where('ticket', $id)->get()]);
        } else {
            return redirect()->back();
        }       
    }

    function sendMessage(Request $request, $id) {
        if ($request->input('message') && mb_strlen($request->input('message')) > 0) {
            $message = $request->input('message');
            $ticket = DB::table('tickets')->where('id', $id)->first();
            if ($ticket) {
                DB::table('messages')->insert([
                    'ticket' => $id,
                    'message' => $message,
                    'sender' => Auth::user()->id
                ]);
            }
            return redirect()->back();
        }
    }

    function close(Request $request, $id) {
        DB::table('tickets')->where('id', $id)->update([
            'status' => 0
        ]);
        return redirect()->back()->with('message', 'Вы закрыли данный тикет');
    }
}
