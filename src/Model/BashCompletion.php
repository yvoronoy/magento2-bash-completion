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

    public function __construct(
        Filesystem $filesystem,
        Generator $bashCompleteGenerator
    ) {
        $this->filesystem = $filesystem;
        $this->bashCompleteGenerator = $bashCompleteGenerator;
    }

    public function generateCompletionList($name = null)
    {
        if (!$name) {
            $name = $this->getName();
        }
        $directoryWrite = $this->filesystem->getDirectoryWrite(DirectoryList::VAR_DIR);
        $directoryWrite->writeFile($name, $this->bashCompleteGenerator->generate());
        return 'Magento2 Bash Completion generated in var/' . $name;
    }

    public function getName()
    {
        return $this->name;
    }
}
