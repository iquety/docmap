<?php

declare(strict_types=1);

namespace Iquety\Docmap;

use Iquety\Docmap\i18n\Lang;
use Iquety\Security\Filesystem;
use Iquety\Security\Path;
use OutOfRangeException;

class Parser
{
    /** @var array<string,string> */
    private array $directoryList = [];

    private Lang $language;

    /** @var array<string,string> */
    private array $fileList = [];

    /** @var array<string,File> */
    private array $parsedList = [];

    /** @var array<int,string> */
    private array $summary = [];

    private string $summaryFile = '';

    public function __construct(Lang $language)
    {
        $this->language = $language;
    }

    public function addDirectory(string $sourcePath, string $targetPath): self
    {
        $this->directoryList[$sourcePath] = $targetPath;

        return $this;
    }

    public function addFile(string $sourceFile, string $targetFile): self
    {
        $this->fileList[$sourceFile] = $targetFile;

        return $this;
    }

    public function analyse(): void
    {
        foreach ($this->directoryList as $originPath => $targetPath) {
            $this->analyseDirectory($originPath, $targetPath);
        }

        foreach ($this->fileList as $originPath => $targetFile) {
            $this->analyseFile($originPath, $targetFile);
        }
    }

    private function analyseDirectory(string $originPath, string $targetPath): void
    {
        $fileList = (new Filesystem($originPath))->getDirectoryFiles('');

        foreach ($fileList as $path) {
            $targetFile = new Path($targetPath);
            $targetFile->addNodePath($path->getNodePath());

            $this->analyseFile($path->getPath(), $targetFile->getPath());
        }
    }

    private function analyseFile(string $filePath, string $targetFile): void
    {
        $file = new File($filePath);

        if ($file->getFileInfo()->getExtension() !== 'md') {
            return;
        }

        $file->setTargetFile($targetFile);
        $file->analyse();

        $this->parsedList[$filePath] = $file;

        if ($file->isSummary($this->getLanguage()->translate('summary_file')) === true) {
            $this->summaryFile = $filePath;
            return;
        }

        if ($file->isReadme($this->getLanguage()->translate('readme_file')) === true) {
            return;
        }

        $this->summary[] = $filePath;
    }

    public function getFile(string $sourcePath): File
    {
        if ($sourcePath === '') {
            return new File('');
        }

        if (isset($this->parsedList[$sourcePath]) === false) {
            throw new OutOfRangeException("The '$sourcePath' file does not exist in the analyzed analysis list");
        }

        return $this->parsedList[$sourcePath];
    }

    public function getLanguage(): Lang
    {
        return $this->language;
    }

    /** @return array<string,File> */
    public function getParsedFiles(): array
    {
        return $this->parsedList;
    }

    /** @return array<int,string> */
    public function getSummaryItems(): array
    {
        return $this->summary;
    }

    public function getSummaryFile(): string
    {
        return $this->summaryFile;
    }
}
