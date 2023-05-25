<?php
//Dependencies
require_once('../../helpers/database.php');

class ContactQueries
{
    //Function to create an contact info
    public function createRow()
    {
        $query = "INSERT INTO informacion_contactos(correo_contactante, mensaje, fecha, estado_contacto, id_cliente)
        VALUES (?, ?, CURRENT_DATE, DEFAULT, ?);";
        $params = array($this->contacting_email, $this->message, $this->client_id);
        return Database::executeRow($query, $params);
    }
}