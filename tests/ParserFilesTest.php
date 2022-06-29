<?php

declare(strict_types=1);

namespace Tests;

use Freep\DocsMapper\i18n\EnUs;
use Freep\DocsMapper\Parser;

class ParserFilesTest extends TestCase
{
    private function parserFactory(): Parser
    {
        $instance = new Parser(new EnUs(), __DIR__ . '/docs-dist');
        $instance->addDirectory(__DIR__ . '/docs-src/en', 'test');
        $instance->addFile(__DIR__ . '/docs-src/pt-br/indice.md', 'test/readme.md');
        $instance->analyse();

        return $instance;
    }

    /** @test */
    public function getFiles(): void
    {
        $instance = $this->parserFactory();

        $this->assertCount(5, $instance->getParsedFiles());
        $this->assertEquals([
            __DIR__ . "/docs-src/en/01-page-one.md",
            __DIR__ . "/docs-src/en/02-page-two.md",
            __DIR__ . "/docs-src/en/03-page-three.md",
            __DIR__ . "/docs-src/en/index.md",
            __DIR__ . "/docs-src/pt-br/indice.md",
        ], array_keys($instance->getParsedFiles()));
    }
}
