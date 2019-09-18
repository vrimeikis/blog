<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

/**
 * Class AddSlugFieldOnCategoriesTable
 */
class AddSlugFieldOnCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('categories', function(Blueprint $table) {
            $table->string('slug');
        });

        $categories = DB::table('categories')->select(['id', 'title'])->get();

        foreach ($categories as $category) {
            $slug = Str::slug($category->title).'-'.$category->id;

            DB::table('categories')
                ->where('id', '=', $category->id)
                ->update([
                    'slug' => $slug,
                ]);
        }

        Schema::table('categories', function(Blueprint $table) {
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
        Schema::table('categories', function(Blueprint $table) {
            $table->dropColumn(['slug']);
        });
    }
}
