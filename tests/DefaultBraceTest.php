<?php
/**
 * Created by IntelliJ IDEA.
 * User: dozo
 * Date: 2014/11/06
 * Time: 21:40
 */

class DefaultBraceTest extends PHPUnit_Framework_TestCase {
    public function setUp(){
        error_reporting (E_ALL & ~(E_DEPRECATED | E_STRICT));

        $this->oBeaut = new PHP_Beautifier();
        $this->oBeaut->setInputFile(__FILE__);

    }

    /**
     *  test add new line before open brace
     */
    public function testBraceTest(){
        $sTextOriginal = <<<SCRIPT
<?php
class class_1 extends class_0 {
    protected \$data                 = array();
    public function __construct(){

        if(true) {
            if(true){
                if(true)
                {
                }
            }
        }

        for(;;){
        }

        foreach(){
        }
    }
}
?>
SCRIPT;
        $sTextExpected = <<<SCRIPT
<?php
class class_1 extends class_0 
{
    protected \$data                 = array();
    public function __construct()
    {

        if(true) 
        {
            if(true)
            {
                if(true)
                {
                }
            }
        }

        for(;;)
        {
        }

        foreach()
        {
        }
    }
}
?>
SCRIPT;

        $this->oBeaut->setInputString($sTextOriginal);
        $this->oBeaut->setNewLine("\n");
        $this->oBeaut->addFilter("Default", ["newlinebc"=>true]);
        $this->oBeaut->process();
        $sTextActual = $this->oBeaut->get();

        $this->assertEquals($sTextExpected, $sTextActual);
    }
    /**
     *  test add new line before open brace
     */
    public function testDoubleParenthesis(){
            $sTextOriginal = <<<SCRIPT
<?php
error_reporting (E_ALL & ~(E_DEPRECATED | E_STRICT));
// Before all, test the tokenizer extension
if (!extension_loaded('tokenizer')) {
    throw new Exception("Compile php with tokenizer extension. Use --enable-tokenizer or don't use --disable-all on configure.");
}
?>
SCRIPT;
            $sTextExpected = <<<SCRIPT
<?php
error_reporting (E_ALL & ~(E_DEPRECATED | E_STRICT));
// Before all, test the tokenizer extension
if (!extension_loaded('tokenizer')) 
{
    throw new Exception("Compile php with tokenizer extension. Use --enable-tokenizer or don't use --disable-all on configure.");
}
?>
SCRIPT;

		$this->oBeaut->setInputString($sTextOriginal);
		$this->oBeaut->setNewLine("\n");
		$this->oBeaut->addFilter("Default", ["newlinebc"=>true]);
		$this->oBeaut->process();
		$sTextActual = $this->oBeaut->get();

		$this->assertEquals($sTextExpected, $sTextActual);
    }

    /**
     *  test add new line before open brace
     */
    public function testAfterObjectOperator(){
        $sTextOriginal = <<<SCRIPT
<?php
\$abc->{\$abc};
?>
SCRIPT;
        $sTextExpected = <<<SCRIPT
<?php
\$abc->{\$abc};
?>
SCRIPT;

        $this->oBeaut->setInputString($sTextOriginal);
        $this->oBeaut->setNewLine("\n");
        $this->oBeaut->addFilter("Default", ["newlinebc"=>true]);
        $this->oBeaut->process();
        $sTextActual = $this->oBeaut->get();

        $this->assertEquals($sTextExpected, $sTextActual);
    }


    /**
     *  test add new line before open brace
     */
    public function testAfterDoller(){
        $sTextOriginal = <<<SCRIPT
<?php
\$abc->\${abc};
?>
SCRIPT;
        $sTextExpected = <<<SCRIPT
<?php
\$abc->\${abc};
?>
SCRIPT;

        $this->oBeaut->setInputString($sTextOriginal);
        $this->oBeaut->setNewLine("\n");
        $this->oBeaut->addFilter("Default", ["newlinebc"=>true]);
        $this->oBeaut->process();
        $sTextActual = $this->oBeaut->get();

        $this->assertEquals($sTextExpected, $sTextActual);
    }

}
