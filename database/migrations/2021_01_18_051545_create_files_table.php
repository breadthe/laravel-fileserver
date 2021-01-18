<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->uuid('uuid');
            $table->string('path')->nullable()->comment('Storage path on disk');
            $table->string('name')->nullable()->comment('Original file name');
            $table->string('mime')->nullable()->comment('File MIME type');
            $table->string('size')->nullable()->comment('Size in bytes');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('files');
    }
}
