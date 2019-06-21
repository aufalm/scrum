<?php

namespace DOSBox\Command;

use DOSBox\Command\BaseCommand as Command;
use DOSBox\Interfaces\IDrive;
use DOSBox\Interfaces\IOutputter;

abstract class BaseCmdMk extends Command
{

    protected $currentDir;
    protected $content;

    public function __construct($commandName, IDrive $drive)
    {
        parent::__construct($commandName, $drive);

    }

    public function execute(IOutputter $outputter)
    {

    }

    public function checkExistingFile($name)
    {
        $this->currentDir = $this->getDrive()->getCurrentDirectory();
        $this->content = $this->currentDir->getContent();
        foreach ($this->content as $item) {
            if (!$item->isDirectory()) {
                if ($item->getName() == $name) {
                    return true;
                }
            }
        }
        return false;
    }

    public function checkExistingDir($name)
    {
        $this->currentDir = $this->getDrive()->getCurrentDirectory();
        $this->content = $this->currentDir->getContent();
        foreach ($this->content as $item) {
            if ($item->isDirectory()) {
                if ($item->getName() == $name) {
                    return true;
                }
            }
        }
        return false;
    }

}
