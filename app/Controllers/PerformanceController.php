<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\NominaModel;
use App\Models\ColaboratorsModel;
use App\Models\AsistenciaModel;
use App\Models\PerformanceModel;
use App\Controllers\BaseController;
use Illuminate\Http\Request;

class PerformanceController extends BaseController
{
    public function performance()
    {
        $colabsModel = new ColaboratorsModel();
        $perModel = new PerformanceModel();
        $id_usuario = session('user_id');
        $people = $colabsModel->getPeople();
        $fedback = $perModel->getFeedbacks($id_usuario);
        $all = $perModel->getAllFeedbacks();
        $coments = $perModel->getComents();
        $tot = count($fedback);
        $tot2 = count($all);
        $totpe = count($people);
        $events = $perModel->getEvents($id_usuario);
        $compe = $perModel->getHabilidades($id_usuario);


        $array = ['people' => $people, 'events' => $events, 't' => $totpe, 'fedback' => $fedback, 'tot' => $tot, 'coments' => $coments, 'id_usuario' => $id_usuario, 'all' => $all, 'tot2' => $tot2, 'compe' => $compe];
        /*echo "<pre>";
        print_r($array);
        echo "</pre>";
        exit();*/
        return view('colaboradores/performance/performance', $array);

    }
    public function calendar()
    {

        $perModel = new PerformanceModel();
        $id_usuario = session('user_id');
        $events = $perModel->getEvents($id_usuario);

        $array = ['events' => $events];
        return view('colaboradores/performance/calendar', $array);

    }
    public function guardarComentario()
    {
        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        exit();*/
        date_default_timezone_set('America/Mexico_City');
        setlocale(LC_TIME, "spanish");
        $session = session();
        $contenido = $this->request->getPost('contenido');
        $id_feedback = $this->request->getPost('id_feedback');
        $id_autor = $this->request->getPost('id_autor');
        $fecha_creacion = strtotime($this->request->getPost('fecha_creacion'));
        $fecha_creacion_format = date("Y-m-d h:i A", $fecha_creacion);
        $perModel = new PerformanceModel();


        if (empty($contenido)) {

            $mensaje = "No puedes dejar vacio el contenido del comentario, verifica.";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/performance"));

        } else {
            $save = $perModel->saveComentario($contenido, $id_feedback, $id_autor, $fecha_creacion_format);


            if ($save) {
                $message = "Comentario, guardado correctamente.";
                $session->setFlashdata('success_message', $message);
                return redirect()->to(base_url("home/performance"));
            } else {
                //si no cumple con el formato
                $mensaje = "No se puede subir el comentario, verifique";
                $session->setFlashdata('error_message', $mensaje);
                return redirect()->to(base_url("home/performance"));
            }

        }
    }
    public function deletecomen($id = NULL)
    {

        $perModel = new PerformanceModel();
        $session = session();

        $delete = $perModel->delComentario($id);

        if ($delete) {
            $message = "Comentario, eliminado correctamente.";
            $session->setFlashdata('success_message', $message);
            return redirect()->to(base_url("home/performance"));
        } else {
            //si no cumple con el formato
            $mensaje = "No se puede subir el comentario, verifique";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/performance"));
        }


    }

    public function savefedback()
    {
        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        exit();*/
        date_default_timezone_set('America/Mexico_City');
        setlocale(LC_TIME, "spanish");
        $session = session();
        $id_usuario = $this->request->getPost('id_usuario');
        $fecha_creacion = strtotime($this->request->getPost('fecha_creacion'));
        $fecha_creacion_format = date("Y-m-d h:i A", $fecha_creacion);
        $id_autor = $this->request->getPost('id_autor');
        $privacidad = $this->request->getPost('privacidad');
        $titulo = $this->request->getPost('titulo');
        $contenido = $this->request->getPost('contenido');
        $perModel = new PerformanceModel();


        /* if (empty($id_usuario) || empty($privacidad) || empty($titulo) || empty($contenido)) {
         
             $mensaje = "Algunos campos están vacíos, verifique";
             $session->setFlashdata('error_message', $mensaje);
             return redirect()->to(base_url("home/performance"));
         } else {*/
        $save = $perModel->savefeedback($id_usuario, $id_autor, $titulo, $contenido, $fecha_creacion_format, $privacidad);

        if ($save) {
            $message = "Feedback, guardado correctamente.";
            $session->setFlashdata('success_message', $message);
            return redirect()->to(base_url("home/performance"));
        } else {
            //si no cumple con el formato
            $mensaje = "No se puede subir el feedback, verifique";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/performance"));
        }
        //}


    }
    public function deletefed($id = NULL)
    {

        $perModel = new PerformanceModel();
        $session = session();

        $delete = $perModel->deletefed($id);

        if ($delete) {
            $message = "Feedback, eliminado correctamente.";
            $session->setFlashdata('success_message', $message);
            return redirect()->to(base_url("home/performance"));
        } else {
            //si no cumple con el formato
            $mensaje = "No se puede eliminar el feedback, verifique";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/performance"));
        }


    }

    public function edit($id = NULL)
    {
        $id = trim($id);

        $session = session();
        $perModel = new PerformanceModel();

        $info = $perModel->getFed($id);
        $array = ['info' => $info];

        /*echo "<pre>";
        print_r($array);
        echo "</pre>";*/

        return view("colaboradores/performance/editFed", $array);

    }

