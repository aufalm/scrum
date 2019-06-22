<?php

namespace DOSBox\Command\Library;

use DOSBox\Command\BaseCommand as Command;
use DOSBox\Interfaces\IDrive;
use DOSBox\Interfaces\IOutputter;

class CmdLabel extends Command
{

    public function __construct($commandName, IDrive $drive)
    {
        parent::__construct($commandName, $drive);
    }

    public function checkNumberOfParameters($numberOfParametersEntered)
    {
        return ($numberOfParametersEntered == 0 || $numberOfParametersEntered == 2);
    }

    public function checkParameterValues(IOutputter $outputter)
    {
        if ($this->getParameterCount() < 3) {
            return true;
        }
        return false;
    }

    public function execute(IOutputter $outputter)
    {
        if (count($this->params) == 0) {
            $line = "";
            while(strcmp(trim($line), "exit") != 0){
                $outputter->printLine("Then this message will be prompted:");
                $outputter->printLine("Volume label (32 character, ENTER for none)?");
    
                try{
                    $char = trim(fread(STDIN, 256));
                    //$char = trim(fgets(STDIN));
                    $line = $char;
                    if ($line !== null) {
                        $this->getDrive()->setLabel($line);
                        $outputter->printLine("The volume name oc C: is set to " . $this->getDrive()->getLabel());
                    }
                } catch (Exception $e){
                    // do nothing by intention
                }
                break;
            }
            

        } else if (count($this->params) == 2) {
            $this->getDrive()->setLabel($this->params[1]);
        }
    }
}
?>