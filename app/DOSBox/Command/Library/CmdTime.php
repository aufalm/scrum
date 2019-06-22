<?php

namespace DOSBox\Command\Library;

use DOSBox\Command\BaseCommand as Command;
use DOSBox\Interfaces\IDrive;
use DOSBox\Interfaces\IOutputter;

class CmdTime extends Command
{

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
        if ($this->getParameterCount() < 1) {
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

}
