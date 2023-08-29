<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Picture;

class ConvertBmp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * 画像データ
     * @var Picture
     */
    protected $picture;

    /**
     * Create a new job instance.
     */
    public function __construct(Picture $picture)
    {
        $this->picture = $picture;        
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // 画像ファイルのパスを取得
        $img_path = storage_path('app/public/' . $this->picture->img_path);
        logger()->debug('画像ファイルのパス:' . $img_path);
        // 画像ファイルの拡張子を取得
        $img_info = pathinfo($img_path);
        logger()->debug('bmpに変換:' . $img_info['filename'] . '.' . $img_info['extension']);

        // 画像ファイルの拡張子によって、次の処理を分岐する
        $img = null;
        switch($img_info['extension']) {
            case 'jpg':
            case 'jpeg':
                $img = imagecreatefromjpeg($img_path);
                break;
            case 'png':
                $img = imagecreatefrompng($img_path);
                break;
            case 'gif':
                $img = imagecreatefromgif($img_path);
                break;
            case 'bmp':
                $img = imagecreatefrombmp($img_path);
                break;
            default:
                logger()->debug('対応していない拡張子です。');
                break;
        }

        if(!empty($img)) {
            imagebmp($img, storage_path('app/public/img/'.$img_info['filename'].'.bmp'));
        }
    }
}
