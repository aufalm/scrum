<?php

namespace DOSBox\Command\Library;

use DOSBox\Command\BaseCmdMk;
use DOSBox\Command\BaseCommand as Command;
use DOSBox\Filesystem\File;
use DOSBox\Interfaces\IDrive;
use DOSBox\Interfaces\IOutputter;

class CmdMkFile extends BaseCmdMk
{
    public function __construct($commandName, IDrive $drive)
    {
        parent::__construct($commandName, $drive);
    }

    public function checkNumberOfParameters($numberOfParametersEntered)
    {
        return true;
    }

    public function checkParameterValues(IOutputter $outputter)
    {
        if (!isset($this->params[0]) && empty($this->params[0])) {
            $outputter->printLine('File name not defined');
            return false;
        }
        if ($this->checkExistingFileDir($this->getParameterAt(0))) {
            $outputter->printLine('File or Directory with name ' . $this->getParameterAt(0) . ' is existing');
            return false;
        }
        return true;
    }

    public function execute(IOutputter $outputter)
    {
        $fileName = $this->params[0];
        $fileContent = null;
        if (isset($this->params[1]) && !empty($this->params[1])) {
            $fileContent = $this->params[1];
        }
        $newFile = new File($fileName, $fileContent);
        $this->getDrive()->getCurrentDirectory()->add($newFile);
    }

}
