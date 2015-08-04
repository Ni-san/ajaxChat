<?php
namespace exceptions;

class DbException extends \Exception {

    /**
     * @param string $message
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($message = 'Unknown database exception', $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
