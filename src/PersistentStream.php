<?php
/**
 * PersistentStream.php
 *
 *
 */


namespace Clue\React\Redis;

use React\EventLoop\LoopInterface;
use \React\Stream\Stream as BaseStream;

class PersistentStream extends BaseStream {

    public function end($data = null)
    {
        if (!$this->writable) {
            return;
        }

        $this->closing = true;

        $this->readable = false;
        $this->writable = false;

        $this->buffer->end($data);
    }

}
