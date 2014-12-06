<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Default Filter: Handle all the tokens. Uses K & R style
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.0 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_0.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   PHP
 * @package    PHP_Beautifier
 * @subpackage Filter
 * @author     Claudio Bustos <cdx@users.sourceforge.com>
 * @copyright  2004-2010 Claudio Bustos
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    CVS: $Id:$
 * @link       http://pear.php.net/package/PHP_Beautifier
 * @link       http://beautifyphp.sourceforge.net
 */
/**
 * Default Filter: Handle all the tokens. Uses K & R style
 *
 * This filters is loaded by default in {@link PHP_Beautifier}. Can handle all the tokens.
 * If one of the tokens doesn't have a function, is added without modification (See {@link __call()})
 * The most important modifications are:
 * - All the statements inside control structures, functions and class are indented with K&R style
 * <CODE>
 * function myFunction() {
 *     echo 'hi';
 * }
 * </CODE>
 * - All the comments in new lines are indented. In multi-line comments, all the lines are indented, too.
 * This class is final, so don't try to extend it!
 *
 * @category   PHP
 * @package    PHP_Beautifier
 * @subpackage Filter
 * @author     Claudio Bustos <cdx@users.sourceforge.com>
 * @copyright  2004-2010 Claudio Bustos
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: @package_version@
 * @link       http://pear.php.net/package/PHP_Beautifier
 * @link       http://beautifyphp.sourceforge.net
 */
final class PHP_Beautifier_Filter_Default extends PHP_Beautifier_Filter
{
    const FILTER_INDENT = "indent";
    const FILTER_LINEFEED = "linefeed";
    const FILTER_BRACENEWLINE = "newlinebc";

    // default settings
    protected $aSettings = array(
        self::FILTER_INDENT => "true",
        self::FILTER_LINEFEED    => "LF", // LF, CR, CRLF, PHPEOL, false
        self::FILTER_BRACENEWLINE => "false",
    );

    protected $sDescription = 'Default Filter for PHP_Beautifier';
    /**
     * Constructor
     * If you need to overload this (for example, to create a
     * definition for setting with {@link addSettingDefinition()}
     * remember call the parent constructor.
     * <code>
     * parent::__construct($oBeaut, $aSettings)
     * </code>
     *
     * @param PHP_Beautifier $oBeaut    PHP_Beautifier Object
     * @param array          $aSettings Settings for the PHP_Beautifier
     *
     * @access public
     * @return void
     */
    public function __construct(PHP_Beautifier $oBeaut, $aSettings = array())
    {
        parent::__construct($oBeaut, $aSettings);
        $this->_init();
    }
    private function _init()
    {
        $this->_initLineFeed();    // linefeed setting
    }
    /**
     * initialize of line feed setting
     */
    private function _initLineFeed()
    {
     // line feed setting
        if ($this->oBeaut->isBatch) {
            $linefeed = $this->getSetting(self::FILTER_LINEFEED);

            $replace = "\n";
            switch($linefeed){
                case "CRLF":
                    $replace = "\r\n";
                    break;
                case "CR":
                    $replace = "\r";
                    break;
                case "PHPEOL":
                    $replace = PHP_EOL;
                    break;
                case "LF":
                default:
                    break;
            }
            $this->oBeaut->setNewLine($replace);
        }
    }

    /**
     * __call
     *
     * @param mixed $sMethod Method name
     * @param mixed $aArgs   Method arguments
     *
     * @access protected
     * @return voidadd_header=apache
     */
    public function __call($sMethod, $aArgs)
    {
        if (!is_array($aArgs) or count($aArgs) != 1) {
            throw (new Exception('Call to Filter::__call with wrong argument'));
        }
//Log::singleton('console')->info(__METHOD__."(".bin2hex($aArgs[0])."):".print_r($aArgs,true));
        $this->add($aArgs[0]);
    }
    // Bypass the function!
    /**
     * off
     *
     * @access public
     * @return void
     */
    public function off()
    {
    }

    /**
     * Indent count
     */
    public function getIndent()
    {
        if ($this->_indentCount === 0) {
            return "";
        }
        $indentChar = $this->oBeaut->getIndentChar();
        $indentNumber = $this->oBeaut->getIndentNumber();
        $indent = str_repeat($indentChar, $indentNumber);
        $indent = str_repeat($indent, $this->_indentCount);
        return $indent;
    }
    protected $_indentCount = 0;
    protected function indentIncrease()
    {
        $this->_indentCount++;
    }
    protected function indentDecrease()
    {
        $this->_indentCount--;
        if ($this->_indentCount < 1) {
            $this->_indentCount = 0;
        }
    }

    /**
     * PHP_Beautify::add
     * @param string $sTag
     */
    public function add($sTag)
    {
        $this->oBeaut->add($this->filterLinefeed($sTag));
    }

