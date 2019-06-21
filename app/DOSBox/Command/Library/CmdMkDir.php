<?php

namespace DOSBox\Command\Library;

use DOSBox\Command\BaseCmdMk;
use DOSBox\Command\BaseCommand as Command;
use DOSBox\Filesystem\Directory;
use DOSBox\Interfaces\IDrive;
use DOSBox\Interfaces\IOutputter;

class CmdMkDir extends BaseCmdMk
{
    const PARAMETER_CONTAINS_BACKLASH = "At least one parameter denotes a path rather than a directory name.";

    public function __construct($commandName, IDrive $drive)
    {
        parent::__construct($commandName, $drive);
    }

    public function checkNumberOfParameters($numberOfParametersEntered)
    {
        return $numberOfParametersEntered >= 1 ? true : false;
    }

    public function checkParameterValues(IOutputter $outputter)
    {
        if ($this->checkExistingFile($this->getParameterAt(0))) {
            $outputter->printLine('File with name ' . $this->getParameterAt(0) . ' is existing');
            return false;
        }
        for ($i = 0; $i < $this->getParameterCount(); $i++) {
            if ($this->parameterContainsBacklashes($this->getParameterAt($i), $outputter)) {
                return false;
            }

        }
        return true;
    }

    // TODO: Unit test
    public static function parameterContainsBacklashes($parameter, IOutputter $outputter)
    {
        // Do not allow "mkdir c:\temp\dir1" to keep the command simple
        if (strstr($parameter, "\\") !== false || strstr($parameter, "/") !== false) {
            $outputter->printLine(self::PARAMETER_CONTAINS_BACKLASH);
            return true;
        }

        return false;
    }

    public function execute(IOutputter $outputter)
    {
        for ($i = 0; $i < $this->getParameterCount(); $i++) {
            $this->createDirectory($this->params[$i], $this->getDrive());
        }
    }

    public function createDirectory($newDirectoryName, IDrive $drive)
    {
        $newDirectory = new Directory($newDirectoryName);
        $drive->getCurrentDirectory()->add($newDirectory);
    }
}
