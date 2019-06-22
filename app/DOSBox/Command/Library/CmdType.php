<?php

namespace DOSBox\Command\Library;

use DOSBox\Command\BaseCommand as Command;
use DOSBox\Interfaces\IDrive;
use DOSBox\Interfaces\IOutputter;

class CmdType extends Command
{

    public function __construct($commandName, IDrive $drive)
    {
        parent::__construct($commandName, $drive);
    }

    public function checkNumberOfParameters($numberOfParametersEntered)
    {
        return ($numberOfParametersEntered == 1);
    }

    public function checkParameterValues(IOutputter $outputter)
    {
        $name = $this->params[0];
        $currentDir = $this->getDrive()->getCurrentDirectory();
        $content = $currentDir->getContent();

        foreach ($content as $item) {
            if ($item->getName() == $name) {
                return true;
            }
        }

        $outputter->printLine('The system cannot find the file specified');
        return false;
    }

    public function execute(IOutputter $outputter)
    {
        $name = $this->params[0];
        $currentDir = $this->getDrive()->getCurrentDirectory();
        $content = $currentDir->getContent();

        foreach ($content as $item) {
            if ($item->getName() == $name) {
                if ($item->isDirectory()) {
                    $outputter->printLine("Access is denied");
                } else {
                    $outputter->printNoLine("\t\t\t\t");
                    $outputter->printNoLine($item->getCreatedAt());
                    $outputter->printNoLine("\t");
                    $outputter->printNoLine($item->getSize() . " ");

                    $outputter->printNoLine($item->getName());
                    $outputter->newLine();
                }
            }
        }
    }

}
