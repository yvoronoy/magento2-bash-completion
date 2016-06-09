<?php
namespace Voronoy\BashCompletion\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BashCompletionCommand extends Command
{
    protected function configure()
    {
        $this->setName('bash:completion:generate')->setDescription('Generate Bash Completion List.');
        $this->setDefinition([new InputArgument(
            'path',
            InputArgument::OPTIONAL,
            'Path to Bash Completion List'
        )]);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        return $output->writeln('Generated file in var/magento2-bash-completion');
    }
}
