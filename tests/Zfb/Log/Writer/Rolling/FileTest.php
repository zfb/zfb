<?php
/**
 * Zend Framework Brasil
 *
 * @category  Zfb
 * @package   UnitTests
 * @version   $Id$
 */

require_once 'Zfb/Log/Writer/Rolling/File.php';

require_once 'Zend/Log.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Zfb_Log_Writer_Rolling_File test case.
 */
class Zfb_Log_Writer_Rolling_FileTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var Zend_Log
	 */
	private $zendLog;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp();
		$this->zendLog = new Zend_Log();
		$dir = dirname(__FILE__).'/resources';

		@unlink($dir.'/application.log');
		@unlink($dir.'/application.log.1');
		@unlink($dir.'/application.log.2');
		@unlink($dir.'/application.log.3');
		@unlink($dir.'/application.log.4');
		@unlink($dir.'/application.log.5');
		@unlink($dir.'/application.log.6');
		@unlink($dir.'/application.log.7');
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->zendLog;
		parent::tearDown();
		$dir = dirname(__FILE__).'/resources';

		@unlink($dir.'/application.log');
		@unlink($dir.'/application.log.1');
		@unlink($dir.'/application.log.2');
		@unlink($dir.'/application.log.3');
		@unlink($dir.'/application.log.4');
		@unlink($dir.'/application.log.5');
		@unlink($dir.'/application.log.6');
		@unlink($dir.'/application.log.7');
	}

	public function testLogRolling() {
		$writer = new Zfb_Log_Writer_Rolling_File(dirname(__FILE__).'/resources/application.log');
		$writer->setFileMaxSize("10KB");
		$writer->setMaxFiles(10);

		$this->zendLog->addWriter($writer);

		for ($i=0; $i<1000; $i++) {
			$this->zendLog->debug('test debug using rolling file : ' . $i);
		}

		$dir = dirname(__FILE__).'/resources';

		$this->assertFileExists($dir.'/application.log');
		$this->assertFileExists($dir.'/application.log.1');
		$this->assertFileExists($dir.'/application.log.2');
		$this->assertFileExists($dir.'/application.log.3');
		$this->assertFileExists($dir.'/application.log.4');
		$this->assertFileExists($dir.'/application.log.5');
		$this->assertFileExists($dir.'/application.log.6');
		$this->assertFileExists($dir.'/application.log.7');
	}

	public function testLogSimple() {
		$writer = new Zfb_Log_Writer_Rolling_File(dirname(__FILE__).'/resources/application.log');
		$writer->setFileMaxSize("10KB");
		$writer->setMaxFiles(10);

		$this->zendLog->addWriter($writer);

		for ($i=0; $i<5; $i++) {
			$this->zendLog->debug('testLogSimple - test debug using rolling file : ' . $i);
		}

		$dir = dirname(__FILE__).'/resources';
		$content = file_get_contents($dir.'/application.log');
		$this->assertFileExists($dir.'/application.log');

		$this->assertRegExp('~testLogSimple - test debug using rolling file : 0~', $content);
		$this->assertRegExp('~testLogSimple - test debug using rolling file : 1~', $content);
		$this->assertRegExp('~testLogSimple - test debug using rolling file : 2~', $content);
		$this->assertRegExp('~testLogSimple - test debug using rolling file : 3~', $content);
		$this->assertRegExp('~testLogSimple - test debug using rolling file : 4~', $content);
	}
}