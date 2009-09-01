<?php
/**
 * Zend Framework Brasil
 *
 * @category  Zfb
 * @package   UnitTests
 * @version   $Id$
 */

require_once 'PHPUnit/Framework/TestSuite.php';

require_once 'UrlTest.php';

class Zfb_Filter_AllTests
{

    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Zend Framework Brasil - Zfb_Filter');

        $suite->addTestSuite('Zfb_Filter_UrlTest');

        return $suite;
    }
}
