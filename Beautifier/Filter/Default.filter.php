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
    protected $aSettings = array();
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
        PHP_Beautifier_Common::getLog()->log('Default Filter:unhandled[' . $aArgs[0] . ']', PEAR_LOG_DEBUG);
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
     * t_whitespace
     *
     * @param mixed $sTag The tag to be processed
     *
     * @access public
     * @return void
     */
    function t_whitespace($sTag)
    {
/*
        $before = strstr($sTag, " ", true);
        $after = strstr($sTag, " ");
        $sTag = $before.substr_replace($after,"",0,1);
*/
//Log::singleton('console')->info(__METHOD__."(".bin2hex($sTag)."):".$sTag);
        $this->oBeaut->add($sTag);
    }
}
