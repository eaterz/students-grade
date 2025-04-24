<?php
require_once './Models/Model.php';

class UserModel extends Model
{
    public $db;

    public function getUser($personal_code){
        return $this->db->execute("SELECT * FROM user WHERE personal_code = ?", [$personal_code]);
    }
}