<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shorts', function (Blueprint $table) {
            $table->id();
            $table->string('hash')->unique();
            $table->text('original_url');
            $table->boolean('is_expirable')->default(false);
            $table->boolean("expired")->default(false);
            $table->date("expiration_date")->nullable();
            $table->integer('visits_count')->default(0);
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('shorts');
    }
};
