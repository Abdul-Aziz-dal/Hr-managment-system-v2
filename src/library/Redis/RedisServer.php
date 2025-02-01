<?php 

class RedisStorage {
    private $redis;
    private $isConnected = false;
    public $PORT=6379;
    public function __construct() {
        try {
            $this->redis = new Redis();
            $this->isConnected = $this->redis->connect('http://3.92.191.85', $this->PORT);
            if (!$this->isConnected) {
                throw new RedisException("Unable to connect to Redis.");
            }
        } catch (RedisException $e) {
            $this->isConnected = false;
            error_log("Redis connection failed: " . $e->getMessage());
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
