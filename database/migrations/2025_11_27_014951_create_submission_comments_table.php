<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('submission_comments', function (Blueprint $table) {
            $table->id('CommentID');
            $table->unsignedBigInteger('SubmissionID');
            $table->unsignedBigInteger('StaffID')->nullable();
            $table->text('comment');
            $table->string('action_taken')->nullable();
            $table->timestamps();

            $table->index('SubmissionID');
            $table->index('StaffID');

            // optional foreign keys if tables exist
            $table->foreign('SubmissionID')->references('SubmissionID')->on('submission')->onDelete('cascade');
            $table->foreign('StaffID')->references('StaffID')->on('support_staff');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submission_comments');
    }
};
