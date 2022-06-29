<?php

declare(strict_types=1);

namespace Freep\DocsMapper;

use Freep\DocsMapper\i18n\EnUs;
use Freep\DocsMapper\i18n\Lang;
use Freep\Security\Filesystem;
use Freep\Security\Path;
use InvalidArgumentException;

class Template
{
    private array $summary = [];

    private array $navigation = [];

    public function __construct(private File $file)
    {}

    public function setSummaryItems(array $summary): void
    {
        $this->summary = $summary;
    }

    public function setPageNavigation(array $structure): void
    {
        $this->navigation = $structure;
    }

    public function parse(): string
    {
        $rowList= $this->file->getContents();

        foreach($rowList as $number => $row) {
            $parseRow = trim($row);

            if (strpos($parseRow, '{{ summary }}')) {
                $rowList[$number] = $this->generateSummary();
                continue;
            }

            if (strpos($parseRow, '{{ page_nav }}')) {
                $rowList[$number] = $this->generatePageNavigation();
            }
        }
        
        return implode("\n", $rowList);
    }

    public function generatePageNavigation(): string
    {
        return '';
    }
    
    public function generateSummary(): string
    {
        $notation = [];

        foreach($this->summary as $path => $title) {
            $notation[] = "- [$title]($path)";
        }

        return implode("\n", $notation);
    }
    
}
