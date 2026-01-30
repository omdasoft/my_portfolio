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
            'PHP',
            'Laravel',
            'Vue.js',
            'Livewire',
            'Nuxt.js',
            'Mysql',
            'Node.js',
            'Backend',
            'Frontend',
            'DevOps',
            'Fullstack',
            'CSS',
            'Bootstrap',
            'TailwindCSS',
            'Docker',
            'Deployment',
            'Refactoring',
            'DatabaseOptimization',
            'DesignPatterns',
            'CodeFormatting',
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
