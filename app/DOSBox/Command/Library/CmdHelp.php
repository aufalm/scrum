<?php

namespace DOSBox\Command\Library;

use DOSBox\Command\BaseCommand as Command;
use DOSBox\Interfaces\IDrive;
use DOSBox\Interfaces\IOutputter;

class CmdHelp extends Command
{

    protected $helps = [
        'CD' => 'Displays the name of or changes the current directory',
        'DIR' => 'Displays a list of files and subdirectories in a directory',
        'EXIT' => 'Quit the CMD.EXE programs (command interpreter) ',
        'FORMAT' => 'Formats a disk for use with windows',
        'HELP' => 'Provides Help information for Windows commands',
        'LABEL' => 'Creates, changes, or deletes the volume label of a disk',
        'MKDIR' => 'Creates a directory',
        'MKFILE' => 'Created a file',
        'MOVE' => 'Moves one or more files from one directory to another directory',
    ];

    public function __construct($commandName, IDrive $drive)
    {
        parent::__construct($commandName, $drive);
    }

    public function checkNumberOfParameters($numberOfParametersEntered)
    {
        return ($numberOfParametersEntered == 0 || $numberOfParametersEntered == 1);
    }

    public function checkParameterValues(IOutputter $outputter)
    {
        if ($this->getParameterCount() < 2) {
            return true;
        }
        return false;
    }

    public function execute(IOutputter $outputter)
    {
        if (count($this->params) < 1) {
            $this->printAllHelp($outputter);
        } else {
            $parameter = strtoupper($this->params[0]);
            $this->printHelp($outputter, $parameter);
        }
    }

    public function printAllHelp(IOutputter $outputter)
    {
        foreach ($this->helps as $key => $value) {
            $outputter->printLine($key . "\t" . $value);
        }
    }

    public function printHelp(IOutputter $outputter, $parameter)
    {
        foreach ($this->helps as $key => $value) {
            if ($key == $parameter) {
                $outputter->printLine($key . "\t" . $value);
            }
        }
    }

}
