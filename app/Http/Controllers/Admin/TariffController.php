<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request as Request;
use App\Traits\UploadTrait;
use App\User;
use DB;

class TariffController extends BaseController
{
    use UploadTrait;

    function index () {
    	$tariffs = DB::table('tariff')->paginate(15);
    	return view('admin.tariff.index', ['tariffs' => $tariffs]);
    }

    function edit (Request $request) {
    	$tariff = DB::table('tariff')->where('id', $request->get('id'))->first();
    	return view('admin.tariff.edit', ['tariff' => $tariff]);
    }

    function save (Request $request) {
    	$messages = [
            'id.required' => 'Не был передан айди сертификата',
            'name.required' => 'Вы не указали имя сертификата',
            'name.min' => 'Название сертификата слишком короткое',
            'period_1.required' => 'Вы не указали проценты еженедельного периода',
            'period_1.numeric' => 'Еженедельный период должен быть числом (например: 200)',
            'period_2.required' => 'Вы не указали проценты ежемесячного периода',
            'period_2.numeric' => 'Ежемесячный период должен быть числом (например: 200)',
            'period_3.required' => 'Вы не указали проценты квартального периода',
            'period_3.numeric' => 'Квартальный период должен быть числом (например: 200)',
            'period_4.required' => 'Вы не указали проценты полугодового периода',
            'period_4.numeric' => 'Полугодовой период должен быть числом (например: 200)',
            'period_5.required' => 'Вы не указали проценты годового периода',
            'period_5.numeric' => 'Годовой период должен быть числом (например: 200)',
    	];

    	$validator = Validator::make($request->all(), [
            'id' => ['required'],
            'name' => ['required', 'min:3'],
            'period_1' => ['required', 'numeric'],
            'period_2' => ['required', 'numeric'],
            'period_3' => ['required', 'numeric'],
            'period_4' => ['required', 'numeric'],
            'period_5' => ['required', 'numeric']
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else {
            if($request->has('image')) {
                $image = $request->file('image');
                $name = mt_rand(1000000, 999999999);
                $folder = '/assets/tariff/';
                $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
                $this->uploadOne($image, $folder, 'public', $name);
            }
            else
                $filePath = null;

            $data = $validator->getData();
            $tariff = DB::table('tariff')->where('id', $data['id'])->first();
            if ($request->input('is_gift'))
            	DB::table('tariff')->where('is_gift', 1)->update(['is_gift' => 0]);
            if ($tariff) {
            	DB::table('tariff')->where('id', $data['id'])->update([
            		'name' => $data['name'],
            		'period_1' => $data['period_1'],
            		'period_2' => $data['period_2'],
            		'period_3' => $data['period_3'],
            		'period_4' => $data['period_4'],
            		'period_5' => $data['period_5'],
            		'is_gift' => $request->input('is_gift') ? 1 : 0,
            	]);
                if($filePath)
                    DB::table('tariff')->where('id', $data['id'])->update(['image' => $filePath]);
            }
            else
            	DB::table('tariff')->insert([
            		'name' => $data['name'],
            		'period_1' => $data['period_1'],
            		'period_2' => $data['period_2'],
            		'period_3' => $data['period_3'],
            		'period_4' => $data['period_4'],
            		'period_5' => $data['period_5'],
                    'image' => $filePath,
            		'is_gift' => $request->input('is_gift') ? 1 : 0,
            	]);
        	return redirect(route('admin.tariff'));
        }
    }

    function delete (Request $request) {
    	DB::table('tariff')->where('id', $request->get('id'))->delete();
    	return redirect()->back();
    }

}
