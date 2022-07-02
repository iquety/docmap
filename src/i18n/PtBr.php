<?php

declare(strict_types=1);

namespace Freep\DocsMapper\i18n;

class PtBr extends AbstractLang
{
    protected function getWordList(): array
    {
        return [
            'back_to_index' => 'Voltar para o índice',
            'back_to_readme' => 'Voltar para o leiame',
            'summary_file' => 'indice.md',
            'readme_file' => 'leiame.md'
        ];
    }
}
