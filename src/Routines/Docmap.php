<?php

declare(strict_types=1);

namespace Iquety\Docmap\Routines;

use Iquety\Console\Arguments;
use Iquety\Console\Command;
use Iquety\Console\Option;
use Iquety\Console\Routine;
use Iquety\Docmap\Generator;
use Iquety\Docmap\i18n\EnUs;
use Iquety\Docmap\i18n\PtBr;
use Iquety\Security\Path;

class Docmap extends Routine
{
    protected function initialize(): void
    {
        $this->setName("docmap");
        $this->setDescription("Generate a navbar documentation");
        $this->setHowToUse("vendor/bin/docmap [options]");

        $this->addOption(
            new Option(
                '-d',
                '--dist',
                'Provides the host available for connections',
                Option::REQUIRED | Option::VALUED,
                ''
            )
        );

        $this->addOption(
            new Option(
                '-l',
                '--lang',
                'Provides the language to translate navigations',
                Option::OPTIONAL | Option::VALUED,
                ''
            )
        );

        $this->addOption(
            new Option(
                '-r',
                '--readme',
                'Provides a relative location to readme.md file',
                Option::OPTIONAL | Option::VALUED,
                ''
            )
        );

        $this->addOption(
            new Option(
                '-s',
                '--src',
                'Provides a directory containing a list of channels and their subscribers',
                Option::REQUIRED | Option::VALUED,
                ''
            )
        );
    }

    protected function handle(Arguments $arguments): void
    {
        $lang = new EnUs();

        if ($arguments->getOption('-l') === 'pt-br') {
            $lang = new PtBr();
        }

        $instance = new Generator($lang);

        $readmeRelativePath = $arguments->getOption('-r');

        if ($readmeRelativePath !== '') {
            $instance->setReadmePath($readmeRelativePath);
        }

        $sourcePath = $this->resolveSourcePath($arguments->getOption('-s'));

        $destinationPath = $this->resolveDestinationPath($arguments->getOption('-d'));
        $destinationObject = new Path($destinationPath);

        $instance->addDirectory($sourcePath, $destinationObject->getName());
        $instance->generateTo($destinationObject->getDirectory());
    }

    private function resolveSourcePath(string $path): string
    {
        return (new Path($path))->getAbsolutePath();
    }

    private function resolveDestinationPath(string $path): string
    {
        $currentObject = new Path($path);

        $parentPath = $currentObject->getDirectory();
        $parentObject = new Path($parentPath);

        $directory = $parentObject->getAbsolutePath();
        $subdirectory = $currentObject->getName();

        return (new Path($directory))->addNodePath($subdirectory)->getPath();
    }
}
