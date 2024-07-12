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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('owner_id');
            $table->text('name');
            $table->text('email')->nullable();
            $table->text('logo')->nullable();
            $table->text('website')->nullable();
            $table->string('about')->nullable();
            $table->text('status')->nullable();
            $table->date('license_expiry')->nullable();
            $table->text('phone_number1')->nullable();
            $table->text('phone_number2')->nullable();
            $table->text('PoBox')->nullable();
            $table->text('color')->nullable();
            $table->text('slogan')->nullable();
            $table->text('twitter')->nullable();
            $table->text('facebook')->nullable();

            

           
            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
