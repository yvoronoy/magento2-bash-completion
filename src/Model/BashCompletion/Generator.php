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
    local cur prev opts
    _get_comp_words_by_ref -n : cur
    COMPREPLY=()
    cur="\${COMP_WORDS[COMP_CWORD]}"
    prev="\${COMP_WORDS[COMP_CWORD-1]}"
    opts="{$this->getAllCommands()}"
    case "\$prev" in 
{$this->getDefinitions()}
    esac
    COMPREPLY=( $(compgen -W "\${opts}" -- \${cur}) )
    __ltrim_colon_completions "\$cur"
}
complete -F _magento2 magento
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
            COMPREPLY=($(compgen -W "{$options}" \${cur}))
            return 0;
        ;;

TEMPLATE;
        }

        return $definitions;
    }
}
