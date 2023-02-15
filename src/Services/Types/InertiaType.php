<?php

namespace Kiwilan\Typescriptable\Services\Types;

use Illuminate\Support\Facades\File;
use Kiwilan\Typescriptable\Services\Types\Inertia\InertiaEmbed;
use Kiwilan\Typescriptable\Services\Types\Inertia\InertiaPage;
use Kiwilan\Typescriptable\TypescriptableConfig;

class InertiaType
{
    protected function __construct(
      public string $filePath,
    ) {
    }

    public static function make(): self
    {
        $path = TypescriptableConfig::outputPath();
        $filename = TypescriptableConfig::inertiaFilename();

        $file = "{$path}/{$filename}";
        $service = new self(
            filePath: $file,
        );
        $generatedRoutes = $service->generate();

        if (! File::isDirectory($path)) {
            File::makeDirectory($filename);
        }
        File::put($file, $generatedRoutes);

        return $service;
    }

    private function generate(): string
    {
        $page = TypescriptableConfig::inertiaPage() ? InertiaPage::make() : '';
        $useEmbed = TypescriptableConfig::inertiaUseEmbed() ? InertiaEmbed::make() : InertiaEmbed::native();

        return <<<typescript
// This file is auto generated by TypescriptableLaravel.
declare namespace Inertia {
  {$page}
}

{$useEmbed}

export {};
typescript;
    }
}
