<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

/**
 * Class AddSlugFieldOnArticlesTable
 */
class AddSlugFieldOnArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('articles', function(Blueprint $table) {
            $table->string('slug');
        });

        $articles = DB::table('articles')->select(['id', 'title'])->get();

        foreach ($articles as $article) {
            $slug = Str::slug($article->title) . '-' . $article->id;

            DB::table('articles')
                ->where('id', '=', $article->id)
                ->update([
                    'slug' => $slug,
                ]);
        }

        Schema::table('articles', function(Blueprint $table) {
            $table->unique('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('articles', function(Blueprint $table) {
            $table->dropColumn(['slug']);
        });
    }
}
