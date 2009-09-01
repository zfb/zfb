<?php
/**
 * Zend Framework Brasil
 *
 * @category  Zfb
 * @package   UnitTests
 * @version   $Id$
 */

require_once 'Zfb/Validate/Cnpj.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Zfb_Validate_Cnpj test case.
 */
class Zfb_Validate_CnpjTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var Zfb_Validate_Cnpj
	 */
	private $Zfb_Validate_Cnpj;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp();
		$this->Zfb_Validate_Cnpj = new Zfb_Validate_Cnpj(/* parameters */);
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->Zfb_Validate_Cnpj = null;
		parent::tearDown();
	}

	/**
	 * Tests Zfb_Validate_Cnpj->isValid()
	 */
	public function testIsValid() {
		$valid = array('03.847.655/0001-98');

		foreach ($valid as $cnpj) {
			$this->assertTrue($this->Zfb_Validate_Cnpj->isValid($cnpj));
		}
	}

	public function testInvalid() {
		$invalid = array(
			'03.847.655/000198', //invalid format
			'03.847.655/0001-90'
		);

		foreach ($invalid as $cnpj) {
			$this->assertFalse($this->Zfb_Validate_Cnpj->isValid($cnpj));
		}
	}

	public function testValidIgnoreFormat() {
		$v = new Zfb_Validate_Cnpj ( true ); //ignore format
		$valid = array(
			'03.847.655/0001-98',
			'03847655000198'
		);

		foreach ($valid as $cnpj) {
			$this->assertTrue($v->isValid($cnpj));
		}
	}

	public function testInvalidIgnoreFormat() {
		$v = new Zfb_Validate_Cnpj ( true ); //ignore format
		$invalid = array(
			'03847655000190'
		);

		foreach ($invalid as $cnpj) {
			$this->assertFalse($v->isValid($cnpj));
		}
	}

}

