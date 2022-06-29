<?php

declare(strict_types=1);

namespace Freep\DocsMapper\i18n;

class EnUs extends AbstractLang
{
    protected function getWordList(): array
    {
        return [
            'back_to_index' => 'Back to index',
            'readme' => 'Readme',
            'summary' => 'Contents',
            'summary_file' => 'index.md',
        ];
    }
}
