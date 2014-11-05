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
	const FILTER_INDENTATION = "indentation";
    protected $aSettings = array(self::FILTER_INDENTATION => "true");
    protected $sDescription = 'Default Filter for PHP_Beautifier';
    /**
     * __call 
     * 
     * @param mixed $sMethod Method name
     * @param mixed $aArgs   Method arguments
     *
     * @access protected
     * @return voidadd_header=apache
     */
    function __call($sMethod, $aArgs) 
    {
        if (!is_array($aArgs) or count($aArgs) != 1) {
            throw (new Exception('Call to Filter::__call with wrong argument'));
        }
//Log::singleton('console')->info(__METHOD__."(".bin2hex($aArgs[0])."):".print_r($aArgs,true));
        $this->oBeaut->add($aArgs[0]);
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
     * replace white space
     */
    private function _whitespace_replace($sTag)
    {
        $indentChar = $this->oBeaut->getIndentChar();
        $indentNumber = $this->oBeaut->getIndentNumber();
        if($indentChar!=="\t"){  // space indent
            $regexChar = "\t";
            $regexNumber = "1";
        }
        else{   // tab indent
            $regexChar = " ";
            $regexNumber = "4";
        }

        $regex = <<<REGEX
![{$regexChar}]{{$regexNumber}}!i
REGEX;
        $replace = str_repeat($indentChar, $indentNumber);
        $sTag = preg_replace($regex, $replace, $sTag);

        return $sTag;
    }

	public function filterIndentation($sTag)
	{
		if($this->getSetting(self::FILTER_INDENTATION)==="true")
	        $this->oBeaut->add( $this->_whitespace_replace($sTag));
		else
	        $this->oBeaut->add($sTag);
	}
	
    /**
     * t_whitespace
     *
     * @param mixed $sTag The tag to be processed
     *
     * @access public
     * @return void
     */
	private $_IndentNextWhitespace = false;
    function t_whitespace($sTag)
    {
/*
        $before = strstr($sTag, " ", true);
        $after = strstr($sTag, " ");
        $sTag = $before.substr_replace($after,"",0,1);
*/
//Log::singleton('console')->info(__METHOD__."(".bin2hex($sTag)."):".$sTag);
		if( $this->haveLinefeed($sTag) )
			$this->filterIndentation($sTag);
		elseif( $this->_IndentNextWhitespace ){
			$this->_IndentNextWhitespace = false;
			$this->filterIndentation($sTag);
		}
		else
	        $this->oBeaut->add($sTag);
    }
    /**
     * t_comment
     *
     * @param mixed $sTag The tag to be processed
     *
     * @access public
     * @return void
     */
    function t_comment($sTag)
    {
		if( $this->haveLinefeed($sTag) ){
			$this->_IndentNextWhitespace = true;
	        $this->oBeaut->add($sTag);
		}
		else
			$this->filterIndentation($sTag);
    }
    /**
     * t_doc_comment 
     *
     * @param mixed $sTag The tag to be processed
     *
     * @access public
     * @return void
     */
    function t_doc_comment($sTag) 
    {
		$this->filterIndentation($sTag);
	}

    /**
     * t_open_tag 
     * 
     * @param mixed $sTag The tag to be processed
     *
     * @access public
     * @return void
     */
	function t_open_tag($sTag){
		$this->_IndentNextWhitespace = true;
		$this->oBeaut->add($sTag);
	}
}
