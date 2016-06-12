<?php

namespace Voronoy\BashCompletion\Model;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Voronoy\BashCompletion\Model\BashCompletion\Generator;

class BashCompletion
{
    private $name = 'magento2-bash-completion';

    private $filesystem;

    private $generator;

    public function __construct(
        Filesystem $filesystem,
        Generator $generator
    ) {
        $this->filesystem = $filesystem;
        $this->generator = $generator;
    }

    public function generateCompletionList($name = null)
    {
        if (!$name) {
            $name = $this->getName();
        }
        $directoryWrite = $this->filesystem->getDirectoryWrite(DirectoryList::VAR_DIR);
        $directoryWrite->writeFile($name, $this->generator->generate());
        return 'Magento2 Bash Completion generated in var/' . $name;
    }

    public function getName()
    {
        return $this->name;
    }
}
