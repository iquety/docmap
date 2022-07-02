<?php

declare(strict_types=1);

namespace Tests;

use Freep\DocsMapper\File;
use OutOfRangeException;

class ParserFilesTest extends TestCase
{
    /** @test */
    public function getFiles(): void
    {
        $instance = $this->parserFactory();

        $this->assertCount(6, $instance->getParsedFiles());
        $this->assertEquals([
            __DIR__ . "/docs-src/en/01-page-one.md",
            __DIR__ . "/docs-src/en/02-page-two.md",
            __DIR__ . "/docs-src/en/03-page-three.md",
            __DIR__ . "/docs-src/en/index.md",
            __DIR__ . "/docs-src/en/readme.md",
            __DIR__ . "/docs-src/pt-br/outro.md",
        ], array_keys($instance->getParsedFiles()));
    }

    /** @test */
    public function getFile(): void
    {
        $instance = $this->parserFactory();

        $this->assertInstanceOf(
            File::class,
            $instance->getFile(__DIR__ . "/docs-src/en/01-page-one.md")
        );
    }

    /** @test */
    public function getFileExceptiuon(): void
    {
        $this->expectException(OutOfRangeException::class);
        $this->expectExceptionMessage(
            "The 'not-exists' file does not exist in the analyzed analysis list"
        );
        

        $instance = $this->parserFactory();

        $instance->getFile("not-exists");
    }
}
