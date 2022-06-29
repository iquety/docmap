<?php

declare(strict_types=1);

namespace Tests;

use Freep\DocsMapper\i18n\EnUs;
use Freep\DocsMapper\i18n\Lang;
use Freep\DocsMapper\Parser;

class ParserEnUsTest extends TestCase
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
    public function getSummary(): void
    {
        $instance = $this->parserFactory();

        // nao tem o arquivo index.md, identificado como sumário
        $this->assertEquals([
            __DIR__ . "/docs-src/en/01-page-one.md" => "First title",
            __DIR__ . "/docs-src/en/02-page-two.md" => "Second title",
            __DIR__ . "/docs-src/en/03-page-three.md" => "Third title",
            __DIR__ . "/docs-src/pt-br/indice.md" => "Índice de teste",
        ], $instance->getSummaryItems());
    }

    /** @test */
    public function getSummaryFile(): void
    {
        $instance = $this->parserFactory();

        $this->assertEquals(
            __DIR__ . "/docs-src/en/index.md",
            $instance->getSummaryFile()
        );
    }
}
