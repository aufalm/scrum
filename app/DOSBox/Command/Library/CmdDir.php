<?php

namespace DOSBox\Command\Library;

use DOSBox\Command\BaseCommand as Command;
use DOSBox\Interfaces\IDrive;
use DOSBox\Interfaces\IOutputter;

class CmdDir extends Command
{
    private $directoryToPrint;

    const SYSTEM_CANNOT_FIND_THE_PATH_SPECIFIED = "File Not Found.";

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
        if ($this->getParameterCount() == 0) {
            $this->directoryToPrint = $this->getDrive()->getCurrentDirectory(); // TODO: check with params
        } else {
            $this->directoryToPrint = $this->checkAndPreparePathParameter($this->getParameterAt(0), $outputter);
        }
        return $this->directoryToPrint != null;
    }

    private function checkAndPreparePathParameter($pathName, IOutputter $outputter)
    {
        $fsi = $this->getDrive()->getItemFromPath($pathName);

        if ($fsi == null) {
            $outputter->printLine(self::SYSTEM_CANNOT_FIND_THE_PATH_SPECIFIED);
            return null;
        }

        // if (!$fsi->isDirectory()) {
        //     return $fsi->getParent();
        // }

        return $fsi;
    }

    public function execute(IOutputter $outputter)
    {
        $this->checkParameterValues($outputter);

        $item = $this->directoryToPrint;

        if (count($this->params) == 1) {
            if ($item->isDirectory()) {
                $outputter->printNoLine("\t\t\t");
                $outputter->printNoLine($item->getCreatedAt());
                $outputter->printNoLine("\t");
                $outputter->printNoLine("<DIR>");
                $outputter->printNoLine("\t");
                $outputter->printNoLine("  ");
            } else {
                $outputter->printNoLine("\t\t\t\t");
                $outputter->printNoLine($item->getCreatedAt());
                $outputter->printNoLine("\t");
                $outputter->printNoLine($item->getSize() . " ");
            }

            $outputter->printNoLine($item->getName());
            $outputter->newLine();
        } else {

            $this->printHeader($this->directoryToPrint, $outputter);
            $this->printContent($this->directoryToPrint->getContent(), $outputter);
            $this->printFooter($this->directoryToPrint, $outputter);
        }
    }

    public function printHeader($directoryToPrint, IOutputter $outputter)
    {
        if ($directoryToPrint->isDirectory()) {
            $outputter->printLine(" Directory of " . $directoryToPrint->getPath() . " " . $directoryToPrint->getCreatedAt());
            $outputter->newLine();
        } else {
            $outputter->printNoLine("\t\t\t\t");
            $outputter->printNoLine($item->getCreatedAt());
            $outputter->printNoLine("\t");
            $outputter->printNoLine($item->getSize() . " ");
        }
    }

    public function printContent($directoryContent, IOutputter $outputter)
    {
        foreach ($directoryContent as $item) {
            if ($item->isDirectory()) {
                $outputter->printNoLine("\t\t\t");
                $outputter->printNoLine($item->getCreatedAt());
                $outputter->printNoLine("\t");
                $outputter->printNoLine("<DIR>");
                $outputter->printNoLine("\t");
                $outputter->printNoLine("  ");
            } else {
                $outputter->printNoLine("\t\t\t\t");
                $outputter->printNoLine($item->getCreatedAt());
                $outputter->printNoLine("\t");
                $outputter->printNoLine($item->getSize() . " ");
            }

            $outputter->printNoLine($item->getName());
            $outputter->newLine();
        }
    }

    public function printFooter($directoryToPrint, IOutputter $outputter)
    {
        $outputter->printLine("\t" . $directoryToPrint->getNumberOfContainedFiles() . " File(s)");
        $outputter->printLine("\t" . $directoryToPrint->getNumberOfContainedDirectories() . " Dir(s)");
    }
}
