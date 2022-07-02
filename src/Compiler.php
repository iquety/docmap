<?php

declare(strict_types=1);

namespace Freep\DocsMapper;

use Freep\Security\Filesystem;

class Compiler
{
    private string $readmePath = '';

    public function __construct(private Parser $parser)
    {}

    /** @return array<string,Link> */
    public function getPageNavigation(string $filePath): array
    {
        $summary = $this->getParser()->getSummaryItems();

        $previousPath = '';

        foreach ($summary as $index => $path) {
            $nextPath = isset($summary[$index + 1]) === false
                ? ''
                : $summary[$index + 1];

            if ($path === $filePath) {
                break;
            }

            $previousPath = $path;
        }

        return [
            'previous' => $this->linkFactory($previousPath),
            'index'    => $this->linkFactory($this->getParser()->getSummaryFile()),
            'next'     => $this->linkFactory($nextPath, $filePath)
        ];
    }

    public function getParser(): Parser
    {
        return $this->parser;
    }

    public function getReadmePath(): string
    {
        return $this->readmePath;
    }

    /** @return array<int,Link> */
    public function getSummaryLinks(): array
    {
        return array_map(
            fn($path) => $this->linkFactory($path),
            $this->parser->getSummaryItems()
        );
    }

    private function linkFactory(string $linkPath): Link
    {
        return new Link($this->getParser(), $linkPath);
    }

    public function makeTo(string $destinationPath): void
    {
        $filesystem = new Filesystem($destinationPath);

        foreach ($this->parser->getParsedFiles() as $fileObject) {
            $template = new Template($this, $fileObject);

            // $template->setPageNavigation($this->getPageNavigation($filePath));
            // $template->setReadmePath($this->readmePath);
            // $template->setSummaryItems($this->getSummaryNavigation());
            $filesystem->setFileContents($fileObject->getTargetFile(), $template->parse());
        }
    }

    public function setReadmePath(string $relativePath): self
    {
        $this->readmePath = $relativePath;

        return $this;
    }
}
