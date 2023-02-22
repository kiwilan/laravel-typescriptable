# kiwilan/typescriptable-laravel

[![packagist](https://img.shields.io/packagist/v/kiwilan/typescriptable-laravel.svg?style=flat-square&color=F28D1A&logo=packagist&logoColor=ffffff&label=packagist)](https://packagist.org/packages/kiwilan/typescriptable-laravel)
[![npm](https://img.shields.io/npm/v/@kiwilan/typescriptable-laravel.svg?style=flat-square&color=CB3837&logo=npm&logoColor=ffffff&label=npm)](https://www.npmjs.com/package/@kiwilan/typescriptable-laravel)

[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/kiwilan/typescriptable-laravel/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/kiwilan/typescriptable-laravel/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/kiwilan/typescriptable-laravel/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/kiwilan/typescriptable-laravel/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/kiwilan/typescriptable-laravel.svg?style=flat-square)](https://packagist.org/packages/kiwilan/typescriptable-laravel)

PHP package for Laravel **to type Eloquent models** and **routes** with **autogenerated TypeScript**, ready for **Inertia** with associated NPM package.

> PHP 8.1 is required and Laravel 9+ is recommended.
>
> -   [`kiwilan/typescriptable-laravel`](https://packagist.org/packages/kiwilan/typescriptable-laravel): PHP package for [Laravel](https://laravel.com/).
> -   [`@kiwilan/typescriptable-laravel`](https://www.npmjs.com/package/@kiwilan/typescriptable-laravel): NPM package to use with [Vite](https://vitejs.dev/) and [Inertia](https://inertiajs.com/).

The package [ziggy](https://github.com/tighten/ziggy) is **NOT REQUIRED** to use `kiwilan/typescriptable-laravel`.

## Installation

[![php](https://img.shields.io/static/v1?label=PHP&message=min.%20v8.1&color=777BB4&style=flat-square&logo=php&logoColor=ffffff)](https://www.php.net/)
[![laravel](https://img.shields.io/static/v1?label=Laravel&message=min.%20v9&color=FF2D20&style=flat-square&logo=laravel&logoColor=ffffff)](https://laravel.com/)

You can install the package via composer:

```bash
composer require kiwilan/typescriptable-laravel
```

## Configuration

You can publish the config file

```bash
php artisan vendor:publish --tag="typescriptable-config"
```

Update config file `config/typescriptable.php`

```php
<?php

return [
    /**
     * The path to the output directory.
     */
    'output_path' => resource_path('js'),

    /**
     * Options for the models.
     */
    'models' => [
        'filename' => 'types-models.d.ts',
        /**
         * The path to the models directory.
         */
        'directory' => app_path('Models'),
        /**
         * Models to skip.
         */
        'skip' => [
            // 'App\\Models\\User',
        ],
        /**
         * Whether to add the LaravelPaginate type (with API type and view type).
         */
        'paginate' => true,
        /**
         * Whether to add the fake Jetstream Team type to avoid errors.
         */
        'fake_team' => false,
    ],
    /**
     * Options for the routes.
     */
    'routes' => [
        'filename' => 'types-routes.d.ts',
        'filename_list' => 'routes.ts',
        /**
         * Use routes `path` instead of `name` for the type name.
         */
        'use_path' => false,
        /**
         * Routes to skip.
         */
        'skip' => [
            'name' => [
                'debugbar.*',
                'horizon.*',
                'telescope.*',
                'nova.*',
                'lighthouse.*',
                'livewire.*',
                'ignition.*',
                'filament.*',
            ],
            'path' => [
                'api/*',
            ],
        ],
    ],
];
```

## Usage

```bash
php artisan typescriptable
```

-   --`A`|`all`: Generate all types.
-   --`M`|`models`: Generate Models types.
-   --`R`|`routes`: Generate Routes types.

### Eloquent Models

Generate `resources/js/types-models.d.ts` file with all models types.

```bash
php artisan typescriptable:models
```

-   Generate TS types for [Eloquent models](https://laravel.com/docs/9.x/eloquent)
-   Generate TS types for [Eloquent relations](https://laravel.com/docs/9.x/eloquent-relationships) (except `morphTo`)
    -   [ ] Generate TS types for `morphTo`
-   Generate TS types for `casts` (include native `enum` support)
-   Generate TS types for `dates`
-   Generate TS types for `appends` (partial for [`Casts\Attribute`](https://laravel.com/docs/9.x/eloquent-mutators#defining-an-accessor), you can use old way to define `get*Attribute` methods)
    -   [ ] Use `appends` to define type for `Casts\Attribute` methods
-   Generate TS types `counts`
-   Generate pagination TS types for [Laravel pagination](https://laravel.com/docs/9.x/pagination) with option `paginate`

### Routes

Generate `resources/js/types-routes.d.ts` file with all routes types and `resources/js/routes.ts` for routes references.

```bash
php artisan typescriptable:routes
```

-   Generate TS types for [Laravel routes](https://laravel.com/docs/9.x/routing)
-   Generate TS types for [Laravel route parameters](https://laravel.com/docs/9.x/routing#route-parameters)
-   Generate TS types seperated by `methods`
-   Helpers to use these types are included in [`@kiwilan/typescriptable-laravel`](https://github.com/kiwilan/typescriptable-laravel/blob/main/lib/README.md) NPM package.

### Inertia

You can use associated NPM package [`@kiwilan/typescriptable-laravel`](https://github.com/kiwilan/typescriptable-laravel/tree/main/lib) to use helpers with `typescriptable:models` and `typescriptable:routes` commands.

-   Execute automatically `typescriptable:models` and `typescriptable:routes` commands with watch mode.
-   A composable `useInertiaTyped` with typed router, typed `usePage` and some helpers.
-   A Vue component `Route` with typed `to` prop.
-   A Vue plugin to inject all new features.
-   All Inertia types for `page` and global properties.

## Examples

### Eloquent Models

An example of Eloquent model.

```php
<?php

namespace App\Models;

use Kiwilan\Steward\Enums\PublishStatusEnum;

class Story extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'abstract',
        'original_link',
        'picture',
        'status',
        'published_at',
        'meta_title',
        'meta_description',
    ];

    protected $appends = [
        'time_to_read',
    ];

    protected $withCount = [
        'chapters',
    ];

    protected $casts = [
        'status' => PublishStatusEnum::class,
        'published_at' => 'datetime:Y-m-d',
    ];

    public function getTimeToReadAttribute(): int

    public function chapters(): HasMany

    public function category(): BelongsTo

    public function author(): BelongsTo

    public function tags(): BelongsToMany
}
```

TS file generated at `resources/js/types-models.d.ts`

```typescript
declare namespace App {
    declare namespace Models {
        export type Story = {
            id: number;
            title: string;
            slug?: string;
            abstract?: string;
            original_link?: string;
            picture?: string;
            status: "draft" | "scheduled" | "published";
            published_at?: Date;
            meta_title?: string;
            meta_description?: string;
            created_at?: Date;
            updated_at?: Date;
            author_id?: number;
            category_id?: number;
            time_to_read?: number;
            chapters?: Chapter[];
            category?: Category;
            author?: Author;
            tags?: Tag[];
            chapters_count?: number;
            tags_count?: number;
        };
    }
    // With `paginate` option.
    export type PaginateLink = {
        url: string;
        label: string;
        active: boolean;
    };
    export type Paginate<T = any> = {
        data: T[];
        current_page: number;
        first_page_url: string;
        from: number;
        last_page: number;
        last_page_url: string;
        links: App.PaginateLink[];
        next_page_url: string;
        path: string;
        per_page: number;
        prev_page_url: string;
        to: number;
        total: number;
    };
}
```

Usage in Vue component.

```vue
<script lang="ts" setup>
defineProps<{
    story?: App.Models.Story;
}>();
</script>
```

Or with paginate option.

```vue
<script lang="ts" setup>
defineProps<{
    stories?: App.Paginate<App.Models.Story>;
}>();
</script>
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

-   [Ewilan Riviere](https://github.com/ewilan-riviere)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
