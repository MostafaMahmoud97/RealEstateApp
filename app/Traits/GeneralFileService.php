<?php
namespace App\Traits;

use Illuminate\Support\Facades\Storage;

Trait GeneralFileService{

    public function SaveFile($file,$path){
        $file_extention = $file->getClientOriginalName();
        $file_name = date('Y-m-d').time().'.'.$file_extention;
        Storage::disk('public')->put($path.'/'.$file_name,file_get_contents($file));
        return $file_name;
    }

    public function getFileType($file){
        $fileName = $file->getClientOriginalName();
        $arraySplit = explode('.',$fileName);
        $extintion = $arraySplit[(count($arraySplit)-1)];
        if ($extintion == "jpg" || $extintion == "png" || $extintion == "jpeg"){
            return "image";
        }elseif($extintion == "pdf"){
            return "file";
        }elseif ($extintion == "mp4"|| $extintion == "avchd"|| $extintion == "mov"|| $extintion == "webm"|| $extintion == "avi"|| $extintion == "flv"|| $extintion == "wmv"){
            return "video";
        }
    }

    public function getValidateFile($file){
        $fileName = $file->getClientOriginalName();
        $arraySplit = explode('.',$fileName);
        $extintion = $arraySplit[(count($arraySplit)-1)];
        if ($extintion == "jpg" || $extintion == "png" || $extintion == "jpeg"|| $extintion == "mp4"|| $extintion == "avchd"|| $extintion == "mov"|| $extintion == "webm"|| $extintion == "avi"|| $extintion == "flv"|| $extintion == "wmv"){
            return true;
        }else{
            return false;
        }
    }

    public function SavePDFFile($file,$path){
        $file_name = date('Y-m-d').time().'.pdf';
        Storage::disk('public')->put($path.$file_name,$file);
        return $file_name;
    }

    public function removeFile($pathImage){
        if(file_exists($pathImage))
            unlink($pathImage);
    }

}
