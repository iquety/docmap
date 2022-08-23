<?php

declare(strict_types=1);

namespace Tests;

use Closure;
use Freep\Console\PhpUnit\ConsoleTestCase;
use Freep\Docmap\i18n\EnUs;
use Freep\Docmap\Parser;

class TestCase extends ConsoleTestCase
{
    protected function parserFactory(?Closure $callback = null): Parser
    {
        $instance = new Parser(new EnUs(), __DIR__ . '/docs-dist');
        $instance->addDirectory(__DIR__ . '/docs-src/en', 'test');
        $instance->addFile(__DIR__ . '/docs-src/pt-br/outro.md', 'test/deep/other.md');
        if ($callback !== null) {
            $callback($instance);
        } 
        $instance->analyse();

        return $instance;
    }
}
