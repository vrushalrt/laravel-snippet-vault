<?php

use App\Models\BlogPost;
use App\Models\Tag;
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
        Schema::create('blog_post_tag', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(BlogPost::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Tag::class)->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_post_tag', function (Blueprint $table) {
            $table->dropForeignIdFor(BlogPost::class);
            $table->dropForeignIdFor(Tag::class);
        });

        Schema::dropIfExists('blog_post_tag');
    }
};
