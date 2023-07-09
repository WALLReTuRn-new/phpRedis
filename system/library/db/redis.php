<?php

namespace WebSiteToYou\System\Library\DB;

//ini_set('default_charset', 'utf-8');

class Redis {

    private $connection;
    private $report_mode;

    public function __construct(string $hostname, string $username, string $password, string $database, string $port = '') {
        if (!$port) {
            $port = '6379';
        }

        try {
            $redis = new \Redis();

            // $redis->connect('127.0.0.1', 6379, 1, '', 0, 0, ['auth' => [$username, $password]]);
            $redis->connect($hostname, $port);
            $redis->auth([$username, $password]);
            if (!$database):
                $database = 0;
                $redis->swapdb(0, $database); /* Swaps DB 0 with DB 1 atomically */
            else:
                $redis->swapdb(0, $database); /* Swaps DB 0 with DB 1 atomically */
            endif;

            $this->connection = $redis;
        } catch (\RedisException $e) {
            throw new \Exception('Error: Could not make a database link using ' . $username . '@' . $hostname . '!');
        }
    }

    public function getQuery(string $key): mixed {
        $result = $this->connection->get($key);
        return $result;
    }

    public function setData(string $key, $data) {
        $this->connection->set($key, json_encode($data));
    }

    public function clearCache() {
        $this->connection->flushAll();
        return true;
    }

}
