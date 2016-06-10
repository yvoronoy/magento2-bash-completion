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
        Generator $bashCompleteGenerator
    ) {
        $this->beConstructedWith(
            $filesystem,
            $bashCompleteGenerator
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
        $bashCompleteGenerator->generate()->shouldBeCalled()->willReturn('abc');
        $filesystem->getDirectoryWrite(DirectoryList::VAR_DIR)
            ->willReturn($write)
            ->shouldBeCalled(1);
        $write->writeFile('magento2-bash-completion', 'abc')->willReturn(3);

        $this->generateCompletionList()
            ->shouldReturn('Magento2 Bash Completion generated in var/magento2-bash-completion');
    }
    
    function it_should_return_entered_name(
        Filesystem $filesystem,
        Generator $bashCompleteGenerator,
        Filesystem\Directory\WriteInterface $write
    ) {
        $bashCompleteGenerator->generate()->shouldBeCalled()->willReturn('abc');
        $filesystem->getDirectoryWrite(DirectoryList::VAR_DIR)
            ->willReturn($write)
            ->shouldBeCalled(1);
        $write->writeFile('custom-name', 'abc')->willReturn(3);
        $this->generateCompletionList('custom-name')
            ->shouldReturn('Magento2 Bash Completion generated in var/custom-name');
    }
}
