<?php


namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{

    public function login($email)
    {
        $query = $this->db->query('SELECT colaboradores.id, colaboradores.nombre, colaboradores.correo, 
        colaboradores.password, areas.descripcion, areas.puesto, colaboradores.rol, colaboradores.ip
        FROM colaboradores
        INNER JOIN areas ON colaboradores.id = areas.id_usuario 
        LEFT JOIN datos_personales ON datos_personales.id_usuario = colaboradores.id
        WHERE colaboradores.correo = ?
        AND datos_personales.fecha_egreso = 0',
        [$email]
        );

        return $query->getResult();
    }
    public function modulo()
    {
        $query = $this->db->query('SELECT * FROM modulos'
        );

        return $query->getResult();
    }

    public function userPerfil($email)
    {
        $query = $this->db->query('SELECT datos_personales.*, colaboradores.nombre 
        FROM datos_personales 
        INNER JOIN colaboradores ON datos_personales.id_usuario = colaboradores.id 
        WHERE colaboradores.correo =  ?',
        [$email]
        );

        return $query->getResult();
    }

    public function account($user_id)
    {
        $query = $this->db->query('SELECT colaboradores.id as id_user, colaboradores.*, areas.*, areas.puesto, datos_personales.* 
        FROM colaboradores INNER JOIN areas 
        ON colaboradores.id = areas.id_usuario 
        INNER JOIN datos_personales 
        ON datos_personales.id_usuario = colaboradores.id
        WHERE colaboradores.id = ?',
        [$user_id]
        );

        return $query->getResult();
    }
    public function updatausers($nuevo_pass, $user_id, $correo)
    {

        $query = $this->db->query(
            'UPDATE colaboradores SET password = ? WHERE id = ? AND correo = ?',
            [$nuevo_pass, $user_id, $correo]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function savephoto($nombre_img, $user_id)
    {
        $query = $this->db->query('UPDATE datos_personales SET datos_personales.foto_perfil = ?
             WHERE datos_personales.id_usuario = ?
             AND EXISTS (SELECT 1 FROM colaboradores WHERE colaboradores.id = datos_personales.id_usuario);',
            [$nombre_img, $user_id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }
    }

    public function verDoc($id_usuario)
    {

        $query = $this->db->query('SELECT id, id_usuario, curriculum_vitae FROM cv_contrato WHERE id_usuario = ?',
        [$id_usuario]
        );

        return $query->getResult();

    }

    public function countdoc($id_usuario)
    {
        $query = $this->db->query("SELECT count(id_usuario) as 'total' FROM cv_contrato WHERE id_usuario = ?",
        [$id_usuario]
         );

        return $query->getResult();
    }

    public function updatedoc($nombre_archivo, $id_usuario)
    {

        $query = $this->db->query(
            'UPDATE cv_contrato SET curriculum_vitae = ? WHERE id_usuario = ?',
            [$nombre_archivo, $id_usuario]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function uploaddoc($id_usuario, $nombre_archivo)
    {
        $query = $this->db->query(
            "INSERT INTO cv_contrato (id_usuario, curriculum_vitae) VALUES (?, ?)",
            [$id_usuario, $nombre_archivo]);

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }
    }

    public function verContrato($id_usuario)
    {

        $query = $this->db->query('SELECT id, id_usuario, contrato_vitae FROM cv_contrato WHERE id_usuario = ?',
        [$id_usuario]
        );

        return $query->getResult();

    }


    public function countcontract($id_usuario)
    {
        $query = $this->db->query("SELECT count(id_usuario) as 'total' FROM cv_contrato WHERE id_usuario = ?",
        [$id_usuario]
         );

        return $query->getResult();
    }

    public function updatecontract($nombre_archivo, $id_usuario)
    {

        $query = $this->db->query(
            'UPDATE cv_contrato SET contrato_vitae = ? WHERE id_usuario = ?',
            [$nombre_archivo, $id_usuario]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function uploadcontract($id_usuario, $nombre_archivo)
    {
        $query = $this->db->query(
            "INSERT INTO cv_contrato (id_usuario, contrato_vitae) VALUES (?, ?)",
            [$id_usuario, $nombre_archivo]);

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }
    }

    public function search($correo, $telefono)
    {
       
        $query = $this->db->query('SELECT colaboradores.id, colaboradores.nombre, datos_personales.telefono, correo 
        FROM colaboradores 
        JOIN datos_personales ON datos_personales.id_usuario = colaboradores.id WHERE correo = ? AND telefono = ?',
        [$correo, $telefono]);

        return $query->getResult();
    }

    public function savePassword($nuevo_pass, $token, $id_usuario)
    {

        $query = $this->db->query(
            'UPDATE colaboradores SET password = ?, token_password = ? WHERE id = ?',
            [$nuevo_pass, $token, $id_usuario]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
    public function saveToken($token, $telefono)
    {

        $query = $this->db->query('UPDATE colaboradores JOIN datos_personales ON datos_personales.id_usuario = colaboradores.id SET token_password = ? WHERE telefono = ?',
            [$token, $telefono]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function searchToken($id)
    {

        $query = $this->db->query('SELECT token_password FROM colaboradores WHERE id = ?',
        [$id]);
    

        return $query->getResult();

    }

}

?>