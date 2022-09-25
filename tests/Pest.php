<?php

use Illuminate\Support\Facades\Storage;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;
use Konnco\FilamentImport\Tests\Resources\Pages\CommonTestList;
use Konnco\FilamentImport\Tests\Resources\Pages\ValidateTestList;
use Konnco\FilamentImport\Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Http\UploadedFile;

uses(TestCase::class)->in(__DIR__);

function livewire($list = null)
{
    return Livewire::test($list ?? CommonTestList::class);
}

function csvFiles($rows = 10, $extraRow = [])
{
    Storage::fake('uploads');

    $content = collect('Title,Slug,Body');
    for ($i = 0; $i < $rows; $i++) {
        $content = $content->push(implode(",", [
            fake()->title,
            fake()->slug,
            fake()->text(500)
        ]));
    }

    if (count($extraRow) > 0) {
        $content = $content->push(collect($extraRow)->join(","));
    }

    return UploadedFile::fake()
        ->createWithContent(
            name: 'file.csv',
            content: $content->join("\n")
        );
}
