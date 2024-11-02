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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->longText('failed_job_ids');
            $table->mediumText('options')->nullable();
            $table->integer('cancelled_at')->nullable();
            $table->integer('created_at');
            $table->integer('finished_at')->nullable();
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        Schema::create('administrators', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('shows', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->string('name');
            $table->time('hour_start');
            $table->time('hour_end');
            $table->date('date_show');
            $table->enum('type', ['POP', 'RAP', 'TRAP', 'FUNK', 'SERTANEJO', 'MPB', 'PAGODE'])->notNull();
            $table->integer('code_access')->nullable();
            $table->char('admin_id', 36);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('admin_id')->references('id')->on('administrators')->onDelete('cascade');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->string('username');
            $table->string('telephone');
            $table->integer('table');
            $table->char('show_id', 36)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('show_id')->references('id')->on('shows')->onDelete('cascade');
        });

        Schema::create('musics', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->string('name');
            $table->string('description');
            $table->integer('position')->nullable();
            $table->string('video_id');
            $table->char('user_id', 36)->nullable();
            $table->char('show_id', 36)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('show_id')->references('id')->on('shows')->onDelete('cascade');
        });

        Schema::create('user_music', function (Blueprint $table) {
            $table->char('user_id', 36);
            $table->char('music_id', 36);
            $table->integer('position');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('music_id')->references('id')->on('musics')->onDelete('cascade');

            $table->primary(['user_id', 'music_id']);
        });

        Schema::create('queues', function (Blueprint $table) {
            $table->char('id', 36);
            $table->char('user_id', 36)->nullable();
            $table->char('music_id', 36);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('music_id')->references('id')->on('musics')->onDelete('cascade');
            $table->primary(['id', 'user_id']);
        });

        Schema::create('music_stats', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('music_id', 36);
            $table->integer('play_count')->default(0);
            $table->integer('request_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        
            $table->foreign('music_id')->references('id')->on('musics')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('music_stats');
        Schema::dropIfExists('users');
        Schema::dropIfExists('administrators');
        Schema::dropIfExists('shows');
        Schema::dropIfExists('musics');
    }
};
