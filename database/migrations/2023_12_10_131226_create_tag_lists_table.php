<?php

use App\Models\TagList;
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
        Schema::create('tag_lists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });

        $tags = [
            'php',
            'laravel',
            'vue.js',
            'livewire',
            'nuxt.js',
            'mysql',
            'node.js',
            'backend',
            'frontend',
            'dev ops',
            'fullstack',
            'css',
            'bootstrap',
            'tailwindcss',
            'docker',
            'deployment',
            'ci/cd',
            'refactoring',
            'database optimization',
            'design patterns',
            'code formatting',
        ];

        foreach ($tags as $key => $tag) {
            TagList::updateOrCreate(['name' => $tag]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_lists');
    }
};
