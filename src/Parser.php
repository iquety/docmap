<?php

declare(strict_types=1);

namespace Freep\DocsMapper;

use Freep\DocsMapper\i18n\EnUs;
use Freep\DocsMapper\i18n\Lang;
use Freep\Security\Filesystem;
use Freep\Security\Path;
use InvalidArgumentException;

class Parser
{
    private string $destinationPath = '';

    /** @var array<string,string> */
    private array $directoryList = [];

    private Lang $language;
    
    /** @var array<string,string> */
    private array $fileList = [];

    /** @var array<string,File> */
    private array $parsedList = [];

    /** @var array<string,string> */
    private array $summary = [];

    private string $summaryFile = '';

    public function __construct(Lang $language, string $destinationPath)
    {
        $this->destinationPath = $destinationPath;
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

    /** @return array<int,array<string,mixed>> */
    public function analyse(): void
    {
        foreach($this->directoryList as $originPath => $targetPath) {
            $this->analyseDirectory($originPath, $targetPath);
        }

        foreach($this->fileList as $originPath => $targetFile) {
            $this->analyseFile($originPath, $targetFile);
        }
    }

    private function analyseDirectory(string $originPath, string $targetPath): void
    {
        $fileList = (new Filesystem($originPath))->getDirectoryFiles('');

        foreach($fileList as $path) {
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

        if ($file->isSummary($this->language->translate('summary_file')) === true) {
            $this->summaryFile = $filePath;
            return;
        }
        
        $this->summary[$filePath] = $file->getTitle();
    }

    /** @return array<string,File> */
    public function getParsedFiles(): array
    {
        return $this->parsedList;
    }

    /** @return array<string,string> */
    public function getSummaryItems(): array
    {
        return $this->summary;
    }

    public function getSummaryFile(): string
    {
        return $this->summaryFile;
    }
}
