<?php

namespace App\Models;

use App\Core\Model;

/**
 * Class of User
 */
class Message extends Model {

    public $tablename = "messages";

    /**
     * Insert user
     *
     * @param array $data
     *
     * @return void
     */
    public function insert($data) {
        if (!isset($data['created_at'])) {
            $data['created_at'] = time();
        }

        $this->db->query("INSERT INTO " . $this->tablename . " SET"
                . " subject='" . $this->db->escape($data['subject']) . "',"
                . " message='" . $this->db->escape($data['message']) . "',"
                . " user_id='" . (int) $data['user_id'] . "',"
                . " created_at='" . (int) $data['created_at'] . "'");
    }

    /**
     * Update user
     *
     * @param array $data
     *
     * @return void
     */
    public function update($id, $data) {
        $this->db->query("UPDATE " . $this->tablename . " SET"
                . " subject='" . $this->db->escape($data['subject']) . "',"
                . " message='" . $this->db->escape($data['message']) . "',"
                . " user_id='" . (int) $data['user_id'] . "',"
                . " created_at='" . (int) $data['created_at'] . "'"
                . " WHERE id='" . (int) $id . "'");
    }

    /**
     * Set messages as old
     */
    public function setMessagesAsOld() {
        $this->db->query("UPDATE " . $this->tablename . " SET is_new='" . 0 . "'");
    }

    /**
     * Get all items from single table
     * 
     * @param string $orderField
     * @param string $sort
     *
     * @return array
     */
    public function getAll($withUser = false) {
        if (!$withUser) {
            return parent::getAll();
        }

        $result = $this->db->query("SELECT m.*, u.name as user_name, u.id as user_id FROM " . $this->tablename . " as m"
                . " LEFT JOIN users u ON m.user_id=u.id"
                . " ORDER BY id DESC");

        return $result->rows;
    }

}
