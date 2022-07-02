<?php

declare(strict_types=1);

namespace Freep\DocsMapper;

use Freep\Security\Filesystem;
use Freep\Security\Path;

class File
{
    /** @var array<int,string> */
    private array $contents = [];

    private Path $info;

    private string $title = '';

    private string $targetFile = '';

    private bool $hasSummary = false;

    public function __construct(string $filePath)
    {
        $this->info = new Path($filePath);
    }

    public function analyse(): void
    {
        $contextPath = $this->getFileInfo()->getDirectory();
        $filePath = $this->getFileInfo()->getFile();

        $fileRows = (new Filesystem($contextPath))->getFileRows($filePath);

        foreach ($fileRows as $row) {
            $this->contents[] = $row;

            $this->extractTitle($row);

            $this->checkSummary($row);
        }
    }

    private function checkSummary(string $row): void
    {
        $row = trim($row);

        if (strpos($row, '--summary--') !== false) {
            $this->hasSummary = true;
        }
    }

    private function extractTitle(string $row): void
    {
        $row = trim($row);

        if ($this->title !== '') {
            return;
        }

        if (str_starts_with($row, '# ') === true) {
            $this->title = ltrim($row, '# ');
        }
    }

    /** @return array<int,string> */
    public function getContents(): array
    {
        return $this->contents;
    }

    public function getFileInfo(): Path
    {
        return $this->info;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getTargetFile(): string
    {
        return $this->targetFile;
    }

    public function isReadme(string $readmeFileName): bool
    {
        $fileName = $this->getFileInfo()->getFile();
        return $fileName === $readmeFileName;
    }

    public function isSummary(string $summaryFileName): bool
    {
        if ($this->hasSummary === false) {
            return false;
        }

        $fileName = $this->getFileInfo()->getFile();
        return $fileName === $summaryFileName;
    }
    
    public function setTargetFile(string $filePath): void
    {
        $this->targetFile = $filePath;
    }
}
