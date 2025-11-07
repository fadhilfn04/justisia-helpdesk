<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('guard_name')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
            $table->string('phone')->nullable();
            $table->timestamps();
        });

        Schema::create('category_agents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('category');
            $table->timestamps();
        });

        Schema::create('ticket_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('master_sla', function (Blueprint $table) {
            $table->id();
            $table->string('prioritas');
            $table->foreignId('category_id')->constrained('ticket_categories')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('master_survey', function (Blueprint $table) {
            $table->id();
            $table->string('pertanyaan');
            $table->timestamps();
        });

        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->text('answer');
            $table->foreignId('category_id')->constrained('ticket_categories')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('ticket_categories')->onDelete('cascade');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->integer('wilayah_id')->nullable();
            $table->string('title');
            $table->text('description');
            $table->string('status')->default('open');
            $table->string('priority')->default('medium');
            $table->timestamps();
        });

        Schema::create('ticket_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade');
            $table->string('file_ticket');
            $table->timestamps();
        });

        Schema::create('ticket_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade');
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            $table->text('message');
            $table->string('attachment')->nullable();
            $table->timestamps();
        });

        Schema::create('ticket_status_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade');
            $table->foreignId('changed_by')->constrained('users')->onDelete('cascade');
            $table->string('old_status')->nullable();
            $table->string('new_status');
            $table->text('note')->nullable();
            $table->timestamps();
        });

        Schema::create('ticket_timelines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade');
            $table->foreignId('actor_id')->constrained('users')->onDelete('cascade');
            $table->string('action');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('feedback_surveys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('survey_id')->nullable()->constrained('master_survey')->onDelete('set null');
            $table->integer('nilai')->nullable();
            $table->text('comment')->nullable();
            $table->string('sent_via')->nullable();
            $table->timestamps();
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('type');
            $table->string('title');
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('feedback_surveys');
        Schema::dropIfExists('ticket_timeline');
        Schema::dropIfExists('ticket_status_logs');
        Schema::dropIfExists('ticket_messages');
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('master_survey');
        Schema::dropIfExists('master_sla');
        Schema::dropIfExists('ticket_categories');
        Schema::dropIfExists('category_agents');
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
    }
};
