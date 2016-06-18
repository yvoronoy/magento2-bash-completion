<?php

namespace Voronoy\BashCompletion\Model\BashCompletion;

use Symfony\Component\Console\Command\Command;
use Voronoy\BashCompletion\Model\CommandCollection;

class Generator
{
    private $commandCollection;
    
    public function __construct(CommandCollection $commandCollection)
    {
        $this->commandCollection = $commandCollection;
    }

    public function generate()
    {
        $template = $this->getTemplate();
        
        return $template;
    }
    
    private function getAllCommands()
    {
        $commandCollection = $this->commandCollection;
        $commands = array_keys($commandCollection->getItems());
        $commands = implode(' ', $commands);
        
        return $commands;
    }
    
    private function getTemplate()
    {
        return <<<TEMPLATE
_magento2()
{
    local cur opts first_word
    COMPREPLY=()
    _get_comp_words_by_ref -n : cur words
    for word in \${words[@]:1}; do
        if [[ \$word != -* ]]; then
            first_word=\$word
            break
        fi
    done
    opts="{$this->getAllCommands()}"
    case "\$first_word" in
{$this->getDefinitions()}
    esac
    COMPREPLY=( $(compgen -W "\${opts}" -- \${cur}) )
    __ltrim_colon_completions "\$cur"
}
complete -o default -F _magento2 magento

TEMPLATE;
    }

    private function getDefinitions()
    {
        $definitions = '';
        foreach ($this->commandCollection->getItems() as $name => $cmd) {
            /** @var Command $cmd */
            if (!$cmd->getDefinition()->getOptions()) {
                continue;
            }
            $options = array_keys($cmd->getDefinition()->getOptions());
            foreach ($options as &$option) {
                $option = sprintf('--%s', $option);
            }
            $options = implode(' ', $options);
            $definitions .= <<<TEMPLATE
        {$name})
            opts="{$options}"
        ;;
TEMPLATE;
        }

        return $definitions;
    }
}
