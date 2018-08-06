<?php

namespace App\Models;

use App\Core\Model;
use App\Models\Role;

/**
 * Class of User
 */
class User extends Model {

    public $tablename = "users";

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

        if (!isset($data['role_id'])) {
            $roleUser = (new Role())->getByAlias('user');
            $data['role_id'] = $roleUser['id'];
        }

        $sql = "INSERT INTO " . $this->tablename . " SET"
                . " name='" . $this->db->escape($data['name']) . "',"
                . " role_id='" . (int) $data['role_id'] . "',";

        if ($data['moderation']) {
            $sql .= " moderation='" . (int) $data['moderation'] . "',";
        }

        $sql .= " email='" . $this->db->escape($data['email']) . "',"
                . " password='" . $this->db->escape($data['password']) . "',"
                . " created_at='" . (int) $data['created_at'] . "'";

        $this->db->query($sql);
    }

    /**
     * Update user
     *
     * @param array $data
     *
     * @return void
     */
    public function update($id, $data) {
        $sql = "UPDATE " . $this->tablename . " SET"
                . " name='" . $this->db->escape($data['name']) . "',"
                . " email='" . $this->db->escape($data['email']) . "',"
                . " moderation='" . $this->db->escape($data['moderation']) . "',";

        if ($data['password']) {
            $sql .= " password='" . $this->db->escape($data['password']) . "',";
        }

        $sql .= " created_at='" . (int) $data['created_at'] . "'"
                . " WHERE id='" . (int) $id . "'";

        $this->db->query($sql);
    }

    /**
     * Get user by Email
     * 
     * @param string $email
     *
     * return array
     */
    public function getByEmail($email) {
        $result = $this->db->query("SELECT * FROM " . $this->tablename . " WHERE email='" . $this->db->escape($email) . "'");
        return $result->row;
    }

    /**
     * Get user by id with role
     *
     * @param integer $id
     *
     * @return array
     */
    public function getById($id) {
        $result = $this->db->query("SELECT u.*, r.id as role_id, r.name as role_name, alias as role_alias FROM " . $this->tablename . " as u"
                . " LEFT JOIN roles r ON r.id = u.role_id"
                . " WHERE u.id='" . (int) $id . "'");

        return $result->row;
    }

    /**
     * Get all items from single table
     * 
     * @param string $orderField
     * @param string $sort
     *
     * @return array
     */
    public function getUsersWithRole() {
        $result = $this->db->query("SELECT u.*, r.id as role_id, r.name as role_name, alias as role_alias FROM " . $this->tablename . " as u"
                . " LEFT JOIN roles r ON r.id = u.role_id"
                . " ORDER BY id DESC");

        return $result->rows;
    }

}
