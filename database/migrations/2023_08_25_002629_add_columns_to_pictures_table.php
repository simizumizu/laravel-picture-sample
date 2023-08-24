<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pictures', function (Blueprint $table) {
            $table->integer('filesize')->default(0)->comment('ファイルサイズ(バイト)');
            $table->integer('width')->default(0)->comment('画像の幅');
            $table->integer('height')->default(0)->comment('画像の高さ');
            $table->integer('filetype')->default(0)->comment('画像のタイプ IMAGETYPE_XXXの定数');
            $table->string('img_tag_attr')->comment('画像タグの属性');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pictures', function (Blueprint $table) {
            $table->dropColumn('filesize');
            $table->dropColumn('width');
            $table->dropColumn('height');
            $table->dropColumn('filetype');
            $table->dropColumn('img_tag_attr');
        });
    }
};