    public function savechanges()
    {
        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";*/

        $session = session();
        $titulo = $this->request->getPost('titulo');
        $id_fed = $this->request->getPost('id_fed');
        $contenido = $this->request->getPost('contenido');
        $privacidad = $this->request->getPost('privacidad');

        $perModel = new PerformanceModel();
        $save = $perModel->savefeedbackchages($titulo, $contenido, $privacidad, $id_fed);

        if ($save) {
            $message = "Feedback, guardado correctamente.";
            $session->setFlashdata('success_message', $message);
            return redirect()->to(base_url("home/performance/edit/$id_fed"));
        } else {
            //si no cumple con el formato
            $mensaje = "No se puede subir el feedback, verifique";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/performance/edit/$id_fed"));
        }

    }

    public function savemodulos()
    {
        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";*/
        $session = session();
        $id_periodo = $this->request->getPost('id_periodo');
        $perModel = new PerformanceModel();
        $save = $perModel->modulos($id_periodo);

        if ($save) {

            $session->set('estado', $id_periodo);
            return redirect()->to(base_url("home/account"));

        }


    }

    public function saveEvents()
    {

        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        exit();*/

        date_default_timezone_set('America/Mexico_City');
        setlocale(LC_TIME, "spanish");
        $session = session();
        $id_usuario = session('user_id');
        $title = $this->request->getPost('title');
        $color = $this->request->getPost('color');
        $ubicacion = $this->request->getPost('ubicacion');
        $start = $this->request->getPost('start');
        $end = $this->request->getPost('end');

        $perModel = new PerformanceModel();

        if (empty($title) || empty($color) || empty($ubicacion)) {

            $mensaje = "No se puede subir el feedback, no dejes Titulo o color vacíos, verifique";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/verC"));

        } else {

            $save = $perModel->saveCalendar($id_usuario, $title, $color, $ubicacion, $start, $end);

            if ($save) {
                $message = "Evento, guardado correctamente.";
                $session->setFlashdata('success_message', $message);
                return redirect()->to(base_url("home/performance"));
            } else {
                //si no cumple con el formato
                $mensaje = "No se puede subir el feedback, verifique";
                $session->setFlashdata('error_message', $mensaje);
                return redirect()->to(base_url("home/performance"));
            }
        }
    }
    public function editEvents()
    {

        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        exit();*/

        date_default_timezone_set('America/Mexico_City');
        setlocale(LC_TIME, "spanish");
        $session = session();
        $user_id = session('user_id');
        $id = $this->request->getPost('id');
        $title = $this->request->getPost('title');
        $color = $this->request->getPost('color');
        $delete = $this->request->getPost('delete');
        $ubicacion = $this->request->getPost('ubicacion');


        $perModel = new PerformanceModel();

        if (isset($delete) && isset($id)) {
            $del = $perModel->delEvent($id);

            if ($del) {
                $message = "Evento, eliminado correctamente.";
                $session->setFlashdata('success_message', $message);
                return redirect()->to(base_url("home/verC"));
            } else {
                //si no cumple con el formato
                $mensaje = "No se puede eliminar el evento, verifique.";
                $session->setFlashdata('error_message', $mensaje);
                return redirect()->to(base_url("home/verC"));
            }

        } else {

            $up = $perModel->updateEvent($title, $color, $ubicacion, $id);

            if ($up) {
                $message = "Evento, editado correctamente.";
                $session->setFlashdata('success_message', $message);
                return redirect()->to(base_url("home/verC"));
            } else {
                //si no cumple con el formato
                $mensaje = "No se puede editar el evento, verifique.";
                $session->setFlashdata('error_message', $mensaje);
                return redirect()->to(base_url("home/verC"));
            }

        }
    }
    public function editEventsLugar()
    {

        if (isset($_POST['Event'][0]) && isset($_POST['Event'][1]) && isset($_POST['Event'][2])) {


            $id = $_POST['Event'][0];
            $start = $_POST['Event'][1];
            $end = $_POST['Event'][2];


            $perModel = new PerformanceModel();
            $save = $perModel->savecalendarEdit($start, $end, $id);

            if ($save) {
                //$message = "Feedback, guardado correctamente.";
                // $session->setFlashdata('success_message', $message);
                die('OK');
                //return redirect()->to(base_url("home/performance"));
            } else {
                //si no cumple con el formato
                //$mensaje = "No se puede subir el feedback, verifique";
                //$session->setFlashdata('error_message', $mensaje);
                //return redirect()->to(base_url("home/performance"));
            }


        }
    }

    public function saveHabi()
    {

        $nuevosValores = $this->request->getPost('nuevoValues');
        $id_usuario = $this->request->getPost('id_usuario');
        $tipo = $this->request->getPost('tipo');
        $session = session();

        $perModel = new PerformanceModel();

        $c = count($nuevosValores);

        if ($c > 0) {
            $exito = true;
            for ($i = 0; $i < $c; $i++) {

                $id = $id_usuario;
                $habilidad = $nuevosValores[$i];
                $tipo1 = $tipo;
                $save = $perModel->insertHabi($id, $habilidad, $tipo1);

                if (!$save) {
                    $exito = false;
                    //return view('admin/err/success');   
                }

            }
            if ($exito) {

                $message = "Habilidad, guardada correctamente.";
                $session->setFlashdata('success_message', $message);
                return redirect()->to(base_url("home/performance"));
            }
        }

    }

