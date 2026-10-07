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
        Schema::table('threads', function (Blueprint $table) {
            $table->integer('score')->default(0)->index();
            $table->foreignId('accepted_comment_id')->nullable()->constrained('comments')->nullOnDelete();
            $table->timestamp('edited_at')->nullable();
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->integer('score')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('threads', function (Blueprint $table) {
            $table->dropConstrainedForeignId('accepted_comment_id');
            $table->dropIndex(['score']);
            $table->dropColumn(['score', 'edited_at']);
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn('score');
        });
    }
};
