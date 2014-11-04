<?php
/**
 * Created by IntelliJ IDEA.
 * User: dozo
 * Date: 2014/11/04
 * Time: 0:24
 */

class DefaultTest extends PHPUnit_Framework_TestCase {
    public function setUp(){
        error_reporting (E_ALL & ~(E_DEPRECATED | E_STRICT));

        $this->oBeaut = new PHP_Beautifier();
        $this->oBeaut->setInputFile(__FILE__);
    }

    /**
     * indent from tab to space
     */
    public function testToSpaceIndent(){
        $sTextOriginal = <<<SCRIPT
<?php
class indent{
	/**
	 * large comment
	 * @author Yohzoh Matsui <dzworks@outlook.jp>
	 */
	public function __construct(){
		abc
	}
}
?>
SCRIPT;
        $sTextExpected = <<<SCRIPT
<?php
class indent{
    /**
     * large comment
     * @author Yohzoh Matsui <dzworks@outlook.jp>
     */
    public function __construct(){
        abc
    }
}
?>
SCRIPT;
        $this->oBeaut->setInputString($sTextOriginal);
        $this->oBeaut->process();
        $sTextActual = $this->oBeaut->get();
        $this->assertEquals($sTextExpected, $sTextActual);

    }

    /**
     * Indent from space to tab
     */
    public function testToTabIndent(){
        $sTextOriginal = <<<SCRIPT
<?php
class indent{
    /**
     * large comment
     * @author Yohzoh Matsui <dzworks@outlook.jp>
     */
    public function __construct(){
        abc
    }
}
?>
SCRIPT;
        $sTextExpected = <<<SCRIPT
<?php
class indent{
	/**
	 * large comment
	 * @author Yohzoh Matsui <dzworks@outlook.jp>
	 */
	public function __construct(){
		abc
	}
}
?>
SCRIPT;
        $this->oBeaut->setInputString($sTextOriginal);
        $this->oBeaut->setIndentNumber(1);
        $this->oBeaut->setIndentChar("\t");
        $this->oBeaut->process();
        $sTextActual = $this->oBeaut->get();
        $this->assertEquals($sTextExpected, $sTextActual);
    }
}
