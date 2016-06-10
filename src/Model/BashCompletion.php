<?php

namespace Voronoy\BashCompletion\Model;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Voronoy\BashCompletion\Model\BashCompletion\Generator;

class BashCompletion
{
    private $name = 'magento2-bash-completion';

    private $filesystem;

    private $bashCompleteGenerator;

    private $collection;

    public function __construct(
        Filesystem $filesystem,
        Generator $bashCompleteGenerator,
        CommandCollection $collection
    ) {
        $this->filesystem = $filesystem;
        $this->bashCompleteGenerator = $bashCompleteGenerator;
        $this->collection = $collection;
    }

    public function generateCompletionList()
    {
        $directoryWrite = $this->filesystem->getDirectoryWrite(DirectoryList::VAR_DIR);
        $directoryWrite->writeFile($this->getName(), $this->bashCompleteGenerator->generate());
        return 'Magento2 Bash Completion generated in var/magento2-bash-completion';
    }

    public function getName()
    {
        return $this->name;
    }
}
