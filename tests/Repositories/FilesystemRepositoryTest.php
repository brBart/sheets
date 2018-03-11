<?php

namespace Spatie\Sheets\Tests\Repositories;

use PHPUnit\Framework\TestCase;
use Spatie\Sheets\Repositories\FilesystemRepository;
use Spatie\Sheets\Sheet;
use Illuminate\Support\Collection;
use Spatie\Sheets\Tests\Concerns\NeedsFactory;
use Spatie\Sheets\Tests\Concerns\NeedsFilesystem;

class FilesystemRepositoryTest extends TestCase
{
    use NeedsFactory;
    use NeedsFilesystem;

    /** @test */
    public function it_can_get_a_sheet()
    {
        $filesystemRepository = new FilesystemRepository(
            $this->createFactory(),
            $this->createFilesystem(__DIR__.'/content')
        );

        $sheet = $filesystemRepository->get('hello-world');

        $this->assertInstanceOf(Sheet::class, $sheet);
        $this->assertEquals('hello-world', $sheet->slug);
        $this->assertEquals('Hello, world!', $sheet->title);
        $this->assertEquals("<h1>Hello, world!</h1>\n", $sheet->contents);
    }

    /** @test */
    public function it_can_get_all_sheets()
    {
        $filesystemRepository = new FilesystemRepository(
            $this->createFactory(),
            $this->createFilesystem(__DIR__.'/content')
        );

        $sheets = $filesystemRepository->all();

        $this->assertInstanceOf(Collection::class, $sheets);
        $this->assertCount(2, $sheets);

        $this->assertInstanceOf(Sheet::class, $sheets[0]);
        $this->assertEquals('foo-bar', $sheets[0]->slug);
        $this->assertEquals('Foo bar', $sheets[0]->title);
        $this->assertEquals("<h1>Foo bar</h1>\n", $sheets[0]->contents);

        $this->assertInstanceOf(Sheet::class, $sheets[1]);
        $this->assertEquals('hello-world', $sheets[1]->slug);
        $this->assertEquals('Hello, world!', $sheets[1]->title);
        $this->assertEquals("<h1>Hello, world!</h1>\n", $sheets[1]->contents);
    }
}
