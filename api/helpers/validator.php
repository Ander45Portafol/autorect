<?php
//Class to generate validations at the server
class Validator
{
    //Making atributs
    private static $passwordError = null;
    private static $fileName = null;
    private static $fileError = null;
    //Method get of the atributs
    public static function getAPasswordError()
    {
        return self::$passwordError;
    }
    public static function getFileName()
    {
        return self::$fileName;
    }
    public static function getFileError()
    {
        return self::$fileError;
    }
    //Function to validate form
    public static function validateForm($fields)
    {
        foreach ($fields as $index => $value) {
            $value = trim($value);
            $fields[$index] = $value;
        }
        return $fields;
    }
    //Function to validate of the number are natural
    public static function validateNaturalNumber($value)
    {
        if (filter_var($value, FILTER_VALIDATE_INT, array('min_range' => 1))) {
            return true;
        } else {
            return false;
        }
    }
    //Function to validate the strings of the used dui
    public static function validateDUI($value)
    {
        if (preg_match('/^[0-9]{8}[-][0-9]{1}$/', $value)) {
            return true;
        } else {
            return false;
        }
    }
    //Function to validate the strings to use at the number phone
    public static function validatePhone($value)
    {
        if (preg_match('/^[2,6,7]{1}[0-9]{3}[-][0-9]{4}$/', $value)) {
            return true;
        } else {
            return false;
        }
    }
    //Function to validate the Email registrer
    public static function validateEmail($value)
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }
    //Function to validate at the data are String
    public static function validateString($value, $minimum, $maximum)
    {
        // Se verifica el contenido y la longitud de acuerdo con la base de datos.
        if (preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\,\;\.]{' . $minimum . ',' . $maximum . '}$/', $value)) {
            return true;
        } else {
            return false;
        }
    }
    //Function to validate image files
    public static function validateImageFile($file, $maxWidth, $maxHeigth)
    {
        list($width, $height, $type) = getimagesize($file['tmp_name']);
        if ($file['size'] > 2097152) {
            self::$fileError = 'El tamaño de la imagen debe ser menor a 2MB';
            return false;
        } elseif ($width > $maxWidth || $height > $maxHeigth) {
            self::$fileError = 'La dimensión de la imagen es incorrecta';
            return false;
        } elseif ($type == 2 || $type == 3) {
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            self::$fileName = uniqid() . '.' . $extension;
            return true;
        } else {
            self::$fileError = 'El tipo de imagen debe ser jpg o png';
            return false;
        }
    }
    //Function to validate password 
    public static function validatePassword($value)
    {
        if (strlen($value) < 6) {
            self::$passwordError = 'Clave menor a 6 caracteres';
            return false;
        } elseif (strlen($value) <= 72) {
            return true;
        } else {
            self::$passwordError = 'Clave mayor a 72 caracteres';
            return false;
        }
    }
    //Function to validate of the data are Alphanumeric
    public static function validateAlphanumeric($value, $minimum, $maximum)
    {
        if (preg_match('/^[a-zA-z0-9ñÑáÁéÉíÍóÓúÚ\s]{' . $minimum . ',' . $maximum . '}$/', $value)) {
            return true;
        } else {
            return false;
        }
    }
    //Function to validate the data are boolean
    public static function validateBoolean($value)
    {
        if ($value == 1 || $value == 0 || $value == true || $value = false) {
            return true;
        } else {
            return false;
        }
    }
    //Function to validate dates
    public static function validateDate($value)
    {
        $date = explode('-', $value);
        if (checkdate($date[1], $date[2], $date[0])) {
            return true;
        } else {
            return false;
        }
    }
    //Function to save files
    public static function saveFile($file, $path, $name)
    {
        if (move_uploaded_file($file['tmp_name'], $path . $name)) {
            return true;
        } else {
            return false;
        }
    }
    //Function to delete file
    public static function deleteFile($path, $name)
    {
        if (@unlink($path . $name)) {
            return true;
        } else {
            return false;
        }
    }
    //Function to validate datas like money
    public static function validateMoney($value)
    {
        if (preg_match('/^[0-9]+(?:\.[0-9]{1,2})?$/', $value)) {
            return true;
        } else {
            return false;
        }
    }
}
