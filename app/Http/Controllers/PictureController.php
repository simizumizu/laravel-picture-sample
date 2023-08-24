<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePictureRequest;
use App\Http\Requests\UpdatePictureRequest;
use App\Models\Picture;

class PictureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('picture.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('picture.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePictureRequest $request)
    {
        // 画像フォームでリクエストした画像情報を取得
        $img = $request->file('img_path');
        // storage > public > img配下に画像が保存される
        $path = $img->store('img','public');

        // 画像の保存に成功したら、DBに記録する
        if($path){
            Picture::create([
                'img_path' => $path,
            ]);
        }

        return redirect()->route('picture.create')->with('success', '画像を保存しました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(Picture $picture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Picture $picture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePictureRequest $request, Picture $picture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Picture $picture)
    {
        //
    }
}
