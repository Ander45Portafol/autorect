<?php
require_once('../../helpers/database.php');

class UserQueries{
    public function checkUser($alias){
        $sql='SELECT id_usuario from usuarios WHERE nombre_usuario = ?';
        $params=array($alias);
        $data=Database::getRow($sql,$params);
        if ($data) {
            $this->id=$data['id_usuario'];
            $this->nombre_usuario=$alias;
            return true;
        }else{
            return false;
        }
    }
    public function checkPassword($password){
        $sql='SELECT clave_usuario FROM usuarios WHERE id_usuario = ?';
        $params =array($this->id);
        $data= Database::getRow($sql,$params);
        if ($password==$data['clave_usuario']) {
            return true;
        }else{
            return false;
        }
    }
    public function readAll(){
        $sql='SELECT id_usuario, nombre_usuario,estado_usuario FROM usuarios ORDER BY nombre_usuario';
        return Database::getRow($sql);
    }
}