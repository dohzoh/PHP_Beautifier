<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DefaultLinefeedTest
 *
 * @author yozo-matsui
 */
class DefaultLinefeedTest extends PHPUnit_Framework_TestCase
{
    public function setUp(){
        error_reporting (E_ALL & ~(E_DEPRECATED | E_STRICT));

        $this->oBeaut = new PHP_Beautifier();
        $this->oBeaut->setInputFile(__FILE__);
		
    }
	
	/**
	 * to CR
	 */
	public function testLinefeedCR(){
		$sTextOriginal = "abc\rdef\nghi\r\njkl";
		$sTextExpected = "abc\rdef\rghi\rjkl";
		
		$this->oBeaut->setInputString($sTextOriginal);
		$this->oBeaut->setNewLine("\r");
		$this->oBeaut->process();
		$sTextActual = $this->oBeaut->get();
		
//        $this->assertEquals(bin2hex($sTextExpected), bin2hex($sTextActual));
        $this->assertEquals($sTextExpected, $sTextActual);
	}
	
	/**
	 * to LF
	 */
	public function testLinefeedLF(){
		$sTextOriginal = "abc\rdef\nghi\r\njkl";
		$sTextExpected = "abc\ndef\nghi\njkl";
		
		$this->oBeaut->setInputString($sTextOriginal);
		$this->oBeaut->setNewLine("\n");
		$this->oBeaut->process();
		$sTextActual = $this->oBeaut->get();
		
        $this->assertEquals($sTextExpected, $sTextActual);
	}
	
	/**
	 * to CRLF
	 */
	public function testLinefeedCRLF(){
		$sTextOriginal = "abc\rdef\nghi\r\njkl";
		$sTextExpected = "abc\r\ndef\r\nghi\r\njkl";
		
		$this->oBeaut->setInputString($sTextOriginal);
		$this->oBeaut->setNewLine("\r\n");
		$this->oBeaut->process();
		$sTextActual = $this->oBeaut->get();
		
        $this->assertEquals($sTextExpected, $sTextActual);
	}
	//put your code here
}
