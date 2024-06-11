<?php

declare(strict_types=1);

namespace Tests;

use Iquety\Docmap\Compiler;
use Iquety\Docmap\Generator;
use Iquety\Docmap\i18n\EnUs;
use Iquety\Docmap\Parser;

class GeneratorTest extends TestCase
{
    /** @test */
    public function runGenerate(): void
    {
        $instance = new Generator();
        $instance->setReadmePath('../../readme.md');
        $instance->addDirectory(__DIR__ . '/docs-src/en', '');
        $instance->generateTo(__DIR__ . '/docs-dist');

        $this->assertDirectoryExists(__DIR__ . '/docs-dist');
        $this->assertFileExists(__DIR__ . '/docs-dist/01-page-one.md');
        $this->assertFileExists(__DIR__ . '/docs-dist/02-page-two.md');
        $this->assertFileExists(__DIR__ . '/docs-dist/03-page-three.md');
        $this->assertFileExists(__DIR__ . '/docs-dist/index.md');
        $this->assertFileExists(__DIR__ . '/docs-dist/readme.md');
    }

    /** @test */
    public function generatedNotChangePhpCode(): void
    {
        $instance = new Generator();
        $instance->setReadmePath('../../readme.md');
        $instance->addDirectory(__DIR__ . '/docs-src/en', '');
        $instance->generateTo(__DIR__ . '/docs-dist');

        $this->assertDirectoryExists(__DIR__ . '/docs-dist');
        $this->assertFileExists(__DIR__ . '/docs-dist/01-page-one.md');

        $originalContent = file_get_contents(__DIR__ . '/docs-src/en/01-page-one.md');
        $generatedContent = file_get_contents(__DIR__ . '/docs-dist/01-page-one.md');

        $phpCode = "class SayHello extends Command\n"
            . "{\n"
            . "    public function show(): string\n"
            . "    {\n"
            . "        if (true) {\n"
            . "            return 'ok';\n"
            . "        }\n"
            . "\n"
            . "        return 'oh no';\n"
            . "    }\n"
            . "}\n";

            $this->assertStringContainsString($phpCode, (string)$originalContent);
            $this->assertStringContainsString($phpCode, (string)$generatedContent);
    }
}
