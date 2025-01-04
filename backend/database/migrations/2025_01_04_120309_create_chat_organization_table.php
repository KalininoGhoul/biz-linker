<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_organization', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_id')->constrained('chats');
            $table->foreignId('organization_id')->constrained('organizations');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_organization');
    }
};
