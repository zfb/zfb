<?php
/**
 * Zend Framework Brasil
 *
 * @category  Zfb
 * @package   UnitTests
 * @version   $Id$
 */

require_once 'Zfb/Image/Resize.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Zfb_Image_Resize test case.
 */
class Zfb_Image_ResizeTest extends PHPUnit_Framework_TestCase {

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp();
		@unlink(dirname(__FILE__).'/resources/logofinal_resized.jpg');
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		parent::tearDown();
		@unlink(dirname(__FILE__).'/resources/logofinal_resized.jpg');
	}

	/**
	 * Tests Zfb_Image_Resize->saveImage()
	 */
	public function testSaveImageLimitHeight() {
		$resize = new Zfb_Image_Resize(dirname(__FILE__).'/resources/logofinal.jpg');
		$resize->setMaxWidth(200);
		$resize->setMaxHeight(200);
		$resize->saveImage(dirname(__FILE__).'/resources/logofinal_resized.jpg');

		$this->assertFileExists(dirname(__FILE__).'/resources/logofinal_resized.jpg');

		$data = getimagesize(dirname(__FILE__).'/resources/logofinal_resized.jpg');
		$this->assertEquals(168, $data[0]);
		$this->assertEquals(200, $data[1]);
	}

	/**
	 * Tests Zfb_Image_Resize->saveImage()
	 */
	public function testSaveImageLimitWidth() {
		$resize = new Zfb_Image_Resize(dirname(__FILE__).'/resources/logofinal.jpg');
		$resize->setMaxWidth(200);
		$resize->setMaxHeight(400);
		$resize->saveImage(dirname(__FILE__).'/resources/logofinal_resized.jpg');

		$this->assertFileExists(dirname(__FILE__).'/resources/logofinal_resized.jpg');

		$data = getimagesize(dirname(__FILE__).'/resources/logofinal_resized.jpg');
		$this->assertEquals(200, $data[0]);
		$this->assertEquals(237, $data[1]);
	}

	/**
	 * Tests Zfb_Image_Resize->saveImage()
	 */
	public function testSaveImageNotResize() {
		$resize = new Zfb_Image_Resize(dirname(__FILE__).'/resources/logofinal.jpg');
		$resize->setMaxWidth(1000);
		$resize->setMaxHeight(1000);
		$resize->saveImage(dirname(__FILE__).'/resources/logofinal_resized.jpg');

		$this->assertFileExists(dirname(__FILE__).'/resources/logofinal_resized.jpg');

		$data = getimagesize(dirname(__FILE__).'/resources/logofinal_resized.jpg');
		$this->assertEquals(800, $data[0]);
		$this->assertEquals(948, $data[1]);
	}
}

