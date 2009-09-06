<?php
/**
 * Zend Framework Brasil
 *
 * @category  Zfb
 * @package   UnitTests
 * @version   $Id$
 */

require_once 'PHPUnit/Framework/TestSuite.php';

require_once 'Rolling/AllTests.php';

class Zfb_Log_Writer_AllTests
{

    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Zend Framework Brasil - Zfb_Log_Writer');

        $suite->addTest(Zfb_Log_Writer_Rolling_AllTests::suite());

        return $suite;
    }
}
