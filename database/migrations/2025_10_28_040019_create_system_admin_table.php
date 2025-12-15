<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('system_admin', function (Blueprint $table) {
            $table->id('AdminID');
            $table->string('Fname');
            $table->string('Lname');
            $table->string('username')->unique();
            $table->string('password')->unique();
            $table->string('email');
            $table->string('contact_no');
            $table->string('position');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_admin');
    }
};
