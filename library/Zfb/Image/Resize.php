<?php
/**
 * Zend Framework Brasil
 *
 * @category  Zfb
 * @package   Zfb_Image
 * @uses      Zfb_Exception
 * @version   $Id$
 */

/**
 * Resize a image
 *
 * @category Zfb
 * @package  Zfb_Image
 * @uses     Zfb_Exception
 * @author   Diego Tremper <diegotremper@gmail.com>
 */
class Zfb_Image_Resize {

	private $_image;

	private $_resizedImage;

	private $_info;

	private $_maxWidth;

	private $_maxHeight;

	private $_imageWidth;

	private $_imageHeight;

	/**
	 * initialize objet to resize image
	 *
	 * @param string $path path to image
	 */
	public function __construct($path)
	{
		$this->_info = @getimagesize($path);

		if (false === $this->_info) {
			throw new Zfb_Exception('Cannot determine type of image ' . $path);
		}

		$type = $this->_info[2];

		if ($type == IMAGETYPE_JPEG) {
			$this->_image = @imagecreatefromjpeg($path);
		} elseif ($type == IMAGETYPE_GIF) {
			$this->_image = @imagecreatefromgif($path);
		} elseif ($type == IMAGETYPE_PNG) {
			$this->_image = @imagecreatefrompng($path);
		} else {
			throw new Zfb_Exception('Unknow type image type ' . $type);
		}

		if (false === $this->_image) {
			throw new Zfb_Exception('Cannot open image ' . $path);
		}

		$this->_imageWidth = imagesx($this->_image);
		$this->_imageHeight = imagesy($this->_image);

	}

	/**
	 * save image resized
	 *
	 * @param string $path path to new resized image
	 */
	public function saveImage($path)
	{
		if ($this->_needResize()) {
			$this->_resize();
		} else {
			$this->_resizedImage = $this->_image;
		}

		$this->_saveImage($path);
	}

	private function _getResizedValues()
	{
		$img_ratio = $this->_imageWidth / $this->_imageHeight;
		$target_ratio = $this->_maxWidth / $this->_maxHeight;

		if ($target_ratio > $img_ratio) {
			$new_height = $this->_maxHeight;
			$new_width = $img_ratio * $this->_maxHeight;
		} else {
			$new_height = $this->_maxWidth / $img_ratio;
			$new_width = $this->_maxWidth;
		}

		if ($new_height > $this->_maxHeight) {
			$new_height = $this->_maxHeight;
		}
		if ($new_width > $this->_maxWidth) {
			$new_height = $this->_maxWidth;
		}

		return array(
			$new_width, $new_height
		);
	}

	private function _needResize()
	{
		return ! ($this->_imageWidth < $this->_maxWidth && $this->_imageHeight < $this->_maxHeight);
	}

	private function _resize()
	{
		$values = $this->_getResizedValues();

		$this->_resizedImage = imagecreatetruecolor($values[0], $values[1]);
		imagecopyresampled(
			$this->_resizedImage,
			$this->_image,
			0,
			0,
			0,
			0,
			$values[0],
			$values[1],
			$this->_imageWidth,
			$this->_imageHeight
		);
	}

	private function _saveImage($path)
	{
		$type = $this->_info[2];

		if ($type == IMAGETYPE_JPEG) {
			imagejpeg($this->_resizedImage, $path);
		} elseif ($type == IMAGETYPE_GIF) {
			imagegif($this->_resizedImage, $path);
		} elseif ($type == IMAGETYPE_PNG) {
			imagepng($this->_resizedImage, $path);
		}
	}

	/**
	 * @return float
	 */
	public function getMaxHeight()
	{
		return $this->_maxHeight;
	}

	/**
	 * @return float
	 */
	public function getMaxWidth()
	{
		return $this->_maxWidth;
	}

	/**
	 * @param float $_maxHeight
	 */
	public function setMaxHeight($_maxHeight)
	{
		$this->_maxHeight = $_maxHeight;
	}

	/**
	 * @param float $_maxWidth
	 */
	public function setMaxWidth($_maxWidth)
	{
		$this->_maxWidth = $_maxWidth;
	}

}

