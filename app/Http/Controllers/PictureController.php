<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePictureRequest;
use App\Http\Requests\UpdatePictureRequest;
use App\Models\Picture;
use App\Jobs\ConvertBmp;

class PictureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pictures = Picture::all();
        return view('picture.index', compact('pictures'));
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
        $filesize = $img->getSize();
        // getimagesize関数で画像の幅と高さを取得
        list($width, $height, $type, $attr) = getimagesize($img);

        // 各画像のtypeを、IMAGETYPE_XXXの定数で比較する
        // logger()->debug([
        //     'IMAGETYPE_GIF' => IMAGETYPE_GIF,
        //     'IMAGETYPE_JPEG' => IMAGETYPE_JPEG,
        //     'IMAGETYPE_JPEG2000' => IMAGETYPE_JPEG2000,
        //     'IMAGETYPE_PNG' => IMAGETYPE_PNG,
        //     'IMAGETYPE_SWF' => IMAGETYPE_SWF,
        //     'IMAGETYPE_PSD' => IMAGETYPE_PSD,
        //     'IMAGETYPE_BMP' => IMAGETYPE_BMP,
        //     'IMAGETYPE_WBMP' => IMAGETYPE_WBMP,
        //     'IMAGETYPE_XBM' => IMAGETYPE_XBM,
        //     'IMAGETYPE_TIFF_II' => IMAGETYPE_TIFF_II,
        //     'IMAGETYPE_TIFF_MM' => IMAGETYPE_TIFF_MM,
        //     'IMAGETYPE_IFF' => IMAGETYPE_IFF,
        //     'IMAGETYPE_JB2' => IMAGETYPE_JB2,
        //     'IMAGETYPE_JPC' => IMAGETYPE_JPC,
        //     'IMAGETYPE_JP2' => IMAGETYPE_JP2,
        //     'IMAGETYPE_JPX' => IMAGETYPE_JPX,
        //     'IMAGETYPE_SWC' => IMAGETYPE_SWC,
        //     'IMAGETYPE_ICO' => IMAGETYPE_ICO,
        //     'IMAGETYPE_WEBP' => IMAGETYPE_WEBP,
        //     'IMAGETYPE_AVIF' => IMAGETYPE_AVIF,
        // ]);
        // storage > public > img配下に画像が保存される
        $path = $img->store('img','public');
        logger()->info([
            'img_path' => $path,
            'filesize' => $filesize, // ファイルサイズは単位がバイト
            'width' => $width,
            'height' => $height,
            'type' => $type,
            'attr' => $attr,
        ]);

        // 画像の保存に成功したら、DBに記録する
        if($path){
            $picture = Picture::create([
                'img_path' => $path,
                'filesize' => $filesize,
                'width' => $width,
                'height' => $height,
                'filetype' => $type,
                'img_tag_attr' => $attr,
            ]);

            // 画像の拡張子をbmpに変換する
            ConvertBmp::dispatch($picture);
        }

        return redirect()->route('picture.index')->with('success', 'ファイルをアップロードしました');
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
