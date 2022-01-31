<?php


namespace Hhennes\CliCommands\Console\Command;

use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * This command is declared in a standard Symfony way
 */
class SampleCommand extends Command
{

    /**
     * @inheritDoc
     */
    protected function configure(): void
    {
        $this->setName('hhennes:cli:samplecommand');
        $this->setDescription('This is a sample basic command.');
        parent::configure();
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<info>Sample command without interactions</info>');
        return Cli::RETURN_SUCCESS;
    }
}
