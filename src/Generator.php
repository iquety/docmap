<?php

declare(strict_types=1);

namespace Freep\DocsMapper;

use Freep\DocsMapper\i18n\EnUs;
use Freep\DocsMapper\i18n\Lang;
use Freep\Security\Filesystem;
use Freep\Security\Path;
use OutOfRangeException;

class Generator
{
    private Parser $parser;

    private Compiler $compiler;

    public function __construct(string $destinationPath, ?Lang $language = null)
    {
        $language = $language ?? new EnUs();

        $this->parser = new Parser($language, $destinationPath);
        $this->compiler = new Compiler($language, $destinationPath);
    }

    public function addDirectory(string $sourceDirectory, string $targetDirectory): self
    {
        $this->parser->addDirectory($sourceDirectory, $targetDirectory);

        return $this;
    }

    public function addFile(string $sourceFile, string $targetFile): self
    {
        $this->parser->addFile($sourceFile, $targetFile);

        return $this;
    }

    public function generate(): void
    {
        $this->parser->analyse();

        $this->compiler
            ->setFiles($this->parser->getFiles())
            ->setSummaryFile($this->parser->getSummaryFile())
            ->setSummaryItems($this->parser->getSummaryItems())
            ->make();
    }
}
