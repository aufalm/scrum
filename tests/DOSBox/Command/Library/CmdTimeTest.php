<?php

use DOSBox\Filesystem\Directory;
use DOSBox\Filesystem\File;
use DOSBox\Command\Library\CmdTime;
use DOSBox\Filesystem\Drive;

class CmdTimeTest extends DOSBoxTestCase {
    private $command;

    protected function setUp() {
    	parent::setUp();
    	$this->drive = new Drive("C");
    	$this->command = new CmdTime("time", $this->drive);

        $this->commandInvoker->addCommand($this->command);

    }

    public function testCmdTime(){
        // given
        $command = "time";
        $time = date("H:i:s");
        // when
        $this->executeCommand($command);
        // then
        
        $this->assertSame($time, $this->mockOutputter->getOutput());
    }

    public function testCmdTime_WithParameterTime_OutputNothing(){
        // given
        $command = "time ";
        $time = "21:30:10";
        // when
        $this->executeCommand($command.$time);
        // then
        
        $this->assertEmpty($this->mockOutputter->getOutput());
    }

    public function testCmdTime_WithParameterString_ReportError(){
        // given
        $command = "time ";
        $parameter = "gaga";
        $expectedOutput = "Wrong parameter entered.";
        // when
        $this->executeCommand($command.$parameter);
        // then
        
        $this->assertContains($expectedOutput, $this->mockOutputter->getOutput());
    }
}