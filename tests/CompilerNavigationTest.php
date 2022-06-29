<?php

declare(strict_types=1);

namespace Tests;

use Freep\DocsMapper\Compiler;
use Freep\DocsMapper\i18n\EnUs;
use Freep\DocsMapper\i18n\Lang;
use Freep\DocsMapper\Parser;

class CompilerNavigationTest extends TestCase
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

    public function getNavigationProvider(): array
    {
        $list = [];

        $list['page one'] = [
            __DIR__ . "/docs-src/en/01-page-one.md",
            '', // prev
           'test/02-page-two.md' // next
         ];

         $list['page two'] = [
            __DIR__ . "/docs-src/en/02-page-two.md",
            'test/01-page-one.md', // prev
            'test/03-page-three.md' // next
        ];

        $list['page three'] = [
            __DIR__ . "/docs-src/en/03-page-three.md",
            'test/02-page-two.md', // prev
            'test/readme.md' // next
        ];

        $list['page four'] = [
            __DIR__ . "/docs-src/pt-br/indice.md",
            'test/03-page-three.md', // prev
            '' // next
        ];

        return $list;
    }

    /**
     * @test
     * @dataProvider getNavigationProvider
     */
    public function getNavigation(string $basePath, string $prevPath, string $nextPath): void
    {
        $instance = $this->compilerFactory();

        $this->assertEquals([
            'previous' => $prevPath,
            'index'    => 'test/index.md',
            'next'     => $nextPath
        ], $instance->getPageNavigation($basePath));
    }
}
