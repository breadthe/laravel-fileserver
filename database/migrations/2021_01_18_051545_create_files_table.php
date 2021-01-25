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
            $table->foreignId('user_id')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->uuid('uuid')->index();
            $table->boolean('public')->default(true);
            $table->string('disk')->default('local')->comment('Storage provider disk');
            $table->string('name')->nullable()->comment('Original file name');
            $table->string('mime')->nullable()->comment('File MIME type');
            $table->unsignedInteger('size')->nullable()->comment('Size in bytes');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('files');
    }
}
