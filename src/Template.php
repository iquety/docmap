<?php

declare(strict_types=1);

namespace Freep\Docmap;

class Template
{
    /** @var array<string,Link> */
    private array $navigation = [];

    public function __construct(private Compiler $compiler, private File $file)
    {
        $filePath = $this->getFilePath();

        $this->navigation = $this->compiler->getPageNavigation($filePath);
    }

    private function getFilePath(): string
    {
        return $this->file->getFileInfo()->getPath();
    }

    public function parse(): string
    {
        $rowList= $this->file->getContents();

        foreach($rowList as $number => $row) {
            $parseRow = trim($row);

            if (strpos($parseRow, '--summary--') !== false) {
                $rowList[$number] = $this->generateSummary();
            }

            if (strpos($parseRow, '--summary-nav--') !== false) {
                $rowList[$number] = $this->generateSummaryPageNavigation();
            }

            if (strpos($parseRow, '--page-nav--') !== false) {
                $rowList[$number] = $this->generatePageNavigation();
            }
        }
        
        return implode("\n", $rowList) . "\n";
    }

    public function generatePageNavigation(): string
    {
        $notation = [];

        $filePath = $this->getFilePath();

        $previous = $this->getLinkPrevious();
        $index    = $this->getLinkIndex();
        $next     = $this->getLinkNext();

        $previousTitle = $previous->getTitle();
        $indexTitle    = $index->getTitle();
        $nextTitle     = $next->getTitle();

        $previousLink = $previous->resolveTo($filePath);
        $indexLink    = $index->resolveTo($filePath);
        $nextLink     = $next->resolveTo($filePath);

        if ($previousLink !== '') {
            $notation[] = "[◂ " . $previousTitle . "](" . $previousLink . ")";
        }

        $indexPrefix = "";
        $indexSufix = "";

        if ($previousLink === '') {
            $indexPrefix = "◂ ";
        }

        if ($nextLink === '') {
            $indexSufix = " ▸";
        }

        $notation[] = "[" . $indexPrefix . $indexTitle . $indexSufix . "](" . $indexLink . ")";

        if ($nextLink !== '') {
            $notation[] = "[" . $nextTitle . " ▸](" . $nextLink . ")";
        }

        $table = array_fill(0, count($notation), '--');

        return implode(' | ', $notation)
            . "\n" 
            . implode(' | ', $table);
    }

    public function generateSummaryPageNavigation(): string
    {
        $filePath = $this->getFilePath();

        $summaryItems = $this->compiler->getSummaryLinks();

        $nextLink = array_shift($summaryItems);

        $notation = [];

        if ($this->getReadmePath() !== '') {
            $notation[] = "[◂ " . $this->getReadmeTitle() . "](" . $this->getReadmePath() . ")";
        }
        
        $notation[] = "[" . $nextLink->getTitle() . " ▸](" . $nextLink->resolveTo($filePath) . ")";

        $table = array_fill(0, count($notation), '--');

        return implode(' | ', $notation)
            . "\n" 
            . implode(' | ', $table);
    }
    
    public function generateSummary(): string
    {
        $filePath = $this->getFilePath();

        $summaryItems = $this->compiler->getSummaryLinks();
        
        $notation = [];

        foreach($summaryItems as $link) {
            $path = $link->resolveTo($filePath);
            $notation[] = "- [" . $link->getTitle() . "](" . $path . ")";
        }

        return implode("\n", $notation);
    }
    
    private function getLinkIndex(): Link
    {
        return $this->navigation['index'];
    }

    private function getLinkNext(): Link
    {
        return $this->navigation['next'];
    }

    private function getLinkPrevious(): Link
    {
        return $this->navigation['previous'];
    }

    public function getReadmePath(): string
    {
        return $this->compiler->getReadmePath();
    }

    public function getReadmeTitle(): string
    {
        return $this->compiler->getParser()->getLanguage()->translate('back_to_readme');
    }
}
