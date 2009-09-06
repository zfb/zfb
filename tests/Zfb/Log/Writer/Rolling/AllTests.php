<?php
/**
 * Zend Framework Brasil
 *
 * @category  Zfb
 * @package   UnitTests
 * @version   $Id$
 */

require_once 'PHPUnit/Framework/TestSuite.php';

require_once 'FileTest.php';

class Zfb_Log_Writer_Rolling_AllTests
{
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Zend Framework Brasil - Zfb_Log_Writer_Rolling');

        $suite->addTestSuite('Zfb_Log_Writer_Rolling_FileTest');

        return $suite;
    }
}