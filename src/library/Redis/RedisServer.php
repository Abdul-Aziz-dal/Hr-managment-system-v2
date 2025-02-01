<?php 

class RedisStorage {
    private $redis;
    private $isConnected = false;
    public $PORT=6379;
    public function __construct() {
        try {
            $this->redis = new Redis();
            $this->isConnected = $this->redis->connect('127.0.0.1', $this->PORT);
        } catch (RedisException $e) {
            $this->isConnected = false;
        }
    }

    public function set($key, $value) {
        if ($this->isConnected) {
            return $this->redis->set($key, $value);
        }
        return false;
    }

    public function get($key) {
        if ($this->isConnected) {
            return $this->redis->get($key);
        }
        return false;
    }

    public function isConnected() {
        return $this->isConnected;
    }


    public function getRedisInstance() {
        if ($this->isConnected) {
            return $this->redis;
        }
        return null;
    }
}
?>
