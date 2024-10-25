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
        Schema::table('comments', function (Blueprint $table) {
            if(env('DB_CONNECTION') === 'sqlite_testing') {
                $table->foreignIdFor(User::class)->default(0);
            } else {
                // sqlite does not support foreign key constraints, so we use
                // a default value of 0. In a real database, we would use
                // a foreign key constraint to ensure that the user_id
                // column references an existing user.
                // In a real database, we use a foreign key constraint to ensure that the
                // user_id column references an existing user. This constraint is not
                // supported in SQLite, so we use a default value of 0 instead.
                // The onDelete('cascade') option is used to delete all comments that
                // belong to a user when that user is deleted. This is a common
                // pattern in many-to-many relationships.
                $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeignIdFor(User::class);
        });
    }
};
