<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $document = $request->get('document');
        $messageTXT = $request->get('message');
        $image = $request->file('image');
        $guest =  $this->getGuest($document);
        if (!$guest) {
            return response(["message" => "Invitado no existe"], 403);
        }
        $lenMessage = strlen($messageTXT);
        $MIN_LEN_MENSSAGE = 2;
        $MAX_LEN_MENSSAGE = 250;
        if ( $lenMessage < $MIN_LEN_MENSSAGE) {
            return response(["message" => "El mensaje es muy corto"], 403);
        } else if ( $lenMessage > $MAX_LEN_MENSSAGE) {
            return response(["message" => "El mensaje es muy largo"], 403);
        }
        $message = new Message();
        $message->idGuest = $guest->id;
        $message->message = $messageTXT;
        $idImage = $image?$this->saveImage($image): $guest->idImage;
        $message->idImage = $idImage;
        $message->save();
        return $message;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    private function saveImage($imageFile) {
        return 1;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
