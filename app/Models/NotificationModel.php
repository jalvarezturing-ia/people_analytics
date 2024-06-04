<?php


namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{

    public function asistencia()
    {

        // Realizar la primera consulta
        $query = $this->db->query('SELECT * FROM asistencia WHERE fecha = CURDATE() ORDER BY fecha DESC LIMIT 5');
        $asistencia = $query->getResult();

        // Realizar la segunda consulta
        $query1 = $this->db->query('SELECT * FROM incidencias_permisos WHERE DATE(f_salida) = CURDATE() ORDER BY TIME(f_salida) ASC LIMIT 5');
        $incidencias_permisos = $query1->getResult();

        // Devolver ambos resultados en un array
        return [
            'asistencia' => $asistencia,
            'incidencias_permisos' => $incidencias_permisos
        ];


    }



}

?>