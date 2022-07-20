<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('vkey');
            $table->string('title');
            $table->text('description');
            $table->enum('state', ['active', 'inactive']);
            $table->enum('status', ['pending', 'processing', 'success', 'failed']);
            $table->enum('scope', ['public', 'private', 'unlisted']);
            $table->integer('duration')->default(0);
            $table->string('directory')->default('');
            $table->integer('default_thumbnail')->default(0);
            $table->string('qualities')->default('');
            $table->string('tags')->default('');
            $table->integer('total_views')->default(0);
            $table->integer('total_comments')->default(0);
            $table->enum('allow_comments', ['yes', 'no']);
            $table->enum('allow_embed', ['yes', 'no']);
            $table->enum('allow_download', ['yes', 'no']);
            $table->string('server_url')->default('');
            $table->timestamp('converted_at')->useCurrent();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
};
