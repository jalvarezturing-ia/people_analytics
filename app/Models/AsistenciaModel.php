<?php


namespace App\Models;

use CodeIgniter\Model;

class AsistenciaModel extends Model
{

    public function validates($fecha, $asistencia, $user_id)
    {

        $query = $this->db->query(
            'SELECT * FROM asistencia WHERE fecha = ? AND tipo_asistencia = ? AND id_usuario = ?',
            [$fecha, $asistencia, $user_id]
        );

        return $query->getResult();

    }
    public function saveinput($user_id, $fecha, $hora, $asistencia, $retardo, $permiso, $nombre_img)
    {
        $query = $this->db->query(
            'INSERT INTO asistencia (id_usuario, fecha, hora, tipo_asistencia, retardo, permiso, captura) VALUES (?, ?, ?, ?, ?, ?, ?) ',
            [$user_id, $fecha, $hora, $asistencia, $retardo, $permiso, $nombre_img]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }
    }
    public function validat($fecha, $asistencia, $user_id)
    {

        $query = $this->db->query(
            'SELECT * FROM asistencia WHERE fecha = ? AND tipo_asistencia = ? AND id_usuario = ?',
            [$fecha, $asistencia, $user_id]
        );

        return $query->getResult();

    }
    public function saveoutput($user_id, $fecha, $hora, $asistencia, $retardo, $permiso, $nombre_img)
    {
        $query = $this->db->query(
            'INSERT INTO asistencia (id_usuario, fecha, hora, tipo_asistencia, retardo, permiso, captura) VALUES (?, ?, ?, ?, ?, ?, ?) ',
            [$user_id, $fecha, $hora, $asistencia, $retardo, $permiso, $nombre_img]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }
    }
    public function getentrada($asistencia0, $user_id)
    {

        $query = $this->db->query(
            'SELECT * FROM asistencia WHERE asistencia.tipo_asistencia = ? AND asistencia.id_usuario = ?
             ORDER BY asistencia.fecha DESC
             ',
            [$asistencia0, $user_id]
        );

        return $query->getResult();

    }
    public function getsalida($asistencia1, $user_id)
    {

        $query = $this->db->query(
            'SELECT * FROM asistencia WHERE asistencia.tipo_asistencia = ? AND asistencia.id_usuario = ? GROUP BY asistencia.id',
            [$asistencia1, $user_id]
        );

        return $query->getResult();

    }
    public function getAllEntradas($fecha)
    {

        $query = $this->db->query("SELECT COUNT(DISTINCT asistencia.id_usuario) AS marcados, (SELECT COUNT(DISTINCT id) FROM colaboradores 
            WHERE nombre NOT IN ('turing-ia', 'Noe Alejandro', 'Jessica')) - COUNT(DISTINCT asistencia.id_usuario) AS no_marcados
            FROM colaboradores
            LEFT JOIN asistencia ON colaboradores.id = asistencia.id_usuario
            WHERE colaboradores.nombre NOT IN ('turing-ia', 'Noe Alejandro', 'Jessica')
            AND asistencia.fecha = ?
            AND asistencia.tipo_asistencia = 'Entrada' ORDER BY asistencia.hora DESC",
            [$fecha]
        );

