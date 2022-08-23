<?php

declare(strict_types=1);

namespace Freep\Docmap\i18n;

abstract class AbstractLang implements Lang
{
    /** @return array<string,string> */
    abstract protected function getWordList(): array;

    public function translate(string $word): string
    {
        $wordList = $this->getWordList();

        if (isset($wordList[$word]) === false) {
            return $word;
        }

        return $wordList[$word];
    }
}
