<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Purchased;
use Config;

class SettingsController extends BaseController
{
    function index () {
    	return view('admin.settings');
    }

    function save(Request $request) {
    	putenv('APP_NAME="' . $request->input('name') . '"');
    	return redirect()->back();
    	// $file = $request->file('logo');
    	// $upload_folder = 'public/folder';
    }

}
