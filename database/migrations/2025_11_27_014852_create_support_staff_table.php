<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('support_staff', function (Blueprint $table) {
            $table->id('StaffID');
            $table->string('Fname');
            $table->string('Lname');
            $table->string('address');
            $table->string('contact_no');
            $table->string('email')->unique;
            $table->string('password');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_staff');
    }
};
