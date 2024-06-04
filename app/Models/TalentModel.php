<?php

namespace App\Models;

use CodeIgniter\Model;

class TalentModel extends Model
{
    protected $table = 'preguntas_formularios';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_formulario', 'pregunta', 'A', 'B', 'C', 'D', 'E', 'F', 'numero'];

    public function saveForm($area, $vacante, $token, $clonado)
    {

        $data = [
            'area' => $area,
            'vacante' => $vacante,
            'token' => $token,
            'clonado' => $clonado,
        ];

        $this->db->table('formularios')
            ->insert($data);

        $lastId = $this->db->insertID();

        if ($lastId) {
            return $lastId; // Devuelve el último ID insertado
        } else {
            return false; // La consulta falló o no se generó un nuevo ID
        }
    }
    public function guardarPreguntas($id_encuesta, $preguntas, $opcionesA, $opcionesB, $opcionesC, $opcionesD, $opcionesE, $opcionesF, $numeros)
    {

        $data = [
            'id_formulario' => $id_encuesta,
            'pregunta' => $preguntas,
            'A' => $opcionesA,
            'B' => $opcionesB,
            'C' => $opcionesC,
            'D' => $opcionesD,
            'E' => $opcionesE,
            'F' => $opcionesF,
            'numero' => $numeros,
        ];

        $query = $this->db->table('preguntas_formularios')->insert($data);

        return $query;

    }
    public function saveCalendly($id_form)
    {
        $data = [
            'id_formulario' => $id_form,
            'calendly' => "Vacío"
        ];

        $query = $this->db->table('calendly')->insert($data);

        return $query;
    }
    public function updateCalendly($valor, $id)
    {
        $query = $this->db->query(
            'UPDATE calendly SET calendly = ? WHERE id_formulario = ?',
            [$valor, $id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
    public function getCandidatos($id)
    {
        //$query = $this->db->table('candidatos')->get();

        $query = $this->db->query('SELECT c.id, c.nombre, c.correo, c.cv, c.fecha_hora, f.vacante, pf.pregunta, rc.respuesta, v.viable as viable_no
        FROM candidatos c
        JOIN respuestas_candidatos rc ON c.id = rc.id_candidato
        JOIN preguntas_formularios pf ON rc.id_pregunta = pf.id
        JOIN formularios f ON pf.id_formulario = f.id 
        LEFT JOIN viables v ON v.id_candidato = c.id
        WHERE f.id = ?
        GROUP by c.id
        ORDER BY c.fecha_hora DESC', [$id]);

        return $query->getResult();
    }
    public function getCandidatosForms()
    {

        $query = $this->db->query('SELECT formularios.id, formularios.area, formularios.vacante, formularios.token,
        COUNT(DISTINCT candidatos.id) AS cantidad_candidatos, calendly.calendly
        FROM formularios 
        LEFT JOIN preguntas_formularios ON preguntas_formularios.id_formulario = formularios.id 
        LEFT JOIN respuestas_candidatos ON respuestas_candidatos.id_pregunta = preguntas_formularios.id 
        LEFT JOIN calendly ON calendly.id_formulario = formularios.id
        LEFT JOIN candidatos ON candidatos.id = respuestas_candidatos.id_candidato OR candidatos.id 
        NOT IN (SELECT DISTINCT id_candidato FROM respuestas_candidatos) GROUP BY formularios.id;');

        return $query->getResult();


    }
    public function getCandidatosViables()
    {

        $query = $this->db->query('SELECT formularios.id, formularios.area, formularios.vacante, formularios.token, 
        COUNT(DISTINCT candidatos.id) AS cantidad_candidatos 
        FROM formularios 
        LEFT JOIN preguntas_formularios ON preguntas_formularios.id_formulario = formularios.id 
        LEFT JOIN respuestas_candidatos ON respuestas_candidatos.id_pregunta = preguntas_formularios.id 
        LEFT JOIN candidatos ON candidatos.id = respuestas_candidatos.id_candidato 
        OR candidatos.id NOT IN (SELECT DISTINCT id_candidato FROM respuestas_candidatos) 
        LEFT JOIN viables ON viables.id_candidato = candidatos.id WHERE viables.viable = 1 GROUP BY formularios.id');

        return $query->getResult();


    }
    public function getForms()
    {

        $query = $this->db->table('formularios')->get();
        return $query->getResult();

    }
    public function getFormsID($token)
    {


        // // $query = $this->db->table('formularios')
        // //     ->join('preguntas_formularios', 'preguntas_formularios.id_formulario = formularios.id')
        // //     ->getWhere(['formularios.token' => $token]);

        // $result = $query->getResult();

        // return $result;

        $query = $this->db->query('SELECT formularios.*, formularios.id as id_form, preguntas_formularios.* 
        FROM formularios LEFT JOIN preguntas_formularios ON preguntas_formularios.id_formulario = formularios.id WHERE formularios.token = ?', [$token]);

        return $query->getResult();


    }
    public function guardarCandidatos($nombre, $correo, $nombre_doc, $fecha_hora)
    {

        $data = [
            'nombre' => $nombre,
            'correo' => $correo,
            'cv' => $nombre_doc,
            'fecha_hora' => $fecha_hora,
        ];

        $this->db->table('candidatos')
            ->insert($data);

        $lastId = $this->db->insertID();

        if ($lastId) {
            return $lastId; // Devuelve el último ID insertado
        } else {
            return false; // La consulta falló o no se generó un nuevo ID
        }

    }
    public function guardarRespuestaEncuesta($id_pregunta, $candidato_id, $respuesta)
    {

        $data = [
            'id_pregunta' => $id_pregunta,
            'id_candidato' => $candidato_id,
            'respuesta' => $respuesta,
        ];

        $query = $this->db->table('respuestas_candidatos')->insert($data);

        return $query;

    }
    public function savetpregunta($valor, $id)
    {

        $query = $this->db->query(
            'UPDATE preguntas_formularios SET pregunta = ? WHERE id = ?',
            [$valor, $id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
    public function savea($valor, $id)
    {

        $query = $this->db->query(
            'UPDATE preguntas_formularios SET A = ? WHERE id = ?',
            [$valor, $id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
    public function saveb($valor, $id)
    {

        $query = $this->db->query(
            'UPDATE preguntas_formularios SET B = ? WHERE id = ?',
            [$valor, $id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
    public function savec($valor, $id)
    {

        $query = $this->db->query(
            'UPDATE preguntas_formularios SET C = ? WHERE id = ?',
            [$valor, $id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
    public function saved($valor, $id)
    {

        $query = $this->db->query(
            'UPDATE preguntas_formularios SET D = ? WHERE id = ?',
            [$valor, $id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
    public function savee($valor, $id)
    {

        $query = $this->db->query(
            'UPDATE preguntas_formularios SET E = ? WHERE id = ?',
            [$valor, $id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
    public function savef($valor, $id)
    {

        $query = $this->db->query(
            'UPDATE preguntas_formularios SET F = ? WHERE id = ?',
            [$valor, $id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
    public function updateField($table, $field, $value, $id)
    {
        $query = $this->db->query(
            "UPDATE $table SET $field = ? WHERE id = ?",
            [$value, $id]
        );

        return $query ? true : false;
    }
    public function delPreguntas($id_pregunta)
    {
        $query = $this->db->query(
            'DELETE FROM preguntas_formularios WHERE id = ?',
            [$id_pregunta]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
    public function delForm($id)
    {


        $query = $this->db->query(
            'DELETE FROM formularios WHERE id = ?',
            [$id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
    public function guardarPregunta($id_formulario, $pregunta, $opciones, $numero)
    {

        // Construye el arreglo de datos para insertar
        $data = [
            'id_formulario' => $id_formulario,
            'pregunta' => $pregunta
        ];

        // Agrega las opciones A, B, C, D, E, F según corresponda
        foreach ($opciones as $key => $opcion) {
            $opcion_columna = chr(65 + $key); // Convierte el índice a letra (A, B, C, ...)
            $data[$opcion_columna] = $opcion;
        }

        // Agrega el número
        $data['numero'] = $numero;

        // Inserta los datos en la base de datos
        $query = $this->insert($data);

        return $query ? true : false; // Devuelve true si la inserción fue exitosa, de lo contrario, false


    }
    public function getDetailsCandidatos($id_candidato, $id_form)
    {
        //$query = $this->db->table('candidatos')->get();

        $query = $this->db->query('SELECT c.id, c.nombre, c.correo, c.cv, f.vacante, pf.pregunta, rc.respuesta, pf.numero
        FROM candidatos c 
        JOIN respuestas_candidatos rc 
        ON c.id = rc.id_candidato 
        JOIN preguntas_formularios pf 
        ON rc.id_pregunta = pf.id 
        JOIN formularios f 
        ON pf.id_formulario = f.id 
        WHERE c.id = ? AND f.id = ?', [$id_candidato, $id_form]);

        return $query->getResult();
    }
    public function delAplicant($id)
    {

        $query = $this->db->query(
            'DELETE candidatos FROM candidatos
            LEFT JOIN respuestas_candidatos ON respuestas_candidatos.id_candidato = candidatos.id
            WHERE candidatos.id = ?
            ',
            [$id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
    public function saveViable($id_candidato, $viable)
    {
        $data = ['id_candidato' => $id_candidato, 'viable' => $viable];

        $query = $this->db->table('viables')->insert($data);

        return $query;
    }
    public function getViable($id_candidato)
    {
        $query = $this->db->query('SELECT * FROM viables WHERE id_candidato = ?', [$id_candidato]);

        return $query->getResult();
    }
    public function updateViable($viable, $id_candidato)
    {
        $query = $this->db->query(
            'UPDATE viables SET viable = ? WHERE id_candidato = ?',
            [$viable, $id_candidato]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }
    }
    public function getCandidatosProceso($id)
    {
        $query = $this->db->query('SELECT 
        c.id, 
        c.nombre, 
        c.correo, 
        c.cv, 
        c.fecha_hora,
        f.vacante, 
        v.viable as viable_no, 
        v.viable_entre, 
        v.calificacion, 
        v.comentarios 
    FROM 
        candidatos c
        JOIN respuestas_candidatos rc ON c.id = rc.id_candidato
        JOIN preguntas_formularios pf ON rc.id_pregunta = pf.id
        JOIN formularios f ON pf.id_formulario = f.id 
        LEFT JOIN viables v ON v.id_candidato = c.id
    WHERE 
        f.id = ?
        AND v.viable = 1
        AND c.id NOT IN (SELECT pc.id_candidato FROM pruebas_candidatos pc)
    GROUP BY 
        c.id
        ORDER BY c.fecha_hora DESC', [$id]);

        return $query->getResult();
    }
    public function getCandidatoViable($id)
    {
        $query = $this->db->query('SELECT c.id, c.nombre, c.correo, c.cv, f.vacante, v.viable as viable_no
        FROM candidatos c
        JOIN respuestas_candidatos rc ON c.id = rc.id_candidato
        JOIN preguntas_formularios pf ON rc.id_pregunta = pf.id
        JOIN formularios f ON pf.id_formulario = f.id 
        LEFT JOIN viables v ON v.id_candidato = c.id
        WHERE c.id = ? AND v.viable = 1
        GROUP by c.id', [$id]);

        return $query->getResult();
    }
    public function updateCalificacion($cal, $calif_total, $coment, $id_user)
    {

        $query = $this->db->query(
            'UPDATE viables SET viable_entre = ?, calificacion = ?, comentarios = ? WHERE id_candidato = ?',
            [$cal, $calif_total, $coment, $id_user]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
    public function getCalendly()
    {
        $query = $this->db->query('SELECT formularios.*, formularios.id as id_cal, calendly.*  FROM formularios LEFT JOIN calendly ON calendly.id_formulario = formularios.id;');

        return $query->getResult();
    }
    public function getCalendlyForm($id_candidato)
    {

        $query = $this->db->query('SELECT c.*, ca.nombre, ca.correo 
        FROM calendly c
        LEFT JOIN formularios f ON f.id = c.id_formulario 
        LEFT JOIN preguntas_formularios pf ON pf.id_formulario = f.id 
        LEFT JOIN respuestas_candidatos rc ON rc.id_pregunta = pf.id 
        LEFT JOIN candidatos ca ON ca.id = rc.id_candidato 
        WHERE ca.id = ? 
        GROUP BY c.id', [$id_candidato]);

        return $query->getResult();

    }
    public function savePrueba($id_user, $f_inicio, $f_fin, $t_dias, $tipoPrueba, $actividades)
    {

        $data = [
            'id_candidato' => $id_user,
            'f_inicio' => $f_inicio,
            'f_fin' => $f_fin,
            't_dias' => $t_dias,
            't_prueba' => $tipoPrueba,
            'comentarios' => $actividades
        ];

        $query = $this->db->table('pruebas_candidatos')->insert($data);

        return $query;

    }
    public function getPruebas()
    {

        $query = $this->db->query('SELECT formularios.id, formularios.area, formularios.vacante, formularios.token, 
        COUNT(DISTINCT candidatos.id) AS cantidad_candidatos 
        FROM formularios 
        LEFT JOIN preguntas_formularios 
        ON preguntas_formularios.id_formulario = formularios.id 
        LEFT JOIN respuestas_candidatos ON respuestas_candidatos.id_pregunta = preguntas_formularios.id 
        LEFT JOIN candidatos ON candidatos.id = respuestas_candidatos.id_candidato 
        INNER JOIN pruebas_candidatos ON pruebas_candidatos.id_candidato = candidatos.id 
        LEFT JOIN viables ON viables.id_candidato = candidatos.id WHERE candidatos.id IS NOT NULL 
        GROUP BY formularios.id');

        return $query->getResult();
    }
    public function getPruebas1()
    {

        $query = $this->db->query('SELECT formularios.id, formularios.area, formularios.vacante, formularios.token, 
        COUNT(DISTINCT candidatos.id) AS cantidad_candidatos 
        FROM formularios 
        LEFT JOIN preguntas_formularios 
        ON preguntas_formularios.id_formulario = formularios.id 
        LEFT JOIN respuestas_candidatos ON respuestas_candidatos.id_pregunta = preguntas_formularios.id 
        LEFT JOIN candidatos ON candidatos.id = respuestas_candidatos.id_candidato 
        INNER JOIN pruebas_candidatos ON pruebas_candidatos.id_candidato = candidatos.id 
        LEFT JOIN viables ON viables.id_candidato = candidatos.id WHERE candidatos.id IS NOT NULL 
        AND pruebas_candidatos.viable_prueba = 1
        GROUP BY formularios.id');

        return $query->getResult();
    }
    public function getDetails($id_form)
    {
        $query = $this->db->query('SELECT c.nombre,c.fecha_hora, f.vacante, pc.* 
        FROM candidatos c JOIN respuestas_candidatos rc 
        ON c.id = rc.id_candidato 
        JOIN preguntas_formularios pf ON rc.id_pregunta = pf.id 
        JOIN formularios f ON pf.id_formulario = f.id 
        LEFT JOIN viables v ON v.id_candidato = c.id 
        LEFT JOIN pruebas_candidatos pc ON pc.id_candidato = c.id 
        WHERE f.id = ? 
        AND pc.id_candidato IS NOT NULL
        AND (pc.enlace_prueba IS NULL OR pc.viable_prueba IS NULL) 
        GROUP by c.id 
        ORDER BY c.fecha_hora DESC', [$id_form]);

        return $query->getResult();

        // $query = $this->db->table('candidatos c')
        //     ->select('c.nombre, c.fecha_hora, f.vacante, pc.*')
        //     ->join('respuestas_candidatos rc', 'c.id = rc.id_candidato')
        //     ->join('preguntas_formularios pf', 'rc.id_pregunta = pf.id')
        //     ->join('formularios f', 'pf.id_formulario = f.id')
        //     ->join('viables v', 'v.id_candidato = c.id', 'left')
        //     ->join('pruebas_candidatos pc', 'pc.id_candidato = c.id', 'left')
        //     ->where('f.id', $id_form)
        //     ->where('(pc.enlace_prueba IS NULL OR pc.viable_prueba IS NULL)')
        //     ->groupBy('c.id')
        //     ->orderBy('c.fecha_hora', 'DESC')
        //     ->get();

        // return $query->getResult();


    }
    public function getDetails1($id_form)
    {
        $query = $this->db->query('SELECT c.nombre,c.fecha_hora, f.vacante, pc.* 
        FROM candidatos c JOIN respuestas_candidatos rc 
        ON c.id = rc.id_candidato 
        JOIN preguntas_formularios pf ON rc.id_pregunta = pf.id 
        JOIN formularios f ON pf.id_formulario = f.id 
        LEFT JOIN viables v ON v.id_candidato = c.id 
        LEFT JOIN pruebas_candidatos pc ON pc.id_candidato = c.id 
        WHERE f.id = ? 
        AND pc.id_candidato IS NOT NULL
        AND pc.viable_prueba = 1
        GROUP by c.id 
        ORDER BY c.fecha_hora DESC', [$id_form]);

        return $query->getResult();

    }
    public function getDetails0($id_form)
    {
        $query = $this->db->query('SELECT c.nombre,c.fecha_hora, f.vacante, pc.* 
        FROM candidatos c JOIN respuestas_candidatos rc 
        ON c.id = rc.id_candidato 
        JOIN preguntas_formularios pf ON rc.id_pregunta = pf.id 
        JOIN formularios f ON pf.id_formulario = f.id 
        LEFT JOIN viables v ON v.id_candidato = c.id 
        LEFT JOIN pruebas_candidatos pc ON pc.id_candidato = c.id 
        WHERE f.id = ? 
        AND pc.id_candidato IS NOT NULL
        AND pc.viable_prueba = 0
        GROUP by c.id 
        ORDER BY c.fecha_hora DESC', [$id_form]);

        return $query->getResult();

    }
    public function updatePrueba($f_inicio, $f_fin, $t_dias, $tipoPrueba, $actividades, $enlace, $viable, $id_prueba)
    {

        $data = [
            'f_inicio' => $f_inicio,
            'f_fin' => $f_fin,
            't_dias' => $t_dias,
            't_prueba' => $tipoPrueba,
            'comentarios' => $actividades,
            'enlace_prueba' => $enlace,
            'viable_prueba' => $viable
        ];

        // Asumiendo que $id_prueba es la columna id de la tabla pruebas_candidatos
        $query = $this->db->table('pruebas_candidatos')
            ->where('id', $id_prueba)
            ->update($data);

        return $query;

    }
    public function delAplicantPrueba($id)
    {

        $query = $this->db->query(
            'DELETE FROM pruebas_candidatos WHERE id = ?',
            [$id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function getFinalCands($id_form)
    {

        $query = $this->db->query('SELECT c.nombre,c.fecha_hora, f.vacante, dc.tipo, pc.* 
        FROM candidatos c JOIN respuestas_candidatos rc 
        ON c.id = rc.id_candidato 
        JOIN preguntas_formularios pf ON rc.id_pregunta = pf.id 
        JOIN formularios f ON pf.id_formulario = f.id 
        LEFT JOIN viables v ON v.id_candidato = c.id 
        LEFT JOIN pruebas_candidatos pc ON pc.id_candidato = c.id 
        LEFT JOIN datos_candidatos dc ON dc.id_candidato = c.id 
        WHERE f.id = ?
        AND pc.id_candidato IS NOT NULL
        AND pc.viable_prueba = 1
        GROUP by c.id 
        ORDER BY c.fecha_hora DESC;', [$id_form]);

        return $query->getResult();

    }

    public function saveToken($id_candidato, $id_form, $token)
    {

        $query = $this->db->query('INSERT INTO datos_candidatos (id_candidato, id_form, token) VALUES (?, ?, ?)', [$id_candidato, $id_form, $token]);

        //return $query->getResult();
        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
    public function findToken($id_candidato, $id_form)
    {

        $query = $this->db->query('SELECT * FROM datos_candidatos WHERE id_candidato = ? AND id_form = ?', [$id_candidato, $id_form]);

        return $query->getResult();

    }

    public function updateType($tipo, $id_user)
    {

        $query = $this->db->query('UPDATE datos_candidatos SET tipo = ? WHERE id_candidato = ?', [$tipo, $id_user]);

        //return $query->getResult();
        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }
        
    }

    public function saveType($id_user, $id_form, $tipo, $newL)
    {

        $query = $this->db->query('INSERT INTO datos_candidatos (id_candidato, id_form, tipo, token) VALUES (?, ?, ?, ?)', [$id_user, $id_form, $tipo, $newL]);

        //return $query->getResult();
        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }


}
