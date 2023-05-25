<?php
//Here are used the functions in the database file
require_once('../../helpers/database.php');
//Class to control all queries at the database
class MembershipQueries
{
    //This function is show all datas of the memberships is used to show data in the table
    public function readPay()
    {
        $query = "SELECT id_tipo_membresia, tipo_membresia, descripcion_membresia, CAST(precio_membresia AS INTEGER) as precio_membresia_int, precio_membresia, imagen_membresia
        FROM tipos_membresias
        WHERE precio_membresia > 0;";
        return Database::getRows($query);
    }

    //this function is to show the imgs that are stored in the database
    public function readImgs()
    {
        $query = "SELECT tipo_membresia, imagen_membresia
        FROM tipos_membresias;";
        return Database::getRows($query);
    }
}