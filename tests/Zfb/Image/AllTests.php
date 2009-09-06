<?php
/**
 * Zend Framework Brasil
 *
 * @category  Zfb
 * @package   UnitTests
 * @version   $Id$
 */

require_once 'PHPUnit/Framework/TestSuite.php';

require_once 'ResizeTest.php';

class Zfb_Image_AllTests
{

    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Zend Framework Brasil - Zfb_Image');

        $suite->addTestSuite('Zfb_Image_ResizeTest');

        return $suite;
    }
}
