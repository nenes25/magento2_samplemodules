<?php


namespace Hhennes\CliCommands\Console\Command;

use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * The name of this command is defined in the di.xml file
 * see
 */
class SampleDiNameCommand extends Command
{

    /**
     * @inheritDoc
     */
    protected function configure(): void
    {
        $this->setDescription('This is a sample basic command with name configured with di.');
        parent::configure();
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<info>Sample command without interactions with name configured with di</info>');
        return Cli::RETURN_SUCCESS;
    }
}
