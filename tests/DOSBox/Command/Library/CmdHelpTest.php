<?php

use DOSBox\Filesystem\Directory;
use DOSBox\Filesystem\File;
use DOSBox\Command\Library\CmdHelp;
use DOSBox\Filesystem\Drive;

class CmdHelpTest extends DOSBoxTestCase {
    private $command;
    private $listOfCommands;

    protected function setUp() {
    	parent::setUp();
    	$this->drive = new Drive("C");
    	$this->command = new CmdHelp("help", $this->drive);

        $this->commandInvoker->addCommand($this->command);

    }

    public function testCmdHelp(){
        // given
        $command = "help";
        $listOfCommands = "Displays the name of or changes the current directoryDIR";
        // when
        $this->executeCommand($command);
        // then
        // 1. Help output list of command
        $this->assertContains($listOfCommands, $this->mockOutputter->getOutput());
    }

}