<?php

use App\Models\BlogPost;
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
        Schema::table('blog_post_tag', function (Blueprint $table) {
            $table->dropForeignIdFor(BlogPost::class);
            $table->dropColumn('blog_post_id');
        });


        Schema::rename('blog_post_tag', 'taggables');

        Schema::table('taggables', function (Blueprint $table) {
            $table->morphs('taggables');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('taggables', function (Blueprint $table) {
            $table->dropMorphs('taggables');
        });

        Schema::rename('taggables', 'blog_post_tag');

        Schema::disableForeignKeyConstraints();

        Schema::table('blog_post_tag', function (Blueprint $table) {
            $table->foreignIdFor(BlogPost::class);
            $table->foreign('blog_post_id')->references('id')->on('blog_posts')->cascadeOnDelete();
        });

        Schema::enableForeignKeyConstraints();
    }
};
