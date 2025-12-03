<?php

namespace App\Modules\MLM\Managements\Settings\Controllers;

use App\Http\Controllers\Controller;

use App\Modules\MLM\Managements\Settings\Actions\Create;
use App\Modules\MLM\Managements\Settings\Actions\Update;

use Illuminate\Http\Request;

class SettingController extends Controller
{

    public function __construct()
    {
        $this->loadModuleViewPath('MLM/Managements/Settings'); // loads custom view path
    }

    public function index()
    {
        $result = Create::execute();
        return view('index', compact('result'));
    }
    public function update(Request $request)
    {
        $result = Update::execute($request);
        return redirect()->back()->with('success', 'MLM Configuration Updated Successfully');
    }
}
