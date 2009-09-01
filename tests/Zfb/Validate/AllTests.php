<?php
/**
 * Zend Framework Brasil
 *
 * @category  Zfb
 * @package   UnitTests
 * @version   $Id$
 */

require_once 'PHPUnit/Framework/TestSuite.php';

require_once 'CnpjTest.php';
require_once 'CpfTest.php';

class Zfb_Validate_AllTests
{

    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Zend Framework Brasil - Zfb_Validate');

        $suite->addTestSuite('Zfb_Validate_CnpjTest');
        $suite->addTestSuite('Zfb_Validate_CpfTest');

        return $suite;
    }
}
