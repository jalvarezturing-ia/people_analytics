<?php


namespace App\Models;

use CodeIgniter\Model;

class ColaboratorsModel extends Model
{

    public function getAreas()
    {
        $query = $this->db->query("SELECT DISTINCT nombre_area, descripcion, puesto FROM areas");

        return $query->getResult();
    }

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

    public function getPeople()
    {

        $query = $this->db->query('SELECT colaboradores.id, colaboradores.nombre, 
        colaboradores.apellido_paterno,
        colaboradores.apellido_materno,
        datos_personales.telefono, 
        colaboradores.correo, areas.descripcion, areas.puesto, nominas.pago_mensual_base 
        FROM colaboradores 
        INNER JOIN areas ON areas.id_usuario = colaboradores.id 
        LEFT JOIN nominas ON nominas.id_usuario = colaboradores.id 
        INNER JOIN datos_personales ON datos_personales.id_usuario = colaboradores.id
        -- WHERE colaboradores.nombre != "turing-ia"
        AND datos_personales.fecha_egreso = "0"
        ORDER BY colaboradores.nombre ASC');

        return $query->getResult();

    }
    public function getPeopleBaja()
    {

        $query = $this->db->query('SELECT colaboradores.id, colaboradores.nombre, 
         colaboradores.apellido_paterno,
        colaboradores.apellido_materno,
        datos_personales.telefono, 
        colaboradores.correo, areas.descripcion, areas.puesto, nominas.pago_mensual_base 
        FROM colaboradores 
        INNER JOIN areas ON areas.id_usuario = colaboradores.id 
        LEFT JOIN nominas ON nominas.id_usuario = colaboradores.id 
        INNER JOIN datos_personales ON datos_personales.id_usuario = colaboradores.id
        WHERE colaboradores.nombre != "turing-ia"
        AND datos_personales.fecha_egreso != "0"
        ORDER BY colaboradores.nombre ASC');

        return $query->getResult();

    }

    public function getColabId($id_user)
    {

        $query = $this->db->query("SELECT colaboradores.id as 
        id_usuario, colaboradores.nombre, colaboradores.apellido_paterno,
        colaboradores.apellido_materno,
        datos_personales.telefono, colaboradores.correo, datos_personales.*, areas.*,
        cv_contrato.curriculum_vitae, cv_contrato.contrato_vitae,
        cv_contrato.c_domicilio,  cv_contrato.c_estudios,  cv_contrato.c_rfc, 
        cv_contrato.d_bancarios,  cv_contrato.c_beneficiario, 
        cv_contrato.INE,  cv_contrato.curp,  cv_contrato.acta_nacimiento
        FROM colaboradores
        LEFT JOIN datos_personales ON datos_personales.id_usuario = colaboradores.id
        LEFT JOIN areas ON areas.id_usuario = colaboradores.id
        LEFT JOIN cv_contrato ON cv_contrato.id_usuario = colaboradores.id 
        WHERE colaboradores.id = ?",
            [$id_user]);

        return $query->getResult();
    }
    public function getNominaId($id_user)
    {

        $query = $this->db->query("SELECT nominas.* FROM nominas WHERE id_usuario = ?",
            [$id_user]);

        return $query->getResult();
    }

    /*public function updatecolab($nombre, $telefono, $correo, $fecha_nacimiento, $fecha_ingreso, $fecha_egreso, $direccion, $nombre_area, $descripcion, $puesto, $id_usuario)
    {

        $query = $this->db->query(
            "UPDATE colaboradores 
            INNER JOIN datos_personales ON datos_personales.id_usuario = colaboradores.id
            INNER JOIN areas ON areas.id_usuario = colaboradores.id 
            SET 
            colaboradores.nombre = ?,
            colaboradores.telefono = ?, 
            colaboradores.correo = ?,
            datos_personales.fecha_nacimiento = ?,
            datos_personales.fecha_ingreso = ?,
            datos_personales.fecha_egreso = ?,
            datos_personales.direccion = ?,
            areas.nombre_area = ?,
            areas.descripcion = ?,
            areas.puesto = ?
            WHERE colaboradores.id = ?",
            [$nombre, $telefono, $correo, $fecha_nacimiento, $fecha_ingreso, $fecha_egreso, $direccion, $nombre_area, $descripcion, $puesto, $id_usuario]
        );
        
        //return $query->getResult();
        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }*/

    public function updatecolab($nombre, $apellido_paterno, $apellido_materno, $telefono, $correo, $fecha_nacimiento, $fecha_ingreso, $fecha_egreso, $direccion, $nombre_area, $descripcion, $puesto, $sexo, $id_usuario)
    {
        // Verifica si ya existen datos personales para el usuario
        $datos_personales_existentes = $this->db->query("SELECT * FROM datos_personales WHERE id_usuario = ?", [$id_usuario])->getRow();

        // Verifica si ya existen datos de área para el usuario
        $areas_existentes = $this->db->query("SELECT * FROM areas WHERE id_usuario = ?", [$id_usuario])->getRow();

        // Actualiza o inserta en colaboradores
        $this->db->query(
            "UPDATE colaboradores 
        SET 
        nombre = ?,
        apellido_paterno = ?, 
        apellido_materno = ?, 
        correo = ?
        WHERE id = ?",
            [$nombre, $apellido_paterno, $apellido_materno, $correo, $id_usuario]
        );

        // Actualiza o inserta en datos_personales
        if ($datos_personales_existentes) {
            $this->db->query(
                "UPDATE datos_personales 
            SET 
            fecha_nacimiento = ?,
            fecha_ingreso = ?,
            fecha_egreso = ?,
            direccion = ?,
            telefono = ?,
            sexo = ?
            WHERE id_usuario = ?",
                [$fecha_nacimiento, $fecha_ingreso, $fecha_egreso, $direccion, $telefono, $sexo, $id_usuario]
            );
        } else {
            $this->db->query(
                "INSERT INTO datos_personales (id_usuario, fecha_nacimiento, fecha_ingreso, fecha_egreso, direccion, telefono, sexo) 
            VALUES (?, ?, ?, ?, ?, ?, ?)",
                [$id_usuario, $fecha_nacimiento, $fecha_ingreso, $fecha_egreso, $direccion, $telefono, $sexo]
            );
        }

        // Actualiza o inserta en áreas
        if ($areas_existentes) {
            $this->db->query(
                "UPDATE areas 
            SET 
            nombre_area = ?,
            descripcion = ?,
            puesto = ?
            WHERE id_usuario = ?",
                [$nombre_area, $descripcion, $puesto, $id_usuario]
            );
        } else {
            $this->db->query(
                "INSERT INTO areas (id_usuario, nombre_area, descripcion, puesto) 
            VALUES (?, ?, ?, ?)",
                [$id_usuario, $nombre_area, $descripcion, $puesto]
            );
        }

        return true; // La operación fue exitosa
    }
    public function deleteColab($fechaFormateada, $id_user)
    {
        $query = $this->db->query("UPDATE datos_personales SET fecha_egreso = ? WHERE id_usuario = ?",
            [$fechaFormateada, $id_user]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }
    }
    public function altaPeople($fecha_egreso, $id_user)
    {
        $query = $this->db->query("UPDATE datos_personales SET fecha_egreso = ? WHERE id_usuario = ?",
            [$fecha_egreso, $id_user]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }
    }

    public function savedatabank($id_usuario, $nombre_banco, $numero_cuenta, $clabe_interbancaria, $pago_mensual_base, $pago_quincenal, $sueldo_diario)
    {

        $query = $this->db->query("UPDATE nominas SET nombre_banco = ?, numero_cuenta = ?, clabe_interbancaria = ?,
        pago_mensual_base = ?, pago_quincenal = ?, sueldo_diario = ? WHERE id_usuario = ?",
        [$nombre_banco, $numero_cuenta, $clabe_interbancaria, $pago_mensual_base, $pago_quincenal, $sueldo_diario, $id_usuario]
    );

    if ($query) {
        return true; // La consulta se ejecutó correctamente
    } else {
        return false; // La consulta falló
    }

    }
    public function savedataa($pago_mensual_base, $id_usuario)
    {

        $query = $this->db->query("UPDATE pago_nomina
        INNER JOIN nominas ON pago_nomina.id_nomina = nominas.id
        INNER JOIN colaboradores ON colaboradores.id = nominas.id_usuario
        SET pago_nomina.sueldo_final = ?
        WHERE colaboradores.id = ?",
        [$pago_mensual_base, $id_usuario]
    );

    if ($query) {
        return true; // La consulta se ejecutó correctamente
    } else {
        return false; // La consulta falló
    }

    }

    public function updatedomicilio($nombre_archivo, $id_usuario)
    {

        $query = $this->db->query(
            'UPDATE cv_contrato SET c_domicilio = ? WHERE id_usuario = ?',
            [$nombre_archivo, $id_usuario]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
    public function uploaddomicilio($id_usuario, $nombre_archivo)
    {
        $query = $this->db->query(
            "INSERT INTO cv_contrato (id_usuario, c_domicilio) VALUES (?, ?)",
            [$id_usuario, $nombre_archivo]);

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }
    }
    public function updateestudios($nombre_archivo, $id_usuario)
    {

        $query = $this->db->query(
            'UPDATE cv_contrato SET c_estudios = ? WHERE id_usuario = ?',
            [$nombre_archivo, $id_usuario]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
    public function uploadestudios($id_usuario, $nombre_archivo)
    {
        $query = $this->db->query(
            "INSERT INTO cv_contrato (id_usuario, c_estudios) VALUES (?, ?)",
            [$id_usuario, $nombre_archivo]);

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }
    }
    public function updaterfc($nombre_archivo, $id_usuario)
    {

        $query = $this->db->query(
            'UPDATE cv_contrato SET c_rfc = ? WHERE id_usuario = ?',
            [$nombre_archivo, $id_usuario]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
    public function uploadrfc($id_usuario, $nombre_archivo)
    {
        $query = $this->db->query(
            "INSERT INTO cv_contrato (id_usuario, c_rfc) VALUES (?, ?)",
            [$id_usuario, $nombre_archivo]);

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }
    }
    public function updatebancarios($nombre_archivo, $id_usuario)
    {

        $query = $this->db->query(
            'UPDATE cv_contrato SET d_bancarios = ? WHERE id_usuario = ?',
            [$nombre_archivo, $id_usuario]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
    public function uploadbancarios($id_usuario, $nombre_archivo)
    {
        $query = $this->db->query(
            "INSERT INTO cv_contrato (id_usuario, d_bancarios) VALUES (?, ?)",
            [$id_usuario, $nombre_archivo]);

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }
    }

    public function updatebeneficiario($nombre_archivo, $id_usuario)
    {

        $query = $this->db->query(
            'UPDATE cv_contrato SET c_beneficiario = ? WHERE id_usuario = ?',
            [$nombre_archivo, $id_usuario]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
    public function uploadbeneficiario($id_usuario, $nombre_archivo)
    {
        $query = $this->db->query(
            "INSERT INTO cv_contrato (id_usuario, c_beneficiario) VALUES (?, ?)",
            [$id_usuario, $nombre_archivo]);

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }
    }

    public function updateine($nombre_archivo, $id_usuario)
    {

        $query = $this->db->query(
            'UPDATE cv_contrato SET INE = ? WHERE id_usuario = ?',
            [$nombre_archivo, $id_usuario]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
    public function uploadine($id_usuario, $nombre_archivo)
    {
        $query = $this->db->query(
            "INSERT INTO cv_contrato (id_usuario, INE) VALUES (?, ?)",
            [$id_usuario, $nombre_archivo]);

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }
    }
    public function updatecurp($nombre_archivo, $id_usuario)
    {

        $query = $this->db->query(
            'UPDATE cv_contrato SET curp = ? WHERE id_usuario = ?',
            [$nombre_archivo, $id_usuario]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
    public function uploadcurp($id_usuario, $nombre_archivo)
    {
        $query = $this->db->query(
            "INSERT INTO cv_contrato (id_usuario, curp) VALUES (?, ?)",
            [$id_usuario, $nombre_archivo]);

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }
    }

    public function updateacta($nombre_archivo, $id_usuario)
    {

        $query = $this->db->query(
            'UPDATE cv_contrato SET acta_nacimiento = ? WHERE id_usuario = ?',
            [$nombre_archivo, $id_usuario]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
    public function uploadacta($id_usuario, $nombre_archivo)
    {
        $query = $this->db->query(
            "INSERT INTO cv_contrato (id_usuario, acta_nacimiento) VALUES (?, ?)",
            [$id_usuario, $nombre_archivo]);

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }
    }

    public function deletesistema($id_usuario)
    {
        

        $query = $this->db->query(
            'DELETE FROM colaboradores WHERE id = ?',
            [$id_usuario]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
}