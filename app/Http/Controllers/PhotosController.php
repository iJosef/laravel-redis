<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class PhotosController extends Controller
{
    public function fetchAllPhotos(Request $request)
    {

        if ($photos = Redis::get('photos.all')) {
            return json_decode($photos);
        }
        $photos = json_decode(file_get_contents('https://jsonplaceholder.typicode.com/photos'), true);
        Redis::set('photos.all', json_encode($photos));
        Redis::expire('photos.all', 10);

        return $photos;
    }

    public function fetchOnePhoto(Request $request, $id)
    {

        if ($photo = Redis::get('photos.one')) {
            return json_decode($photo);
        }
        $photo = json_decode(file_get_contents('https://jsonplaceholder.typicode.com/photos/'.$id), true);
        Redis::set('photos.one', json_encode($photo));
        Redis::expire('photos.one', 10);

        return $photo;
    }
}
