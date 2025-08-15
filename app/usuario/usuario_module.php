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

  public function loginUserExistsDB($login)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT loginuser FROM user_data_table WHERE loginuser = :login");
    $stmt->execute(['login' => $login]);
    return $stmt->fetchColumn();
  }

  public function createNewUserDB($id, $name, $email, $login, $password, $type)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("INSERT INTO user_data_table(id, nameuser,emailuser,loginuser,passworduser,leveluser) VALUES (?,?,?,?,?,?)");
    $stmt->execute([$id, $name, $email, $login, $password, $type]);
    return $stmt;
  }

  public function getPasswordUserDB($id)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT passworduser FROM user_data_table WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetchColumn();
  }

  public function updateUserDataDBPasswordOff($id, $name, $email, $login, $type)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE user_data_table SET nameuser=:nameuser,emailuser=:emailuser,loginuser=:loginuser,leveluser=:leveluser WHERE id = :id");
    $stmt->execute(['nameuser' => $name, 'emailuser' => $email, 'loginuser' => $login, 'leveluser' => $type, 'id' => $id]);
    return $stmt->rowCount();
  }
  public function updateUserDataDBPasswordOn($id, $name, $email, $login, $pwhash, $type)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE user_data_table SET nameuser=:name, emailuser=:email, loginuser=:login, passworduser=:pwhash, leveluser=:type WHERE id = :id");
    $stmt->execute(['name' => $name, 'email' => $email, 'login' => $login, 'pwhash' => $pwhash, 'type' => $type, 'id' => $id]);
    return $stmt->rowCount();
  }

  public function getListUsersDB()
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT A.id, nameuser, emailuser, loginuser, B.nameusertype
                                  FROM user_data_table AS A
                                INNER JOIN user_types_data_table AS B ON A.leveluser=B.id 
                                WHERE statususer = 1");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getDataUsersDB($id)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM user_data_table WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public function deleteUserDB($id)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE user_data_table SET statususer = :status WHERE id = :id");
    $stmt->execute(['status' => 0, 'id' => $id]);
    return $stmt->rowCount();
  }

   public function getDataUserLogin($login)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM user_data_table WHERE loginuser = :login");
    $stmt->execute(['login' => $login]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
