<?php
/**
 * Zend Framework Brasil
 *
 * @category  Zfb
 * @package   UnitTests
 * @version   $Id$
 */

require_once 'PHPUnit/Framework/TestSuite.php';

require_once 'Validate/AllTests.php';
require_once 'Filter/AllTests.php';

class Zfb_AllTests
{
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Zend Framework Brasil - Zfb');

        $suite->addTest(Zfb_Filter_AllTests::suite());
        $suite->addTest(Zfb_Validate_AllTests::suite());

        return $suite;
    }
}