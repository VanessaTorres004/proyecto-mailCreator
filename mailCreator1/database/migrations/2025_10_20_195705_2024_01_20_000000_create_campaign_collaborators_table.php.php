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
        Schema::create('campaign_collaborators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained('campaigns')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('assigned_by')->constrained('users')->onDelete('cascade');
            $table->text('instructions');
            $table->dateTime('deadline')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'returned_for_review', 'needs_changes', 'completed'])->default('pending');
            $table->text('admin_comments')->nullable();
            $table->timestamps();
            
            // Ensure a user can only be assigned once per campaign
            $table->unique(['campaign_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_collaborators');
    }
};
