<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Controllers\PreguntasController;
use App\Models\TalentModel;
use App\Controllers\EmailController;

class TalentController extends BaseController
{
    public function applicants()
    {

        $talentModel = new TalentModel();
        $id = '0';

        $candidatos = $talentModel->getCandidatos($id);
        $candidatosForms = $talentModel->getCandidatosForms();
        $viables = $talentModel->getCandidatosViables();

        $tot = '';
        $totViables = '';

        if ($tot > 0 && $totViables > 0) {
            $inf = $candidatosForms[0];
            $tot = $inf->cantidad_candidatos;
            $totViables = $viables[0]->cantidad_candidatos;
        }

        $array = ['candidatos' => $candidatos, 'tot' => $tot, 'candidatosForms' => $candidatosForms, 'viables' => $viables, 'totViables' => $totViables];

        return view("comercial/capitalHumanoGeneral/talent/aplicants", $array);

    }
    public function calendly()
    {

        $talentModel = new TalentModel();
        $candidatosForms = $talentModel->getCandidatosForms();
        $calendlys = $talentModel->getCalendly();
        $array = ['candidatosForms' => $candidatosForms, 'calendlys' => $calendlys];

        // echo "<pre>";
        // print_r($array);
        // echo "</pre>";
        // exit();

        return view("comercial/capitalHumanoGeneral/talent/calendly", $array);


    }
    public function formdetails($id = NULL)
    {
        $talentModel = new TalentModel();
        $candidatos = $talentModel->getCandidatos($id);
        $tot = count($candidatos);


        $vacante = ''; // Inicializamos $vacante en caso de que $candidatos esté vacío

        if ($tot > 0) {
            $inf = $candidatos[0];
            $vacante = $inf->vacante;
        }

        $array = ['candidatos' => $candidatos, 'tot' => $tot, 'vacante' => $vacante, 'id_formulario' => $id];

        // echo "<pre>";
        // print_r($array);
        // echo "</pre>";
        // exit();

        return view("comercial/capitalHumanoGeneral/talent/formsCandidatos", $array);

    }
    public function forms()
    {

        $talModel = new TalentModel();
        $forms = $talModel->getForms();

        // echo "<pre>";
        // print_r($forms);
        // echo "</pre>";
        // exit();

        $longitud = 45;
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $link = '';

        for ($i = 0; $i < $longitud; $i++) {
            $indice = rand(0, strlen($caracteres) - 1);
            $link .= $caracteres[$indice];
            $newL = $link . "?use=1";
        }

        $total = count($forms);


        $array = ['token' => $newL, 'forms' => $forms, 'total' => $total];

        return view("comercial/capitalHumanoGeneral/talent/forms", $array);

    }
    public function nuevoForm($token = NULL)
    {

        $array = ['token' => $token];

        return view("comercial/capitalHumanoGeneral/talent/newforms", $array);

    }
    public function saveform()
    {
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        // exit();
        $session = session();
        $talentModel = new TalentModel();
        $area = $this->request->getPost('area');
        $token = $this->request->getPost('token');
        $vacante = $this->request->getPost('vacante');

        $preguntas = $this->request->getPost('preg');
        $opcionesA = $this->request->getPost('A');
        $opcionesB = $this->request->getPost('B');
        $opcionesC = $this->request->getPost('C');
        $opcionesD = $this->request->getPost('D');
        $opcionesE = $this->request->getPost('E');
        $opcionesF = $this->request->getPost('D');
        $numeros = $this->request->getPost('numero'); //guarda el orden de las preguntas 
        $clonado = 0;
        $id_form = $talentModel->saveForm($area, $vacante, $token, $clonado);
        $talentModel->saveCalendly($id_form);

        if ($id_form) {

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
                        $opcionesE = $_POST['E'][$i];
                        $opcionesF = $_POST['F'][$i];
                        $numeros = $_POST['numero'][$i];
                        $id_encuesta = $id_form;


                        $guardar = $talentModel->guardarPreguntas($id_encuesta, $preguntas, $opcionesA, $opcionesB, $opcionesC, $opcionesD, $opcionesE, $opcionesF, $numeros);

                        if (!$guardar) {
                            $exito = false;

                        }

                    }

                    if ($exito) {
                        $message = "Preguntas añadidas correctamente.";
                        $session->setFlashdata('success_message', $message);
                        return redirect()->to(base_url("home/forms"));

                    } else {

                        $mensaje = "No se pueden subir las preguntas, verifique";
                        $session->setFlashdata('error_message', $mensaje);
                        return redirect()->to(base_url("home/forms"));

                    }
                } else {
                    $mensaje = "No pueden haber preguntas vacías, verifique";
                    $session->setFlashdata('error_message', $mensaje);
                    return redirect()->to(base_url("home/forms"));
                }
            }


        }
    }
    public function form_applicant($token = NULL)
    {

        $talentModel = new TalentModel();
        $data = $talentModel->getFormsID($token);

        $inf = $data[0];
        $title = $inf->vacante;
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // exit();
        $array = ['data' => $data, 'vacante' => $title, 'token' => $token];

        return view("comercial/capitalHumanoGeneral/talent/formsResponder", $array);
    }
    public function saveRespuestasAplicantes()
    {
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        // exit();

        $nombreEncontrado = false; // Variable para almacenar si se encontró la pregunta con "nombre"
        $correoEncontrado = false; // Variable para almacenar si se encontró la pregunta con "nombre"
        $nombre = ''; // Variable para almacenar el valor del nombre
        $correo = ''; // Variable para almacenar el valor del nombre
        $session = session();
        $nombre_doc = $_FILES['documento']['name'];
        $tipo = $_FILES['documento']['type'];
        $tamano = $_FILES['documento']['size'];

        $fecha_hora = $this->request->getPost('fecha_hora');
        $id_encuesta = $this->request->getPost('id_encuesta');
        $preguntas = $this->request->getPost('pregunta');
        $respuestas = $this->request->getPost('resp');
        $token = $this->request->getPost('token');
        $talentModel = new TalentModel();


        // Iterar sobre las preguntas y verificar si alguna contiene "nombre"
        foreach ($preguntas as $preguntaId => $pregunta) {
            // Convertir la pregunta a minúsculas para hacer una comparación sin distinción entre mayúsculas y minúsculas
            $preguntaMinusculas = strtolower($pregunta);

            // Verificar si la pregunta contiene "nombre" o sus derivados
            if (strpos($preguntaMinusculas, 'nombre') !== false) {
                // Si se encontró "nombre", asignar true a la variable y obtener el valor del nombre
                $nombreEncontrado = true;
                $nombreRespuesta = $respuestas[$preguntaId][0]; // Suponiendo que siempre hay una sola respuesta para la pregunta
                $nombre = $nombreRespuesta;
                break;
            }
        }

        foreach ($preguntas as $preguntaId => $pregunta) {
            // Convertir la pregunta a minúsculas para hacer una comparación sin distinción entre mayúsculas y minúsculas
            $preguntaMinusculas = strtolower($pregunta);

            // Verificar si la pregunta contiene "nombre" o sus derivados
            if (strpos($preguntaMinusculas, 'correo') !== false) {
                // Si se encontró "nombre", asignar true a la variable y obtener el valor del nombre
                $correoEncontrado = true;
                $correoRespuesta = $respuestas[$preguntaId][0]; // Suponiendo que siempre hay una sola respuesta para la pregunta
                $correo = $correoRespuesta;
                break;
            }
        }

        if (($nombre_doc != '') && ($tipo == 'application/msword' || $tipo == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || $tipo == 'application/pdf') && ($tamano <= 200000000)) {

            $directorio = $_SERVER['DOCUMENT_ROOT'] . "Turing-IA/public/assets/"; // Ruta local en el servidor
            /*IMPORTANTE! EL DIRECTORIO LOCAL NO ES EL MISMO QUE EL DEL DOMINIO, VALIDAR EL CODIGO COMENTADO DE $DIRECTORIO, PARA 
            SEGUIR ESA ESTRUCTURA DE DIRECTOTIOS PARA IMG, PDF Y DOC */

            if (!file_exists($directorio)) {
                mkdir($directorio, 0777, true);
            }

            $nombre_archivo = $_FILES['documento']['name'];
            if (move_uploaded_file($_FILES['documento']['tmp_name'], $directorio . $nombre_archivo)) {
                $exito = true;
            } else {
                $mensaje = "Error al mover el archivo.";
                $session->setFlashdata('error_message', $mensaje);

            }
            // echo $correo;
            // exit();

            $candidato_id = $talentModel->guardarCandidatos($nombre, $correo, $nombre_doc, $fecha_hora);
            foreach ($preguntas as $id_pregunta => $pregunta) {
                // Verificar si hay respuestas para esta pregunta
                if (isset($respuestas[$id_pregunta])) {
                    // Recorrer las respuestas
                    foreach ($respuestas[$id_pregunta] as $respuesta) {
                        // Guardar la respuesta en la base de datos

                        $guardar = $talentModel->guardarRespuestaEncuesta($id_pregunta, $candidato_id, $respuesta);

                        // Verificar si ocurrió un error al guardar la respuesta
                        if (!$guardar) {
                            // Manejar el error aquí si es necesario
                        }
                    }
                }
            }

            if ($exito && $guardar && $candidato_id) {

                $mensaje = "Formulario guardado con éxito, espera las respuestas.";
                $session->setFlashdata('success_message', $mensaje);
                return redirect()->to(base_url("/form_applicant/$token"));

            } else {
                $mensaje = "Archivo subido con éxito";
                $session->setFlashdata('success_message', $mensaje);
                return redirect()->to(base_url("/form_applicant/$token"));
            }
        }

    }
    public function editForm($id = NULL, $token = NULL)
    {

        $talentModel = new TalentModel();
        $data = $talentModel->getFormsID($token);

        $inf = $data[0];
        $area = $inf->area;
        $vacante = $inf->vacante;

        $longitud = 45;
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $link = '';

        for ($i = 0; $i < $longitud; $i++) {
            $indice = rand(0, strlen($caracteres) - 1);
            $link .= $caracteres[$indice];
            $newL = $link . "?use=1";
        }

        $array = ['forms' => $data, 'id' => $id, 'token' => $token, 'area' => $area, 'vacante' => $vacante, 'nuevoT' => $newL];

        // print_r($array);
        // exit();

        return view("comercial/capitalHumanoGeneral/talent/formsEditar", $array);
    }
    public function saveFormsAplicantEdit()
    {

        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        // exit();
        $talentModel = new TalentModel();
        $preguntas = $this->request->getPost('preg');
        $opcionesA = $this->request->getPost('A');
        $opcionesB = $this->request->getPost('B');
        $opcionesC = $this->request->getPost('C');
        $opcionesD = $this->request->getPost('D');
        $opcionesE = $this->request->getPost('E');
        $opcionesF = $this->request->getPost('F');
        $numeros = $this->request->getPost('numero'); //guarda el orden de las preguntas 
        $id_encuesta = $this->request->getPost('id_encuesta');
        $session = session();

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
                    $opcionesE = $_POST['E'][$i];
                    $opcionesF = $_POST['F'][$i];
                    $numeros = $_POST['numero'][$i];
                    $id_encuestaa = $id_encuesta;


                    $guardar = $talentModel->guardarPreguntas($id_encuestaa, $preguntas, $opcionesA, $opcionesB, $opcionesC, $opcionesD, $opcionesE, $opcionesF, $numeros);

                    if (!$guardar) {
                        $exito = false;

                    }

                }

                if ($exito) {
                    $message = "Preguntas añadidas correctamente.";
                    $session->setFlashdata('success_message', $message);
                    return redirect()->to(base_url("home/forms"));

                } else {

                    $mensaje = "No se pueden subir las preguntas, verifique";
                    $session->setFlashdata('error_message', $mensaje);
                    return redirect()->to(base_url("home/forms"));

                }
            } else {
                $mensaje = "No pueden haber preguntas vacías, verifique";
                $session->setFlashdata('error_message', $mensaje);
                return redirect()->to(base_url("home/forms"));
            }
        }

    }
    public function saveeditCalendly()
    {

        $id = $this->request->getPost('id');
        $valor = $this->request->getPost('valor');

        $perModel = new TalentModel();
        $variable = false;

        $update = $perModel->updateCalendly($valor, $id);

        if ($update) {
            $variable = true;
        } else {
            $variable = false;
        }

        return $this->response->setJSON(['success' => $variable]);

    }
    public function saveEditFormAplicant()
    {
        $id = $this->request->getPost('id');
        $valor = $this->request->getPost('valor');
        $nombre = $this->request->getPost('nombre');

        $perModel = new TalentModel();
        $variable = false;

        switch ($nombre) {
            case 'area':
                $variable = $perModel->updateField('formularios', 'area', $valor, $id);
                break;
            case 'vacante':
                $variable = $perModel->updateField('formularios', 'vacante', $valor, $id);
                break;
            default:

                if ($nombre == 'pregunta_a') {
                    $update = $perModel->savea($valor, $id);
                    $variable = $update;

                } elseif ($nombre == 'pregunta_b') {
                    $update = $perModel->saveb($valor, $id);
                    $variable = $update;

                } elseif ($nombre == 'pregunta_c') {
                    $update = $perModel->savec($valor, $id);
                    $variable = $update;

                } elseif ($nombre == 'pregunta_d') {
                    $update = $perModel->saved($valor, $id);
                    $variable = $update;

                } elseif ($nombre == 'pregunta_e') {
                    $update = $perModel->savee($valor, $id);
                    $variable = $update;

                } elseif ($nombre == 'pregunta_f') {
                    $update = $perModel->savef($valor, $id);
                    $variable = $update;

                } elseif ($nombre == 'titulo_pregunta') {

                    $update = $perModel->savetpregunta($valor, $id);
                    $variable = $update;

                }
        }

        return $this->response->setJSON(['success' => $variable]);
    }
    public function eliminarPregForm($id_pregunta = NULL, $id_form = NULL, $tokn = NULL)
    {


        $session = session();
        $talentModel = new TalentModel();
        $del = $talentModel->delPreguntas($id_pregunta);

        if ($del) {
            $message = "Respuestas, eliminadas correctamente.";
            $session->setFlashdata('success_message', $message);
            return redirect()->to(base_url("home/forms/edit/$id_form/$tokn"));
        } else {
            //si no cumple con el formato
            $mensaje = "No se pueden eliminar las respuestas, verifique";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/forms/edit/$id_form/$tokn"));
        }
    }
    public function eliminarForm($id = NULL)
    {

        $session = session();
        $talentModel = new TalentModel();
        $del = $talentModel->delForm($id);

        if ($del) {
            $message = "Formulario, eliminado correctamente.";
            $session->setFlashdata('success_message', $message);
            return redirect()->to(base_url("home/forms"));
        } else {
            //si no cumple con el formato
            $mensaje = "No se puede eliminar el formulario, verifique";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/forms"));
        }


    }
    public function clonar($token = NULL)
    {
        $talentModel = new TalentModel();
        $data = $talentModel->getFormsID($token);
        $session = session();

        $inf = $data[0];
        $area = $inf->area;
        $vacante = $inf->vacante;

        $longitud = 45;
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $link = '';

        for ($i = 0; $i < $longitud; $i++) {
            $indice = rand(0, strlen($caracteres) - 1);
            $link .= $caracteres[$indice];
            $newL = $link;
        }

        $preguntas = []; // Arreglo para almacenar las preguntas y respuestas
        $clonado = 1;
        $id_form = $talentModel->saveForm($area, $vacante, $newL, $clonado);
        $talentModel->saveCalendly($id_form);


        foreach ($data as $formulario) {
            // Obtén los datos específicos de cada formulario
            $pregunta = $formulario->pregunta;
            $opciones = array($formulario->A, $formulario->B, $formulario->C, $formulario->D, $formulario->E, $formulario->F);
            $numero = $formulario->numero;

            // Agrega los datos al arreglo de preguntas y respuestas
            $preguntas[] = [
                'pregunta' => $pregunta,
                'opciones' => $opciones,
                'numero' => $numero
            ];

            // Guarda cada pregunta y respuesta en la base de datos
            $exito = $talentModel->guardarPregunta($id_form, $pregunta, $opciones, $numero);

            // Verifica si la inserción fue exitosa
            if (!$exito) {
                $mensaje = "No se pueden subir las preguntas, verifique";
                $session->setFlashdata('error_message', $mensaje);
                return redirect()->to(base_url("home/forms"));
            }
        }

        // Si todas las inserciones fueron exitosas, redirecciona con un mensaje de éxito
        $message = "Preguntas añadidas correctamente.";
        $session->setFlashdata('success_message', $message);
        return redirect()->to(base_url("home/forms"));
    }
    public function detailsapp($id_form = NULL, $id_user = NULL)
    {
        $id_form = trim($id_form);
        $id_user = trim($id_user);

        $talentModel = new TalentModel();
        $candidatos = $talentModel->getDetailsCandidatos($id_user, $id_form);

        $inf = $candidatos[0];
        $vacante = $inf->vacante;

        $array = ['id_form' => $id_form, 'id_user' => $id_user, 'candidatos' => $candidatos, 'vacante' => $vacante];

        return view("comercial/capitalHumanoGeneral/talent/respuestacandidatos", $array);
    }
    public function delAplicant($id = NULL, $id_form = NULL)
    {
        $session = session();
        $talentModel = new TalentModel();
        $del = $talentModel->delAplicant($id);

        if ($del) {
            $message = "Aplicante, eliminado correctamente.";
            $session->setFlashdata('success_message', $message);
            return redirect()->to(base_url("home/applicants/form/$id_form"));
        } else {
            //si no cumple con el formato
            $mensaje = "No se puede eliminar el candidato, verifique";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/applicants/form/$id_form"));
        }
    }
    public function viable($viable = NULL, $id_candidato = NULL)
    {
        // echo $id_candidato;

        $talentModel = new TalentModel();
        $emControll = new EmailController();
        $id_candidato = trim($id_candidato);
        $session = session();

        $candi = $talentModel->getViable($id_candidato);

        if (!empty($candi)) {

            //$actualiza = $talentModel->updateViable($viable, $id_candidato);

            if ($viable == "1") {

                $candidato = $talentModel->getCalendlyForm($id_candidato);
                $calendly = $candidato[0]->calendly;
                $name = $candidato[0]->nombre;
                $correo = $candidato[0]->correo;

                $array = [
                    'calendly' => $calendly,
                    'nombre' => $name,
                    'correo' => $correo
                ];

                $variable = $emControll->mailareas($array);
                $viableSave = $talentModel->updateViable($viable, $id_candidato);

                if ($variable && $viableSave) {

                    $message = "Aplicante, guardado y correo enviado exitosamente.";
                    $session->setFlashdata('success_message', $message);
                    return redirect()->to(base_url("home/applicants"));


                } else {

                    $mensaje = "No se puede guardar el candidato, verifique";
                    $session->setFlashdata('error_message', $mensaje);
                    return redirect()->to(base_url("home/applicants"));

                }

            } else {

                $candidato = $talentModel->getCalendlyForm($id_candidato);
                $name = $candidato[0]->nombre;
                $correo = $candidato[0]->correo;

                $array = [
                    'nombre' => $name,
                    'correo' => $correo
                ];

                $viableSave = $talentModel->updateViable($viable, $id_candidato);
                $variable = $emControll->mailareas($array);

                if ($variable && $viableSave) {

                    $message = "Aplicante, guardado y correo enviado exitosamente.";
                    $session->setFlashdata('success_message', $message);
                    return redirect()->to(base_url("home/applicants"));


                } else {

                    $mensaje = "No se puede guardar el candidato, verifique";
                    $session->setFlashdata('error_message', $mensaje);
                    return redirect()->to(base_url("home/applicants"));

                }

            }

        } else { // Si esta vacio

            //echo "para insertar nuevo";

            //echo $viable . " - " . $id_candidato;

            //  }

            if ($viable == "1") {

                $candidato = $talentModel->getCalendlyForm($id_candidato);
                $calendly = $candidato[0]->calendly;
                $name = $candidato[0]->nombre;
                $correo = $candidato[0]->correo;

                $array = [
                    'calendly' => $calendly,
                    'nombre' => $name,
                    'correo' => $correo
                ];

                $variable = $emControll->mailareas($array);
                $viableSave = $talentModel->saveViable($id_candidato, $viable);

                if ($variable && $viableSave) {

                    $message = "Aplicante, guardado y correo enviado exitosamente.";
                    $session->setFlashdata('success_message', $message);
                    return redirect()->to(base_url("home/applicants"));


                } else {

                    $mensaje = "No se puede guardar el candidato, verifique";
                    $session->setFlashdata('error_message', $mensaje);
                    return redirect()->to(base_url("home/applicants"));

                }

            } else {


                $candidato = $talentModel->getCalendlyForm($id_candidato);
                $name = $candidato[0]->nombre;
                $correo = $candidato[0]->correo;

                $array = [
                    'nombre' => $name,
                    'correo' => $correo
                ];


                $viableSave = $talentModel->saveViable($id_candidato, $viable);
                $variable = $emControll->mailareas($array);

                if ($variable && $viableSave) {

                    $message = "Aplicante, guardado y correo enviado exitosamente.";
                    $session->setFlashdata('success_message', $message);
                    return redirect()->to(base_url("home/applicants"));


                } else {

                    $mensaje = "No se puede guardar el candidato, verifique";
                    $session->setFlashdata('error_message', $mensaje);
                    return redirect()->to(base_url("home/applicants"));

                }

            }
        }
    }
    public function proceso($id_form = NULL)
    {
        $talentModel = new TalentModel();
        $viables = $talentModel->getCandidatosProceso($id_form);

        $t_viables = count($viables);

        $vacante = '';

        if ($t_viables > 0) {

            $vacante = $viables[0]->vacante;
        }

        // $vacante = $viables[0]->vacante;

        // Inicializar contadores
        $count_0 = 0;
        $count_1 = 0;
        $count_2 = 0;

        // Recorrer el array de usuarios
        foreach ($viables as $viable) {
            // Obtener el valor de viable_entre para el usuario actual
            $viable_entre = $viable->viable_entre;

            // Incrementar el contador correspondiente
            if ($viable_entre == 0) {
                $count_0++;
            } elseif ($viable_entre == 1) {
                $count_1++;
            } elseif ($viable_entre == 2) {
                $count_2++;
            }
        }

        // Retornar los contadores en un array asociativo
        $total_counts = array(
            'Con 0' => $count_0,
            'Con 1' => $count_1,
            'Con 2' => $count_2
        );

        $t_0_2 = $count_0 + $count_2;

        $array = ['viables' => $viables, 'vacante' => $vacante, 't_viables' => $t_viables, 'id_form' => $id_form, 't_sin' => $t_0_2, 'proces' => $count_1];

        // echo "<pre>";
        // print_r($array);
        // echo "</pre>";
        // exit();

        return view("comercial/capitalHumanoGeneral/talent/procesoAplicantes", $array);

    }
    public function formato($id_form = NULL, $id = NULL)
    {

        // echo $id_form;
        // exit();
        $talentModel = new TalentModel();
        $cc = new PreguntasController();

        $candidato = $talentModel->getCandidatoViable($id);
        $vacante = $candidato[0]->vacante;
        $nombre = $candidato[0]->nombre;
        $correo = $candidato[0]->correo;

        switch ($vacante) {

            case 'Becario Comercial':
                $data = $cc->comercial();
                break;

            case 'Becario Tableau':
                $data = $cc->tableau();
                break;

            case 'Becario Recursos Humanos':
                $data = $cc->rh();
                break;

            case 'Becario Project Management':
                $data = $cc->pm();
                break;

            case 'Becario Marketing':
                $data = $cc->mk();
                break;

            case 'Becario Administración':
                $data = $cc->admn();
                break;

            case 'Becario Desarrollo Software':
                $data = $cc->ds();
                break;

            case 'Becario Admon de servidores':
                $data = $cc->infra();
                break;

            case 'Becario Jurídico':
                //$data = $cc->ju();
                break;


            default:

        }


        $array = ['vacante' => $data, 'nombre' => $nombre, 'vacante_n' => $vacante, 'id_form' => $id_form, 'id_user' => $id, 'correo' => $correo];
        // echo "<pre>";
        // print_r($array);
        // echo "</pre>";
        // exit();
        return view("comercial/capitalHumanoGeneral/talent/formAplicante", $array);

    }
    public function saveFormato()
    {

        $id_user = $this->request->getPost('id_user');
        $calif_total = $this->request->getPost('calif_total');
        $coment = $this->request->getPost('coment');

        if ($calif_total >= 75) {
            $cal = 1;
        } else if ($calif_total < 75) {
            $cal = 2;
        }

        // echo $cal;

        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        // exit();

        $session = session();
        $perModel = new TalentModel();
        $update = $perModel->updateCalificacion($cal, $calif_total, $coment, $id_user);


        if ($update) {
            $message = "Aplicante, calificado correctamente.";
            $session->setFlashdata('success_message', $message);
            return redirect()->to(base_url("home/applicants"));
        } else {
            //si no cumple con el formato
            $mensaje = "No se puede eliminar el candidato, verifique";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/applicants"));
        }

    }
    public function prueba($id_form = NULL, $id = NULL)
    {

        $talentModel = new TalentModel();
        $emControll = new EmailController();
        $id_candidato = trim($id);
        $session = session();

        $candidato = $talentModel->getCandidatoViable($id);
        $vacante = $candidato[0]->vacante;
        $nombre = $candidato[0]->nombre;
        $correo = $candidato[0]->correo;

        $array = ['id_form' => $id_form, 'id_user' => $id, 'vacante' => $vacante, 'nombre' => $nombre, 'correo' => $correo];

        // echo "<pre>";
        // print_r($array);
        // echo "</pre>";
        // exit();

        return view("comercial/capitalHumanoGeneral/talent/periodoPrueba", $array);

    }
    public function ats()
    {

        $talentModel = new TalentModel();
        $session = session();

        $candidatos = $talentModel->getPruebas();
        $candidatos1 = $talentModel->getPruebas1();

        $array = ['candidatos' => $candidatos, 'candidatos1' => $candidatos1];

        // echo "<pre>";
        // echo print_r($array);
        // echo "</pre>";
        // exit();

        return view("comercial/capitalHumanoGeneral/talent/periodoPruebaDetalles", $array);


    }
    public function saveprueba()
    {

        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        // exit();
        $talentModel = new TalentModel();
        $session = session();

        $id_user = $this->request->getPost('id_user');
        $f_inicio = $this->request->getPost('f_inicio');
        $f_fin = $this->request->getPost('f_fin');
        $t_dias = $this->request->getPost('t_dias');
        $tipoPrueba = $this->request->getPost('tipoPrueba');
        $actividades = $this->request->getPost('actividades');

        $save = $talentModel->savePrueba($id_user, $f_inicio, $f_fin, $t_dias, $tipoPrueba, $actividades);

        if ($save) {
            $message = "Periodo guardado correctamente.";
            $session->setFlashdata('success_message', $message);
            return redirect()->to(base_url("home/applicants"));
        } else {

            $mensaje = "No se puede guardar el periodo, verifique";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/applicants"));
        }
    }
    public function eliminarCands($id_form = NULL, $token = NULL)
    {

        $token = trim($token);
        $id_form = trim($id_form);

    }
    public function formPrueba($id_form = NULL)
    {

        $talentModel = new TalentModel();
        $session = session();

        $users = $talentModel->getDetails($id_form);
        $users1 = $talentModel->getDetails1($id_form);
        $users0 = $talentModel->getDetails0($id_form);
        $tot = count($users);
        $tot1 = count($users1);
        $tot0 = count($users0);

        $vacante = '';

        if ($tot > 0) {
            $vacante = $users[0]->vacante;
        }

        // 1 viable 0 no viable
        $array = [
            'candidatos' => $users,
            'id_form' => $id_form,
            'tot' => $tot,
            'vacante' => $vacante,
            'viables' => $users1,
            'no_viables' => $users0,
            'tot_viables' => $tot1,
            'tot_no_viables' => $tot0

        ];

        // echo "<pre>";
        // print_r($users0);
        // echo "</pre>";
        // exit();

        return view("comercial/capitalHumanoGeneral/talent/pruebaSeguimiento", $array);
    }
    public function saveEditPrueba()
    {

        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        // exit();
        $talentModel = new TalentModel();
        $session = session();

        $id_form = $this->request->getPost('id_form');
        $id_prueba = $this->request->getPost('id_prueba');
        $f_inicio = $this->request->getPost('f_inicio');
        $f_fin = $this->request->getPost('f_fin');
        $t_dias = $this->request->getPost('t_dias');
        $tipoPrueba = $this->request->getPost('tipoPrueba');
        $actividades = $this->request->getPost('actividades');
        $enlace = $this->request->getPost('enlace');
        $viable = $this->request->getPost('viable');

        $save = $talentModel->updatePrueba($f_inicio, $f_fin, $t_dias, $tipoPrueba, $actividades, $enlace, $viable, $id_prueba);

        if ($save) {
            $message = "Aplicante editado correctamente.";
            $session->setFlashdata('success_message', $message);
            return redirect()->to(base_url("home/ats/form/$id_form"));
        } else {
            //si no cumple con el formato
            $mensaje = "No se puede editar el candidato, verifique";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/ats/form/$id_form"));
        }


    }
    public function delAplicantPrueba($id = NULL, $id_form = NULL)
    {
        $session = session();
        $talentModel = new TalentModel();
        $del = $talentModel->delAplicantPrueba($id);

        if ($del) {
            $message = "Prueba del candidato eliminada correctamente.";
            $session->setFlashdata('success_message', $message);
            return redirect()->to(base_url("home/ats/form/$id_form"));
        } else {
            //si no cumple con el formato
            $mensaje = "No se puede eliminar la prueba verifique";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/ats/form/$id_form"));
        }
    }
    public function final($id_form = NULL)
    {
        $talentModel = new TalentModel();

        $details = $talentModel->getFinalCands($id_form);

        $tot = count($details);

        $vacante = '';

        if ($tot > 0) {
            $vacante = $details[0]->vacante;
        }

        $array = ['detalles' => $details, 'vacante' => $vacante, 'tot' => $tot, 'id_form' => $id_form];

        // echo "<pre>";
        // echo print_r($details);
        // echo "</pre>";
        // exit();

        return view("comercial/capitalHumanoGeneral/talent/finalAplicants", $array);

    }
    public function candidat($id_form = NULL, $id_candidato = NULL)
    {

        $talentModel = new TalentModel();
        $id_form = trim($id_form);
        $id_candidato = trim($id_candidato);

        $longitud = 45;
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $link = '';

        $details = $talentModel->getFinalCands($id_form);
        $existToken = $talentModel->findToken($id_candidato, $id_form);

        $tok = $existToken[0]->token;
        $tipo = $existToken[0]->tipo;
        $nombre = $details[0]->nombre;
        $vacante = $details[0]->vacante;
        $enlace_prueba = $details[0]->enlace_prueba;

        $array = ['id_candidato' => $id_candidato, 'nombre' => $nombre, 'vacante' => $vacante, 'enlace' => $enlace_prueba, 'token' => $tok, 'id_form' => $id_form,'tipo' =>$tipo];
        // echo "<pre>";
        // print_r($array);
        // echo "</pre>";
        // exit();

        return view("comercial/capitalHumanoGeneral/talent/finalDoc", $array);
        // if ($tipo == 'Trabajo') {

        //     return view("comercial/capitalHumanoGeneral/talent/finalDoc", $array);
          
        // } else {

        //     return view("comercial/capitalHumanoGeneral/talent/finalDoc1", $array);
            
        // }

        // if ($existToken) {

        //     $tok = $existToken[0]->token;
        //     $nombre = $details[0]->nombre;
        //     $vacante = $details[0]->vacante;
        //     $enlace_prueba = $details[0]->enlace_prueba;

        //     $array = ['id_candidato' => $id_candidato, 'nombre' => $nombre, 'vacante' => $vacante, 'enlace' => $enlace_prueba, 'token' => $tok, 'id_form' => $id_form];

        //     // echo "<pre>";
        //     // print_r($array);
        //     // echo "</pre>";

        //     return view("comercial/capitalHumanoGeneral/talent/finalDoc", $array);

        // } else {

        //     for ($i = 0; $i < $longitud; $i++) {
        //         $indice = rand(0, strlen($caracteres) - 1);
        //         $link .= $caracteres[$indice];
        //         $newL = $link . "?use=1";
        //     }

        //     $candidat = $talentModel->saveToken($id_candidato, $id_form, $newL);
        //     $tok = $newL;
        //     $nombre = $details[0]->nombre;
        //     $vacante = $details[0]->vacante;
        //     $enlace_prueba = $details[0]->enlace_prueba;

        //     $array = ['id_candidato' => $id_candidato, 'nombre' => $nombre, 'vacante' => $vacante, 'enlace' => $enlace_prueba, 'token' => $tok, 'id_form' => $id_form];

        //     // echo "<pre>";
        //     // print_r($array);
        //     // echo "</pre>";

        //     return view("comercial/capitalHumanoGeneral/talent/finalDoc", $array);

        // }

    }

    public function form_candidat($id_user = NULL, $token = NULL)
    {

        echo "heavy";

    }

    public function savetypecand()
    {

        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";

        $talentModel = new TalentModel();
        $session = session();

        $nombre = $this->request->getPost('nombre');
        $id_form = $this->request->getPost('id_form');
        $id_user = $this->request->getPost('id_user');
        $tipo = $this->request->getPost('tipo');

        $longitud = 45;
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $link = '';

        for ($i = 0; $i < $longitud; $i++) {
            $indice = rand(0, strlen($caracteres) - 1);
            $link .= $caracteres[$indice];
            $newL = $link . "?use=1";
        }

        $existToken = $talentModel->findToken($id_user, $id_form);

        if (!$existToken) {

            $save = $talentModel->saveType($id_user, $id_form, $tipo, $newL);

            if ($save) {
                $message = "Tipo de aplicante editado correctamente.";
                $session->setFlashdata('success_message', $message);
                return redirect()->to(base_url("home/ats/final/$id_form"));
            } else {
                //si no cumple con el formato
                $mensaje = "No se puede editar Tipo de aplicante, verifique";
                $session->setFlashdata('error_message', $mensaje);
                return redirect()->to(base_url("home/ats/final/$id_form"));
            }

        } else {

            $update = $talentModel->updateType($tipo, $id_user);

            if ($update) {
                $message = "Tipo de aplicante editado correctamente.";
                $session->setFlashdata('success_message', $message);
                return redirect()->to(base_url("home/ats/final/$id_form"));
            } else {
                //si no cumple con el formato
                $mensaje = "No se puede editar Tipo de aplicante, verifique";
                $session->setFlashdata('error_message', $mensaje);
                return redirect()->to(base_url("home/ats/final/$id_form"));
            }

        }


        // echo "<pre>";
        // print_r($existToken);
        // echo "</pre>";
        // exit();



    }
}
