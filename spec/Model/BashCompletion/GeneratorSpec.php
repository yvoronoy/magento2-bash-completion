<?php

namespace spec\Voronoy\BashCompletion\Model\BashCompletion;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Voronoy\BashCompletion\Model\CommandCollection;

class GeneratorSpec extends ObjectBehavior
{
    function let(
        CommandCollection $collection,
        Command $command1,
        Command $command2,
        InputDefinition $inputDefinition,
        InputDefinition $inputDefinition2,
        InputOption $inputOption,
        InputOption $inputOption2
    ) {
        $inputDefinition->getOptions()->willReturn([
            'option1' => $inputOption, 
            'option2' => $inputOption2
        ]);
        $command1->getName()->willReturn('test:command');
        $command1->getDefinition()->willReturn($inputDefinition);

        $inputDefinition2->getOptions()->willReturn([]);
        $command2->getName()->willReturn('other-command');
        $command2->getDefinition()->willReturn($inputDefinition2);
        
        
        $collection->getItems()->willReturn([
            'test:command' => $command1,
            'other-command' => $command2
        ]);
        $this->beConstructedWith($collection);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType('Voronoy\BashCompletion\Model\BashCompletion\Generator');
    }
    
    function it_there_is_generate_method() {

        $expected = <<<'TEMPLATE'
_magento2()
{
    local cur opts first_word
    COMPREPLY=()
    _get_comp_words_by_ref -n : cur words
    for word in ${words[@]:1}; do
        if [[ $word != -* ]]; then
            first_word=$word
            break
        fi
    done
    opts="test:command other-command"
    case "$first_word" in
        test:command)
            opts="--option1 --option2"
        ;;
    esac
    COMPREPLY=( $(compgen -W "${opts}" -- ${cur}) )
    __ltrim_colon_completions "$cur"
}
complete -o default -F _magento2 magento

TEMPLATE;

        $this->generate()->shouldBe($expected);
    }
}