    public function savelistcheck()
    {

        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        // exit();
        $nuevosValores = $this->request->getPost('nuevoValues');
        $dato_id = $this->request->getPost('dato_id');
        $titulo = $this->request->getPost('titulo');
        $session = session();

        $perModel = new PerformanceModel();

        $c = count($nuevosValores);

        if ($c > 0) {
            $exito = true;
            for ($i = 0; $i < $c; $i++) {

                $id = $dato_id;
                $habilidad = $nuevosValores[$i];
                $save = $perModel->insertonboardings($id, $habilidad);

                if (!$save) {
                    $exito = false;
                    //return view('admin/err/success');   
                }

            }
            if ($exito) {

                $message = "Actividad, guardada correctamente.";
                $session->setFlashdata('success_message', $message);
                return redirect()->to(base_url("home/onboarding/checklist/$dato_id/$titulo"));
            }
        }

    }

    public function delHabi($id = NULL)
    {

        $perModel = new PerformanceModel();
        $session = session();

        $delete = $perModel->delHabi($id);

        if ($delete) {
            $message = "Habilidad, eliminada correctamente.";
            $session->setFlashdata('success_message', $message);
            return redirect()->to(base_url("home/performance"));
        } else {
            //si no cumple con el formato
            $mensaje = "No se puede eliminar la habilidad, verifique";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/performance"));
        }

    }

    public function saveHabiEdit()
    {

        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";*/

        // Obtiene los datos enviados desde el frontend
        $id = $this->request->getPost('id');
        $valor = $this->request->getPost('valor');
        $perModel = new PerformanceModel();
        $session = session();

        $delete = $perModel->updHabi($valor, $id);

        if ($delete) {
            return $this->response->setJSON(['success' => true]);

        }

        // Envía una respuesta de éxito al frontend


    }

    public function aprendizaje()
    {
        $id = session('user_id');

        $perModel = new PerformanceModel();
        $session = session();
        $cursos = $perModel->getCursos($id);
        $objetivos = $perModel->getObjetivos($id);

        $array = ['id' => $id, 'cursos' => $cursos, 'objetivos' => $objetivos];

        return view("colaboradores/performance/aprendizaje", $array);

    }

    public function nuevaM($id)
    {

        $array = ['id' => $id];

        return view("colaboradores/performance/nuevaM", $array);

    }

    public function savecurso()
    {
        $id = session('user_id');
        $tipo = $this->request->getPost('tipo');
        $tema = $this->request->getPost('tema');
        $url = $this->request->getPost('url');
        $tiempo = $this->request->getPost('tiempo');
        $inicio = $this->request->getPost('inicio');
        $fin = $this->request->getPost('fin');
        $observaciones = $this->request->getPost('observaciones');
        $estado = $this->request->getPost('estado');

        $perModel = new PerformanceModel();
        $session = session();


        $save = $perModel->saveMeta($id, $tipo, $tema, $url, $tiempo, $inicio, $fin, $observaciones, $estado);

        if ($save) {
            $message = $tipo . ", guardado correctamente.";
            $session->setFlashdata('success_message', $message);
            return redirect()->to(base_url("home/aprendizaje/nuevaM/$id"));
        } else {
            //si no cumple con el formato
            $mensaje = "No se puede subir el feedback, verifique";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/aprendizaje/nuevaM/$id"));
        }


    }


    public function savecCursoEdit()
    {
        $id = $this->request->getPost('id');
        $valor = $this->request->getPost('valor');
        $perModel = new PerformanceModel();
        ;

        $update = $perModel->updCurso($valor, $id);

        if ($update) {
            return $this->response->setJSON(['success' => true]);

        }
    }

    public function delCurso($id = NULL)
    {

        $perModel = new PerformanceModel();
        $session = session();

        $delete = $perModel->delCurso($id);

        if ($delete) {
            $message = "Entrada, eliminada correctamente.";
            $session->setFlashdata('success_message', $message);
            return redirect()->to(base_url("home/aprendizaje"));
        } else {
            //si no cumple con el formato
            $mensaje = "No se puede eliminar la habilidad, verifique";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/aprendizaje"));
        }

    }

    public function certificado($id_user = NULL, $id_dato = NULL)
    {

        $perModel = new PerformanceModel();
        $session = session();
        $cursos = $perModel->getCursos($id_user);
        $asisModel = new AsistenciaModel();
        $session = session();
        $info = $asisModel->getInfo($id_user);

        $data = $info[0];
        $name = $data->nombre . " " . $data->apellido_paterno . " " . $data->apellido_materno;

        $cursoDeseado = null;

        foreach ($cursos as $curso) {
            if ($curso->id == $id_dato) {
                $cursoDeseado = $curso;
                break; // detener la iteración una vez que se encuentre el articulo
            }
        }

        $cursoD = $cursoDeseado->tema;
        $f_fin = $cursoDeseado->f_fin;
        $tiempo = $cursoDeseado->tiempo;

        $array = ['cursos' => $cursoD, 'name' => $name, 'tiempo' => $tiempo, 'fin' => $f_fin];

        // echo "<pre>";
        // print_r($cursoDeseado);
        // echo "</pre>";

        return view("colaboradores/performance/certificado", $array);


    }

