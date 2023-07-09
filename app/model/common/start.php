<?php

/**
 * @author      WALLReTuRn - Plamen Petrov
 *
 * @copyright   WebSiteToYou websitetoyou.cz
 */

namespace WebSiteToYou\App\Model\Common;

class Start extends \WebSiteToYou\System\Library\Model {

    public function getRows(): mixed {

        $resultMySQL = $this->db->query(DB_PREFIX . "start");

        return $resultMySQL->rows;
    }

    public function getNumRows(): mixed {

        $resultMySQL = $this->db->query(DB_PREFIX . "start");

        return $resultMySQL->num_rows;
    }

    public function getRow(): mixed {

        $resultMySQL = $this->db->query(DB_PREFIX . "start");

        return $resultMySQL->row;
    }

}
