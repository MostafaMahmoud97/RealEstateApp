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
            "image" => "required|mimes:jpg,png,jpeg"
        ]);

        if ($Validator->fails()){
            return Response::errorResponse($Validator->errors());
        }
        $path = "Test_image/";
        $file_name = $this->SaveFile($request->image, $path);

        return Response::successResponse([],"Image Save success");

    }
}
