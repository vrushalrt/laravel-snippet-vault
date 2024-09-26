<?php

use App\Models\Author;
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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();

            // $table->unsignedBigInteger('author_id')
            //     ->constrained()
            //     ->onDelete('cascade');

            $table->foreignIdFor(Author::class)->constrained()->uniqid();
            
            // $table->unique('author_id');
            
            // $table->foreign('author_id')->references('id')->on('authors');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::disableForeignKeyConstraints();

        Schema::table('profiles', function (Blueprint $table) {
            // $table->dropForeign('author_id');
            if (env('DB_CONNECTION') !== 'sqlite_testing') {
            $table->dropForeignIdFor(Author::class);
            }
        });   

        Schema::dropIfExists('profiles');

    }
};
