<?php

require_once 'DB.php';

class User
{
	public $id_user;
	public $user;
    public $password;

	static function getById($id_user)
	{
		$stmt = DB::getStatement('SELECT * FROM users WHERE id_user = :id_user');
		$stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
		$stmt->execute();
		if ($stmt->rowCount() === 1) {
		    return $stmt->fetchObject('User');
        }
		return null;
	}

}