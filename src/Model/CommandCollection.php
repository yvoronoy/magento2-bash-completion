<?php

namespace Voronoy\BashCompletion\Model;

use Symfony\Component\Console\Command\Command;

class CommandCollection implements \Countable
{
    private $commands = [];

    public function add(Command $command)
    {
        $this->commands[$command->getName()] = $command;
    }

    public function getItems()
    {
        return $this->commands;
    }

    public function getItem($commandName)
    {
        if (isset($this->commands[$commandName])) {
            return $this->commands[$commandName];
        }
    }

    public function count()
    {
        return count($this->commands);
    }

    /**
     * Set Items
     *
     * @param array $commands
     */
    public function setItems(array $commands)
    {
        $this->commands = $commands;
    }
}
