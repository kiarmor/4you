<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Traits\UploadTrait;
use DB;

class TicketController extends BaseController
{
    use UploadTrait;

    function index() {
        return view('tickets.index', ['tickets' => DB::table('tickets')->where('user', Auth::user()->id)->orderBy('id', 'desc')->get()]);
    }

    function create() {
        return view('tickets.create');
    }

    function more($id) {
        $ticket = DB::table('tickets')->where('id', $id)->where('user', Auth::user()->id)->first();
        return $ticket ? view('tickets.more', ['ticket' => $ticket, 'messages' => DB::table('messages')->where('ticket', $id)->get()])
                       : redirect()->back();
    }

    function sendMessage(Request $request, $id) {
        if ($request->input('message') && mb_strlen($request->input('message')) > 0) {
            $message = $request->input('message');
            $ticket = DB::table('tickets')->where('id', $id)->where('user', Auth::user()->id)->where('status', 1)->first();
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

    function createPost(Request $request) {
        $messages = [
            'topic.required' => 'Вы не указали тему обращения, попробуйте ещё раз',
            'topic.min' => 'Тема обращения не может быть настолько короткой',
            'topic.max' => 'Тема обращения слишком длинная, попробуйте ещё раз',
            'message.required' => 'Вы не указали текст обращения, попробуйте ещё раз',
            'message.min' => 'Текст обращения слишком короткий и не может быть таким',
            'attachment.image' => 'Вложением должно являться только изображение (jpg, png и др.)'
        ];
        $validator = Validator::make($request->all(), [
            'topic' => ['required', 'min:3', 'max:64'],
            'message' => ['required', 'min:3'],
            'attachment' => ['image']
        ], $messages);

        if (!$validator->fails()) {
            $data = $validator->getData();
            if($request->has('attachment')) {
                $image = $request->file('attachment');
                $name = mt_rand(1000000, 999999999);
                $folder = '/assets/ticket_data/';
                $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
                $this->uploadOne($image, $folder, 'public', $name);
            }
            else
                $filePath = null;

            $ticket = DB::table('tickets')->insertGetId([
                'user' => Auth::user()->id,
                'topic' => $data['topic'],
                'message' => $data['message'],
                'attachment' => $filePath
            ]);

            DB::table('messages')->insert([
                'ticket' => $ticket,
                'message' => $data['message'],
                'attachment' => $filePath,
                'sender' => Auth::user()->id
            ]);

            return redirect()->back()->with('message', 'Запрос успешно направлен администрации сайта! Вы сможете отслеживать диалог по данному тикету на текущей странице');
        }
        else
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
    }
}