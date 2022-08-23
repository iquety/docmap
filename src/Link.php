<?php

declare(strict_types=1);

namespace Freep\Docmap;

use Freep\Security\Path;

class Link
{
    public function __construct(private Parser $parser, private string $path)
    {}

    private function extractBaseName(string $path): string
    {
        if ($path === ''){
            return '';    
        }

        return (new Path($path))->getFile();
    }

    private function extractTopDirectory(string $path, int $levels): string
    {
        if ($levels < 1) {
            return $path;
        }

        $reverse = strrev($path);
        
        $removedLevels = (new Path($reverse))->getDirectory($levels);

        return strrev($removedLevels);
    }

    private function getParser(): Parser
    {
        return $this->parser;
    }
    
    public function getSourceLink(): string
    {
        return $this->path;
    }

    public function getTargetLink(): string
    {
        return $this->getParser()
            ->getFile($this->getSourceLink())
            ->getTargetFile();
    }

    public function getTitle(): string
    {
        return $this->getParser()
            ->getFile($this->getSourceLink())
            ->getTitle();
    }

    private function toTargetFrom(string $sourcePath): string
    {
        return $this->parser->getFile($sourcePath)->getTargetFile();
    }

    public function resolveTo(string $documentWithLinks): string
    {
        if ($this->getSourceLink() === '') {
            return '';
        }

        $documentPath = $this->toTargetFrom($documentWithLinks);
        $documentLevels = substr_count($documentPath, '/');

        $linkPath = $this->toTargetFrom($this->getSourceLink());
        $linkLevels = substr_count($linkPath, '/');

        $diffBetween = $linkLevels - $documentLevels;

        // link está acima do diretorio do documento
        // adiciona ../
        if ($diffBetween < 0) {
            $linkPath = $this->extractBaseName($linkPath);

            return $this->prependUpperDirectory($linkPath, abs($diffBetween));
        }

        // link está em subdiretório
        // remove apenas os diretórios presentes em ambos (link e documento)
        if ($diffBetween > 0) {
            $topDirs = $linkLevels - $diffBetween;

            return $this->extractTopDirectory($linkPath, $topDirs);
        }

        // link está no mesmo diretorio do documento
        // mantém apenas o nome do arquivo
        $documentPath = $this->extractBaseName($documentPath);

        $topDirs = $linkLevels - substr_count($documentPath, '/');

        return $this->extractTopDirectory($linkPath, $topDirs);
    }

    private function prependUpperDirectory(string $path, int $levels): string
    {
        return str_repeat('../', $levels) . $path;
    }
}
