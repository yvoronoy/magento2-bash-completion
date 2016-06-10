<?php

namespace spec\Voronoy\BashCompletion\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Console\Command\Command;
use Voronoy\BashCompletion\Model\CommandCollection;

class CommandCollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Voronoy\BashCompletion\Model\CommandCollection');
    }
    
    function it_should_be_able_add_command(Command $command)
    {
        $command->getName()->willReturn('abc');
        $this->add($command);
        $this->getItems()->shouldBeArray();
        $this->getItems()->shouldContain($command);
        $this->getItem('abc')->shouldReturn($command);
    }
    
    function it_should_be_countable(Command $command1, Command $command2)
    {
        $command1->getName()->willReturn('abc');
        $command2->getName()->willReturn('cba');
        $this->add($command1);
        $this->add($command2);
        
        $this->count()->shouldBe(2);
    }
    
    function it_can_add_multiple_items_to_collection(Command $command1, Command $command2)
    {
        $this->setItems([$command1, $command2]);
        $this->count()->shouldBe(2);
    }
}
