<?php

namespace App\Modules\MLM\Settings\Controllers;

use App\Http\Controllers\BaseController;


use App\Modules\Managements\MLM\Settings\Actions\Create;
use App\Modules\Managements\MLM\Settings\Actions\Update;
use Illuminate\Http\Request;

class Controller extends BaseController
{

    public function __construct()
    {
        parent::__construct(); // inherits global data
        $this->loadModuleViewPath('MLM/Settings'); // loads custom view path
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
