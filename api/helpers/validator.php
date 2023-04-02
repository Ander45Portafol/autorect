<?php
class Validator
{

    private static $passwordError = null;
    private static $fileError = null;
    private static $fileName = null;

    public static function getAPasswordError()
    {
        return self::$passwordError;
    }

    public static function getFileName(){
        return self::$fileName;
    }

    public static function getFileError(){
        return self::$fileError;
    }

    public static function validateForm($fields)
    {
        foreach ($fields as $index => $value) {
            $value = trim($value);
            $fields[$index] = $value;
        }
        return $fields;
    }
    public static function validateNaturalNumber($value)
    {
        // Se verifica que el valor sea un número entero mayor o igual a uno.
        if (filter_var($value, FILTER_VALIDATE_INT, array('min_range' => 1))) {
            return true;
        } else {
            return false;
        }
    }
    public static function validateImageFile($file, $maxWidth, $maxHeigth)
    {
        // Se obtienen las dimensiones y el tipo de la imagen.
        list($width, $height, $type) = getimagesize($file['tmp_name']);
        // Se comprueba si el archivo tiene un tamaño mayor a 2MB.
        if ($file['size'] > 2097152) {
            self::$fileError = 'El tamaño de la imagen debe ser menor a 2MB';
            return false;
        } elseif ($width > $maxWidth || $height > $maxHeigth) {
            self::$fileError = 'La dimensión de la imagen es incorrecta';
            return false;
        } elseif ($type == 2 || $type == 3) {
            // Se obtiene la extensión del archivo y se convierte a minúsculas.
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            // Se establece un nombre único para el archivo.
            self::$fileName = uniqid() . '.' . $extension;
            return true;
        } else {
            self::$fileError = 'El tipo de imagen debe ser jpg o png';
            return false;
        }
    }

    public static function validateEmail($value){
        if(filter_var($value, FILTER_VALIDATE_EMAIL)){
            return true;
        }else{
            return false;
        }
    }

    public static function validateBoolean($value){
        if($value == 1 || $value == 0 || $value == true || $value == false){
            return true;
        }else{
            return false;
        }
    }
    public static function validatePassword($value)
    {
        if (strlen($value) < 6) {
            self::$passwordError = 'Clave menor a 6 caracteres';
            return false;
        } elseif (strlen($value) <= 72) {
            return false;
        } else {
            self::$passwordError = 'Clave mayor a 72 caracteres';
            return false;
        }
    }
    public static function validateAlphanumeric($value, $minimum, $maximum)
    {
        if (preg_match('/^[a-zA-z0-9ñÑáÁéÉíÍóÓúÚ\s]{' . $minimum . ',' . $maximum . '}$/', $value)) {
            return true;
        } else {
            return false;
        }
    }

    public static function validateString($value, $minimum, $maximum)
    {
        if (preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\,\;\.]{' . $minimum . ',' . $maximum . '}$/', $value)) {
            return true;
        } else {
            return false;
        }
    }
}