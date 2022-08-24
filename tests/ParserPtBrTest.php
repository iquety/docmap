<?php

declare(strict_types=1);

namespace Tests;

use Freep\Docmap\i18n\PtBr;
use Freep\Docmap\Parser;

class ParserPtBrTest extends TestCase
{
    private function parserPtBrFactory(): Parser
    {
        $instance = new Parser(new PtBr());
        $instance->addDirectory(__DIR__ . '/docs-src/pt-br', 'test');
        $instance->addFile(__DIR__ . '/docs-src/en/index.md', 'test/leiame.md');
        $instance->analyse();

        return $instance;
    }

    /** @test */
    public function getSummary(): void
    {
        $instance = $this->parserPtBrFactory();

        // nao tem o arquivo indice.md, identificado como sumário
        $this->assertEquals([
            __DIR__ . "/docs-src/pt-br/01-pagina-um.md",
            __DIR__ . "/docs-src/pt-br/02-pagina-dois.md",
            __DIR__ . "/docs-src/pt-br/03-pagina-tres.md",
            __DIR__ . "/docs-src/pt-br/outro.md",
            __DIR__ . "/docs-src/en/index.md",
        ], $instance->getSummaryItems());
    }

    /** @test */
    public function getSummaryFile(): void
    {
        $instance = $this->parserPtBrFactory();

        $this->assertEquals(
            __DIR__ . "/docs-src/pt-br/indice.md",
            $instance->getSummaryFile()
        );
    }
}
