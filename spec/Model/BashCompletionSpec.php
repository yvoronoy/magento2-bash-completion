<?php

namespace spec\Voronoy\BashCompletion\Model;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Console\Command\Command;
use Voronoy\BashCompletion\Model\BashCompletion;
use Voronoy\BashCompletion\Model\BashCompletion\Generator;
use Voronoy\BashCompletion\Model\CommandCollection;

class BashCompletionSpec extends ObjectBehavior
{
    function let(
        Filesystem $filesystem, 
        Generator $bashCompleteGenerator,
        CommandCollection $collection,
        Command $command1,
        Command $command2
    ) {
        $collection->add($command1);
        $collection->add($command2);
        $this->beConstructedWith(
            $filesystem,
            $bashCompleteGenerator,
            $collection
        );
    }
    function it_is_initializable()
    {
        $this->shouldHaveType('Voronoy\BashCompletion\Model\BashCompletion');
    }

    function it_should_generate_bash_completion_file(
        Filesystem $filesystem, 
        Filesystem\Directory\WriteInterface $write,
        Generator $bashCompleteGenerator
    ) {
        $filesystem->getDirectoryWrite(DirectoryList::VAR_DIR)
            ->willReturn($write)
            ->shouldBeCalled(1);

        $bashCompleteGenerator->generate()->shouldBeCalled()->willReturn(3);
        
        $this->generateCompletionList()
            ->shouldReturn('Magento2 Bash Completion generated in var/magento2-bash-completion');
    }
}
