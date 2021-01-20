<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDownloadsTable extends Migration
{
    public function up()
    {
        Schema::create('downloads', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index();
            $table->string('path')->nullable()->comment('Storage path on disk');
            $table->string('name')->nullable()->comment('Original file name');
            $table->string('ip', 32)->nullable()->comment('Client IP');
            $table->text('meta')->nullable()->comment('General meta field');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('downloads');
    }
}
