<?php

use DOSBox\Filesystem\Directory;
use DOSBox\Filesystem\File;
use DOSBox\Command\Library\CmdRen;
use DOSBox\Filesystem\Drive;

class CmdRenTest extends DOSBoxTestCase {
    private $command;
    private $listOfCommands;

    protected function setUp() {
    	parent::setUp();
    	$this->drive = new Drive("C");
    	$this->command = new CmdHelp("ren", $this->drive);

        $this->commandInvoker->addCommand($this->command);

    }
}