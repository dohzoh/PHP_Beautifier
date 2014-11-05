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
	//put your code here
}
