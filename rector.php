<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use RectorLaravel\Set\LaravelSetList;

return static function (RectorConfig $rectorConfig): void {
    // Define paths to refactor
    $rectorConfig->paths([
        __DIR__.'/app',
        __DIR__.'/config',
        __DIR__.'/database',
        __DIR__.'/routes',
        __DIR__.'/tests',
    ]);

    // Skip certain files/directories
    $rectorConfig->skip([
        __DIR__.'/vendor',
        __DIR__.'/bootstrap/cache',
        __DIR__.'/storage',
        __DIR__.'/node_modules',
        // Skip Laravel core files that shouldn't be modified
        __DIR__.'/app/Console/Kernel.php',
        __DIR__.'/app/Http/Kernel.php',
        __DIR__.'/app/Exceptions/Handler.php',
        // Skip migration files
        __DIR__.'/database/migrations',
    ]);

    // Apply PHP version upgrades incrementally
    $rectorConfig->sets([
        // PHP version upgrade (start with your current version)
        // LevelSetList::UP_TO_PHP_74,
        // LevelSetList::UP_TO_PHP_80,
        // LevelSetList::UP_TO_PHP_81,
        LevelSetList::UP_TO_PHP_82,

        // General code quality improvements
        SetList::CODE_QUALITY,
        SetList::DEAD_CODE,
        SetList::EARLY_RETURN,
        SetList::TYPE_DECLARATION,

        // Laravel-specific rules (enable progressively)
        // LaravelSetList::LARAVEL_80,
        // LaravelSetList::LARAVEL_90,
        // LaravelSetList::LARAVEL_100,
        LaravelSetList::LARAVEL_110,

        // Laravel code quality improvements
        LaravelSetList::LARAVEL_CODE_QUALITY,
        LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL,
    ]);

    // Configure specific rules
    $rectorConfig->rule(InlineConstructorDefaultToPropertyRector::class);

    // Import configuration
    $rectorConfig->importNames();
    $rectorConfig->importShortClasses();

    // Performance optimizations
    $rectorConfig->parallel();
    $rectorConfig->cacheDirectory(__DIR__.'/var/cache/rector');
};
