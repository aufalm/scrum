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
        } else {
            $parameters = $this->params[0];
            return (date('H:i:s', strtotime($parameters)) == $parameters);
        }
        return false;
    }

    public function execute(IOutputter $outputter)
    {
        if (count($this->params) < 1) {
            $outputter->printLine(date("H:i:s"));
        }
    }

}
