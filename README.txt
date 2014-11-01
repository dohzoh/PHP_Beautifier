= What is cbf?

cbf(Code BeautiFier) is a Open Source PHP aplication for composer package (porting PEAR::PHP_Beautifer), distributed under the terms of PHP Licence 3.0. This program tries to reformat and beautify PHP 4 and PHP 5 code automatically.
Who needs it?

    * developers who get PHP code from other coders and are slightly confused
    * developers who can't read their own PHP code anymore
    * developers who want to share their PHP code
	* similar to CodeSniffer2.0(phpcbf) OR php-cs-fixer
	
== Features of cbf

    * Version independent: Needs PHP5 to work, but can handle PHP 4 and PHP 5 scripts. Should beautify PHP 3, too (if anyone test it, please send a report)
    * Plataform-independent: Should work on all the plataforms that supports PHP 5. Tested on Windows 98,2000,XP and Linux Gentoo 1.4.6
    * Automatic indentation of PHP source code according to given number of spaces
    * Automatic newlines, if required
    * You can use the web frontend, command line or, if you prefer, could use the class directly
    * Plug-in architecture, by the use of Filters. The control of beautify proccess is delegated on the Filters.
    * The code to beautify can make callbacks to the base class and the filters. So, you can set the options for the beautify inside the same file. See Callbacks
    * Batch processing. You can beautify multiple files inside directories (recursively, if you want to) and save they in another directory.
    * Parse only Php Code. All other tokens (HTML,Comments) are bypassed to the output
    * HEREDOC parsed without any indentation
    * Use of braces for indexing a string (ex. $this->myString{1}) doesn't produce strange indentation
    * Switch statements are indented as 
	* Tab Indent Support
	* Not support Coding Standard(like PSRx)

== RoadMap
	* Remove PEAR Library
	* Remove a lot of "requires"
	* Register Packagist
