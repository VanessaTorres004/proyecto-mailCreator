<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_user_permissions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Si es null, hereda del rol. Si es true/false, sobrescribe
            $table->boolean('can_use_custom_header')->nullable();
            $table->boolean('can_use_custom_footer')->nullable();
            $table->boolean('can_use_custom_logo')->nullable();
            $table->boolean('can_change_theme_color')->nullable();
            $table->boolean('can_change_background_color')->nullable();
            $table->boolean('can_use_custom_text_sizes')->nullable();
            
            // Configuraciones personalizadas (si son null, usa las del rol)
            $table->json('allowed_text_sizes')->nullable();
            $table->string('forced_theme_color')->nullable();
            $table->string('forced_background_color')->nullable();
            $table->string('forced_logo')->nullable();
            $table->string('forced_header')->nullable();
            $table->string('forced_footer')->nullable();
            
            // Control
            $table->boolean('use_custom_permissions')->default(false); // Si false, hereda del rol
            
            $table->timestamps();
            
            $table->unique('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_permissions');
    }
};