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
        $sql='SELECT id_usuario, nombre_usuario, clave_usuario, estado_usuario, id_empleado, id_tipo_usuario, id_tema, id_idioma FROM usuarios ORDER BY id_usuario';
        return Database::getRows($sql);
    }
    public function searchRows($value){
        $sql='SELECT id_usuario, nombre_usuario, clave_usuario, estado_usuario, id_empleado, id_tipo_usuario FROM usuarios WHERE nombre_usuario ILIKE ? ORDER BY id_usuario';
        $params=array("%$value%");
        return Database::getRows($sql,$params);
    }
    public function createRow(){
        $sql='INSERT INTO usuarios(nombre_usuario,clave_usuario,imagen_usuario,estado_usuario,id_empleado,id_tipo_usuario,id_tema,id_idioma) values(?,?,?,?,?,?,?,?)';
        $params=array($this->nombre_usuario,$this->clave_usuario, $this->imagen, $this->estado_usuario ,$this->empleado,$this->tipo_usuario,$this->tema=1,$this->idioma=2);
        return Database::executeRow($sql,$params);
    }
    public function readOne(){
        $sql='SELECT id_usuario, nombre_usuario, imagen_usuario, clave_usuario, estado_usuario, id_empleado, id_tipo_usuario FROM usuarios WHERE id_usuario=?';
        $params=array($this->id);
        return Database::getRow($sql,$params);
    }
    public function updateRow($current_image){
        ($this->imagen)?Validator::deleteFile($this->getRuta(),$current_image):$this->imagen=$current_image;
        $sql='UPDATE usuarios SET nombre_usuario=?, clave_usuario=?, imagen_usuario=?, estado_usuario=?, id_empleado=?, id_tipo_usuario=? WHERE id_usuario=?';
        $params=array($this->nombre_usuario,$this->clave_usuario, $this->imagen, $this->estado_usuario, $this->empleado,$this->tipo_usuario,$this->id);
        return Database::executeRow($sql,$params);
    }
    public function deleteRow(){
        $sql='DELETE FROM usuarios WHERE id_usuario=?';
        $params=array($this->id);
        return Database::executeRow($sql,$params);
    }
    public function readEmployees(){
        $sql='SELECT id_empleado, nombre_empleado FROM empleados';
        return Database::getRows($sql);
    }
    public function readType_Users(){
        $sql='SELECT id_tipo_usuario,tipo_usuario FROM tipos_usuarios';
        return Database::getRows($sql);
    }
}