    public function saveObjetivo()
    {

        $id = session('user_id');
        $perModel = new PerformanceModel();
        $session = session();
        $titulo = $this->request->getPost('titulo');
        $f_inicio = $this->request->getPost('f_inicio');
        $f_fin = $this->request->getPost('f_fin');
        $descripcion = $this->request->getPost('descripcion');
        $estado = $this->request->getPost('estado');
        $porcentaje = "0";

        $save = $perModel->saveObjet($id, $titulo, $f_inicio, $f_fin, $descripcion, $estado, $porcentaje);

        if ($save) {
            $message = "Objetivo guardado correctamente.";
            $session->setFlashdata('success_message', $message);
            return redirect()->to(base_url("home/aprendizaje"));
        } else {
            //si no cumple con el formato
            $mensaje = "No se puede eliminar la habilidad, verifique";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/aprendizaje"));
        }

    }

    public function saveProgress()
    {


        $id = $this->request->getPost('id');
        $valor = $this->request->getPost('valor');
        $perModel = new PerformanceModel();

        $variable = true;

        if ($valor == 'Realizado' || $valor == 'Sin comenzar' || $valor == 'Trabajando' || $valor == 'Detenido') {

            $update = $perModel->updObjEstado($valor, $id);
            $variable = $update;

        } else {

            $update = $perModel->updObjProgress($valor, $id);
            $variable = $update;
        }



        return $this->response->setJSON(['success' => $variable]);


    }

    public function delObject($id = NULL)
    {

        $perModel = new PerformanceModel();
        $session = session();

        $delete = $perModel->delObject($id);

        if ($delete) {
            $message = "Entrada, eliminada correctamente.";
            $session->setFlashdata('success_message', $message);
            return redirect()->to(base_url("home/aprendizaje"));
        } else {
            //si no cumple con el formato
            $mensaje = "No se puede eliminar la habilidad, verifique";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/aprendizaje"));
        }

    }

    public function onboarding()
    {
        $id = session('user_id');
        $perModel = new PerformanceModel();
        $onboarding = $perModel->getOnboarding($id);

        $array = ['onboardings' => $onboarding];

        return view("colaboradores/performance/onboarding", $array);

    }

    public function saveOnboarding()
    {

        $id = session('user_id');
        $perModel = new PerformanceModel();
        $session = session();
        $titulo = $this->request->getPost('titulo');
        $f_inicio = $this->request->getPost('f_inicio');
        $estado = $this->request->getPost('estado');

        $save = $perModel->saveOnboarding($id, $titulo, $f_inicio, $estado);

        if ($save) {
            $message = "Onboarding guardado correctamente.";
            $session->setFlashdata('success_message', $message);
            return redirect()->to(base_url("home/onboarding"));
        } else {
            //si no cumple con el formato
            $mensaje = "No se puede subir el onboarding, verifique";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/onboarding"));
        }

    }

    public function saveOnboardingEdit()
    {

        $id = $this->request->getPost('id');
        $valor = $this->request->getPost('valor');
        $valor0 = "Finalizado";
        $valor1 = "Proceso";
        $perModel = new PerformanceModel();
        $variable = true;

        if ($valor === 'Completar onboarding') {

            $fin = date('Y-m-d');
            $update = $perModel->saveOnboardingEdit($fin, $valor0, $id);
            $variable = $update;

        } else if ($valor === 'Marcar como no completado') {

            $fin = NULL;
            $update = $perModel->saveOnboardingEdit($fin, $valor1, $id);
            $variable = $update;

        } else {

            $variable = false;

        }

        return $this->response->setJSON(['success' => $variable]);
    }

    public function savelistaEdit()
    {
        $id = $this->request->getPost('id');
        $valor = $this->request->getPost('valor');

        $perModel = new PerformanceModel();
        $variable = true;

        if (is_numeric($valor)) {
            $update = $perModel->savelistEdit1($valor, $id);
            $variable = $update;
            //return $this->response->setJSON(['success' => $valor]);
        } else {

            $update = $perModel->savelistEdit($valor, $id);
            $variable = $update;
            //return $this->response->setJSON(['success' => $valor]);
        }
        return $this->response->setJSON(['success' => $variable]);
    }

    public function checklist($id_dato = NULL, $titulo = NULL)
    {

        $id = session('user_id');
        $perModel = new PerformanceModel();
        $activities = $perModel->getOnboardingActivities($id_dato);
        $array = ['activities' => $activities, 'id_dato' => $id_dato, 'id_user' => $id, 'titulo' => $titulo];
        return view("colaboradores/performance/nuevocheck", $array);

    }

    public function saveOnboardingEditData()
    {
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";

        $session = session();
        $id = $this->request->getPost('id');
        $titulo = $this->request->getPost('titulo');
        $f_inicio = $this->request->getPost('f_inicio');
        $f_fin = $this->request->getPost('f_fin');

        $perModel = new PerformanceModel();

        $edit = $perModel->saveOnboardingEditData($titulo, $f_inicio, $f_fin, $id);

        if ($edit) {
            $message = "Onboarding guardado correctamente.";
            $session->setFlashdata('success_message', $message);
            return redirect()->to(base_url("home/onboarding"));
        } else {
            //si no cumple con el formato
            $mensaje = "No se puede subir el onboarding, verifique";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/onboarding"));
        }


    }

    public function delOnboarding($id = NULL)
    {

        $perModel = new PerformanceModel();
        $session = session();

        $delete = $perModel->delOnboarding($id);

        if ($delete) {
            $message = "Onboarding, eliminado correctamente.";
            $session->setFlashdata('success_message', $message);
            return redirect()->to(base_url("home/onboarding"));
        } else {
            //si no cumple con el formato
            $mensaje = "No se puede eliminar el Onboarding, verifique";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/onboarding"));
        }
    }

