<?php
/**
 * Zend Framework Brasil
 *
 * @category  Zfb
 * @package   Zfb_Exception
 * @version   $Id$
 */

require_once 'Zend/Log/Writer/Abstract.php';

require_once 'Zend/Log/Formatter/Simple.php';

/**
 * Write logs on multiples files
 *
 * @category Zfb
 * @package  Zfb_Log
 * @uses     Zend_Log_Writer_Abstract
 * @uses     Zend_Log_Formatter_Simple
 * @uses     Zend_Log_Exception
 * @author   Diego Tremper <diegotremper@gmail.com>
 */
class Zfb_Log_Writer_Rolling_File extends Zend_Log_Writer_Abstract {

    /**
     * Holds the PHP stream to log to.
     * @var null|stream
     */
    protected $_stream = null;

    /**
     * default 1MB
     */
    protected $fileMaxSize = 1048576;

    protected $maxFiles = 10;

    protected $_filename = null;

    /**
     * Class Constructor
     *
     * @param  streamOrUrl     Stream or URL to open as a stream
     * @param  mode            Mode, only applicable if a URL is given
     */
    public function __construct($streamOrUrl, $mode = 'a') {
        if (is_resource ( $streamOrUrl )) {
            $stream_data = stream_get_meta_data ( $streamOrUrl );

            if (get_resource_type ( $streamOrUrl ) != 'plainfile') {
                require_once 'Zend/Log/Exception.php';
                throw new Zend_Log_Exception ( 'Resource is not a plainfile' );
            }

            if ($mode != 'a') {
                require_once 'Zend/Log/Exception.php';
                throw new Zend_Log_Exception ( 'Mode cannot be changed on existing streams' );
            }

            $filename = $stream_data ['uri'];
            $this->_stream = $streamOrUrl;
        } else {
            if (! $this->_stream = @fopen ( $streamOrUrl, $mode, false )) {
                $msg = "\"$streamOrUrl\" cannot be opened with mode \"$mode\"";
                require_once 'Zend/Log/Exception.php';
                throw new Zend_Log_Exception ( $msg );
            }

            $filename = $streamOrUrl;
        }

        $this->_fileName = $filename;

        fseek ( $this->_stream, filesize ( $this->_fileName ) - 1 );

        $this->_formatter = new Zend_Log_Formatter_Simple ( );
    }

    /**
     * @return int
     */
    public function getFileMaxSize() {
        return $this->fileMaxSize;
    }

    /**
     * Set the maximum size that the output file is allowed to reach
     * before being rolled over to backup files.
     *
     * The maxFileSize option takes an long integer in the range 0 - 2^63.
     * You can specify the value with the suffixes "KB", "MB" or "GB"
     * so that the integer is interpreted being expressed respectively
     * in kilobytes, megabytes or gigabytes. For example, the value "10KB"
     * will be interpreted as 10240.
     *
     * @param int|string $fileMaxSize
     */
    public function setFileMaxSize($fileMaxSize) {
        if (is_string($fileMaxSize)) {
            $this->fileMaxSize = $this->_convertMaxFileSize($fileMaxSize);
        } else {
            $this->fileMaxSize = $fileMaxSize;
        }
    }

    /**
     * @return int
     */
    public function getMaxFiles() {
        return $this->maxFiles;
    }

    /**
     * @param int $maxFiles
     */
    public function setMaxFiles($maxFiles) {
        $this->maxFiles = $maxFiles;
    }

    /**
     * Close the stream resource.
     *
     * @return void
     */
    public function shutdown() {
        if (is_resource ( $this->_stream )) {
            fclose ( $this->_stream );
        }
    }

    /**
     * Write a message to the log.
     *
     * @param  array  $event  event data
     * @return void
     */
    protected function _write($event) {
        $line = $this->_formatter->format ( $event );

        if (false === @fwrite ( $this->_stream, $line )) {
            require_once 'Zend/Log/Exception.php';
            throw new Zend_Log_Exception ( "Unable to write to stream" );
        }

        if (ftell ( $this->_stream )> $this->fileMaxSize)
            $this->_rollOver ();
    }

    protected function _rollOver() {
        if ($this->maxFiles> 0) {
            $file = $this->_fileName . '.' . $this->maxFiles;

            if (is_writable ( $file ))
                unlink ( $file );

            for($i = $this->maxFiles - 1; $i>= 1; $i --) {
                $file = $this->_fileName . '.' . $i;
                if (is_readable ( $file )) {
                    $target = $this->_fileName . '.' . ($i + 1);
                    rename ( $file, $target );
                }
            }

            $target = $this->_fileName . '.1';

            $this->shutdown ();

            rename ( $this->_fileName, $target );
        }

        $this->__construct ( $this->_fileName, 'w' );
    }

    /**
     * Convert maxFileSize value
     *
     * @param mixed $value
     */
    private function _convertMaxFileSize($value) {
        $maxFileSize = null;
        $numpart = substr ( $value, 0, strlen ( $value ) - 2 );
        $suffix = strtoupper ( substr ( $value, - 2 ) );

        switch ($suffix) {
            case 'KB' :
                $maxFileSize = ( int ) (( int ) $numpart * 1024);
                break;
            case 'MB' :
                $maxFileSize = ( int ) (( int ) $numpart * 1024 * 1024);
                break;
            case 'GB' :
                $maxFileSize = ( int ) (( int ) $numpart * 1024 * 1024 * 1024);
                break;
            default :
                require_once 'Zend/Log/Exception.php';
                throw new Zend_Log_Exception ( 'Invalid size' );
        }

        return $maxFileSize;
    }

}