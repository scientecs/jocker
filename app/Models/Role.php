<?php

namespace App\Models;

use App\Core\Model;

/**
 * Class of Role
 */
class Role extends Model {

    public $tablename = 'roles';

    /**
     * Get one item by alias
     *
     * @param string $alias
     *
     * @return array
     */
    public function getByAlias($alias) {
        $result = $this->db->query("SELECT * FROM " . $this->tablename . " WHERE alias='" . $this->db->escape($alias) . "'");
        return $result->row;
    }

}
