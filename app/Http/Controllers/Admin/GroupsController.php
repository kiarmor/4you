<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;

class GroupsController extends BaseController
{
    function index () {
    	$groups = DB::table('groups')->paginate(15);
    	return view('admin.groups.index', ['groups' => $groups]);
    }

    function edit (Request $request) {
    	$group = DB::table('groups')->where('id', $request->get('id'))->first();
    	return view('admin.groups.edit', ['group' => $group]);
    }

    function save (Request $request) {
    	$messages = [
            'id.required' => 'Не был передан айди группы',
            'name.required' => 'Вы не указали имя группы',
            'name.min' => 'Название группы слишком короткое'
    	];

    	$validator = Validator::make($request->all(), [
            'id' => ['required'],
            'name' => ['required', 'min:3'],
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else {
            $data = $validator->getData();
            $group = DB::table('groups')->where('id', $data['id'])->first();
            if ($group)
            	DB::table('groups')->where('id', $data['id'])->update(['name' => $data['name']]);
            else
            	DB::table('groups')->insert(['name' => $data['name']]);
        	return redirect(route('admin.groups'));
        }
    }

    function delete (Request $request) {
    	DB::table('groups')->where('id', $request->get('id'))->delete();
    	return redirect(route('admin.groups'));
    }

}
