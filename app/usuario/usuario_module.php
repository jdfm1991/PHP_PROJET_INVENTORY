<?php
require_once("../../config/conexion.php");

class Usuario extends Conectar
{

  public function getNameUserTypes()
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM user_types_data_table");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function createNewUserDB($id, $name, $email, $login, $password, $type)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("INSERT INTO user_data_table(u_id, u_name, u_email, u_login, u_pass, u_level) VALUES (:id, :name, :email, :login, :pass, :level)");
    $stmt->execute(['id' => $id, 'name' => $name, 'email' => $email, 'login' => $login, 'pass' => $password, 'level' => $type]);
    return $stmt->rowCount();
  }

  public function updateUserDataDBPasswordOff($id, $name, $email, $login, $type)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE user_data_table SET u_name = :name, u_email = :email, u_login = :login, u_level = :level WHERE u_id = :id");
    $stmt->execute(['name' => $name, 'email' => $email, 'login' => $login, 'level' => $type, 'id' => $id]);
    return $stmt->rowCount();
  }
  public function updateUserDataDBPasswordOn($id, $name, $email, $login, $pwhash, $type)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE user_data_table SET u_name = :name, u_email = :email, u_login = :login, u_pass = :pwhash, u_level = :type WHERE u_id = :id");
    $stmt->execute(['name' => $name, 'email' => $email, 'login' => $login, 'pwhash' => $pwhash, 'type' => $type, 'id' => $id]);
    return $stmt->rowCount();
  }

  public function getListUsersDB()
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT A.u_id, u_name, u_email, u_login, B.ut_name
                                  FROM user_data_table AS A
                                INNER JOIN user_types_data_table AS B ON A.u_level = B.ut_id 
                                WHERE u_status = 1");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getDataUsersDB($id)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM user_data_table WHERE u_id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public function deleteUserDB($id)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE user_data_table SET u_status = :status WHERE u_id = :id");
    $stmt->execute(['status' => 0, 'id' => $id]);
    return $stmt->rowCount();
  }

   public function getDataUserLogin($login)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM user_data_table WHERE u_login = :login");
    $stmt->execute(['login' => $login]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
