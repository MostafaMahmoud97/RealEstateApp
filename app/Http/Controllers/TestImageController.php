<?php

namespace App\Http\Controllers;

use App\Traits\GeneralFileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class TestImageController extends Controller
{
    use GeneralFileService;

    public function store_image(Request $request){
        $Validator = Validator::make($request->all(),[
            "image" => "required|string"
        ]);

        if ($Validator->fails()){
            return Response::errorResponse($Validator->errors());
        }
        $path = "Test_image/";
        $file_name = $this->SaveBase64Image($request->image,$request->extention, $path);

        return Response::successResponse($file_name,"Image Save success");

    }
}
