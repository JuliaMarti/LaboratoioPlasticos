<?php

require_once 'DB.php';
require_once 'User.php';

class Log
{
    public $id_log;
    public $id_user;
    public $correct;
    public $ip;
    public $timestamp;
    public $password;

	static function getById($id_log)
	{
		$stmt = DB::getStatement('SELECT * FROM logs WHERE id = :id_log');
		$stmt->bindParam(':id_log', $id_log, PDO::PARAM_INT);
		$stmt->execute();
		if ($stmt->rowCount() === 1) {
		    return $stmt->fetchObject('Log');
        }
		return null;
    }
    
    public function getUser()
    {
        $user = Categoria::getById($this->id_user);
        if ($user) {
            return $user;
        }
        return null;
    }

    public function getUserCorrectPassword()
    {
        $user = $this->getUser();
        if ($user) {
            return $user->password;
        }
        return '';
    }

    public function isCorrect()
    {
        if($this->correct) {
            return 'Correcto';
        }
        return 'Incorrecto';
    }

}