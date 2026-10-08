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
        // 1. Tabel Postingan Komunitas
        Schema::create('community_posts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->string('category')->default('diskusi'); // 'diskusi', 'showcase', 'poll', 'promosi'
            $table->string('species')->nullable(); // 'Santigi Karang', 'Beringin Kimeng', dll
            $table->string('post_type')->default('standard'); // 'standard', 'before_after', 'poll', 'flash_sale'
            $table->text('content');
            $table->json('images')->nullable();
            $table->string('before_image')->nullable();
            $table->string('after_image')->nullable();
            $table->foreignUuid('bonsai_id')->nullable()->constrained('bonsais')->onDelete('set null');
            $table->string('discount_code')->nullable();
            $table->string('discount_percent')->nullable();
            $table->dateTime('flash_sale_ends_at')->nullable();
            $table->unsignedInteger('likes_count')->default(0);
            $table->unsignedInteger('subur_count')->default(0);
            $table->unsignedInteger('comments_count')->default(0);
            $table->timestamps();
        });

        // 2. Tabel Komentar
        Schema::create('community_comments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('post_id')->constrained('community_posts')->onDelete('cascade');
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->text('comment');
            $table->boolean('is_best_solution')->default(false);
            $table->timestamps();
        });

        // 3. Tabel Reaksi (Subur & Suka)
        Schema::create('community_reactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('post_id')->constrained('community_posts')->onDelete('cascade');
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->string('type'); // 'subur', 'like'
            $table->timestamps();

            $table->unique(['post_id', 'user_id', 'type']);
        });

        // 4. Tabel Poling & Suara
        Schema::create('community_polls', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('post_id')->constrained('community_posts')->onDelete('cascade');
            $table->string('question');
            $table->json('options'); // array of ['id' => 'a', 'text' => 'Gaya Kengai']
            $table->unsignedInteger('total_votes')->default(0);
            $table->timestamps();
        });

        Schema::create('community_poll_votes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('post_id')->constrained('community_posts')->onDelete('cascade');
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->string('option_id');
            $table->timestamps();

            $table->unique(['post_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_poll_votes');
        Schema::dropIfExists('community_polls');
        Schema::dropIfExists('community_reactions');
        Schema::dropIfExists('community_comments');
        Schema::dropIfExists('community_posts');
    }
};
