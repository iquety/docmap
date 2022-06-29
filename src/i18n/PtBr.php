<?php

declare(strict_types=1);

namespace Freep\DocsMapper\i18n;

class PtBr extends AbstractLang
{
    protected function getWordList(): array
    {
        return [
            'back_to_index' => 'Voltar para o índice',
            'readme' => 'Leiame',
            'summary' => 'Conteúdo',
            'summary_file' => 'indice.md',
        ];
    }
}
