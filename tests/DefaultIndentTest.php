<?php
/**
 * Created by IntelliJ IDEA.
 * User: dozo
 * Date: 2014/11/04
 * Time: 0:24
 */

class DefaultIndentTest extends PHPUnit_Framework_TestCase {
    public function setUp(){
        error_reporting (E_ALL & ~(E_DEPRECATED | E_STRICT));

        $this->oBeaut = new PHP_Beautifier();
        $this->oBeaut->setInputFile(__FILE__);
		
    }
	
	public function replaceTab($sTextOriginal){
		$this->oBeaut->setInputString($sTextOriginal);
		$this->oBeaut->setIndentNumber(1);
		$this->oBeaut->setIndentChar("\t");
		$this->oBeaut->process();
		return $sTextActual = $this->oBeaut->get();
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
        $this->assertEquals(bin2hex($sTextExpected), bin2hex($sTextActual));
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
        $this->assertEquals($sTextExpected, $this->replaceTab($sTextOriginal));
    }

	/**
	 * opendoc pattern
	 */
	public function testOpenTag(){
        $sTextOriginal = <<<SCRIPT
<?php
    // abc
?>
SCRIPT;
        $sTextExpected = <<<SCRIPT
<?php
	// abc
?>
SCRIPT;
        $this->assertEquals($sTextExpected, $this->replaceTab($sTextOriginal));
	}
			
	/**
	 * docComment pattern
	 */
	public function testDocComment(){
        $sTextOriginal = <<<SCRIPT
<?php
    class class_1 extends class_0 {
        /* parameters */
        protected \$data                 = array();

        /**
         * large comment
         * @author Yohzoh Matsui <dzworks@outlook.jp>
         */
        public function __construct(){
        }
    }
?>
SCRIPT;
        $sTextExpected = <<<SCRIPT
<?php
	class class_1 extends class_0 {
		/* parameters */
		protected \$data                 = array();

		/**
		 * large comment
		 * @author Yohzoh Matsui <dzworks@outlook.jp>
		 */
		public function __construct(){
		}
	}
?>
SCRIPT;
        $this->assertEquals($sTextExpected, $this->replaceTab($sTextOriginal));
	}
	
	
    /**
     * Indent from space to tab
     */
    public function testNotIndentedPattern(){
        $sTextOriginal = <<<SCRIPT
<?php
    class class_1 extends class_0 {
        protected \$data                 = array();
        protected \$host_data            = array();
        protected \$main_data            = array();
        protected \$bonus_data           = array();		
    }
?>
SCRIPT;
		
        $sTextExpected = <<<SCRIPT
<?php
	class class_1 extends class_0 {
		protected \$data                 = array();
		protected \$host_data            = array();
		protected \$main_data            = array();
		protected \$bonus_data           = array();		
	}
?>
SCRIPT;
        $this->assertEquals($sTextExpected, $this->replaceTab($sTextOriginal));
	}
	
}
