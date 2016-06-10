<?php
namespace Voronoy\BashCompletion\Console\Command;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Filesystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Descriptor\ApplicationDescription;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Voronoy\BashCompletion\Model\BashCompletion;
use Voronoy\BashCompletion\Model\CommandCollection;

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
        $description = new ApplicationDescription($this->getApplication());
        $commands = $description->getCommands();
        $commandCollection = new CommandCollection();
        foreach ($commands as $command) {
            $commandCollection->add($command);
        }
        
        $filesystem = ObjectManager::getInstance()->get(Filesystem::class);
        $generator = new BashCompletion\Generator($commandCollection);
        $bashCompletion = new BashCompletion($filesystem, $generator, $commandCollection);
        $result = $bashCompletion->generateCompletionList();

        return $output->writeln($result);
    }
}