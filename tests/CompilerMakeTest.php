<?php

declare(strict_types=1);

namespace Tests;

use Freep\DocsMapper\Compiler;
use Freep\DocsMapper\i18n\EnUs;
use Freep\DocsMapper\Parser;

class CompilerMakeTest extends TestCase
{
    private function compilerFactory(): Compiler
    {
        $parser = $this->parserFactory(function($parser){
            $parser->addFile(__DIR__ . '/docs-src/pt-br/indice.md', 'test/deep/indice.md');
        });

        $instance = new Compiler($parser);
        $instance->setReadmePath('../../readme.md');

        // $instance->setFiles($parser->getParsedFiles())
        //     ->setReadmePath('../readme.md')
        //     ->setSummaryFile($parser->getSummaryFile())
        //     ->setSummaryItems($parser->getSummaryItems());

        return $instance;
    }

    /**
     * @test
     */
    public function runMake(): void
    {
        $instance = $this->compilerFactory();

        $instance->makeTo(__DIR__ . '/docs-dist');

        $this->assertDirectoryExists(__DIR__ . '/docs-dist/test');
        $this->assertFileExists(__DIR__ . '/docs-dist/test/01-page-one.md');
        $this->assertFileExists(__DIR__ . '/docs-dist/test/02-page-two.md');
        $this->assertFileExists(__DIR__ . '/docs-dist/test/03-page-three.md');
        $this->assertFileExists(__DIR__ . '/docs-dist/test/index.md');
        $this->assertFileExists(__DIR__ . '/docs-dist/test/readme.md');
    }
}
