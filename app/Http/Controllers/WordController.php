<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class WordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->getMessages(0);
    }
    private function getMessages($id, $random = false) {
        $query = DB::table('messages as A')
            ->join("images as B", "A.idImage", 'B.id')
            ->join("guests as C", "A.idGuest", "C.id")
            ->join("images as D", "C.idImage", "D.id")
            ->select("A.message", "B.path", "A.id", "C.firstname as user", "D.path as pathG");

        if($id) {
            $query->where("A.id", '>', $id);
        }
        if($random) {
            $query->inRandomOrder();
        } else {
            $query->orderBy("A.id", "DESC");
        }
        $messages = $query->get();
        $urlBase = Config::get('app.url');
        foreach ($messages as $key => $message) {
            $message->image = $urlBase.Storage::url($message->path);
            $message->avatar = $urlBase.Storage::url($message->pathG);
        }
        return $messages;
    }
    public function getRemenbers() {
        return $this->getMessages(0, true);
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->getMessages($id);
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
