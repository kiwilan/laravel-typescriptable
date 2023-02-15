<?php

namespace Kiwilan\Typescriptable;

class TypescriptableConfig
{
    public static function outputPath(): string
    {
        return  config('typescriptable.output_path') ?? resource_path('js');
    }

    public static function filenameModels(): string
    {
        return  config('typescriptable.filename.models') ?? 'types-models.d.ts';
    }

    public static function filenameRoutes(): string
    {
        return  config('typescriptable.filename.routes') ?? 'types-routes.d.ts';
    }

    public static function filenameRoutesList(): string
    {
        return  config('typescriptable.filename.routes_list') ?? 'routes.ts';
    }

    public static function filenameInertia(): string
    {
        return  config('typescriptable.filename.inertia') ?? 'types-inertia.d.ts';
    }

    public static function filenameZiggy(): string
    {
        return  config('typescriptable.filename.ziggy') ?? 'types-ziggy.d.ts';
    }

    public static function routesSkipName(): array
    {
        return  config('typescriptable.routes.skip.name') ?? [];
    }

    public static function routesSkipPath(): array
    {
        return  config('typescriptable.routes.skip.path') ?? [];
    }
}
