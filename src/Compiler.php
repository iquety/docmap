<?php

declare(strict_types=1);

namespace Freep\DocsMapper;

use Freep\DocsMapper\i18n\EnUs;
use Freep\DocsMapper\i18n\Lang;
use Freep\Security\Filesystem;
use Freep\Security\Path;
use InvalidArgumentException;

class Compiler
{
    private string $destinationPath = '';

    private Lang $language;
    
    /** @var array<string,File> */
    private array $fileList = [];

    /** @var array<string,string> */
    private array $summary = [];

    private string $summaryFile = '';

    public function __construct(Lang $language, string $destinationPath)
    {
        $this->destinationPath = $destinationPath;
        $this->language = $language;
    }

    private function getFile(string $originPath): File
    {
        if ($originPath === '') {
            return new File('');
        }

        return $this->fileList[$originPath];
    }
    
    /** @return array<string,array<string,string>> */
    public function getPageNavigation(string $filepath): array
    {
        $summary = array_keys($this->summary);

        $previousPath = '';

        foreach ($summary as $index => $path) {
            $nextPath = isset($summary[$index + 1]) === false
                ? ''
                : $summary[$index + 1];

            if ($path === $filepath) {
                break;
            }

            $previousPath = $path;
        }

        $indexPath = $this->summaryFile;

        return [
            'previous' => $this->getFile($previousPath)->getTargetFile(),
            'index'    => $this->getFile($indexPath)->getTargetFile(),
            'next'     => $this->getFile($nextPath)->getTargetFile()
        ];
    }

    /** @return array<string,string> */
    public function getSummaryNavigation(): array
    {
        $summary = [];

        foreach ($this->summary as $filePath => $title) {
            $index = $this->getFile($filePath)->getTargetFile();
            $summary[$index] = $title;
        }

        return $summary;
    }

    public function make(): void
    {
        $filesystem = new Filesystem($this->destinationPath);

        foreach ($this->fileList as $filePath => $fileObject) {
            $template = new Template($fileObject);
            $template->setSummaryItems($this->summary);
            $template->setPageNavigation($this->getPageNavigation($filePath));
            $filesystem->setFileContents($fileObject->getTargetFile(), $template->parse());
        }
    }

    public function setFiles(array $fileList): self
    {
        $this->fileList = $fileList;

        return $this;
    }

    public function setSummaryItems(array $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function setSummaryFile(string $filePath): self
    {
        $this->summaryFile = $filePath;

        return $this;
    }
}
