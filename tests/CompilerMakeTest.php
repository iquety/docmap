<?php

declare(strict_types=1);

namespace Tests;

use Freep\DocsMapper\Compiler;
use Freep\DocsMapper\i18n\EnUs;
use Freep\DocsMapper\i18n\Lang;
use Freep\DocsMapper\Parser;

class CompilerMakeTest extends TestCase
{
    private function compilerFactory(): Compiler
    {
        $parser = new Parser(new EnUs(), __DIR__ . '/docs-dist');
        $parser->addDirectory(__DIR__ . '/docs-src/en', 'test')
            ->addFile(__DIR__ . '/docs-src/pt-br/indice.md', 'test/readme.md')
            ->analyse();

        $instance = new Compiler(new EnUs(), __DIR__ . '/docs-dist');
        $instance->setFiles($parser->getParsedFiles())
            ->setSummaryFile($parser->getSummaryFile())
            ->setSummaryItems($parser->getSummaryItems());

        return $instance;
    }

    /**
     * @test
     */
    public function runMake(): void
    {
        $instance = $this->compilerFactory();

        $instance->make();

        $this->assertDirectoryExists(__DIR__ . '/docs-dist/test');
        $this->assertFileExists(__DIR__ . '/docs-dist/test/01-page-one.md');
        $this->assertFileExists(__DIR__ . '/docs-dist/test/02-page-two.md');
        $this->assertFileExists(__DIR__ . '/docs-dist/test/03-page-three.md');
        $this->assertFileExists(__DIR__ . '/docs-dist/test/index.md');
        $this->assertFileExists(__DIR__ . '/docs-dist/test/readme.md');
    }
}
