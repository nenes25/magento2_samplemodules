<?php

namespace Hhennes\CliCommands\Test\Console\Command;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Hhennes\CliCommands\Console\Command\SampleCommand;

class SampleCommandTest extends TestCase
{

    /**
     * @var CommandTester
     */
    private CommandTester $commandTester;


    protected function setUp(): void
    {
        $this->commandTester = new CommandTester(
            new SampleCommand()
        );
    }

    public function testExecute():void
    {
        $this->commandTester->execute([]);
        $this->assertEquals(
            'Sample command without interactions' . PHP_EOL,
            $this->commandTester->getDisplay()
        );
    }
}
