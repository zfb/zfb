<?php
/**
 * Zend Framework Brasil
 *
 * @category  Zfb
 * @package   UnitTests
 * @version   $Id$
 */

require_once 'Zfb/Validate/Cpf.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Zfb_Validate_Cpf test case.
 */
class Zfb_Validate_CpfTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var Zfb_Validate_Cpf
	 */
	private $Zfb_Validate_Cpf;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp();
		$this->Zfb_Validate_Cpf = new Zfb_Validate_Cpf(/* parameters */);
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->Zfb_Validate_Cpf = null;
		parent::tearDown();
	}

	/**
	 * Tests Zfb_Validate_Cpf->isValid()
	 */
	public function testIsValid() {
		$valid = array(
			'123.456.789-09'
		);

		foreach ($valid as $cpf) {
			$this->assertTrue($this->Zfb_Validate_Cpf->isValid($cpf));
		}
	}

	/**
	 * Tests Zfb_Validate_Cpf->isValid()
	 */
	public function testIsInvalid() {
		$invalid = array(
			'123.456.78909',
			'123.456.789-08'
		);

		foreach ($invalid as $cpf) {
			$this->assertFalse($this->Zfb_Validate_Cpf->isValid($cpf));
		}
	}

	/**
	 * Tests Zfb_Validate_Cpf->isValid()
	 */
	public function testIsValidIgnoreFormat() {
		$v = new Zfb_Validate_Cpf(true);

		$valid = array(
			'123.456.789-09',
			'12345678909'
		);

		foreach ($valid as $cpf) {
			$this->assertTrue($v->isValid($cpf));
		}
	}

	/**
	 * Tests Zfb_Validate_Cpf->isValid()
	 */
	public function testIsInvalidIgnoreFormat() {
		$v = new Zfb_Validate_Cpf(true);

		$valid = array(
			'12345678900'
		);

		foreach ($valid as $cpf) {
			$this->assertFalse($v->isValid($cpf));
		}
	}

}

