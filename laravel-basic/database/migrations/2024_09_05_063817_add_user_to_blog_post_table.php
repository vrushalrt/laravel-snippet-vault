<?php

use App\Models\User;
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
        Schema::table('blog_posts', function (Blueprint $table) {
            if (env('DB_CONNECTION') === 'sqlite_testing') {
                $table->unsignedInteger('user_id')->default(0);
            }
            else {
                $table->foreignIdFor(User::class)->constrained();
            }
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            if (env('DB_CONNECTION') !== 'sqlite_testing') {
                $table->dropForeignIdFor(User::class)->constrained();
            }
        });
    }
};
