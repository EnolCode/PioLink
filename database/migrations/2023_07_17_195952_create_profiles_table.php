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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name',20)->required();
            $table->string('lastName',45)->required();
            $table->string('location', 80)->required();
            $table->integer('age')->nullable()->default(null);
            $table->boolean("isBanned")->required()->default(false);
            $table->string("longDescription", 255)->nullable();
            $table->string("shortDescription", 75)->nullable();
            $table->string("linkedIn", 45)->nullable();
            $table->string("avatarImage")->nullable();
            $table->string("backgroundImage")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
