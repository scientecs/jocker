<?php

namespace App\Core;

use App\Core\DB;

/**
 * Class of Model
 */
class Model {

    /**
     * Link for work with database
     * 
     * @var DB
     */
    protected $db = null;

    public function __construct() {
        $this->db = DB::make(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    }

    /**
     * Get all items from single table
     * 
     * @param string $orderField
     * @param string $sort
     *
     * @return array
     */
    public function getAll() {
        $result = $this->db->query("SELECT * FROM " . $this->tablename);

        return $result->rows;
    }

    /**
     * Get single item by id
     * 
     * @param integer $id
     *
     * @return array
     */
    public function getById($id) {
        $result = $this->db->query("SELECT * FROM " . $this->tablename . " WHERE id='" . (int) $id . "'");

        return $result->row;
    }

    /**
     * Get items by ids
     *
     * @param integer $ids
     *
     * @return array
     */
    public function getByIds($ids) {
        $result = $this->db->query("SELECT * FROM " . $this->tablename . " WHERE id IN (" . implode(',', $ids) . ")");

        return $result->rows;
    }

    /**
     * Get single item by id
     * 
     * @param integer $id
     *
     * @return array
     */
    public function delete($id) {
        $result = $this->db->query('DELETE FROM ' . $this->tablename . ' WHERE id=' . (int) $id);
        return $result->row;
    }

}
