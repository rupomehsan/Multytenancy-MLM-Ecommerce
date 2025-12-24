<?php

namespace App\Modules\ECOMMERCE\Managements\Orders\Actions;

class AddMoreProduct
{
    public static function execute($request)
    {
        $rowNo = $request->rowno;
        $returnHTML = view('add_more', compact('rowNo'))->render();
        return response()->json(['more' => $returnHTML]);
    }
}