    public function urlprueba($id = NULL)
    {
        $perModel = new PerformanceModel();
        $session = session();

        $delete = $perModel->delOnboardingActivity($id);

    }

    public function encuestas()
    {

        $permodel = new PerformanceModel();
        $id = session('user_id');
        $encuestas = $permodel->getEncuestasUser($id);
        $respondidas = $permodel->getEncuestasUserRespondidas($id);

        $array = ['encuestas' => $encuestas, 'respondidas' => $respondidas];

        return view("colaboradores/performance/encuestas", $array);
    }

    public function responder($id = NULL, $titulo = NULL)
    {

        /*echo trim($titulo);
        exit();*/
        $permodel = new PerformanceModel();
        $preguntas = $permodel->obtenerPreguntas($id);
        $array = ['preguntas' => $preguntas, 'titulo' => $titulo];

        return view("colaboradores/performance/responderencuestas", $array);
    }

    public function guardarResultados()
    {

        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        // exit();
        // Recuperar los datos del formulario
        $id_encuesta = $this->request->getPost('id_encuesta');
        $id_usuario = $this->request->getPost('id_usuario');
        $preguntas = $this->request->getPost('pregunta');
        $respuestas = $this->request->getPost('resp');

        // Instanciar el modelo de la base de datos
        $perModel = new PerformanceModel();
        $session = session();

        // Recorrer las preguntas y respuestas para guardarlas en la base de datos
        foreach ($preguntas as $id_pregunta => $pregunta) {
            // Verificar si hay respuestas para esta pregunta
            if (isset($respuestas[$id_pregunta])) {
                // Recorrer las respuestas
                foreach ($respuestas[$id_pregunta] as $respuesta) {
                    // Guardar la respuesta en la base de datos
                    $guardar = $perModel->guardarRespuestaEncuesta($id_encuesta, $id_usuario, $id_pregunta, $respuesta);

                    // Verificar si ocurrió un error al guardar la respuesta
                    if (!$guardar) {
                        // Manejar el error aquí si es necesario
                    }
                }
            }
        }

        $message = "Respuestas guardadas correctamente.";
        $session->setFlashdata('success_message', $message);
        return redirect()->to(base_url("home/encuestas"));
    }

    public function review()
    {

        $perModel = new PerformanceModel();
        $encuestas = $perModel->getEncuestasAdmin();
        $respondidas = $perModel->getEncuestasAdminRespondidas();
        $array = ['encuestas' => $encuestas, 'respondidas' => $respondidas];
        return view('comercial/capitalHumanoGeneral/performance/encuestas', $array);
    }

    public function newreview()
    {

        $colabModel = new ColaboratorsModel();
        $people = $colabModel->getPeople();
        $array = ['people' => $people];

        // echo "<pre>";
        // print_r($array);
        // echo "</pre>";

        return view("comercial/capitalHumanoGeneral/performance/nuevaEncuesta", $array);
    }

    public function saveidencuesta()
    {

        $email = \Config\Services::email();

        $session = session();
        $perModel = new PerformanceModel();
        $selectedUserIds = $this->request->getPost('selectedUsers');
        $id_cuestionario = $this->request->getPost('id_cuestionario');

        $getMails = $perModel->getMails($selectedUserIds);



        $c = count($selectedUserIds);

        if ($c > 0) {
            //$this->enviarCorreos($getMails);
            $exito = true; // Variable de bandera para rastrear si hubo algun error

            for ($i = 0; $i < $c; $i++) {

                $selectedUserIds = $_POST['selectedUsers'][$i];
                $id_cuestionario = $_POST['id_cuestionario'];

                $guardar = $perModel->guardarAsignaciones($id_cuestionario, $selectedUserIds);

                if (!$guardar) {
                    $exito = false;

                }

            }

            if ($exito) {
                $message = "Invitaciones enviadas a sus correos con éxito.";
                $session->setFlashdata('success_message', $message);
                return redirect()->to(base_url("home/review/edit/$id_cuestionario"));

            } else {

                $mensaje = "No se pueden subir los usuarios, verifique";
                $session->setFlashdata('error_message', $mensaje);
                return redirect()->to(base_url("home/review/edit/$id_cuestionario"));

            }
        } else {

        }



    }

