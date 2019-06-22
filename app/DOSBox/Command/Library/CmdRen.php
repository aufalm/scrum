<?php

namespace DOSBox\Command\Library;

use DOSBox\Command\BaseCommand as Command;
use DOSBox\Interfaces\IDrive;
use DOSBox\Interfaces\IOutputter;

class CmdRen extends Command
{
    protected $currentDir;
    protected $content;

    public function __construct($commandName, IDrive $drive)
    {
        parent::__construct($commandName, $drive);
    }

    public function checkNumberOfParameters($numberOfParametersEntered)
    {
        return ($numberOfParametersEntered == 2);
    }

    public function checkParameterValues(IOutputter $outputter)
    {

        if ($this->getParameterCount() < 1) {
            return false;
        }

        $this->currentDir = $this->getDrive()->getCurrentDirectory();
        $this->content = $this->currentDir->getContent();

        $name = $this->params[0];
        $rename = $this->params[1];

        $isFile = true;

        $fileFound = false;

        foreach ($this->content as $item) {
            if ($item->getName() == $name) {
                $fileFound = true;
            }
            if ($item->isDirectory()) {
                $isFile = false;
            }
        }

        if (!$fileFound) {
            $outputter->printLine('File not exists');
            return false;
        }

        if ($name == $rename) {
            if ($isFile) {
                $outputter->printLine('File already exists');
            } else {
                $outputter->printLine('Directory already exists');
            }
            return false;
        } else {
            return true;
        }

        return false;
    }

    public function execute(IOutputter $outputter)
    {
        $name = $this->params[0];
        $rename = $this->params[1];

        $this->currentDir = $this->getDrive()->getCurrentDirectory();
        $this->content = $this->currentDir->getContent();

        foreach ($this->content as $item) {
            if ($item->getName() == $name) {
                $item->setName($rename);
            }
        }
    }

}
