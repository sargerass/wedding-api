<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Image as ImageModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

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
        $image = new ImageModel();
        $image->name = $name;
        $image->path = $url;
        $image->idGuest = $idGuest;
        $image->save();
        return $image->id;
    }
    public function saveImageBase64($idGuest, $image_64, $name) {
        $code = uniqid();



        $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf

        $replace = substr($image_64, 0, strpos($image_64, ',')+1);

        // find substring fro replace here eg: data:image/png;base64,

        $image = str_replace($replace, '', $image_64);

        $image = str_replace(' ', '+', $image);
        $png_url = "$code.$extension";
        $date = date('Y/m/d');
        $path = "$date/" . $png_url;;
        $url = "public/$path";
        //ImageManager::make(file_get_contents($base64))->save($path);
        Storage::disk('local')->put($url, base64_decode($image));
        $image = new ImageModel();
        $image->name = $name;
        $image->path = $path;
        $image->idGuest = $idGuest;
        $image->save();
        /*
        $manager = new ImageManager(array('driver' => 'imagick'));

        // to finally create image instances
        $newImage = $manager->make('public/foo.jpg')->resize(300, 200);
        */
        return $image->id;
    }
}