    public function enviarCorreos($getMails)
    {

        // echo "<pre>";
        // print_r($getMails);
        // echo "</pre>";
        // exit();

        $email = \Config\Services::email();

        // Configurar el correo electrónico
        $email->setFrom('Encuestas People Analytics');
        $email->setSubject('Tienes una evaluación pendiente de responder'); // Asunto del correo electrónico

        // Cuerpo del correo electrónico


        // Bucle para enviar correos a cada dirección de correo electrónico
        foreach ($getMails as $correo) {

            $namee = strtoupper($correo->nombre . " " . $correo->apellido_paterno);

            $message = '
            <!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Correo electrónico</title>
                <style>
                    /* Estilos CSS */
                    body {
                        font-family: "Century Gothic";
            background: #F8FAFC;
                        color: #333;
                        margin: 0;
                        padding: 0;
                    }
                    .container {
                        max-width: 600px;
                        margin: 0 auto;
                        padding: 20px;
                        background-color: #fff;
                        border-radius: 10px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    }
                    h1 {
                        color: #333;
                        text-align: center;
                    }
                    p {
                        margin-bottom: 20px;
                    }
                    .ver-periodo-btn {
          color: #3498db; /* Color del texto */
          background-color: #dff2fe; /* Color de fondo */
          padding: 8px 15px; /* Ajusta el espaciado interno */
          border-radius: 8px; /* Bordes redondeados */
          text-decoration: none; /* Sin subrayado */
          font-size: 14px; /* Tamaño del texto */
          transition: background-color 0.3s, color 0.3s; /* Transición suave del color de fondo y del texto */
        }
        
        .ver-periodo-btn:hover {
          background-color: #aedbf3; /* Cambia el color de fondo al pasar el mouse */
          color: #2980b9; /* Cambia el color del texto al pasar el mouse */
        }
                    .logo {
                        text-align: center;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="logo">
                        <h1>Turing-IA</h1>
                        <img src="https://portal.turing-latam.com/public/gifs/fondo.png" alt="logo_turing" width="110px" height="100px">
                    </div>
                    <h1>Tienes una evaluación pendiente de responder</h1>
                    <p style="text-align:center;">Hola <strong>' . $namee . '</strong></p>
                    <p>El Área de Capital Humano te asignó una evaluación y necesitamos que respondas la evaluación.</p>
                    <p>Puedes responder desde el siguiente botón:</p>
                    <p style="text-align:center;"><a href="' . base_url('/home/encuestas') . '" class="btn ver-periodo-btn" target="_blank">Responder ahora</a></p>
                </div>
            </body>
            </html>';
            // Establecer el destinatario
            $email->setTo($correo->correo);

            // Agregar el mensaje al correo electrónico
            $email->setMessage($message);

            // Enviar el correo electrónico
            if ($email->send()) {
                // Si se envía correctamente
                $mensaje = "Correo enviado exitosamente a la dirección: " . $correo->correo . ". Verifique su buzón de entrada/spam.";
                // Puedes agregar un mensaje de éxito aquí si lo deseas
            } else {
                // Si hay un error al enviar el correo electrónico
                $mensaje = 'Error al enviar el correo: ' . $email->printDebugger();
                // Puedes manejar el error aquí según tus necesidades
            }
        }

        // Redirigir o retornar una respuesta según sea necesario
    }


    public function saveencuesta()
    {

        $session = session();
        $titulo = $this->request->getPost('titulo');
        $subtitulo = $this->request->getPost('subtitulo');


        $perModel = new PerformanceModel();

        $lastId = $perModel->saveencuesta($titulo, $subtitulo);

        if ($lastId) {
            $message = "Encuesta guardada correctamente en el sistema.";
            $session->setFlashdata('success_message', $message);
            return redirect()->to(base_url("home/review/edit/$lastId"));
        } else {
            //si no cumple con el formato
            $mensaje = "No se puede subir la encuesta, verifique";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/review/new_review"));
        }

    }

    public function editEncuesta($id = NULL)
    {

        $colabModel = new ColaboratorsModel();
        $perModel = new PerformanceModel();
        $people = $perModel->getPeople($id);
        $encuestas = $perModel->getEncuestasAdminId($id);
        $preguntas = $perModel->getPreguntasAdminId($id);
        $usuarios = $perModel->getUsersId($id);

        $array = ['id' => $id, 'people' => $people, 'encuestas' => $encuestas, 'preguntas' => $preguntas, 'usuarios' => $usuarios];

        // echo "<pre>";
        // print_r($array);
        // echo "</pre>";

        return view("comercial/capitalHumanoGeneral/performance/editEncuesta", $array);


    }

    public function saveencuestaEdit()
    {

        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        //exit();
        $session = session();
        if (empty($_POST)) {

            $mensaje = "No pueden haber preguntas vacías, verifique";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/review"));

        } else {

            $preguntas = $this->request->getPost('preg');
            $opcionesA = $this->request->getPost('A');
            $opcionesB = $this->request->getPost('B');
            $opcionesC = $this->request->getPost('C');
            $opcionesD = $this->request->getPost('D');
            $id_encuesta = $this->request->getPost('id_encuesta');
            $numeros = $this->request->getPost('numero'); //guarda el orden de las preguntas 

            $perModel = new PerformanceModel();


            $c = 0;
            if (is_array($numeros)) {
                $c = count($numeros);

                // $c = count($id_encuesta); 
                echo $c;


                if ($c > 0) {
                    $exito = true; // Variable de bandera para rastrear si hubo algun error

                    for ($i = 0; $i < $c; $i++) {

                        $preguntas = $_POST['preg'][$i];
                        $opcionesA = $_POST['A'][$i];
                        $opcionesB = $_POST['B'][$i];
                        $opcionesC = $_POST['C'][$i];
                        $opcionesD = $_POST['D'][$i];
                        $numeros = $_POST['numero'][$i];
                        $id_encuesta = $_POST['id_encuesta'][$i];


                        $guardar = $perModel->guardarPreguntas($id_encuesta, $opcionesA, $opcionesB, $opcionesC, $opcionesD, $preguntas, $numeros);

                        if (!$guardar) {
                            $exito = false;

                        }

                    }

                    if ($exito) {
                        $message = "Preguntas añadidas correctamente.";
                        $session->setFlashdata('success_message', $message);
                        return redirect()->to(base_url("home/review/edit/$id_encuesta"));

                    } else {

                        $mensaje = "No se pueden subir las preguntas, verifique";
                        $session->setFlashdata('error_message', $mensaje);
                        return redirect()->to(base_url("home/review/edit/$id_encuesta"));

                    }
                } else {
                    $mensaje = "No pueden haber preguntas vacías, verifique";
                    $session->setFlashdata('error_message', $mensaje);
                    return redirect()->to(base_url("home/review/edit/$id_encuesta"));
                }
            }
        }

    }

    public function eliminarEncs($id = NULL)
    {

        $perModel = new PerformanceModel();
        $session = session();

        $delete = $perModel->delEncuesta($id);

        if ($delete) {
            $message = "Encuesta, eliminada correctamente.";
            $session->setFlashdata('success_message', $message);
            return redirect()->to(base_url("home/review"));
        } else {
            //si no cumple con el formato
            $mensaje = "No se puede eliminar la encuesta, verifique";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/review"));
        }

    }

    public function saveEditEncuesta()
    {

        $id = $this->request->getPost('id');
        $valor = $this->request->getPost('valor');
        $nombre = $this->request->getPost('nombre');

        $perModel = new PerformanceModel();
        $variable = true;

        if ($nombre === 'titulo_encuesta') {

            $update1 = $perModel->savetitleencuesta($valor, $id);
            $variable = $update1;

        } else if ($nombre == 'titulo_pregunta') {

            $update = $perModel->savetitlepregunta($valor, $id);
            $variable = $update;

        } else if ($nombre == 'pregunta_a') {
            $update = $perModel->savea($valor, $id);
            $variable = $update;

        } else if ($nombre == 'pregunta_b') {
            $update = $perModel->saveb($valor, $id);
            $variable = $update;

        } else if ($nombre == 'pregunta_c') {
            $update = $perModel->savec($valor, $id);
            $variable = $update;

        } else if ($nombre == 'pregunta_d') {
            $update = $perModel->saved($valor, $id);
            $variable = $update;

        } else if ($nombre == 'descripcion_encuesta') {
            $update = $perModel->savedescripcion($valor, $id);
            $variable = $update;

        }


        return $this->response->setJSON(['success' => $variable]);

    }

    public function eliminarPreg($id = NULL, $id_encuesta = NULL)
    {

        $perModel = new PerformanceModel();
        $session = session();

        $delete = $perModel->delPregunta($id);

        if ($delete) {
            $message = "Pregunta, eliminada correctamente.";
            $session->setFlashdata('success_message', $message);
            return redirect()->to(base_url("home/review/edit/$id_encuesta"));
        } else {
            //si no cumple con el formato
            $mensaje = "No se puede eliminar la pregunta, verifique";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/review/edit/$id_encuesta"));
        }

    }

    public function delUser($id = NULL)
    {
        $session = session();
        $id = $this->request->getPost('id');

        $perModel = new PerformanceModel();
        $variable = true;

        $update1 = $perModel->delUser($id);
        $variable = $update1;



        return $this->response->setJSON(['success' => $variable]);
    }

    public function respuestas($id = NULL, $titulo = NULL)
    {
        $id_usuario = session('user_id');

        $permodel = new PerformanceModel();
        $respuestas = $permodel->obtenerPreguntasRespondidas($id, $id_usuario);



        $array = ['respuestas' => $respuestas, 'titulo' => $titulo];

        // echo "<pre>";
        // print_r($respuestas);
        // echo "</pre>";
        // exit();

        return view("colaboradores/performance/respuestas", $array);
    }

    public function deleterespuestas($id_user = NULL, $id_encuesta = NULL)
    {

        $perModel = new PerformanceModel();
        $session = session();

        $delete = $perModel->delRespuestas($id_encuesta, $id_user);

        if ($delete) {
            $message = "Respuestas, eliminadas correctamente.";
            $session->setFlashdata('success_message', $message);
            return redirect()->to(base_url("home/review/edit/$id_encuesta"));
        } else {
            //si no cumple con el formato
            $mensaje = "No se pueden eliminar las respuestas, verifique";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/review/edit/$id_encuesta"));
        }

    }

    public function verespuestas($id_user = NULL, $id_encuesta = NULL, $titulo = NULL)
    {

        $perModel = new PerformanceModel();
        $respuestas = $perModel->getRespuestasAdmin($id_encuesta, $id_user);

        $array = ['respuestas' => $respuestas, 'titulo' => $titulo, 'id' => $id_encuesta];
        return view("comercial/capitalHumanoGeneral/performance/verrespuestas", $array);

    }

    public function ciclos()
    {
        date_default_timezone_set('America/Mexico_City');
        setlocale(LC_TIME, "spanish");
        /* OBTIENE LA INFORMACIÓN DE USUARIO PERSONAL PARA VISUALIZARLA EN LA VISTA */
        $session = session();
        $user_id = $session->get('user_id');
        $rol = $session->get('rol');

        $authModel = new AuthModel();
        $permodel = new PerformanceModel();
        $account = $authModel->account($user_id);
        $ciclos = $permodel->getCiclesUser($user_id);

        $info = $account[0];
        $nacimiento = $info->fecha_nacimiento;

        $fecha_nacimiento_obj = new \DateTime($nacimiento);
        $fecha_actual = new \DateTime();

        $diferencia = $fecha_actual->diff($fecha_nacimiento_obj);

        $edad = $diferencia->y;

        // $cumpleaños_actual = $fecha_nacimiento_obj->modify("+" . $edad . " years");
        // echo "<br>";
        // echo "El cumpleaños actual es: " . $cumpleaños_actual->format('d/m/Y');

        // echo "<pre>";
        // print_r($account);
        // echo "</pre>";


        $array = ['account' => $account, 'edad' => $edad, 'user_id' => $user_id, 'ciclos ' => $ciclos ];
        return view("colaboradores/performance/ciclos", $array);
    }

    public function ver($id = NULL)
    {

        date_default_timezone_set('America/Mexico_City');
        setlocale(LC_TIME, "spanish");
        /* OBTIENE LA INFORMACIÓN DE USUARIO PERSONAL PARA VISUALIZARLA EN LA VISTA */
        $session = session();
        $user_id = $session->get('user_id');
        $rol = $session->get('rol');

        $authModel = new AuthModel();
        $permodel = new PerformanceModel();
        $account = $authModel->account($user_id);
        $ciclos = $permodel->getCiclesUser($user_id);

        $info = $account[0];
        $nacimiento = $info->fecha_nacimiento;

        $fecha_nacimiento_obj = new \DateTime($nacimiento);
        $fecha_actual = new \DateTime();

        $diferencia = $fecha_actual->diff($fecha_nacimiento_obj);

        $edad = $diferencia->y;


        $array = ['account' => $account, 'edad' => $edad, 'user_id' => $user_id, 'ciclos' =>$ciclos];

        // print_r($array);
        // exit();

        return view("colaboradores/performance/ciclosver", $array);
    }

    public function cicles()
    {

        $perModel = new PerformanceModel();
        $pendientes = $perModel->getCiclesPendientes();
        $finalizados = $perModel->getCiclesFinalizados();

        $array = ['pendientes' => $pendientes, 'finalizados' => $finalizados];

        return view("comercial/capitalHumanoGeneral/performance/ciclos", $array);

    }

    public function newCicle()
    {

        $colabModel = new PerformanceModel();
        $people = $colabModel->getPeople1();
        $array = ['people' => $people];

        return view("comercial/capitalHumanoGeneral/performance/newciclos", $array);
    }

    public function savecicle()
    {

        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        // exit();

        $session = session();
        $detalles = $this->request->getPost('detalles');
        $descripcion = $this->request->getPost('descripcion');
        $f_inicio = $this->request->getPost('f_inicio');
        $f_fin = $this->request->getPost('f_fin');
        $estado = $this->request->getPost('estado');

        $perModel = new PerformanceModel();
        $getid = $perModel->saveCicle($detalles, $descripcion, $f_inicio, $f_fin, $estado);


        if ($getid) {
            $message = "Ciclo guardado con éxito.";
            $session->setFlashdata('success_message', $message);
            return redirect()->to(base_url("home/cicle/edit/$getid"));
        } else {
            //si no cumple con el formato
            $mensaje = "No se pueden eliminar las respuestas, verifique";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/cicles/new_cicle"));
        }


    }

    public function editCicle($id = NULL)
    {
        $permodel = new PerformanceModel();
        $infos = $permodel->getCicles($id);
        $people = $permodel->getPeople1();
        $array = ['infos' => $infos, 'id' => $id, 'people' => $people];

        return view("comercial/capitalHumanoGeneral/performance/editCiclos", $array);

    }

    public function saveidcicle()
    {
        

        $session = session();
        $perModel = new PerformanceModel();
        $selectedUserIds = $this->request->getPost('selectedUsers');
        $id_cuestionario = $this->request->getPost('id_cuestionario');

        $getMails = $perModel->getMails($selectedUserIds);

        $c = count($selectedUserIds);

        if ($c > 0) {
            //$this->enviarCorreos($getMails);
            $exito = true; // Variable de bandera para rastrear si hubo algun error

            for ($i = 0; $i < $c; $i++) {

                $selectedUserIds = $_POST['selectedUsers'][$i];
                $id_cuestionario = $_POST['id_cuestionario'];

                $guardar = $perModel->guardarAsignacionesCiclos($id_cuestionario, $selectedUserIds);

                if (!$guardar) {
                    $exito = false;

                }

            }

            if ($exito) {
                $message = "Usuarios guardados";
                $session->setFlashdata('success_message', $message);
                return redirect()->to(base_url("home/cicle/edit/$id_cuestionario"));

            } else {

                $mensaje = "No se pueden subir los usuarios, verifique";
                $session->setFlashdata('error_message', $mensaje);
                return redirect()->to(base_url("home/cicle/edit/$id_cuestionario"));

            }
        } else {

        }

    }

    public function savecicleedit()
    {

        $session = session();
        $detalles = $this->request->getPost('detalles');
        $descripcion = $this->request->getPost('descripcion');
        $f_inicio = $this->request->getPost('f_inicio');
        $f_fin = $this->request->getPost('f_fin');
        $estado = $this->request->getPost('estado');
        $id_ciclo = $this->request->getPost('id_ciclo');

        $perModel = new PerformanceModel();
        $getid = $perModel->updateCicle($detalles, $descripcion, $f_inicio, $f_fin, $estado, $id_ciclo);


        if ($getid) {
            $message = "Ciclo guardado con éxito.";
            $session->setFlashdata('success_message', $message);
            return redirect()->to(base_url("home/cicle/edit/$id_ciclo"));
        } else {
            //si no cumple con el formato
            $mensaje = "No se pueden eliminar las respuestas, verifique";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/cicle/edit/$id_ciclo"));
        }

    }

}
