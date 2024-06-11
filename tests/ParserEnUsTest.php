<?php

declare(strict_types=1);

namespace Tests;

class ParserEnUsTest extends TestCase
{
    /** @test */
    public function getSummary(): void
    {
        $instance = $this->parserFactory();

        // nao tem o arquivo index.md, identificado como sumário
        $this->assertEquals([
            __DIR__ . "/docs-src/en/01-page-one.md",
            __DIR__ . "/docs-src/en/02-page-two.md",
            __DIR__ . "/docs-src/en/03-page-three.md",
            __DIR__ . "/docs-src/pt-br/outro.md",
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
