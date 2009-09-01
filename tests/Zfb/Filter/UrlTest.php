<?php
/**
 * Zend Framework Brasil
 *
 * @category  Zfb
 * @package   UnitTests
 * @version   $Id$
 */

require_once 'Zfb/Filter/Url.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Zfb_Filter_Url test case.
 */
class Zfb_Filter_UrlTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var Zfb_Filter_Url
	 */
	private $Zfb_Filter_Url;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp();
		$this->Zfb_Filter_Url = new Zfb_Filter_Url(/* parameters */);
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->Zfb_Filter_Url = null;
		parent::tearDown();
	}

	public function testFilter() {
		$filters = array(
			'test-a-filter-url' => 'Test a filter url',
			'minhas-ferias-no-calcadao' => 'Minhas férias no calçadão!'
		);

		foreach ($filters as $result => $input) {
			$this->assertEquals($result, $this->Zfb_Filter_Url->filter($input));
		}
	}

}

