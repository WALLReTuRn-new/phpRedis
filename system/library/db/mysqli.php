<?php

namespace WebSiteToYou\System\Library\DB;

class MySQLi {

    private object $connection;
    private object $report_mode;
    private $dbRedis;

    public function __construct(string $hostname, string $username, string $password, string $database, string $port = '') {
        if (!$port) {
            $port = '3306';
        }

        try {
            $mysqli = @new \MySQLi($hostname, $username, $password, $database, $port);

            $this->connection = $mysqli;
            //$this->connection->report_mode = MYSQLI_REPORT_ERROR;
            $this->connection->set_charset('utf8mb4');
            $this->connection->query("SET SESSION sql_mode = 'NO_ZERO_IN_DATE,NO_ENGINE_SUBSTITUTION'");
        } catch (\mysqli_sql_exception $e) {
            throw new \Exception('Error: Could not make a database link using ' . $username . '@' . $hostname . '!');
        }
    }

    public function query(string $sql): bool|object {

        $this->dbRedis = new \WebSiteToYou\System\Library\DB(DBRedis_DRIVER, DBRedis_HOSTNAME, DBRedis_USERNAME, DBRedis_PASSWORD, DBRedis_DATABASE, DBRedis_PORT);

        $cachedEntry = $this->dbRedis->getQuery($sql);
        $redisKey = $sql;

        if ($cachedEntry):
            //display the result from redis Cachaed
            //From redis Cachaed
            $result = new \stdClass();
            $result->num_rows = count(json_decode($cachedEntry, true));
            $result->row = isset(json_decode($cachedEntry, true)[0]) ? json_decode($cachedEntry, true)[0] : [];
            $result->rows = json_decode($cachedEntry, true);
            return $result;
        else:
            $sql = "SELECT * FROM " . $sql;

            try {
                $query = $this->connection->query($sql);

                if ($query instanceof \mysqli_result) {
                    $data = [];

                    while ($row = $query->fetch_assoc()) {
                        $data[] = $row;
                    }

                    $this->dbRedis->setData($redisKey, $data);

                    $result = new \stdClass();
                    $result->num_rows = $query->num_rows;
                    $result->row = isset($data[0]) ? $data[0] : [];
                    $result->rows = $data;

                    $query->close();

                    unset($data);

                    return $result;
                } else {
                    return true;
                }
            } catch (\mysqli_sql_exception $e) {

                throw new \Exception('Error: ' . $this->connection->error . '<br/>Error No: ' . $this->connection->errno . '<br/>' . $sql);
            }
        endif;
    }

    public function error($sql) {

        // if (mysqli_errno($this->connection) == 1062):
        //    $error = $this->connection->error;
        //else:
        //    $error = 'Error: ' . $this->connection->error . '<br/>Error No: ' . $this->connection->errno . '<br/>' . $sql;
        // endif;

        $error = throw new \Exception('Error: ' . $this->connection->error . '<br/>Error No: ' . $this->connection->errno . '<br/>' . $sql);

        return $error;
    }

    public function escape(string $value): string {
        return $this->connection->real_escape_string($value);
    }

    public function countAffected(): int {
        return $this->connection->affected_rows;
    }

    public function getLastId(): int {
        return $this->connection->insert_id;
    }

    public function isConnected(): bool {
        if ($this->connection) {
            return $this->connection->ping();
        } else {
            return false;
        }
    }

    /**
     * __destruct
     *
     * Closes the DB connection when this object is destroyed.
     *
     */
    public function __destruct() {
        if ($this->connection) {
            $this->connection->close();

            unset($this->connection);
        }
    }

}
