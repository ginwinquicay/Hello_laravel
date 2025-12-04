<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('submission', function (Blueprint $table) {
            $table->id('SubmissionID');
            $table->unsignedBigInteger('CustomerID');
            $table->unsignedBigInteger('CategoryID');
            $table->unsignedBigInteger('PriorityID');

            $table->unsignedBigInteger('StaffID')->nullable();
            $table->string('description', 2000);
            $table->dateTime('dateSubmitted')->nullable();
            $table->string('status')->default('Pending');
            $table->dateTime('resolved_at')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();

            // indexes and foreign keys (if you have these tables)
            $table->index('CustomerID');
            $table->index('CategoryID');
            $table->index('PriorityID');
            $table->index('StaffID');

            // (optional) add foreign keys if related tables exist
            $table->foreign('CustomerID')->references('CustomerID')->on('customer')->onDelete('cascade');
            $table->foreign('CategoryID')->references('CategoryID')->on('category');
            $table->foreign('PriorityID')->references('PriorityID')->on('priority_level');
            $table->foreign('StaffID')->references('StaffID')->on('support_staff');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submission');
    }
};
