<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Actions;

use App\Modules\ECOMMERCE\Managements\Configurations\Database\Models\EmailConfigure;


class ViewEmailCredentials
{



    public static function execute($request)
    {
        try {
            $data = EmailConfigure::orderBy('id', 'desc')->first();
            return $data;
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}


//  return Datatables::of($data)
//                     ->editColumn('status', function ($data) {
//                         if ($data->status == 0) {
//                             return '<button class="btn btn-sm btn-danger rounded">Inactive</button>';
//                         } else {
//                             return '<button class="btn btn-sm btn-success rounded">Active</button>';
//                         }
//                     })
//                     ->editColumn('encryption', function ($data) {
//                         if ($data->encryption == 0) {
//                             return 'None';
//                         } elseif ($data->encryption == 1) {
//                             return 'TLS';
//                         } else {
//                             return 'SSL';
//                         }
//                     })
//                     // ->editColumn('password', function($data) {

//                     //     $ciphering = "AES-128-CTR";
//                     //     $options = 0;

//                     //     $decryption_iv = '1234567891011121';
//                     //     $decryption_key = "GenericCommerceV1";
//                     //     return $decryption = openssl_decrypt ($data->password, $ciphering, $decryption_key, $options, $decryption_iv);
//                     // })
//                     ->addIndexColumn()
//                     ->addColumn('action', function ($data) {
//                         $btn = ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->slug . '" data-original-title="Edit" class="mb-1 btn-sm btn-warning rounded editBtn"><i class="fas fa-edit"></i></a>';
//                         $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" title="Delete" data-id="' . $data->slug . '" data-original-title="Delete" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';
//                         return $btn;
//                     })
//                     ->rawColumns(['action', 'status'])
//                     ->make(true);
//             }