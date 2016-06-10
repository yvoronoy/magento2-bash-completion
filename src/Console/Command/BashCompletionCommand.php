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
    const COMMAND_NAME = 'bash:completion:generate';

    const INPUT_ARG_NAME = 'name';

    private $commandCollection;

    private $bashCompletion;

    public function __construct(
        CommandCollection $commandCollection,
        BashCompletion $bashCompletion
    ) {
        $this->commandCollection = $commandCollection;
        $this->bashCompletion = $bashCompletion;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName(self::COMMAND_NAME)
            ->setDescription('Generate Bash Completion List.');
        $this->setDefinition([new InputArgument(
            self::INPUT_ARG_NAME,
            InputArgument::OPTIONAL,
            'Bash Completion File Name'
        )]);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $description = new ApplicationDescription($this->getApplication());
        $this->commandCollection->setItems($description->getCommands());
        $result = $this->bashCompletion->generateCompletionList(
            $input->getArgument(self::INPUT_ARG_NAME));

        return $output->writeln($result);
    }
}