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
        // Schema::table('images', function (Blueprint $table) {
        //     $table->dropForeignIdFor(BlogPost::class)->constrained();
        //     $table->dropColumn('blog_post_id');

        //     $table->morphs('imageable');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('images', function (Blueprint $table) {
            $table->foreignIdFor(BlogPost::class)->nullable()->constrained();

            $table->dropMorphs('imageable');
        });
    }
};
