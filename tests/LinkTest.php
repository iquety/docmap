<?php

declare(strict_types=1);

namespace Tests;

use Freep\Docmap\i18n\EnUs;
use Freep\Docmap\Link;
use Freep\Docmap\Parser;
use Freep\Security\Path;

class LinkTest extends TestCase
{
    private function linkFactory(string $targetLinkPath, string $targetDocumentPath): Link
    {
        $link = new Path(__DIR__ . "/docs-src/en/01-page-one.md");
        $ref = new Path(__DIR__ . "/docs-src/en/02-page-two.md");

        $parser = new Parser(new EnUs());
        $parser->addFile($link->getPath(), $targetLinkPath);
        $parser->addFile($ref->getPath(), $targetDocumentPath);

        $parser->analyse();

        return new Link($parser, $link->getPath());
    }

    /** @test */
    public function getInfo(): void
    {
        $link = $this->linkFactory(
            'test/01-page-one.md', // link
            'test/02-page-two.md'  // document
        );

        $this->assertEquals("First title", $link->getTitle());
        $this->assertEquals(__DIR__ . "/docs-src/en/01-page-one.md", $link->getSourceLink());
        $this->assertEquals("test/01-page-one.md", $link->getTargetLink());
    }

    /** @test */
    public function resolveEmptyLink(): void
    {
        $link = new Link($this->parserFactory(), '');

        $this->assertEquals(
            "",
            $link->resolveTo(__DIR__ . "/docs-src/en/02-page-two.md")
        );
    }

    /** @return array<string,array<int,string>> */
    public function linkListProvider(): array
    {
        $list = [];

        $list['link same dir with document'] = [
            'test/01-page-one.md', // link
            'test/02-page-two.md', // document
            "01-page-one.md",      // resolved
        ];

        $list['link same dir with document in two levels'] = [
            'test/subdir/01-page-one.md', // link
            'test/subdir/02-page-two.md', // document
            "01-page-one.md",             // resolved
        ];

        $list['link in upper dir with document'] = [
            '01-page-one.md',      // link
            'test/02-page-two.md', // document
            "../01-page-one.md",   // resolved
        ];

        $list['link in upper dir with document in two levels'] = [
            'test/01-page-one.md',        // link
            'test/subdir/02-page-two.md', // document
            "../01-page-one.md",          // resolved
        ];

        $list['link in subdir with document'] = [
            'test/subdir/01-page-one.md', // link
            'test/02-page-two.md',        // document
            "subdir/01-page-one.md",      // resolved
        ];

        $list['link in subdir with document in two levels'] = [
            'test/subdir/deepdir/01-page-one.md', // link
            'test/subdir/02-page-two.md',         // document
            "deepdir/01-page-one.md",             // resolved
        ];

        return $list;
    }

    /**
     * @test
     * @dataProvider linkListProvider
     */
    public function resolveTo(string $link, string $document, string $resolved): void
    {
        $link = $this->linkFactory($link, $document);

        $this->assertEquals(
            $resolved,
            $link->resolveTo(__DIR__ . "/docs-src/en/02-page-two.md")
        );
    }
}