        return $query->getResult();

    }
    public function getAllMarcas($fecha)
    {

        $query = $this->db->query("SELECT
        colaboradores.id AS id_marcados,
        colaboradores.nombre AS nombre_marcados,
        colaboradores.apellido_paterno AS apellido_paterno_marcados,
        asistencia.id AS id_asis_marcados,
        asistencia.hora AS hora_marcados,
        asistencia.fecha AS fecha_marcados,
        asistencia.captura AS captura_marcados,
        NULL AS id_no_marcados,
        NULL AS nombre_no_marcados,
        NULL AS apellido_paterno_no_marcados,
        NULL AS id_asis_no_marcados,
        NULL AS hora_no_marcados,
        NULL AS fecha_no_marcados,
        NULL AS captura_no_marcados
        FROM colaboradores
        LEFT JOIN asistencia ON colaboradores.id = asistencia.id_usuario
        WHERE colaboradores.nombre NOT IN ('turing-ia', 'Noe Alejandro', 'Jessica')
            AND asistencia.fecha = ?
            AND asistencia.tipo_asistencia = 'Entrada'
    
        UNION ALL
        
        SELECT
            NULL AS id_marcados,
            NULL AS nombre_marcados,
            NULL AS apellido_paterno_marcados,
            NULL AS id_asis_marcados, 
            NULL AS hora_marcados,
            NULL AS fecha_marcados,
            NULL AS captura_marcados,
            colaboradores.id AS id_no_marcados,
            colaboradores.nombre AS nombre_no_marcados,
            colaboradores.apellido_paterno AS apellido_paterno_no_marcados,
             NULL AS id_asis_no_marcados, 
            NULL AS hora_no_marcados,
            NULL AS fecha_no_marcados,
            NULL AS captura_no_marcados
        FROM colaboradores
        WHERE colaboradores.nombre NOT IN ('turing-ia', 'Noe Alejandro', 'Jessica')
            AND colaboradores.id NOT IN (
                SELECT DISTINCT asistencia.id_usuario
                FROM asistencia
                WHERE asistencia.fecha = ?
                AND asistencia.tipo_asistencia = 'Entrada'
            )
 
        ORDER BY hora_marcados DESC, nombre_no_marcados ASC;",
            [$fecha, $fecha]
        );

        return $query->getResult();

    }
    public function getAllSalidas($fecha)
    {

        $query = $this->db->query("SELECT COUNT(DISTINCT asistencia.id_usuario) AS marcados, (SELECT COUNT(DISTINCT id) FROM colaboradores 
            WHERE nombre NOT IN ('turing-ia', 'Noe Alejandro', 'Jessica')) - COUNT(DISTINCT asistencia.id_usuario) AS no_marcados
            FROM colaboradores
            LEFT JOIN asistencia ON colaboradores.id = asistencia.id_usuario
            WHERE colaboradores.nombre NOT IN ('turing-ia', 'Noe Alejandro', 'Jessica')
            AND asistencia.fecha = ?
            AND asistencia.tipo_asistencia = 'Salida' ORDER BY asistencia.hora DESC",
            [$fecha]
        );

        return $query->getResult();

    }
    public function getAllMarcasSalidas($fecha)
    {

        $query = $this->db->query("SELECT
        colaboradores.id AS id_marcados,
        colaboradores.nombre AS nombre_marcados,
        colaboradores.apellido_paterno AS apellido_paterno_marcados,
        asistencia.id AS id_asis_marcados,
        asistencia.hora AS hora_marcados,
        asistencia.fecha AS fecha_marcados,
        asistencia.captura AS captura_marcados,
        NULL AS id_no_marcados,
        NULL AS nombre_no_marcados,
        NULL AS apellido_paterno_no_marcados,
        NULL AS id_asis_no_marcados,
        NULL AS hora_no_marcados,
        NULL AS fecha_no_marcados,
        NULL AS captura_no_marcados
        FROM colaboradores
        LEFT JOIN asistencia ON colaboradores.id = asistencia.id_usuario
        WHERE colaboradores.nombre NOT IN ('turing-ia', 'Noe Alejandro', 'Jessica')
            AND asistencia.fecha = ?
            AND asistencia.tipo_asistencia = 'Salida'
    
        UNION ALL
        
        SELECT
            NULL AS id_marcados,
            NULL AS nombre_marcados,
            NULL AS apellido_paterno_marcados,
            NULL AS id_asis_marcados, 
            NULL AS hora_marcados,
            NULL AS fecha_marcados,
            NULL AS captura_marcados,
            colaboradores.id AS id_no_marcados,
            colaboradores.nombre AS nombre_no_marcados,
            colaboradores.apellido_paterno AS apellido_paterno_no_marcados,
             NULL AS id_asis_no_marcados, 
            NULL AS hora_no_marcados,
            NULL AS fecha_no_marcados,
            NULL AS captura_no_marcados
        FROM colaboradores
        WHERE colaboradores.nombre NOT IN ('turing-ia', 'Noe Alejandro', 'Jessica')
            AND colaboradores.id NOT IN (
                SELECT DISTINCT asistencia.id_usuario
                FROM asistencia
                WHERE asistencia.fecha = ?
                AND asistencia.tipo_asistencia = 'Salida'
            )
 
        ORDER BY hora_marcados DESC, nombre_no_marcados ASC;",
            [$fecha, $fecha]
        );

        return $query->getResult();

    }
    public function getHistory($fecha_inicio, $fecha_fin, $user_id, $tipo)
    {
        $query = $this->db->query(
            'SELECT * FROM asistencia WHERE asistencia.fecha >= ? AND asistencia.fecha <= ? AND asistencia.id_usuario = ? AND asistencia.tipo_asistencia = ?',
            [$fecha_inicio, $fecha_fin, $user_id, $tipo]
        );

        return $query->getResult();

    }
    public function updateCaptura($nombre_img, $id_hora)
    {

        $query = $this->db->query(
            'UPDATE asistencia SET captura = ? WHERE id = ?',
            [$nombre_img, $id_hora]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
    public function updateHora1($fecha_edit, $hora_actual, $captura, $id_user)
    {

        $query = $this->db->query(
            "UPDATE asistencia SET fecha = ?, hora = ?, captura = ? WHERE id = ?",
            [$fecha_edit, $hora_actual, $captura, $id_user]
        );

        //return $query->getResult();
        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
    public function updateHora2($fecha_edit, $hora_actual, $nombre_img, $id_user)
    {


        $query = $this->db->query(
            "UPDATE asistencia SET fecha = ?, hora = ?, captura = ? WHERE id = ?",
            [$fecha_edit, $hora_actual, $nombre_img, $id_user]
        );

        //return $query->getResult();
        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
    public function getInfo($user_id)
    {

        $query = $this->db->query(
            'SELECT colaboradores.nombre, colaboradores.apellido_paterno, colaboradores.apellido_materno, colaboradores.correo, areas.descripcion, areas.puesto FROM colaboradores INNER JOIN areas ON areas.id_usuario = colaboradores.id 
            WHERE colaboradores.id = ?',
            [$user_id]
        );

        return $query->getResult();

    }
    public function savePermit($user_id, $motivo, $f_salida_format, $f_regreso_format, $horas_reponer, $estado, $motivo1, $nombre_img, $resuelta, $reset)
    {

        $query = $this->db->query(
            'INSERT INTO incidencias_permisos (id_usuario, motivo, f_salida, f_regreso, horas_reponer, estado, descripcion, evidencia, resuelta, validadas) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [$user_id, $motivo, $f_salida_format, $f_regreso_format, $horas_reponer, $estado, $motivo1, $nombre_img, $resuelta, $reset]
        );

        //return $query->getResult();
        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
    public function getPendiente($user_id)
    {

        $query = $this->db->query(
            'SELECT * FROM incidencias_permisos WHERE estado = "Pendiente" AND motivo = "Permiso"  AND id_usuario = ?',
            [$user_id]
        );

        return $query->getResult();

    }
    public function getAutorizados($user_id)
    {

        $query = $this->db->query(
            'SELECT * FROM incidencias_permisos WHERE estado = "Aprobado" AND motivo = "Permiso"  AND id_usuario = ?',
            [$user_id]
        );

        return $query->getResult();

    }
    public function getAutorizados1($user_id)
    {

        $query = $this->db->query(
            'SELECT incidencias_permisos.*, incidencias_permisos.id as id_inc, reposicion.* 
            FROM incidencias_permisos LEFT JOIN reposicion 
            ON reposicion.id_motivo = incidencias_permisos.id 
            WHERE incidencias_permisos.estado = "Aprobado"
            AND incidencias_permisos.motivo = "Permiso" 
            AND incidencias_permisos.id_usuario = ? 
            ORDER BY incidencias_permisos.f_salida DESC;
            ',
            [$user_id]
        );

        return $query->getResult();

    }
    public function deleteP($id)
    {
        $query = $this->db->query(
            'DELETE FROM incidencias_permisos WHERE id = ? LIMIT 1',
            [$id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }
    }
    public function getPermisos()
    {

        $query = $this->db->query('SELECT colaboradores.nombre, colaboradores.apellido_paterno, datos_personales.foto_perfil, incidencias_permisos.* FROM incidencias_permisos
        INNER JOIN colaboradores ON colaboradores.id = incidencias_permisos.id_usuario
        INNER JOIN datos_personales ON datos_personales.id_usuario = colaboradores.id
        WHERE incidencias_permisos.estado = "Pendiente" AND motivo = "Permiso"
        ORDER BY colaboradores.apellido_paterno ASC'
        );

        return $query->getResult();

    }
    public function getAprobados()
    {

        $query = $this->db->query('SELECT colaboradores.nombre, colaboradores.apellido_paterno, datos_personales.foto_perfil, incidencias_permisos.* FROM incidencias_permisos
        INNER JOIN colaboradores ON colaboradores.id = incidencias_permisos.id_usuario
        INNER JOIN datos_personales ON datos_personales.id_usuario = colaboradores.id
        WHERE incidencias_permisos.estado = "Aprobado"  AND motivo = "Permiso"
        ORDER BY colaboradores.apellido_paterno ASC'
        );

        return $query->getResult();

    }
    public function saveAprob($text, $id_p)
    {
        $query = $this->db->query(
            'UPDATE incidencias_permisos set estado = ? WHERE id = ? LIMIT 1',
            [$text, $id_p]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
    public function updateEdit($motivo, $f_salida, $f_regreso, $horas_reponer, $captura, $permiso_id)
    {

        $query = $this->db->query(
            'UPDATE incidencias_permisos set descripcion = ?, f_salida = ?, f_regreso = ?, horas_reponer = ?, evidencia = ? WHERE id = ? LIMIT 1',
            [$motivo, $f_salida, $f_regreso, $horas_reponer, $captura, $permiso_id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
    public function saveIncidencia($user_id, $motivo, $f_salida_format, $f_regreso_format, $horas_reponer, $estado, $motivo1, $nombre_video, $resuelta, $reset)
    {

        $query = $this->db->query(
            'INSERT INTO incidencias_permisos (id_usuario, motivo, f_salida, f_regreso, horas_reponer, estado, descripcion, evidencia, resuelta, validadas) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?)',
            [$user_id, $motivo, $f_salida_format, $f_regreso_format, $horas_reponer, $estado, $motivo1, $nombre_video, $resuelta, $reset]
        );

        //return $query->getResult();
        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }


    }
    public function getReporte($user_id)
    {

        $query = $this->db->query(
            'SELECT * FROM incidencias_permisos WHERE motivo = "Incidencia" AND id_usuario = ? ORDER BY f_salida DESC',
            [$user_id]
        );

        return $query->getResult();

    }
    public function getReporte1($user_id)
    {

        $query = $this->db->query(
            'SELECT incidencias_permisos.*, incidencias_permisos.id as id_inc, reposicion.* 
            FROM incidencias_permisos LEFT JOIN reposicion 
            ON reposicion.id_motivo = incidencias_permisos.id 
            WHERE incidencias_permisos.validadas != "si"
            AND incidencias_permisos.id_usuario = ?
            ORDER BY incidencias_permisos.f_salida DESC',
            [$user_id]
        );

        return $query->getResult();

    }
    public function deletePP($id)
    {
        $query = $this->db->query(
            'DELETE FROM incidencias_permisos WHERE id = ? LIMIT 1',
            [$id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }
    }
    public function closeIncidencia($f_regreso_format, $horas_reponer, $nombre_video, $resuelta, $id_incidencia)
    {

        $query = $this->db->query(
            'UPDATE incidencias_permisos SET f_regreso = ?, horas_reponer = ?, evidencia = ?, resuelta = ? WHERE id = ?',
            [$f_regreso_format, $horas_reponer, $nombre_video, $resuelta, $id_incidencia]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
    public function getid($user_id, $id_dato)
    {

        $query = $this->db->query(
            'SELECT incidencias_permisos.*, reposicion.h_reponer, reposicion.h_restantes, reposicion.forma FROM incidencias_permisos 
            LEFT JOIN reposicion ON reposicion.id_motivo = incidencias_permisos.id
            WHERE id_usuario = ? AND incidencias_permisos.id = ?
            GROUP BY f_salida DESC;',
            [$user_id, $id_dato]
        );

        return $query->getResult();

    }
    public function saveRepo($id_dato, $f_salida_format, $f_regreso_format, $horas_reponer, $horas_restantes, $forma)
    {

        $query = $this->db->query(
            'INSERT INTO reposicion (id_motivo, fecha_inicio, fecha_fin, h_reponer, h_restantes, forma) VALUES (?, ?, ?, ?, ?, ?)',
            [$id_dato, $f_salida_format, $f_regreso_format, $horas_reponer, $horas_restantes, $forma]
        );

        //return $query->getResult();
        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
    public function getProceso($user_id)
    {
        $query = $this->db->query(
            'SELECT reposicion.*, reposicion.id as id_repo, incidencias_permisos.motivo, incidencias_permisos.horas_reponer FROM reposicion LEFT JOIN incidencias_permisos
            ON incidencias_permisos.id = reposicion.id_motivo
            WHERE incidencias_permisos.id_usuario = ?
            AND reposicion.finalizado != "1"
            ORDER BY reposicion.fecha_inicio DESC;',
            [$user_id]
        );

        return $query->getResult();
    }
    public function getRepuestas($user_id)
    {
        $query = $this->db->query('SELECT reposicion.*, incidencias_permisos.* FROM reposicion LEFT JOIN incidencias_permisos
            ON incidencias_permisos.id = reposicion.id_motivo
            WHERE incidencias_permisos.id_usuario = ?
            AND reposicion.finalizado >= "1"
            ORDER BY reposicion.fecha_inicio DESC;',
            [$user_id]
        );

        return $query->getResult();
    }
    public function detalleProceso($id_dato, $id_user)
    {

        $query = $this->db->query(
            'SELECT * FROM reposicion INNER JOIN incidencias_permisos 
            ON incidencias_permisos.id = reposicion.id_motivo WHERE reposicion.id = ? AND incidencias_permisos.id_usuario = ?',
            [$id_dato, $id_user]
        );

        return $query->getResult();



    }
    public function saveHoras($finalizado, $nombre_img, $nombre_img1, $id_dato)
    {
        $query = $this->db->query(
            'UPDATE reposicion set finalizado = ?, evidencia_inic = ?, evidencia_fin = ? WHERE id = ? LIMIT 1',
            [$finalizado, $nombre_img, $nombre_img1, $id_dato]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }
    }
    public function updateStatus($reset, $id_dato)
    {
        $query = $this->db->query(
            'UPDATE incidencias_permisos INNER JOIN reposicion ON reposicion.id_motivo = incidencias_permisos.id
            SET incidencias_permisos.validadas = ? WHERE reposicion.id = ? LIMIT 1',
            [$reset, $id_dato]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }
    }
    public function getIncidencias()
    {

        $query = $this->db->query('SELECT colaboradores.nombre, colaboradores.apellido_paterno, incidencias_permisos.id as id_inc ,incidencias_permisos.*, reposicion.* FROM incidencias_permisos
        LEFT JOIN reposicion ON reposicion.id_motivo = incidencias_permisos.id
        LEFT JOIN colaboradores ON colaboradores.id = incidencias_permisos.id_usuario
        WHERE incidencias_permisos.motivo = "Incidencia"
        GROUP BY incidencias_permisos.id;');

        return $query->getResult();


    }

    public function updateIncidente($f_salida, $f_regreso, $horas_reponer, $descripcion, $nombre_video, $id_dato)
    {

        $query = $this->db->query(
            'UPDATE incidencias_permisos set f_salida = ?, f_regreso = ?, horas_reponer = ?, descripcion = ?, evidencia = ? WHERE id = ? LIMIT 1',
            [$f_salida, $f_regreso, $horas_reponer, $descripcion, $nombre_video, $id_dato]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function getRepo()
    {

        $query = $this->db->query('SELECT colaboradores.nombre, colaboradores.apellido_paterno, areas.descripcion as area_desc, incidencias_permisos.id as id_inc, incidencias_permisos.*, reposicion.* FROM incidencias_permisos
        INNER JOIN reposicion ON reposicion.id_motivo = incidencias_permisos.id
        INNER JOIN colaboradores ON colaboradores.id = incidencias_permisos.id_usuario
        INNER JOIN areas ON areas.id_usuario = colaboradores.id
        GROUP BY reposicion.id;');

        return $query->getResult();

    }

    public function saveFines($user_id,$año,$mes,$f_salida_format,$f_regreso_format,$horas_trabajar,$jornada) 
    {

        $query = $this->db->query('INSERT INTO dias_extras (id_usuario, año, mes, f_inicio, f_fin, h_trabajar, jornada) VALUES (?,?,?,?,?,?,?)',
            [$user_id,$año,$mes,$f_salida_format,$f_regreso_format,$horas_trabajar,$jornada]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function getDias($user_id)
    {

        $query = $this->db->query('SELECT * FROM dias_extras WHERE id_usuario = ?',[$user_id]);

        return $query->getResult();

    }

    public function saveDias($nombre_img, $nombre_img1, $actividades, $id_dato)
    {

        $query = $this->db->query('UPDATE dias_extras set evidencia_inic = ?, evidencia_fin = ?, actividades = ? WHERE id = ? LIMIT 1',
            [$nombre_img, $nombre_img1, $actividades, $id_dato]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function getAllDias()
    {

        $query = $this->db->query('SELECT dias_extras.id as dias_id, dias_extras.año, dias_extras.mes, colaboradores.id as id_colab, COUNT(*) AS total_registros FROM dias_extras LEFT JOIN colaboradores ON dias_extras.id_usuario = colaboradores.id
        GROUP BY dias_extras.año, dias_extras.mes');

        return $query->getResult();

    }
    public function getAllDiass($año, $mes)
    {

        $query = $this->db->query('SELECT dias_extras.*, colaboradores.* FROM dias_extras LEFT JOIN colaboradores ON dias_extras.id_usuario = colaboradores.id WHERE
        dias_extras.año = ? AND dias_extras.mes = ?
        ',[$año, $mes]);

        return $query->getResult();

    }

    public function getInfo1($user_id)
    {

        $query = $this->db->query(
            'SELECT colaboradores.nombre, colaboradores.apellido_paterno, colaboradores.apellido_materno, colaboradores.correo, areas.descripcion, areas.puesto, datos_personales.fecha_ingreso FROM colaboradores INNER JOIN areas ON areas.id_usuario = colaboradores.id 
            INNER JOIN datos_personales ON datos_personales.id_usuario = colaboradores.id WHERE colaboradores.id = ?',
            [$user_id]
        );

        return $query->getResult();

    }

    public function getVacaciones($user_id)
    {

        $query = $this->db->query(
            'SELECT * FROM vacaciones WHERE id_usuario = ? ORDER BY restantes ASC LIMIT 1',
            [$user_id]
        );

        return $query->getResult();

    }
    public function getVacacioness($user_id)
    {

        $query = $this->db->query(
            'SELECT * FROM vacaciones WHERE id_usuario = ? ORDER BY restantes ASC',
            [$user_id]
        );

        return $query->getResult();

    }

    public function savevacas($user_id, $totales, $restantes, $f_inicio, $f_fin, $d_solicitados, $nombre_doc)
    {

        $query = $this->db->query('INSERT INTO `vacaciones`(`id_usuario`, `d_totales`, `restantes`, `f_inicio`, `f_fin`, `d_solicitados`, documento) VALUES (?,?,?,?,?,?,?)',
            [$user_id, $totales, $restantes, $f_inicio, $f_fin, $d_solicitados, $nombre_doc]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
    public function savevacasedit($restantes, $f_inicio, $f_fin, $d_solicitados,  $nombre_doc ,$id_dato)
    {

        $query = $this->db->query('UPDATE vacaciones SET restantes = ?, f_inicio = ?, f_fin = ?, d_solicitados = ?, documento = ? WHERE id = ?',
            [$restantes, $f_inicio, $f_fin, $d_solicitados,  $nombre_doc, $id_dato, ]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function eliminarV($id_per)
    {


        $query = $this->db->query(
            'DELETE FROM vacaciones WHERE id = ? LIMIT 1',
            [$id_per]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function getVacacionesAdm()
    {

        $query = $this->db->query(
            'SELECT vacaciones.*, colaboradores.nombre, colaboradores.apellido_paterno FROM vacaciones 
            INNER JOIN colaboradores ON colaboradores.id = vacaciones.id_usuario
            ORDER BY restantes ASC'
        );

        return $query->getResult();

    }

    public function setUpdates($estado, $id_periodo)
    {

        $query = $this->db->query('UPDATE vacaciones SET estado = ? WHERE id = ?',
            [$estado, $id_periodo]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }



}