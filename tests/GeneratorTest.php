<?php

declare(strict_types=1);

namespace Tests;

use Freep\Docmap\Compiler;
use Freep\Docmap\Generator;
use Freep\Docmap\i18n\EnUs;
use Freep\Docmap\Parser;

class GeneratorTest extends TestCase
{
    /**
     * @test
     */
    public function runGenerate(): void
    {
        $instance = new Generator();
        $instance->setReadmePath('../../readme.md');
        $instance->addDirectory(__DIR__ . '/docs-src/en', '');
        $instance->generateTo(__DIR__ . '/docs-dist');

        $this->assertDirectoryExists(__DIR__ . '/docs-dist/test');
        $this->assertFileExists(__DIR__ . '/docs-dist/test/01-page-one.md');
        $this->assertFileExists(__DIR__ . '/docs-dist/test/02-page-two.md');
        $this->assertFileExists(__DIR__ . '/docs-dist/test/03-page-three.md');
        $this->assertFileExists(__DIR__ . '/docs-dist/test/index.md');
        $this->assertFileExists(__DIR__ . '/docs-dist/test/readme.md');
    }
}
