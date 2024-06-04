<?php


namespace App\Models;

use CodeIgniter\Model;

class DocumentosModel extends Model
{


    public function saveColab($nombre, $apellido_paterno, $apellido_materno, $correo, $nuevo_pass, $rol, $token)
    {
        // Define los datos a insertar
        $data = [
            'nombre' => $nombre,
            'apellido_paterno' => $apellido_paterno,
            'apellido_materno' => $apellido_materno,
            'correo' => $correo,
            'password' => $nuevo_pass,
            'rol' => $rol,
            'token_password' => $token,
        ];
        $this->db->table('colaboradores')->insert($data);

        // Recupera el último ID insertado
        $lastId = $this->db->insertID();

        if ($lastId) {
            return $lastId; // Devuelve el último ID insertado
        } else {
            return false; // La consulta falló o no se generó un nuevo ID
        }
    }

    public function saveArea($insertedId, $nombre_area, $descripcion, $puesto)
    {

        $query = $this->db->query("INSERT INTO areas (id_usuario, nombre_area, descripcion, puesto) VALUES ('$insertedId', '$nombre_area', '$descripcion', '$puesto')"
        );

        //return $query->getResult();
        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
    public function saveData($insertedId, $foto_perfil, $fecha_nacimiento, $fecha_ingreso, $direccion, $telefono, $sexo)
    {

        $query = $this->db->query('INSERT INTO datos_personales (id_usuario, foto_perfil, fecha_nacimiento, fecha_ingreso, direccion, telefono, sexo) 
        VALUES (?, ?, ?, ?, ?, ?, ?)', 
        [$insertedId, $foto_perfil, $fecha_nacimiento, $fecha_ingreso, $direccion, $telefono, $sexo]
        );

        //return $query->getResult();
        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

}