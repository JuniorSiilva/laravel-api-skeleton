<?php

use App\Enums\AttachmentType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id('id');
            $table->morphs('attachmentable');
            $table->uuid('uniqid')->unique();
            $table->string('name', 255);
            $table->enum('type', AttachmentType::getKeys());
            $table->string('url', 255);
            $table->string('description', 255)->nullable();

            $table->unsignedBigInteger('owner_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('owner_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attachments');
    }
}
