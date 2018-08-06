<?php

namespace App\Core;

use App\Core\DB\Mysql;
use App\Core\DB\DMysqli;
use App\Core\DB\Postgre;

/**
 * Class of DB
 */
class DB {

    public static function make($driver, $hostname, $username, $password, $database) {
        switch ($driver) {
            case 'mysql' :
                return new DMysql($hostname, $username, $password, $database);
                break;
            case 'mysqli' :
                return new DMysqli($hostname, $username, $password, $database);
                break;
            case 'postgre' :
                return new DPostgre($hostname, $username, $password, $database);
                break;
            default :
                throw \Exception('Undefined DB driver');
                break;
        }
        return;
    }

}
