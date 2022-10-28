<?php

declare(strict_types=1);

namespace Iquety\Docmap;

use Iquety\Docmap\i18n\EnUs;
use Iquety\Docmap\i18n\Lang;
use Iquety\Security\Filesystem;
use Iquety\Security\Path;
use OutOfRangeException;

class Generator
{
    private Parser $parser;

    private string $readmePath = '../../readme.md';

    public function __construct(?Lang $language = null)
    {
        $language = $language ?? new EnUs();

        $this->parser = new Parser($language);
    }

    public function addDirectory(string $sourceDirectory, string $targetDirectory = ''): self
    {
        $this->parser->addDirectory($sourceDirectory, $targetDirectory);

        return $this;
    }

    public function addFile(string $sourceFile, string $targetFile = ''): self
    {
        if ($targetFile === '') {
            $targetFile = (new Path($sourceFile))->getFile();
        }

        $this->parser->addFile($sourceFile, $targetFile);

        return $this;
    }

    public function setReadmePath(string $relativePath): self
    {
        $this->readmePath = $relativePath;

        return $this;
    }

    public function generateTo(string $destinationPath): void
    {
        $this->parser->analyse();

        $compiler = new Compiler($this->parser);

        $compiler->setReadmePath($this->readmePath)
            ->makeTo($destinationPath);
    }
}
