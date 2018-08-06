<?php

namespace App\Core\DB;

/**
 * Interface of Database
 * @author scientecs
 */
interface Database {

    public function query($sql);

    public function escape($value);

    public function countAffected();

    public function getLastId();
}
