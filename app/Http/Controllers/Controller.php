<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Image;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getGuest($document) {
        return  Guest::where("document", $document)->first();
    }
    public function saveImage($idGuest,$file)
    {
        $name = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $code = uniqid();
        $date = date('Y/m/d');
        $destinationPath = "../storage/app/public/$date";
        $nameFile = "$code.$extension";
        $url = "$date/$nameFile";
        $file->move($destinationPath, $nameFile);
        $image = new Image();
        $image->name = $name;
        $image->path = $url;
        $image->idGuest = $idGuest;
        $image->save();
        return $image->id;
    }
}
