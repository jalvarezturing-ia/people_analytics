<?php

namespace App\Models;

use CodeIgniter\Model;

class PerformanceModel extends Model
{

    public function getFeedbacks($id_usuario)
    {

        $query = $this->db->query('SELECT 
             h1.foto_perfil AS foto_autor, 
            c1.nombre AS n_autor, 
            c1.apellido_paterno AS ap_autor, 
            c1.correo AS correo_autor,
            h2.foto_perfil AS foto_usuario, 
            c2.nombre AS n_usuario, 
            c2.apellido_paterno AS ap_usuario, 
            c2.correo AS correo_usuario, 
            f.*
        FROM 
            feedbacks f
        INNER JOIN 
            colaboradores c1 ON f.id_autor = c1.id /*autor*/
        INNER JOIN 
            colaboradores c2 ON f.id_usuario = c2.id /*usuario*/
        INNER JOIN 
        	datos_personales h1 ON h1.id_usuario = c1.id /*autor*/
        INNER JOIN 
            datos_personales h2 ON h2.id_usuario = c2.id /*usuario*/
        WHERE 
            f.id_usuario = ? OR f.id_autor = ? /*Recupera los feedbacks donde eres el usuario o el autor*/
        ORDER BY 
            f.fecha_creacion DESC', [$id_usuario, $id_usuario]);

        return $query->getResult();

    }
    public function getComents()
    {

        $query = $this->db->query('SELECT colaboradores.nombre as n_autor, colaboradores.apellido_paterno as ap_autor, respuestas_fed.*
        FROM colaboradores 
        INNER JOIN respuestas_fed ON respuestas_fed.id_autor = colaboradores.id
        LEFT JOIN feedbacks ON feedbacks.id = respuestas_fed.fed_id');

        return $query->getResult();

    }

    public function saveComentario($contenido, $id_feedback, $id_autor, $fecha_creacion_format)
    {
        $query = $this->db->query(
            'INSERT INTO respuestas_fed (contenido, fed_id, id_autor, fecha_creacion) VALUES (?,?,?,?)',
            [$contenido, $id_feedback, $id_autor, $fecha_creacion_format]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }
    }
    public function delComentario($id)
    {
        $query = $this->db->query(
            'DELETE FROM respuestas_fed WHERE id = ?',
            [$id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }
    }

    public function getAllFeedbacks()
    {

        $query = $this->db->query('SELECT 
             h1.foto_perfil AS foto_autor, 
            c1.nombre AS n_autor, 
            c1.apellido_paterno AS ap_autor, 
            c1.correo AS correo_autor,
            h2.foto_perfil AS foto_usuario, 
            c2.nombre AS n_usuario, 
            c2.apellido_paterno AS ap_usuario, 
            c2.correo AS correo_usuario, 
            f.*
        FROM 
            feedbacks f
        INNER JOIN 
            colaboradores c1 ON f.id_autor = c1.id /*autor*/
        INNER JOIN 
            colaboradores c2 ON f.id_usuario = c2.id /*usuario*/
        INNER JOIN 
        	datos_personales h1 ON h1.id_usuario = c1.id /*autor*/
        INNER JOIN 
            datos_personales h2 ON h2.id_usuario = c2.id /*usuario*/
        ORDER BY 
            f.fecha_creacion DESC');

        return $query->getResult();

    }

    public function savefeedback($id_usuario, $id_autor, $titulo, $contenido, $fecha_creacion_format, $privacidad)
    {

        $query = $this->db->query(
            'INSERT INTO feedbacks (id_usuario, id_autor, titulo, contenido, fecha_creacion, privacidad) VALUES (?,?,?,?,?,?)',
            [$id_usuario, $id_autor, $titulo, $contenido, $fecha_creacion_format, $privacidad]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function deletefed($id)
    {

        $query = $this->db->query(
            'DELETE FROM feedbacks WHERE id = ?',
            [$id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function getFed($id)
    {

        $query = $this->db->query('SELECT feedbacks.id as id_fed, feedbacks.* FROM `feedbacks` 
       
        WHERE feedbacks.id = ?', [$id]);

        return $query->getResult();

    }

    public function savefeedbackchages($titulo, $contenido, $privacidad, $id_fed)
    {

        $query = $this->db->query(
            'UPDATE feedbacks SET titulo = ?, contenido = ?, privacidad = ? WHERE id = ?',
            [$titulo, $contenido, $privacidad, $id_fed]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function modulos($id_periodo)
    {

        $query = $this->db->query(
            'UPDATE modulos SET estado = ?',
            [$id_periodo]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function getEvents($id_usuario)
    {

        $query = $this->db->query('SELECT * FROM `eventos` WHERE id_usuario = ?', [$id_usuario]);

        return $query->getResult();

    }

    public function savecalendarEdit($start, $end, $id)
    {

        $query = $this->db->query(
            'UPDATE eventos SET f_inicio = ?, f_fin = ? WHERE id = ?',
            [$start, $end, $id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function saveCalendar($id_usuario, $title, $color, $ubicacion, $start, $end)
    {

        $query = $this->db->query(
            'INSERT INTO eventos (id_usuario, titulo, color, ubicacion, f_inicio, f_fin) VALUES (?,?,?,?,?,?)',
            [$id_usuario, $title, $color, $ubicacion, $start, $end]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function delEvent($id)
    {

        $query = $this->db->query(
            'DELETE FROM eventos WHERE id = ?',
            [$id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function updateEvent($title, $color, $ubicacion, $id)
    {
        $query = $this->db->query(
            'UPDATE eventos SET titulo = ?, color = ?, ubicacion = ? WHERE id = ?',
            [$title, $color, $ubicacion, $id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function insertHabi($id_usuario, $data, $tipo)
    {

        $query = $this->db->query(
            'INSERT INTO habilidades (id_usuario, habilidad, tipo) VALUES (?,?,?)',
            [$id_usuario, $data, $tipo]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

        /*echo "<pre>";
        print_r($data);
        print_r($id_usuario);
        echo "</pre>";
        exit();*/
    }

    public function getHabilidades($id_usuario)
    {

        $query = $this->db->query('SELECT * FROM `habilidades` WHERE id_usuario = ?', [$id_usuario]);

        return $query->getResult();

    }

    public function delHabi($id)
    {

        $query = $this->db->query(
            'DELETE FROM habilidades WHERE id = ?',
            [$id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }


    }

    public function updHabi($valor, $id)
    {

        $query = $this->db->query(
            'UPDATE habilidades set habilidad  = ? WHERE id = ?',
            [$valor, $id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function saveMeta($id, $tipo, $tema, $url, $tiempo, $inicio, $fin, $observaciones, $estado)
    {

        $query = $this->db->query(
            'INSERT INTO cursos (id_usuario, tipo, tema, url_curso, tiempo, f_inicio, f_fin, observaciones, estado) VALUES (?,?,?,?,?,?,?,?,?)',
            [$id, $tipo, $tema, $url, $tiempo, $inicio, $fin, $observaciones, $estado]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function getCursos($id_usuario)
    {

        $query = $this->db->query('SELECT * FROM `cursos` WHERE id_usuario = ?', [$id_usuario]);

        return $query->getResult();

    }


    public function updCurso($valor, $id)
    {

        $query = $this->db->query(
            'UPDATE cursos set estado  = ? WHERE id = ?',
            [$valor, $id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function delCurso($id)
    {

        $query = $this->db->query(
            'DELETE FROM cursos WHERE id = ?',
            [$id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }


    }
    public function delObject($id)
    {

        $query = $this->db->query(
            'DELETE FROM objetivos WHERE id = ?',
            [$id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }


    }

    public function saveObjet($id, $titulo, $f_inicio, $f_fin, $descripcion, $estado, $porcentaje)
    {

        $query = $this->db->query(
            'INSERT INTO objetivos (id_usuario, titulo, fecha_inicio, fecha_fin, descripcion, estado, porcentaje) VALUES (?,?,?,?,?,?,?)',
            [$id, $titulo, $f_inicio, $f_fin, $descripcion, $estado, $porcentaje]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function getObjetivos($id)
    {
        $query = $this->db->query('SELECT * FROM objetivos WHERE id_usuario = ?', [$id]);

        return $query->getResult();

    }

    public function updObjEstado($valor, $id)
    {
        $query = $this->db->query(
            'UPDATE objetivos set estado  = ? WHERE id = ?',
            [$valor, $id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function updObjProgress($valor, $id)
    {
        $query = $this->db->query(
            'UPDATE objetivos set porcentaje  = ? WHERE id = ?',
            [$valor, $id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function getOnboarding($id)
    {

        $query = $this->db->query('SELECT * FROM onboardings WHERE id_usuario = ?', [$id]);

        return $query->getResult();

    }
    public function getOnboardingActivities($id)
    {

        $query = $this->db->query('SELECT actividades_onboarding.* FROM actividades_onboarding LEFT JOIN onboardings ON onboardings.id = actividades_onboarding.id_onboarding WHERE actividades_onboarding.id_onboarding = ?', [$id]);

        return $query->getResult();

    }

    public function saveOnboarding($id, $titulo, $f_inicio, $estado)
    {

        $query = $this->db->query(
            'INSERT INTO onboardings (id_usuario, titulo, fecha_inicio, estado) VALUES (?,?,?,?)',
            [$id, $titulo, $f_inicio, $estado]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function saveOnboardingEdit($fin, $valor, $id)
    {


        $query = $this->db->query(
            'UPDATE onboardings SET fecha_fin = ?, estado = ? WHERE id = ?',
            [$fin, $valor, $id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function insertonboardings($id, $habilidad)
    {

        $query = $this->db->query(
            'INSERT INTO actividades_onboarding (id_onboarding, actividad, estado) VALUES (?,?,0)',
            [$id, $habilidad]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function savelistEdit($valor, $id)
    {

        $query = $this->db->query(
            'UPDATE actividades_onboarding SET actividad = ? WHERE id = ?',
            [$valor, $id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
    public function savelistEdit1($valor, $id)
    {

        $query = $this->db->query(
            'UPDATE actividades_onboarding SET estado = ? WHERE id = ?',
            [$valor, $id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function saveOnboardingEditData($titulo, $f_inicio, $f_fin, $id)
    {

        $query = $this->db->query(
            'UPDATE onboardings SET titulo = ?, fecha_inicio = ?, fecha_fin = ? WHERE id = ?',
            [$titulo, $f_inicio, $f_fin, $id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }
    }


    public function delOnboarding($id)
    {

        $query = $this->db->query(
            'DELETE FROM onboardings WHERE id = ?',
            [$id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function delOnboardingActivity($id)
    {
        $query = $this->db->query(
            'DELETE FROM actividades_onboarding WHERE id = ?',
            [$id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function saveencuesta($titulo, $subtitulo)
    {

        $data = [
            'titulo' => $titulo,
            'subtitulo' => $subtitulo,
            'estado' => 'Pendiente'
        ];

        $this->db->table('encuesta')
            ->insert($data);

        $lastId = $this->db->insertID();

        if ($lastId) {
            return $lastId; // Devuelve el último ID insertado
        } else {
            return false; // La consulta falló o no se generó un nuevo ID
        }

    }

    public function getEncuestasAdmin()
    {

        $query = $this->db->query('SELECT encuesta.id as id_encuesta, encuesta.*, asignados_cuestionarios.*, colaboradores.nombre
        FROM encuesta
        LEFT JOIN asignados_cuestionarios ON asignados_cuestionarios.id_cuestionario = encuesta.id
        LEFT JOIN respuestas_encuestas ON respuestas_encuestas.id_encuesta = encuesta.id AND respuestas_encuestas.id_usuario = asignados_cuestionarios.id_usuarios
        LEFT JOIN colaboradores ON colaboradores.id = asignados_cuestionarios.id_usuarios
        WHERE respuestas_encuestas.id_encuesta IS NULL GROUP BY encuesta.id;');

        return $query->getResult();
    }
    public function getEncuestasAdminRespondidas()
    {

        $query = $this->db->query('SELECT encuesta.id as id_encuesta, encuesta.*, asignados_cuestionarios.*, respuestas_encuestas.*, colaboradores.nombre
        FROM encuesta
        LEFT JOIN asignados_cuestionarios ON asignados_cuestionarios.id_cuestionario = encuesta.id
        LEFT JOIN respuestas_encuestas ON respuestas_encuestas.id_encuesta = encuesta.id
        INNER JOIN colaboradores ON colaboradores.id = asignados_cuestionarios.id_usuarios
        GROUP BY encuesta.id
        HAVING COUNT(DISTINCT asignados_cuestionarios.id_usuarios) = COUNT(DISTINCT respuestas_encuestas.id_usuario)');

        return $query->getResult();
    }

    public function getEncuestasAdminId($id)
    {
        $query = $this->db->query('SELECT * FROM encuesta WHERE id = ?', [$id]);

        return $query->getResult();
    }
    public function getPreguntasAdminId($id)
    {
        $query = $this->db->query('SELECT * FROM preguntas_encuestas WHERE id_encuesta = ?', [$id]);

        return $query->getResult();
    }

    public function guardarPreguntas($id_encuesta, $opcionesA, $opcionesB, $opcionesC, $opcionesD, $preguntas, $numeros)
    {

        $data = [
            'id_encuesta' => $id_encuesta,
            'A' => $opcionesA,
            'B' => $opcionesB,
            'C' => $opcionesC,
            'D' => $opcionesD,
            'pregunta' => $preguntas,
            'numero' => $numeros,

        ];

        $query = $this->db->table('preguntas_encuestas')->insert($data);

        return $query;

    }

    public function delEncuesta($id)
    {

        $query = $this->db->query(
            'DELETE FROM encuesta WHERE id = ?',
            [$id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function savetitleencuesta($valor, $id)
    {

        $query = $this->db->query(
            'UPDATE encuesta SET titulo = ? WHERE id = ?',
            [$valor, $id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
    public function savetitlepregunta($valor, $id)
    {

        $query = $this->db->query(
            'UPDATE preguntas_encuestas SET pregunta = ? WHERE id = ?',
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
            'UPDATE preguntas_encuestas SET A = ? WHERE id = ?',
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
            'UPDATE preguntas_encuestas SET B = ? WHERE id = ?',
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
            'UPDATE preguntas_encuestas SET C = ? WHERE id = ?',
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
            'UPDATE preguntas_encuestas SET D = ? WHERE id = ?',
            [$valor, $id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }
    public function savedescripcion($valor, $id)
    {

        $query = $this->db->query(
            'UPDATE encuesta SET subtitulo = ? WHERE id = ?',
            [$valor, $id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function delPregunta($id)
    {
        $query = $this->db->query(
            'DELETE FROM preguntas_encuestas WHERE id = ?',
            [$id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }
    }

    public function guardarAsignaciones($id_cuestionario, $selectedUserIds)
    {


        $data = [
            'id_cuestionario' => $id_cuestionario,
            'id_usuarios' => $selectedUserIds
        ];

        $query = $this->db->table('asignados_cuestionarios')->insert($data);

        return $query;

    }

    public function getUsersId($id)
    {

        $query = $this->db->query('SELECT asignados_cuestionarios.id AS id_asig, colaboradores.id AS id_colab, colaboradores.nombre, colaboradores.apellido_paterno, areas.descripcion, areas.puesto, (CASE WHEN respuestas_encuestas.id_encuesta IS NOT NULL THEN "Contestado" ELSE "No contestado" END) AS estado_respuesta FROM asignados_cuestionarios LEFT JOIN colaboradores ON colaboradores.id = asignados_cuestionarios.id_usuarios INNER JOIN areas ON areas.id_usuario = colaboradores.id LEFT JOIN respuestas_encuestas ON respuestas_encuestas.id_encuesta = ? AND respuestas_encuestas.id_usuario = asignados_cuestionarios.id_usuarios WHERE id_cuestionario = ? GROUP BY colaboradores.id ORDER BY colaboradores.nombre ASC', [$id, $id]);

        return $query->getResult();

    }

    public function delUser($id)
    {

        $query = $this->db->query(
            'DELETE FROM asignados_cuestionarios WHERE id = ?',
            [$id]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function getPeople($id)
    {

        $query = $this->db->query('SELECT colaboradores.id as id_colab, colaboradores.nombre, colaboradores.apellido_paterno,
        areas.descripcion, areas.puesto
        FROM colaboradores
        INNER JOIN areas ON areas.id_usuario = colaboradores.id
        WHERE colaboradores.id NOT IN (
            SELECT id_usuarios
            FROM asignados_cuestionarios
            WHERE id_cuestionario = ?
        ) 
        ORDER BY colaboradores.nombre ASC;', [$id]);

        return $query->getResult();

    }
    public function getPeople1()
    {

        $query = $this->db->query('SELECT colaboradores.id as id_colab, colaboradores.nombre, colaboradores.apellido_paterno, areas.descripcion, areas.puesto 
        FROM colaboradores INNER JOIN areas ON areas.id_usuario = colaboradores.id 
        WHERE colaboradores.nombre != "Noe Alejandro" 
        AND colaboradores.nombre != "TURING-IA"
        AND areas.descripcion != "Dirección de Servicios" ORDER BY colaboradores.nombre ASC');

        return $query->getResult();

    }

    public function getEncuestasUser($id)
    {

        $query = $this->db->query('SELECT encuesta.*
        FROM encuesta
        INNER JOIN asignados_cuestionarios ON encuesta.id = asignados_cuestionarios.id_cuestionario
        LEFT JOIN respuestas_encuestas ON respuestas_encuestas.id_encuesta = encuesta.id AND respuestas_encuestas.id_usuario = ?
        WHERE asignados_cuestionarios.id_usuarios = ? 
        AND respuestas_encuestas.id_encuesta IS NULL', [$id, $id]);

        return $query->getResult();

    }
    public function getEncuestasUserRespondidas($id)
    {

        $query = $this->db->query('SELECT DISTINCT encuesta.*
        FROM encuesta
        INNER JOIN respuestas_encuestas ON respuestas_encuestas.id_encuesta = encuesta.id
        WHERE respuestas_encuestas.id_usuario = ?', [$id]);

        return $query->getResult();

    }

    public function obtenerPreguntas($id)
    {

        $query = $this->db->query('SELECT * FROM `preguntas_encuestas` WHERE id_encuesta = ?', [$id]);

        return $query->getResult();

    }

    public function guardarRespuestaEncuesta($id_encuesta, $id_usuario, $id_pregunta, $respuesta)
    {

        $data = [
            'id_encuesta' => $id_encuesta,
            'id_usuario' => $id_usuario,
            'id_pregunta' => $id_pregunta,
            'respuesta' => $respuesta,
        ];

        $query = $this->db->table('respuestas_encuestas')->insert($data);

        return $query;

    }

    public function obtenerPreguntasRespondidas($id, $id_usuario)
    {
        $query = $this->db->query('SELECT respuestas_encuestas.*, preguntas_encuestas.* FROM respuestas_encuestas INNER JOIN preguntas_encuestas ON preguntas_encuestas.id = respuestas_encuestas.id_pregunta WHERE respuestas_encuestas.id_encuesta = ? AND respuestas_encuestas.id_usuario = ?', [$id,$id_usuario]);

        return $query->getResult();

    }

    public function getMails($selectedUserIds)
    {
        // Creamos una cadena de placeholders para los IDs de usuario
        $placeholders = str_repeat('?,', count($selectedUserIds) - 1) . '?';

        // Consulta SQL para obtener los correos electrónicos de los usuarios seleccionados
        $sql = "SELECT nombre, apellido_paterno, correo FROM colaboradores WHERE id IN ($placeholders)";

        // Ejecutamos la consulta con los IDs de usuario como parámetros
        $query = $this->db->query($sql, $selectedUserIds);

        // Retornamos los resultados de la consulta
        return $query->getResult();
    }

    public function delRespuestas($id_encuesta, $id_user)
    {

        $query = $this->db->query(
            'DELETE FROM respuestas_encuestas WHERE id_encuesta = ? AND id_usuario = ? ',
            [$id_encuesta, $id_user]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function getRespuestasAdmin($id_encuesta, $id_user)
    {

        $query = $this->db->query('SELECT respuestas_encuestas.*, preguntas_encuestas.* FROM respuestas_encuestas INNER JOIN preguntas_encuestas ON preguntas_encuestas.id = respuestas_encuestas.id_pregunta WHERE respuestas_encuestas.id_encuesta = ? AND respuestas_encuestas.id_usuario = ?', [$id_encuesta, $id_user]);

        return $query->getResult();

    }

    public function saveCicle($detalles, $descripcion, $f_inicio, $f_fin, $estado)
    {
        $data = [
            'detalles' => $detalles,
            'descripcion' => $descripcion,
            'f_inicio' => $f_inicio,
            'f_fin' => $f_fin,
            'estado' => $estado
        ];

        $this->db->table('ciclos')
            ->insert($data);

        $lastId = $this->db->insertID();

        if ($lastId) {
            return $lastId; // Devuelve el último ID insertado
        } else {
            return false; // La consulta falló o no se generó un nuevo ID
        }
    }

    public function getCiclesPendientes()
    {

        $query = $this->db->query('SELECT * FROM ciclos WHERE estado = "Sin comenzar" OR estado = "Trabajando" OR estado= "Detenido"');

        return $query->getResult();
    }
    public function getCiclesFinalizados()
    {

        $query = $this->db->query('SELECT * FROM ciclos WHERE estado = "Realizado"');

        return $query->getResult();
    }

    public function getCicles($id)
    {

        $query = $this->db->query('SELECT ciclos.*, ciclos.id as id_ciclo, ciclos_asignados.*, colaboradores.id as id_colab, colaboradores.nombre, colaboradores.apellido_paterno FROM ciclos LEFT JOIN ciclos_asignados ON ciclos_asignados.id_ciclo = ciclos.id LEFT JOIN colaboradores ON colaboradores.id = ciclos_asignados.id_usuario WHERE ciclos.id = ?',[$id]);

        return $query->getResult();
    }

    public function guardarAsignacionesCiclos($id_cuestionario, $selectedUserIds)
    {

        $data = [
            'id_usuario' => $selectedUserIds,
            'id_ciclo' => $id_cuestionario
        ];

        $query = $this->db->table('ciclos_asignados')->insert($data);

        return $query;

    }

    public function updateCicle($detalles, $descripcion, $f_inicio, $f_fin, $estado, $id_ciclo)
    {

        $query = $this->db->query(
            'UPDATE ciclos SET detalles = ?, descripcion = ?, f_inicio = ?, f_fin = ?, estado = ? WHERE id = ? ',
            [$detalles, $descripcion, $f_inicio, $f_fin, $estado, $id_ciclo]
        );

        if ($query) {
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // La consulta falló
        }

    }

    public function getCiclesUser($id)
    {

        $query = $this->db->query('SELECT ciclos.*, ciclos.id as id_ciclo, ciclos_asignados.*, colaboradores.id as id_colab, colaboradores.nombre, colaboradores.apellido_paterno FROM ciclos LEFT JOIN ciclos_asignados ON ciclos_asignados.id_ciclo = ciclos.id LEFT JOIN colaboradores ON colaboradores.id = ciclos_asignados.id_usuario WHERE colaboradores.id = ?',[$id]);

        return $query->getResult();

    }

}
