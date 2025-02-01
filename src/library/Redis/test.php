
<?php
$redis = new Redis();
try {
    $redis->connect('127.0.0.1', 6379);
    echo "Redis Connection: " . $redis->ping();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>