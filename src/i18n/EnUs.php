<?php

declare(strict_types=1);

namespace Iquety\Docmap\i18n;

class EnUs extends AbstractLang
{
    protected function getWordList(): array
    {
        return [
            'back_to_index' => 'Back to index',
            'back_to_readme' => 'Back to readme',
            'summary_file' => 'index.md',
            'readme_file' => 'readme.md'
        ];
    }
}
