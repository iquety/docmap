<?php

declare(strict_types=1);

namespace Tests;

use Freep\Docmap\i18n\PtBr;

class LanguageTest extends TestCase
{
    /** @test */
    public function translate(): void
    {
        $lang = new PtBr();

        $this->assertEquals('indice.md', $lang->translate('summary_file'));

        $this->assertEquals('not_exist_tag', $lang->translate('not_exist_tag'));
    }
}
