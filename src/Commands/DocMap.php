<?php

declare(strict_types=1);

namespace Freep\DocsMapper\Commands;

use Freep\Console\Arguments;
use Freep\Console\Command;
use Freep\Console\Option;

class DocMap extends Command
{
    protected function initialize(): void
    {
        $this->setName("docmap");
        $this->setDescription("Generate a navbar documentation");
        $this->setHowToUse("vendor/bin/docmap [options]");

        $this->addOption(
            new Option(
                '-s',
                '--src',
                'Provides a directory containing a list of channels and their subscribers',
                Option::REQUIRED | Option::VALUED,
                ''
            )
        );

        $this->addOption(
            new Option(
                '-d',
                '--dist',
                'Provides the host available for connections',
                Option::REQUIRED | Option::VALUED,
                'localhost'
            )
        );
    }

    protected function handle(Arguments $arguments): void
    {
        
    }
}
