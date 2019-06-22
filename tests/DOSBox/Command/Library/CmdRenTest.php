<?php

use DOSBox\Filesystem\Directory;
use DOSBox\Filesystem\File;
use DOSBox\Command\Library\CmdRen;
use DOSBox\Command\Library\CmdMkFile;
use DOSBox\Command\Library\CmdDir;
use DOSBox\Command\Library\CmdMkDir;
use DOSBox\Filesystem\Drive;

class CmdRenTest extends DOSBoxTestCase {
    private $command;
    private $listOfCommands;

    protected function setUp() {
    	parent::setUp();
    	$this->drive = new Drive("C");
    	$this->command = new CmdRen("ren", $this->drive);

        $this->commandInvoker->addCommand($this->command);
        $this->command = new CmdMkFile("mkfile", $this->drive);

        $this->commandInvoker->addCommand($this->command);
        $this->command = new CmdDir("dir", $this->drive);

        $this->commandInvoker->addCommand($this->command);
        $this->command = new CmdMkDir("mkdir", $this->drive);

        $this->commandInvoker->addCommand($this->command);

    }

    public function testCmdRen_RenameSingleFile(){
        // given
        $commandRen = "ren ";
        $commandMkFile = "mkfile ";
        $commandDir = "dir ";
        $file1 = "file1 ";
        $file2 = "file2";
        // when
        $this->executeCommand($commandMkFile.$file1);
        $this->executeCommand($commandRen.$file1.$file2);
        $this->executeCommand($commandDir);
        // then
        
        $this->assertContains($file2, $this->mockOutputter->getOutput());
    }

    public function testCmdRen_RenameSameFile_ReportError(){
        // given
        $commandRen = "ren ";
        $commandMkFile = "mkfile ";
        $commandDir = "dir ";
        $file1 = "file1 ";
        // when
        $this->executeCommand($commandMkFile.$file1);
        $this->executeCommand($commandRen.$file1.$file1);
        $this->executeCommand($commandDir);
        // then
        
        $this->assertContains("already exists", $this->mockOutputter->getOutput());
    }

    public function testCmdRen_RenameSingleDir(){
        // given
        $commandRen = "ren ";
        $commandMkDir = "mkdir ";
        $commandDir = "dir ";
        $dir1 = "dir1 ";
        $dir2 = "dir2";
        // when
        $this->executeCommand($commandMkDir.$dir1);
        $this->executeCommand($commandRen.$dir1.$dir2);
        $this->executeCommand($commandDir);
        // then
        
        $this->assertContains($dir2, $this->mockOutputter->getOutput());
    }

    public function testCmdRen_RenameSameDir_ReportError(){
        // given
        $commandRen = "ren ";
        $commandMkDir = "mkdir ";
        $commandDir = "dir ";
        $dir1 = "dir1 ";
        // when
        $this->executeCommand($commandMkDir.$dir1);
        $this->executeCommand($commandRen.$dir1.$dir1);
        $this->executeCommand($commandDir);
        // then
        
        $this->assertContains("already exists", $this->mockOutputter->getOutput());
    }
}