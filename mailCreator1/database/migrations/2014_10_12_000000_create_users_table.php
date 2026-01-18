<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type'); // 'assignment', 'status_change', 'deadline', 'comment'
            $table->string('title');
            $table->text('message');
            $table->foreignId('campaign_id')->nullable()->constrained('campaigns')->onDelete('cascade');
            $table->unsignedBigInteger('collaboration_id')->nullable();
            $table->boolean('read')->default(false);
            $table->string('action_url')->nullable();
            $table->timestamps();
            
            $table->foreign('collaboration_id')->references('id')->on('campaign_collaborators')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};