    /**
     * indentation filter
     * @param type $sTag
     */
    public function filterIndentation($sTag)
    {
        $indentChar = $this->oBeaut->getIndentChar();
        $indentNumber = $this->oBeaut->getIndentNumber();
        if ($indentChar!=="\t") {
// space indent
            $regexChar = "\t";
            $regexNumber = "1";
        } else {
// tab indent
            $regexChar = " ";
            $regexNumber = "4";
        }
        $regex = <<<REGEX
![{$regexChar}]{{$regexNumber}}!i
REGEX;
        $replace = str_repeat($indentChar, $indentNumber);
        $replace = preg_replace($regex, $replace, $sTag);

        if ($this->getSetting(self::FILTER_INDENT)!=="false") {
            return $replace;
        } else {
            return $sTag;
        }
    }

    /**
     * linefeed filter
     * @param string $sTag
     */
    public function filterLinefeed($sTag)
    {
        if (($linefeed = $this->getSetting(self::FILTER_LINEFEED))!=="false") {
            $replace = $this->oBeaut->getNewLine();
            $sTag = strtr($sTag, array_fill_keys(array("\r\n", "\r", "\n"), $replace));
      //			$sTag = preg_replace($regex, $replace,$sTag);
        }
        return $sTag;
    }

    /**
     * new line before open brace
     * @param string $sTag
     */
    public function filterBraceNewLine($sTag)
    {
//        Log::singleton('console')->info(__METHOD__."(".bin2hex($sTag)."):".var_export($sTag,true));
//            Log::singleton('console')->info("getRawPrevToken".var_export($this->oBeaut->getRawPrevToken(),true));
//            Log::singleton('console')->info("getRawNextToken".var_export($this->oBeaut->getRawNextToken(),true));
        if ($this->getSetting(self::FILTER_BRACENEWLINE)!=="false") {
            $sTag = $this->oBeaut->getNewLine().$this->getIndent().$sTag;
//        Log::singleton('console')->info(__METHOD__."(".bin2hex($sTag)."):".var_export($sTag,true));
        }
        return $sTag;
    }
    /**
     * t_whitespace
     *
     * @param mixed $sTag The tag to be processed
     *
     * @access public
     * @return void
     */
    // // comment[LF]
    // [SPACE][SPACE][SPACE][SPACE]
    private $_IndentNextWhitespace = false;
    private $_lastIndentation = "";
    public function t_whitespace($sTag)
    {
        if ($this->haveLinefeed($sTag)) {
            $sTag = $this->filterIndentation($sTag);
        } elseif ($this->_IndentNextWhitespace) {
            $this->_IndentNextWhitespace = false;
            $sTag = $this->filterIndentation($sTag);
        } else {
              //            $sTag = $this->filterBraceNewLine($sTag);
        }
        $this->add($sTag);
    }
    /**
     * t_comment
     *
     * @param mixed $sTag The tag to be processed
     *
     * @access public
     * @return void
     */
    public function t_comment($sTag)
    {
        if ($this->haveLinefeed($sTag)) {
            $this->_IndentNextWhitespace = true;
               $this->add($sTag);
        } else {
            $this->add($this->filterIndentation($sTag));
        }
    }
    /**
     * t_doc_comment
     *
     * @param mixed $sTag The tag to be processed
     *
     * @access public
     * @return void
     */
    public function t_doc_comment($sTag)
    {
        $this->add($this->filterIndentation($sTag));
    }

    /**
     * t_open_tag
     *
     * @param mixed $sTag The tag to be processed
     *
     * @access public
     * @return void
     */
    public function t_open_tag($sTag)
    {
        $this->_IndentNextWhitespace = true;
        $this->add($sTag);
    }

    /**
     * t_open_brace t_close_brace
     *
     * @param mixed $sTag The tag to be processed
     *
     * @access public
     * @return void
     */
    public function t_open_brace($sTag)
    {
//		Log::singleton('console')->info(__METHOD__.var_export($sTag,true));
        $prevToken = $this->oBeaut->getRawPrevToken();
        if (! is_array($prevToken) || $prevToken[0] !== T_WHITESPACE) {
      //            Log::singleton('console')->info("prev not whitespace".var_export( $prevToken,true));
            switch($prevToken[0]){
                case T_OBJECT_OPERATOR:
                    break;

                default:
                    $sTag = $this->filterBraceNewLine($sTag);
                    break;
            }
        } // previous token is white space
        else {
            if (! $this->haveLinefeed($prevToken[1])) {
         //                Log::singleton('console')->info("prev whitespace not have line feed".var_export( $prevToken,true));
                $sTag = $this->filterBraceNewLine($sTag);
            }
        }

        $this->add($sTag);
        $this->indentIncrease();
    }
    public function t_close_brace($sTag)
    {
        $this->add($sTag);
        $this->indentDecrease();
    }
}
