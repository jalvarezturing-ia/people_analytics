<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\NominaModel;
use App\Models\ColaboratorsModel;
use App\Models\AsistenciaModel;


class AsistenciaController extends BaseController
{

    public function assistence()
    {
        date_default_timezone_set('America/Mexico_City');
        setlocale(LC_TIME, "spanish");
        $fecha = date('Y-m-d');
        $user_id = session('user_id');
        $asistencia = "Entrada";
        $asisModel = new AsistenciaModel();
        $search = $asisModel->validates($fecha, $asistencia, $user_id);
        $info = $asisModel->getInfo($user_id);

        $name = $info[0]->nombre; 
        $apellido_paterno = $info[0]->apellido_paterno; 
        $apellido_materno = $info[0]->apellido_materno; 

        $completo = $name . " " .$apellido_paterno . " " . $apellido_materno;

        $data = ['valida' => $search, 'completo' => $completo];
        
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        //exit();

        return view("colaboradores/asistencia/entrada", $data);
    }

    public function saveassistence()
    {
        date_default_timezone_set('America/Mexico_City');
        setlocale(LC_TIME, "spanish");

        $session = session();

        $user_id = $this->request->getPost('user_id');
        $fecha = $this->request->getPost('fecha');
        $hora = $this->request->getPost('hora');

        /*$latitud = $this->request->getPost('latitud');
        $longitud = $this->request->getPost('longitud');
        echo "LAT: " . $latitud;
        echo "<br>";
        echo "LONG: " . $longitud;
        exit();*/

        $nombre_img = $_FILES['imagen']['name'];
        $asistencia = "Entrada";
        $permiso = "NO";


        $hora_obj = \DateTime::createFromFormat('h:i:s a', $hora);

        // Definir las horas límite para la validación
        $hora_limite_manana = \DateTime::createFromFormat('h:i:s a', '9:11:00 am');
        $hora_limite_tarde = \DateTime::createFromFormat('h:i:s a', '1:00:00 pm');

        // Realizar la validación
        if ($hora_obj >= $hora_limite_manana && $hora_obj <= $hora_limite_tarde) {
            $retardo = "SI";
        } else {
            $retardo = "NO";
        }

        /*echo $retardo;
        echo "<pre>";
        var_dump( $hora_limite_manana);
        var_dump( $hora_limite_tarde);
        echo "</pre>";

        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        exit();*/



        if (($nombre_img == !NULL) && ($_FILES['imagen']['size'] <= 200000000)) {

            if (
                ($_FILES["imagen"]["type"] == "image/gif")
                || ($_FILES["imagen"]["type"] == "image/jpeg")
                || ($_FILES["imagen"]["type"] == "image/jpg")
                || ($_FILES["imagen"]["type"] == "image/png")
            ) {

                $directorio = $_SERVER['DOCUMENT_ROOT'] . 'Turing-IA/public/prueb_asist/'; // ruta local en el servidor
                //$directorio = '/home/u378733989/domains/turing-latam.com/public_html/portal/public/fotos_colab/';
                /*IMPORTANTE! EL DIRECTORIO LOCAL NO ES EL MISMO QUE EL DEL DOMINIO, VALIDAR EL CODIGO COMENTADO DE $DIRECTORIO, PARA 
                SEGUIR ESA ESTRUCTURA DE DIRECTOTIOS PARA IMG, PDF Y DOC */

                if (!file_exists($directorio)) {
                    mkdir($directorio, 0777, true); // Crea el directorio si no existe 
                    //EL PERMISO 0777 es para acrhivos locales y el 0755 es para el del servidor 
                }
                $nombre_img = $_FILES['imagen']['name']; // Nombre del archivo

                //move_uploaded_file($_FILES['imagen']['tmp_name'],$directorio.$nombre_img);

                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio . $nombre_img)) {
                    //echo 'Archivo movido con éxito.';
                } else {
                    //echo 'Error al mover el archivo.';
                }

                $asisModel = new AsistenciaModel();


                $upload = $asisModel->saveinput($user_id, $fecha, $hora, $asistencia, $retardo, $permiso, $nombre_img);

                if ($upload) {
                    $message = "Asistencia, guardada correctamente.";
                    $session->setFlashdata('success_message', $message);
                    return redirect()->to(base_url('home/assistence'));
                } //fin tercer if


            } //fin segundo if
            else {
                //si no cumple con el formato
                $mensaje = "No se puede subir el archivo de imagen con ese formato, verifique";
                $session->setFlashdata('error_message', $mensaje);
                return redirect()->to(base_url('home/assistence'));
            }

        } //fin primer if
        else {
            //si existe la variable pero se pasa del tamaño permitido
            if ($nombre_img == !NULL)
                $mensaje = "La imagen es demasiado grande";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url('home/assistence'));
        }




        /*echo "<pre>";
        print_r($_POST);
        echo $nombre_img;
        echo "</pre>";*/

    }

    public function output()
    {
        date_default_timezone_set('America/Mexico_City');
        setlocale(LC_TIME, "spanish");
        $fecha = date('Y-m-d');
        $user_id = session('user_id');
        $asistencia = "Salida";
        $asisModel = new AsistenciaModel();
        $search = $asisModel->validat($fecha, $asistencia, $user_id);

        $info = $asisModel->getInfo($user_id);

        $name = $info[0]->nombre; 
        $apellido_paterno = $info[0]->apellido_paterno; 
        $apellido_materno = $info[0]->apellido_materno; 

        $completo = $name . " " .$apellido_paterno . " " . $apellido_materno;

        $data = ['valida' => $search, 'completo' => $completo];

        /*echo "<pre>";
        print_r($data);
        echo "</pre>";*/

        return view("colaboradores/asistencia/salida", $data);
    }

    public function saveoutput()
    {

        $session = session();
        $user_id = $this->request->getPost('user_id');
        $fecha = $this->request->getPost('fecha');
        $hora = $this->request->getPost('hora');
        $nombre_img = $_FILES['imagen']['name'];
        $asistencia = "Salida";
        $retardo = "--";
        $permiso = "--";

        if (($nombre_img == !NULL) && ($_FILES['imagen']['size'] <= 200000000)) {

            if (
                ($_FILES["imagen"]["type"] == "image/gif")
                || ($_FILES["imagen"]["type"] == "image/jpeg")
                || ($_FILES["imagen"]["type"] == "image/jpg")
                || ($_FILES["imagen"]["type"] == "image/png")
            ) {

                $directorio = $_SERVER['DOCUMENT_ROOT'] . 'Turing-IA/public/prueb_salid/'; // ruta local en el servidor
                //$directorio = '/home/u378733989/domains/turing-latam.com/public_html/portal/public/fotos_colab/';
                /*IMPORTANTE! EL DIRECTORIO LOCAL NO ES EL MISMO QUE EL DEL DOMINIO, VALIDAR EL CODIGO COMENTADO DE $DIRECTORIO, PARA 
                SEGUIR ESA ESTRUCTURA DE DIRECTOTIOS PARA IMG, PDF Y DOC */

                if (!file_exists($directorio)) {
                    mkdir($directorio, 0777, true); // Crea el directorio si no existe 
                    //EL PERMISO 0777 es para acrhivos locales y el 0755 es para el del servidor 
                }
                $nombre_img = $_FILES['imagen']['name']; // Nombre del archivo

                //move_uploaded_file($_FILES['imagen']['tmp_name'],$directorio.$nombre_img);

                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio . $nombre_img)) {
                    //echo 'Archivo movido con éxito.';
                } else {
                    //echo 'Error al mover el archivo.';
                }

                $asisModel = new AsistenciaModel();


                $upload = $asisModel->saveoutput($user_id, $fecha, $hora, $asistencia, $retardo, $permiso, $nombre_img);

                if ($upload) {
                    $message = "Hora de salida guardada correctamente.";
                    $session->setFlashdata('success_message', $message);
                    return redirect()->to(base_url('home/output'));
                } //fin tercer if


            } //fin segundo if
            else {
                //si no cumple con el formato
                $mensaje = "No se puede subir el archivo de imagen con ese formato, verifique";
                $session->setFlashdata('error_message', $mensaje);
                return redirect()->to(base_url('home/output'));
            }

        } //fin primer if
        else {
            //si existe la variable pero se pasa del tamaño permitido
            if ($nombre_img == !NULL)
                $mensaje = "La imagen es demasiado grande";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url('home/output'));
        }




        /*echo "<pre>";
        print_r($_POST);
        echo $nombre_img;
        echo "</pre>";*/

    }

    public function analysis()
    {
        $user_id = session('user_id');
        $asistencia0 = "Entrada";
        $asistencia1 = "Salida";

        $asisModel = new AsistenciaModel();
        $entrada = $asisModel->getentrada($asistencia0, $user_id);
        $salida = $asisModel->getsalida($asistencia1, $user_id);

        $data = ['entrada' => $entrada, 'salida' => $salida];


        /*echo "<pre>";
        print_r($data);
        echo "</pre>";*/


        return view("colaboradores/asistencia/analisis", $data);
    }

    public function attendance()
    {
        date_default_timezone_set('America/Mexico_City');
        setlocale(LC_TIME, "spanish");
        $fecha = date('Y-m-d');
        $date = strftime("%d/%B/%Y", strtotime($fecha));
        $asisModel = new AsistenciaModel();

        $general = $asisModel->getAllEntradas($fecha);
        $general2 = $asisModel->getAllMarcas($fecha);

        //print_r($general2);

        $salida = $asisModel->getAllSalidas($fecha);
        $salida2 = $asisModel->getAllMarcasSalidas($fecha);

        /* */
        $uno = $general[0];
        $t_entrada_marcados = $uno->marcados;
        $t_entrada_no_marcados = $uno->no_marcados;
        /* */

        /* */
        $info = $salida[0];
        $t_salida_marcados = $info->marcados;
        $t_salida_no_marcados = $info->no_marcados;
        /* */

        $data = [
            'lista' => $general2,
            'listasalidas' => $salida2,
            'tentrada' => $t_entrada_marcados,
            'tnoentrada' => $t_entrada_no_marcados,
            'fecha' => $date,
            'fecha1' => $date,
            'tsalida' => $t_salida_marcados,
            'tnosalida' => $t_salida_no_marcados,
        ];

        /*echo "<pre>";
        print_r($salida2);
        echo "</pre>";
        exit();**/

        return view("comercial/capitalHumanoGeneral/asistencia/asistencia", $data);
    }

    public function history()
    {

        $session = session();
        $user_id = session('user_id');
        $fecha_inicio = $this->request->getGet('start');
        $fecha_fin = $this->request->getGet('end');
        $tipo = $this->request->getGet('tipe');

        $asisModel = new AsistenciaModel();
        $history = $asisModel->getHistory($fecha_inicio, $fecha_fin, $user_id, $tipo);
        $entrada = NULL;
        $salida = NULL;


        $data = ['hist' => $history, 'entrada' => $entrada, 'salida' => $salida, 'inicio' => $fecha_inicio, 'fin' => $fecha_fin];

        return view("colaboradores/asistencia/analisis", $data);

        /*echo "<pre>";
        print_r($history);
        echo "</pre>";
        exit();*/
    }

    public function savecapture()
    {
        // print_r($_POST);

        $session = session();
        $id_hora = $this->request->getPost('id_hora');
        $nombre_img = $_FILES['imagen']['name'];


        if (($nombre_img == !NULL) && ($_FILES['imagen']['size'] <= 200000000)) {

            if (
                ($_FILES["imagen"]["type"] == "image/gif")
                || ($_FILES["imagen"]["type"] == "image/jpeg")
                || ($_FILES["imagen"]["type"] == "image/jpg")
                || ($_FILES["imagen"]["type"] == "image/png")
            ) {

                $directorio = $_SERVER['DOCUMENT_ROOT'] . 'Turing-IA/public/prueb_asist/'; // ruta local en el servidor
                //$directorio = '/home/u378733989/domains/turing-latam.com/public_html/portal/public/fotos_colab/';
                /*IMPORTANTE! EL DIRECTORIO LOCAL NO ES EL MISMO QUE EL DEL DOMINIO, VALIDAR EL CODIGO COMENTADO DE $DIRECTORIO, PARA 
                SEGUIR ESA ESTRUCTURA DE DIRECTOTIOS PARA IMG, PDF Y DOC */

                if (!file_exists($directorio)) {
                    mkdir($directorio, 0777, true); // Crea el directorio si no existe 
                    //EL PERMISO 0777 es para acrhivos locales y el 0755 es para el del servidor 
                }
                $nombre_img = $_FILES['imagen']['name']; // Nombre del archivo

                //move_uploaded_file($_FILES['imagen']['tmp_name'],$directorio.$nombre_img);

                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio . $nombre_img)) {
                    //echo 'Archivo movido con éxito.';
                } else {
                    //echo 'Error al mover el archivo.';
                }

                $asisModel = new AsistenciaModel();


                $upload = $asisModel->updateCaptura($nombre_img, $id_hora);

                if ($upload) {
                    $message = "Captura, editada correctamente.";
                    $session->setFlashdata('success_message', $message);
                    return redirect()->to(base_url('home/analysis'));
                } //fin tercer if


            } //fin segundo if
            else {
                //si no cumple con el formato
                $mensaje = "No se puede subir el archivo de imagen con ese formato, verifique";
                $session->setFlashdata('error_message', $mensaje);
                return redirect()->to(base_url('home/analysis'));
            }

        } //fin primer if
        else {
            //si existe la variable pero se pasa del tamaño permitido
            if ($nombre_img == !NULL)
                $mensaje = "La imagen es demasiado grande";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url('home/analysis'));
        }





    }

    public function saveedit()
    {
        $session = session();
        $asisModel = new AsistenciaModel();

        $nombre_img = $_FILES['imagen']['name'];
        $id_user = $this->request->getPost('id_user');
        $captura = $this->request->getPost('captura');
        $fecha_edit = $this->request->getPost('fecha_edit');
        $hora_actual = $this->request->getPost('hora_actual');
        $tipe = $this->request->getPost('tipo');

        if ($nombre_img == NULL) {

            $msj = $asisModel->updateHora1($fecha_edit, $hora_actual, $captura, $id_user);

            if ($msj) {
                $message = "Información editada correctamente.";
                $session->setFlashdata('success_message', $message);
                return redirect()->to(base_url('home/attendance'));
            }

        } else {

            if (($nombre_img == !NULL) && ($_FILES['imagen']['size'] <= 200000000)) {

                if (
                    ($_FILES["imagen"]["type"] == "image/gif")
                    || ($_FILES["imagen"]["type"] == "image/jpeg")
                    || ($_FILES["imagen"]["type"] == "image/jpg")
                    || ($_FILES["imagen"]["type"] == "image/png")
                ) {
                    if ($tipe == 'Entrada') {

                        $directorio = $_SERVER['DOCUMENT_ROOT'] . 'Turing-IA/public/prueb_asist/'; // ruta local en el servidor

                    } elseif ($tipe == 'Salida') {

                        $directorio = $_SERVER['DOCUMENT_ROOT'] . 'Turing-IA/public/prueb_salid/'; // ruta local en el servidor
                    }


                    //$directorio = '/home/u378733989/domains/turing-latam.com/public_html/portal/public/fotos_colab/';
                    /*IMPORTANTE! EL DIRECTORIO LOCAL NO ES EL MISMO QUE EL DEL DOMINIO, VALIDAR EL CODIGO COMENTADO DE $DIRECTORIO, PARA 
                    SEGUIR ESA ESTRUCTURA DE DIRECTOTIOS PARA IMG, PDF Y DOC */

                    if (!file_exists($directorio)) {
                        mkdir($directorio, 0777, true); // Crea el directorio si no existe 
                        //EL PERMISO 0777 es para acrhivos locales y el 0755 es para el del servidor 
                    }
                    $nombre_img = $_FILES['imagen']['name']; // Nombre del archivo

                    //move_uploaded_file($_FILES['imagen']['tmp_name'],$directorio.$nombre_img);

                    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio . $nombre_img)) {
                        //echo 'Archivo movido con éxito.';
                    } else {
                        //echo 'Error al mover el archivo.';
                    }


                    //$value = true;
                    $value = $asisModel->updateHora2($fecha_edit, $hora_actual, $nombre_img, $id_user);

                    if ($value) {
                        $message = "Captura, editada correctamente.";
                        $session->setFlashdata('success_message', $message);
                        return redirect()->to(base_url('home/attendance'));
                    } //fin tercer if*/


                } //fin segundo if
                else {
                    //si no cumple con el formato
                    $mensaje = "No se puede subir el archivo de imagen con ese formato, verifique";
                    $session->setFlashdata('error_message', $mensaje);
                    return redirect()->to(base_url('home/attendance'));
                }

            } //fin primer if
            else {
                //si existe la variable pero se pasa del tamaño permitido
                if ($nombre_img == !NULL)
                    $mensaje = "La imagen es demasiado grande";
                $session->setFlashdata('error_message', $mensaje);
                return redirect()->to(base_url('home/attendance'));
            }

        }
    }

    public function saveinputcolab()
    {
        $session = session();

        $id_user = $this->request->getPost('id_usuario');
        $fecha_edit = $this->request->getPost('fecha_edit');
        $hora_actual = $this->request->getPost('hora_actual');


        $nombre_img = $_FILES['imagen']['name'];
        $asistencia = "Entrada";
        $permiso = "NO";
        $retardo = "";
        /*echo $hora;
        echo "<br>";*/

        if ($fecha_edit >= "9:10:00 am" || $fecha_edit >= "1:00:00 pm") {
            $retardo = "SI";

        } else if ($fecha_edit <= "9:10:00 am") {

            $retardo = "NO";
        }



        if (($nombre_img == !NULL) && ($_FILES['imagen']['size'] <= 200000000)) {

            if (
                ($_FILES["imagen"]["type"] == "image/gif")
                || ($_FILES["imagen"]["type"] == "image/jpeg")
                || ($_FILES["imagen"]["type"] == "image/jpg")
                || ($_FILES["imagen"]["type"] == "image/png")
            ) {

                $directorio = $_SERVER['DOCUMENT_ROOT'] . 'Turing-IA/public/prueb_asist/'; // ruta local en el servidor
                //$directorio = '/home/u378733989/domains/turing-latam.com/public_html/portal/public/fotos_colab/';
                /*IMPORTANTE! EL DIRECTORIO LOCAL NO ES EL MISMO QUE EL DEL DOMINIO, VALIDAR EL CODIGO COMENTADO DE $DIRECTORIO, PARA 
                SEGUIR ESA ESTRUCTURA DE DIRECTOTIOS PARA IMG, PDF Y DOC */

                if (!file_exists($directorio)) {
                    mkdir($directorio, 0777, true); // Crea el directorio si no existe 
                    //EL PERMISO 0777 es para acrhivos locales y el 0755 es para el del servidor 
                }
                $nombre_img = $_FILES['imagen']['name']; // Nombre del archivo

                //move_uploaded_file($_FILES['imagen']['tmp_name'],$directorio.$nombre_img);

                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio . $nombre_img)) {
                    //echo 'Archivo movido con éxito.';
                } else {
                    //echo 'Error al mover el archivo.';
                }

                $asisModel = new AsistenciaModel();


                $upload = $asisModel->saveinput($id_user, $fecha_edit, $hora_actual, $asistencia, $retardo, $permiso, $nombre_img);

                if ($upload) {
                    $message = "Asistencia, guardada correctamente.";
                    $session->setFlashdata('success_message', $message);
                    return redirect()->to(base_url('home/attendance'));
                } //fin tercer if


            } //fin segundo if
            else {
                //si no cumple con el formato
                $mensaje = "No se puede subir el archivo de imagen con ese formato, verifique";
                $session->setFlashdata('error_message', $mensaje);
                return redirect()->to(base_url('home/attendance'));
            }

        } //fin primer if
        else {
            //si existe la variable pero se pasa del tamaño permitido
            if ($nombre_img == !NULL)
                $mensaje = "La imagen es demasiado grande";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url('home/attendance'));
        }


    }

    public function permits($user_id = NULL)
    {


        $asisModel = new AsistenciaModel();
        $session = session();
        $info = $asisModel->getInfo($user_id);
        $pendiente = $asisModel->getPendiente($user_id);
        $autorizados = $asisModel->getAutorizados($user_id);

        $total = count($autorizados);

        $title = "Nueva notificación";
        $body = "Se te aprobaron " . $total . " permisos de salida.";

        $data1 = array(
            'title' => $title,
            'total' => $total,
            'body' => $body,
        );

        $session->set('data', $data1);

        $data = $info[0];
        $name = $data->nombre . " " . $data->apellido_paterno . " " . $data->apellido_materno;
        $mail = $data->correo;
        $desc = $data->descripcion;
        $puesto = $data->puesto;

        $array = ['name' => $name, 'mail' => $mail, 'desc' => $desc, 'puesto' => $puesto, 'id' => $user_id, 'pendientes' => $pendiente, 'autorizados' => $autorizados];

        return view("colaboradores/asistencia/permisos", $array);

    }

    public function savepermit()
    {
        $session = session();

        date_default_timezone_set('America/Mexico_City');
        setlocale(LC_TIME, "spanish");
        $asisModel = new AsistenciaModel();
        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        exit();*/

        // Obtener las fechas y horas del formulario
        $f_salida = strtotime($this->request->getPost('f_salida'));
        $f_regreso = strtotime($this->request->getPost('f_regreso'));

        $user_id = $this->request->getPost('user_id');
        $motivo = $this->request->getPost('motivo');
        $f_salida_format = date("Y-m-d h:i A", $f_salida);
        $f_regreso_format = date("Y-m-d h:i A", $f_regreso);
        $horas_reponer = $this->request->getPost('horas_reponer');
        $motivo1 = $this->request->getPost('motivo1');
        $nombre_img = $_FILES['imagen']['name'];
        $estado = "Pendiente";
        $resuelta = "No";
        $tipo = "Permiso";
        $reset = "no";

        if (($nombre_img == !NULL) && ($_FILES['imagen']['size'] <= 200000000)) {

            if (
                ($_FILES["imagen"]["type"] == "image/gif")
                || ($_FILES["imagen"]["type"] == "image/jpeg")
                || ($_FILES["imagen"]["type"] == "image/jpg")
                || ($_FILES["imagen"]["type"] == "image/png")
            ) {

                $directorio = $_SERVER['DOCUMENT_ROOT'] . 'Turing-IA/public/permisos/'; // ruta local en el servidor
                //$directorio = '/home/u378733989/domains/turing-latam.com/public_html/portal/public/fotos_colab/';
                /*IMPORTANTE! EL DIRECTORIO LOCAL NO ES EL MISMO QUE EL DEL DOMINIO, VALIDAR EL CODIGO COMENTADO DE $DIRECTORIO, PARA 
                SEGUIR ESA ESTRUCTURA DE DIRECTOTIOS PARA IMG, PDF Y DOC */

                if (!file_exists($directorio)) {
                    mkdir($directorio, 0777, true); // Crea el directorio si no existe 
                    //EL PERMISO 0777 es para acrhivos locales y el 0755 es para el del servidor 
                }
                $nombre_img = $_FILES['imagen']['name']; // Nombre del archivo

                //move_uploaded_file($_FILES['imagen']['tmp_name'],$directorio.$nombre_img);

                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio . $nombre_img)) {
                    //echo 'Archivo movido con éxito.';
                } else {
                    //echo 'Error al mover el archivo.';
                }


                $true = $asisModel->savePermit($user_id, $tipo, $f_salida_format, $f_regreso_format, $horas_reponer, $estado, $motivo1, $nombre_img, $resuelta, $reset);


                if ($true) {
                    $message = "Permiso, guardado correctamente.";
                    $session->setFlashdata('success_message', $message);
                    return redirect()->to(base_url("home/permits/$user_id"));
                } //fin tercer if


            } //fin segundo if
            else {
                //si no cumple con el formato
                $mensaje = "No se puede subir el archivo de imagen con ese formato, verifique";
                $session->setFlashdata('error_message', $mensaje);
                return redirect()->to(base_url("home/permits/$user_id"));
            }

        } //fin primer if
        else {
            //si existe la variable pero se pasa del tamaño permitido
            if ($nombre_img == !NULL)
                $mensaje = "La imagen es demasiado grande";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/permits/$user_id"));
        }

    }

    public function savepermitt()
    {

        $session = session();

        date_default_timezone_set('America/Mexico_City');
        setlocale(LC_TIME, "spanish");
        $asisModel = new AsistenciaModel();
        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        exit();*/

        // Obtener las fechas y horas del formulario
        $f_salida = strtotime($this->request->getPost('f_salida'));
        $f_regreso = strtotime($this->request->getPost('f_regreso'));

        $user_id = $this->request->getPost('id_usuario');
        $motivo = $this->request->getPost('motivo');
        $f_salida_format = date("Y-m-d h:i A", $f_salida);
        $f_regreso_format = date("Y-m-d h:i A", $f_regreso);
        $horas_reponer = $this->request->getPost('horas_reponer');
        $motivo1 = $this->request->getPost('motivo1');
        $nombre_img = $_FILES['imagen']['name'];
        $estado = "Pendiente";
        $resuelta = "No";
        $tipo = "Permiso";
        $reset = "no";

        if (($nombre_img == !NULL) && ($_FILES['imagen']['size'] <= 200000000)) {

            if (
                ($_FILES["imagen"]["type"] == "image/gif")
                || ($_FILES["imagen"]["type"] == "image/jpeg")
                || ($_FILES["imagen"]["type"] == "image/jpg")
                || ($_FILES["imagen"]["type"] == "image/png")
            ) {

                $directorio = $_SERVER['DOCUMENT_ROOT'] . 'Turing-IA/public/permisos/'; // ruta local en el servidor
                //$directorio = '/home/u378733989/domains/turing-latam.com/public_html/portal/public/fotos_colab/';
                /*IMPORTANTE! EL DIRECTORIO LOCAL NO ES EL MISMO QUE EL DEL DOMINIO, VALIDAR EL CODIGO COMENTADO DE $DIRECTORIO, PARA 
                SEGUIR ESA ESTRUCTURA DE DIRECTOTIOS PARA IMG, PDF Y DOC */

                if (!file_exists($directorio)) {
                    mkdir($directorio, 0777, true); // Crea el directorio si no existe 
                    //EL PERMISO 0777 es para acrhivos locales y el 0755 es para el del servidor 
                }
                $nombre_img = $_FILES['imagen']['name']; // Nombre del archivo

                //move_uploaded_file($_FILES['imagen']['tmp_name'],$directorio.$nombre_img);

                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio . $nombre_img)) {
                    //echo 'Archivo movido con éxito.';
                } else {
                    //echo 'Error al mover el archivo.';
                }


                $true = $asisModel->savePermit($user_id, $tipo, $f_salida_format, $f_regreso_format, $horas_reponer, $estado, $motivo1, $nombre_img, $resuelta, $reset);


                if ($true) {
                    $message = "Permiso, guardado correctamente.";
                    $session->setFlashdata('success_message', $message);
                    return redirect()->to(base_url("home/permit"));
                } //fin tercer if


            } //fin segundo if
            else {
                //si no cumple con el formato
                $mensaje = "No se puede subir el archivo de imagen con ese formato, verifique";
                $session->setFlashdata('error_message', $mensaje);
                return redirect()->to(base_url("home/permit"));
            }

        } //fin primer if
        else {
            //si existe la variable pero se pasa del tamaño permitido
            if ($nombre_img == !NULL)
                $mensaje = "La imagen es demasiado grande";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/permit"));
        }

    }

    public function eliminarP($id = NULL, $captura = NULL)
    {
        $session = session();
        $id_per = trim($id);
        $cap = trim($captura);


        $user_id = session('user_id');
        $asisModel = new AsistenciaModel();
        $delete = $asisModel->deleteP($id_per);

        $ruta_archivo = $_SERVER['DOCUMENT_ROOT'] . "Turing-IA/public/permisos/$cap";

        // Verificar si el archivo existe antes de intentar eliminarlo
        if (file_exists($ruta_archivo)) {
            // Intentar eliminar el archivo
            if (unlink($ruta_archivo)) {
                //echo "El archivo se eliminó correctamente.";
            } else {
                //echo "No se pudo eliminar el archivo.";
            }
        } else {
            //echo "El archivo no existe.";
        }

        if ($delete) {

            $mensaje = "Solicitud eliminada con éxito.";
            $session->setFlashdata('success_message', $mensaje);
            return redirect()->to(base_url("home/permits/$user_id"));
        } else {

            $mensaje = "Algo salió mal, inténtelo más tarde.";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/permits/$user_id"));

        }

    }

    public function permit()
    {

        $session = session();
        $user_id = session('user_id');
        $colabModel = new ColaboratorsModel();
        $asisModel = new AsistenciaModel();
        $people = $colabModel->getPeople();
        $info = $asisModel->getPermisos();
        $info1 = $asisModel->getAprobados();


        $data = ['info' => $info, 'aprobado' => $info1, 'people' => $people];


        return view("comercial/capitalHumanoGeneral/asistencia/permisos", $data);
    }

    public function aprobP($id = NULL)
    {
        $session = session();
        $id_p = trim($id);
        $text = "Aprobado";

        $asisModel = new AsistenciaModel();
        $save = $asisModel->saveAprob($text, $id_p);

        if ($save) {
            $message = "Permiso, aprobado correctamente.";
            $session->setFlashdata('success_message', $message);
            return redirect()->to(base_url("home/permit"));
        } else {

            $message = "Ocurrio algun error, intente más tarde.";
            $session->setFlashdata('error_message', $message);
            return redirect()->to(base_url("home/permit"));

        }
    }

    public function savepermitDF()
    {
        $session = session();
        $asisModel = new AsistenciaModel();

        $nombre_img = $_FILES['imagen']['name'];
        $permiso_id = $this->request->getPost('permiso_id');
        $motivo = $this->request->getPost('motivo');
        $f_salida = $this->request->getPost('f_salida');
        $f_regreso = $this->request->getPost('f_regreso');
        $horas_reponer = $this->request->getPost('horas_reponer');
        $captura = $this->request->getPost('captura');

        if ($nombre_img == NULL) {

            $msj = $asisModel->updateEdit($motivo, $f_salida, $f_regreso, $horas_reponer, $captura, $permiso_id);

            if ($msj) {
                $message = "Información editada correctamente.";
                $session->setFlashdata('success_message', $message);
                return redirect()->to(base_url('home/permit'));
            }

        } else {

            if (($nombre_img == !NULL) && ($_FILES['imagen']['size'] <= 200000000)) {

                if (
                    ($_FILES["imagen"]["type"] == "image/gif")
                    || ($_FILES["imagen"]["type"] == "image/jpeg")
                    || ($_FILES["imagen"]["type"] == "image/jpg")
                    || ($_FILES["imagen"]["type"] == "image/png")
                ) {


                    $directorio = $_SERVER['DOCUMENT_ROOT'] . 'Turing-IA/public/permisos/'; // ruta local en el servidor


                    //$directorio = '/home/u378733989/domains/turing-latam.com/public_html/portal/public/fotos_colab/';
                    /*IMPORTANTE! EL DIRECTORIO LOCAL NO ES EL MISMO QUE EL DEL DOMINIO, VALIDAR EL CODIGO COMENTADO DE $DIRECTORIO, PARA 
                    SEGUIR ESA ESTRUCTURA DE DIRECTOTIOS PARA IMG, PDF Y DOC */

                    if (!file_exists($directorio)) {
                        mkdir($directorio, 0777, true); // Crea el directorio si no existe 
                        //EL PERMISO 0777 es para acrhivos locales y el 0755 es para el del servidor 
                    }
                    $nombre_img = $_FILES['imagen']['name']; // Nombre del archivo

                    //move_uploaded_file($_FILES['imagen']['tmp_name'],$directorio.$nombre_img);

                    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio . $nombre_img)) {
                        //echo 'Archivo movido con éxito.';
                    } else {
                        //echo 'Error al mover el archivo.';
                    }


                    //$value = true;
                    $value = $asisModel->updateEdit($motivo, $f_salida, $f_regreso, $horas_reponer, $nombre_img, $permiso_id);

                    if ($value) {
                        $message = "Captura, editada correctamente.";
                        $session->setFlashdata('success_message', $message);
                        return redirect()->to(base_url('home/permit'));
                    } //fin tercer if*/


                } //fin segundo if
                else {
                    //si no cumple con el formato
                    $mensaje = "No se puede subir el archivo de imagen con ese formato, verifique";
                    $session->setFlashdata('error_message', $mensaje);
                    return redirect()->to(base_url('home/permit'));
                }

            } //fin primer if
            else {
                //si existe la variable pero se pasa del tamaño permitido
                if ($nombre_img == !NULL)
                    $mensaje = "La imagen es demasiado grande";
                $session->setFlashdata('error_message', $mensaje);
                return redirect()->to(base_url('home/permit'));
            }

        }
    }

    public function deleteP($id = NULL)
    {

        $session = session();
        $id_per = trim($id);


        $user_id = session('user_id');
        $asisModel = new AsistenciaModel();
        $delete = $asisModel->deleteP($id_per);

        if ($delete) {

            $mensaje = "Solicitud eliminada con éxito.";
            $session->setFlashdata('success_message', $mensaje);
            return redirect()->to(base_url("home/permit"));
        } else {

            $mensaje = "Algo salió mal, inténtelo más tarde.";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/permit"));

        }

    }

    public function registro()
    {

        date_default_timezone_set('America/Mexico_City');
        setlocale(LC_TIME, "spanish");
        $fecha = date('Y-m-d');
        $date = strftime("%d/%B/%Y", strtotime($fecha));
        $asisModel = new AsistenciaModel();

        $general = $asisModel->getAllEntradas($fecha);
        $general2 = $asisModel->getAllMarcas($fecha);

        //print_r($general2);

        $salida = $asisModel->getAllSalidas($fecha);
        $salida2 = $asisModel->getAllMarcasSalidas($fecha);

        /* */
        $uno = $general[0];
        $t_entrada_marcados = $uno->marcados;
        $t_entrada_no_marcados = $uno->no_marcados;
        /* */

        /* */
        $info = $salida[0];
        $t_salida_marcados = $info->marcados;
        $t_salida_no_marcados = $info->no_marcados;
        /* */

        $data = [
            'lista' => $general2,
            'listasalidas' => $salida2,
            'tentrada' => $t_entrada_marcados,
            'tnoentrada' => $t_entrada_no_marcados,
            'fecha' => $date,
            'fecha1' => $date,
            'tsalida' => $t_salida_marcados,
            'tnosalida' => $t_salida_no_marcados,
        ];

        /*echo "<pre>";
        print_r($salida2);
        echo "</pre>";
        exit();**/

        return view("direccion/asistencia/asistencia", $data);

    }

    public function permisos()
    {

        $session = session();
        $user_id = session('user_id');
        $asisModel = new AsistenciaModel();
        $info = $asisModel->getPermisos();
        $info1 = $asisModel->getAprobados();

        $data = ['info' => $info, 'aprobado' => $info1];


        return view("direccion/asistencia/permisos", $data);

    }

    public function incidence($id = NULL)
    {
        $user_id = trim($id);
        $asisModel = new AsistenciaModel();
        $session = session();
        $info = $asisModel->getInfo($user_id);
        $reporte = $asisModel->getReporte($user_id);
        $proceso = $asisModel->getProceso($user_id);
        $repuestas = $asisModel->getRepuestas($user_id);

        $reporte1 = $asisModel->getReporte1($user_id);
        //$autorizados1 = $asisModel->getAutorizados1($user_id);

        $data = $info[0];
        $name = $data->nombre . " " . $data->apellido_paterno . " " . $data->apellido_materno;
        $mail = $data->correo;
        $desc = $data->descripcion;
        $puesto = $data->puesto;

        $tot = '0';
        $suma1 = 0;
        foreach ($reporte1 as $key1):
            $total1 = $key1->horas_reponer;
            $tot = $key1->h_restantes;
        endforeach;

        // Verificamos si $tot está vacío
        if ($tot == '') {
            $tot = '0';
        }


        /*$tot1 = '0';
        $suma = 0;
        foreach ($autorizados1 as $key):
            $total = $key->horas_reponer;
            $tot1 = $key->h_restantes;
        endforeach;*/

        // Verificamos si $tot está vacío
        if ($tot == '') {
            $tot = '0';
        }

        /*if ($tot1 == '') {
            $tot1 = '0';
        }*/


        // Construimos el array con las variables que necesitas pasar a la vista
        $array = [
            'tot' => $tot,
            //'tot1' => $tot1,
            'proceso' => $proceso,
            'name' => $name,
            'mail' => $mail,
            'desc' => $desc,
            'puesto' => $puesto,
            'id' => $user_id,
            'reporte' => $reporte,
            // 'autorizados' => $autorizados1,
            'reporte1' => $reporte1,
            'repuestas' => $repuestas
        ];

        /*echo "<pre>";
        print_r($array);
        echo "</pre>";
        //exit();*/

        // Retornamos la vista con el array de datos
        return view("colaboradores/asistencia/incidencia", $array);


    }

    public function eliminarPP($id = NULL)
    {
        $session = session();
        $id_per = trim($id);

        $user_id = session('user_id');
        $asisModel = new AsistenciaModel();
        $delete = $asisModel->deletePP($id_per);

        if ($delete) {

            $mensaje = "Solicitud eliminada con éxito.";
            $session->setFlashdata('success_message', $mensaje);
            return redirect()->to(base_url("home/incidence/$user_id"));
        } else {

            $mensaje = "Algo salió mal, inténtelo más tarde.";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/incidence/$user_id"));

        }

    }

    public function event()
    {

        $colabModel = new ColaboratorsModel();
        $asisModel = new AsistenciaModel();
        $people = $colabModel->getPeople();
        $reporte = $asisModel->getIncidencias();
        $repo = $asisModel->getRepo();



        $array = ['info' => $people, 'reporte' => $reporte, 'repo' => $repo];

        return view("comercial/capitalHumanoGeneral/asistencia/incidencias", $array);

    }

    public function saveincidencia()
    {

        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        exit();*/
        $session = session();
        date_default_timezone_set('America/Mexico_City');
        setlocale(LC_TIME, "spanish");
        $asisModel = new AsistenciaModel();
        $f_salida = strtotime($this->request->getPost('f_salida'));
        $f_regreso = strtotime($this->request->getPost('f_regreso'));
        $user_id = $this->request->getPost('id_usuario');
        //$motivo = $this->request->getPost('motivo');
        $motivo = "Incidencia";
        $f_salida_format = date("Y-m-d h:i A", $f_salida);
        $f_regreso_format = date("Y-m-d h:i A", $f_regreso);
        $horas_reponer = $this->request->getPost('horas_reponer');
        $motivo1 = $this->request->getPost('motivo1');
        $nombre_video = '';
        $estado = "Pendiente";
        $reset = "no";

        if (isset($_FILES['video']['name']) && $_FILES['video']['name'] !== '') {
            $nombre_video = $_FILES['video']['name'];
        }

        $resuelta = '';

        if ($nombre_video === '') {
            $resuelta = "Sin resolver";
            $f_regreso_format = "";
        } else {
            $resuelta = "Resuelta";
        }

        if (
            $nombre_video === '' || ($_FILES['video']['size'] <= 104857600 && (
                $_FILES["video"]["type"] == "video/mp4" ||
                $_FILES["video"]["type"] == "video/mpeg" ||
                $_FILES["video"]["type"] == "video/quicktime"
            ))
        ) {
            // Se cumple una de las siguientes condiciones:
            // 1. No se recibe ningún video
            // 2. Se recibe un video y cumple con los requisitos de tamaño y tipo

            if ($nombre_video !== '') {
                $directorio = $_SERVER['DOCUMENT_ROOT'] . 'Turing-IA/public/permisos/';
                if (!file_exists($directorio)) {
                    mkdir($directorio, 0777, true);
                }

                if (move_uploaded_file($_FILES['video']['tmp_name'], $directorio . $nombre_video)) {
                    // Archivo movido con éxito.
                } else {
                    // Error al mover el archivo.
                }
            }

            $true = $asisModel->saveIncidencia($user_id, $motivo, $f_salida_format, $f_regreso_format, $horas_reponer, $estado, $motivo1, $nombre_video, $resuelta, $reset);

            if ($true) {
                $message = "Incidencia, notificada correctamente.";
                $session->setFlashdata('success_message', $message);
                return redirect()->to(base_url("home/event"));
            }
        } else {
            $mensaje = $nombre_video === '' ? "No se recibió ningún video." : "El video es demasiado grande o tiene un formato incorrecto.";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/event"));
        }
    }

    public function closeincidencia()
    {

        $session = session();
        $id = $session->get('user_id');
        date_default_timezone_set('America/Mexico_City');
        setlocale(LC_TIME, "spanish");
        $asisModel = new AsistenciaModel();

        $id_incidencia = $this->request->getPost('id_incidencia');
        $resuelta = $this->request->getPost('resuelta');
        $motivo = $this->request->getPost('motivo');
        $f_regreso = strtotime($this->request->getPost('f_regreso'));
        $f_regreso_format = date("Y-m-d h:i A", $f_regreso);
        $horas_reponer = $this->request->getPost('h_reponer');
        $nombre_video = $_FILES['video']['name'];


        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        exit();*/

        if (isset($_FILES['video']['name']) && $_FILES['video']['name'] !== '') {
            $nombre_video = $_FILES['video']['name'];
        }

        if (
            $nombre_video === '' || ($_FILES['video']['size'] <= 104857600 && (
                $_FILES["video"]["type"] == "video/mp4" ||
                $_FILES["video"]["type"] == "video/mpeg" ||
                $_FILES["video"]["type"] == "video/quicktime"
            ))
        ) {
            // Se cumple una de las siguientes condiciones:
            // 1. No se recibe ningún video
            // 2. Se recibe un video y cumple con los requisitos de tamaño y tipo

            if ($nombre_video !== '') {
                $directorio = $_SERVER['DOCUMENT_ROOT'] . 'Turing-IA/public/permisos/';
                if (!file_exists($directorio)) {
                    mkdir($directorio, 0777, true);
                }

                if (move_uploaded_file($_FILES['video']['tmp_name'], $directorio . $nombre_video)) {
                    // Archivo movido con éxito.
                } else {
                    // Error al mover el archivo.
                }
            }

            $true = $asisModel->closeIncidencia($f_regreso_format, $horas_reponer, $nombre_video, $resuelta, $id_incidencia);

            if ($true) {
                $message = "Incidencia, cerrada correctamente.";
                $session->setFlashdata('success_message', $message);
                return redirect()->to(base_url("home/incidence/$id"));
            }
        } else {
            $mensaje = $nombre_video === '' ? "No se recibió ningún video." : "El video es demasiado grande o tiene un formato incorrecto.";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/incidence/$id"));
        }


    }

    public function gestion($id_user = NULL, $id_dato = NULL)
    {

        $id_user = trim($id_user);
        $id_dato = trim($id_dato);

        $asisModel = new AsistenciaModel();
        $info = $asisModel->getInfo($id_user);
        $datos = $asisModel->getid($id_user, $id_dato);


        $data = $info[0];
        $name = $data->nombre . " " . $data->apellido_paterno . " " . $data->apellido_materno;
        $mail = $data->correo;
        $desc = $data->descripcion;
        $puesto = $data->puesto;

        $array = ['id' => $id_user, 'name' => $name, 'mail' => $mail, 'desc' => $desc, 'puesto' => $puesto, 'datos' => $datos, 'id_dato' => $id_dato];

        return view("colaboradores/asistencia/reposicion", $array);

    }

    public function savegestion()
    {
        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        exit();*/

        $session = session();
        $id = $session->get('user_id');
        date_default_timezone_set('America/Mexico_City');
        setlocale(LC_TIME, "spanish");

        $asisModel = new AsistenciaModel();

        $user_id = $this->request->getPost('user_id');
        $id_dato = $this->request->getPost('id_dato');

        $f_salida = strtotime($this->request->getPost('f_inicio'));
        $f_regreso = strtotime($this->request->getPost('f_termino'));
        $f_salida_format = date("Y-m-d h:i A", $f_salida);
        $f_regreso_format = date("Y-m-d h:i A", $f_regreso);

        $horas_totales = $this->request->getPost('horas_totales');
        $horas_reponer = $this->request->getPost('horas_reponer');
        $horas_restantes = $this->request->getPost('horas_restantes');
        $forma = $this->request->getPost('forma');

        $save = $asisModel->saveRepo($id_dato, $f_salida_format, $f_regreso_format, $horas_reponer, $horas_restantes, $forma);

        if ($save) {

            $mensaje = "Formato registrado con éxito.";
            $session->setFlashdata('success_message', $mensaje);
            return redirect()->to(base_url("home/incidence/gestion/$user_id/$id_dato"));
        } else {

            $mensaje = "Algo salió mal, inténtelo más tarde.";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/incidence/gestion/$user_id/$id_dato"));

        }
    }

    public function reposicion($id_user = NULL, $id_dato = NULL)
    {
        $id_user = trim($id_user);
        $id_dato = trim($id_dato);

        $asisModel = new AsistenciaModel();
        $info = $asisModel->getInfo($id_user);
        $datos = $asisModel->detalleProceso($id_dato, $id_user);

        $data = $info[0];
        $name = $data->nombre . " " . $data->apellido_paterno . " " . $data->apellido_materno;
        $mail = $data->correo;
        $desc = $data->descripcion;
        $puesto = $data->puesto;

        $array = ['id' => $id_user, 'name' => $name, 'mail' => $mail, 'desc' => $desc, 'puesto' => $puesto, 'datos' => $datos, 'id_dato' => $id_dato];

        return view("colaboradores/asistencia/gestion", $array);
    }

    public function saveprimer()
    {

        /*echo "<pre>";
       print_r($_POST);
       echo "</pre>";
       exit();*/

        $session = session();
        $id = $session->get('user_id');
        date_default_timezone_set('America/Mexico_City');
        setlocale(LC_TIME, "spanish");

        $asisModel = new AsistenciaModel();

        $user_id = $this->request->getPost('user_id');
        $id_dato = $this->request->getPost('id_dato');
        $horas_reponer = $this->request->getPost('horas_reponer');
        $horas_restantes = $this->request->getPost('horas_restantes');
        $nombre_img = $_FILES['imagen']['name'];
        $nombre_img1 = $_FILES['imagen1']['name'];
        $finalizado = "1";


        if ($horas_restantes == '0') {
            $reset = "si";

            $asisModel->updateStatus($reset, $id_dato);

        } else {

            $reset = "no";

            $asisModel->updateStatus($reset, $id_dato);

        }



        if (($nombre_img == !NULL) && ($_FILES['imagen']['size'] <= 200000000)) {

            if (
                ($_FILES["imagen"]["type"] == "image/gif")
                || ($_FILES["imagen"]["type"] == "image/jpeg")
                || ($_FILES["imagen"]["type"] == "image/jpg")
                || ($_FILES["imagen"]["type"] == "image/png")
            ) {

                $directorio = $_SERVER['DOCUMENT_ROOT'] . 'Turing-IA/public/repo/'; // ruta local en el servidor
                //$directorio = '/home/u378733989/domains/turing-latam.com/public_html/portal/public/fotos_colab/';
                /*IMPORTANTE! EL DIRECTORIO LOCAL NO ES EL MISMO QUE EL DEL DOMINIO, VALIDAR EL CODIGO COMENTADO DE $DIRECTORIO, PARA 
                SEGUIR ESA ESTRUCTURA DE DIRECTOTIOS PARA IMG, PDF Y DOC */

                if (!file_exists($directorio)) {
                    mkdir($directorio, 0777, true); // Crea el directorio si no existe 
                    //EL PERMISO 0777 es para acrhivos locales y el 0755 es para el del servidor 
                }
                $nombre_img = $_FILES['imagen']['name']; // Nombre del archivo

                //move_uploaded_file($_FILES['imagen']['tmp_name'],$directorio.$nombre_img);

                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio . $nombre_img) && move_uploaded_file($_FILES['imagen1']['tmp_name'], $directorio . $nombre_img1)) {
                    //echo 'Archivo movido con éxito.';
                } else {
                    //echo 'Error al mover el archivo.';
                }


                $true = $asisModel->saveHoras($finalizado, $nombre_img, $nombre_img1, $id_dato);


                if ($true) {
                    $message = "Horas registradas correctamente.";
                    $session->setFlashdata('success_message', $message);
                    return redirect()->to(base_url("home/incidence/$user_id"));
                } //fin tercer if


            } //fin segundo if
            else {
                //si no cumple con el formato
                $mensaje = "No se puede subir el archivo de imagen con ese formato, verifique";
                $session->setFlashdata('error_message', $mensaje);
                return redirect()->to(base_url("home/incidence/$user_id"));
            }

        } //fin primer if
        else {
            //si existe la variable pero se pasa del tamaño permitido
            if ($nombre_img == !NULL)
                $mensaje = "La imagen es demasiado grande";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/incidence/$user_id"));
        }

        /*echo $nombre_img;
        echo "<br>";
        echo $nombre_img1;
        echo "<br>";
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        exit();*/

    }


    public function saveincidenciaa()
    {


        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        exit();*/

        $session = session();
        $asisModel = new AsistenciaModel();


        $captura = $this->request->getPost('captura');
        $id_dato = $this->request->getPost('id_dato');
        $descripcion = $this->request->getPost('descripcion');
        $f_salida = $this->request->getPost('f_salida');
        $f_regreso = $this->request->getPost('f_regreso');
        $horas_reponer = $this->request->getPost('horas_reponer');
        $nombre_video = $_FILES['video']['name'];

        if ($nombre_video == NULL) {

            //$msj = $asisModel->updateEdit($motivo, $f_salida, $f_regreso, $horas_reponer, $captura, $permiso_id);
            $msj = $asisModel->updateIncidente($f_salida, $f_regreso, $horas_reponer, $descripcion, $captura, $id_dato);

            if ($msj) {
                $message = "Información editada correctamente.";
                $session->setFlashdata('success_message', $message);
                return redirect()->to(base_url('home/event'));
            }

        } else {

            if ($nombre_video === '' || $_FILES['video']['size'] <= 104857600) {

                if (
                    ($_FILES["video"]["type"] == "video/mp4" ||
                        $_FILES["video"]["type"] == "video/mpeg" ||
                        $_FILES["video"]["type"] == "video/quicktime")
                ) {


                    $directorio = $_SERVER['DOCUMENT_ROOT'] . 'Turing-IA/public/permisos/'; // ruta local en el servidor


                    //$directorio = '/home/u378733989/domains/turing-latam.com/public_html/portal/public/fotos_colab/';
                    /*IMPORTANTE! EL DIRECTORIO LOCAL NO ES EL MISMO QUE EL DEL DOMINIO, VALIDAR EL CODIGO COMENTADO DE $DIRECTORIO, PARA 
                    SEGUIR ESA ESTRUCTURA DE DIRECTOTIOS PARA IMG, PDF Y DOC */

                    if (!file_exists($directorio)) {
                        mkdir($directorio, 0777, true); // Crea el directorio si no existe 
                        //EL PERMISO 0777 es para acrhivos locales y el 0755 es para el del servidor 
                    }
                    $nombre_video = $_FILES['video']['name'];

                    //move_uploaded_file($_FILES['imagen']['tmp_name'],$directorio.$nombre_img);

                    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio . $nombre_video)) {
                        //echo 'Archivo movido con éxito.';
                    } else {
                        //echo 'Error al mover el archivo.';
                    }


                    //$value = true;
                    $value = $asisModel->updateIncidente($f_salida, $f_regreso, $horas_reponer, $descripcion, $nombre_video, $id_dato);

                    if ($value) {
                        $message = "Captura, editada correctamente.";
                        $session->setFlashdata('success_message', $message);
                        return redirect()->to(base_url('home/permit'));
                    } //fin tercer if*/


                } //fin segundo if
                else {
                    //si no cumple con el formato
                    $mensaje = "No se puede subir el archivo de imagen con ese formato, verifique";
                    $session->setFlashdata('error_message', $mensaje);
                    return redirect()->to(base_url('home/permit'));
                }

            } //fin primer if
            else {
                //si existe la variable pero se pasa del tamaño permitido
                if ($nombre_video == !NULL)
                    $mensaje = "La imagen es demasiado grande";
                $session->setFlashdata('error_message', $mensaje);
                return redirect()->to(base_url('home/permit'));
            }

        }
    }

    public function hours($id_user = NULL)
    {

        $user_id = trim($id_user);
        $asisModel = new AsistenciaModel();
        $session = session();
        $info = $asisModel->getInfo($user_id);
        $dias = $asisModel->getDias($user_id);


        $data = $info[0];
        $name = $data->nombre . " " . $data->apellido_paterno . " " . $data->apellido_materno;
        $mail = $data->correo;
        $desc = $data->descripcion;
        $puesto = $data->puesto;

        $array = [

            'name' => $name,
            'mail' => $mail,
            'desc' => $desc,
            'puesto' => $puesto,
            'id' => $user_id,
            'dias' => $dias
        ];

        return view("colaboradores/asistencia/horas", $array);
    }

    public function savefinsemana()
    {

        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        exit();*/

        $session = session();
        $asisModel = new AsistenciaModel();


        $user_id = $this->request->getPost('user_id');
        $año = $this->request->getPost('año');
        $mes = $this->request->getPost('mes');
        $f_inicio = strtotime($this->request->getPost('f_inicio'));
        $f_fin = strtotime($this->request->getPost('f_fin'));
        $f_salida_format = date("Y-m-d h:i A", $f_inicio);
        $f_regreso_format = date("Y-m-d h:i A", $f_fin);
        $horas_trabajar = $this->request->getPost('horas_trabajar');
        $jornada = $this->request->getPost('jornada');

        $insert = $asisModel->saveFines(
            $user_id,
            $año,
            $mes,
            $f_salida_format,
            $f_regreso_format,
            $horas_trabajar,
            $jornada
        );

        if ($insert) {

            $mensaje = "Formato registrado con éxito.";
            $session->setFlashdata('success_message', $mensaje);
            return redirect()->to(base_url("home/hours/$user_id"));
        } else {

            $mensaje = "Algo salió mal, inténtelo más tarde.";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/hours/$user_id"));

        }

    }

    public function saveExtras()
    {
        /*$nombre_img = $_FILES['imagen']['name'];
        $nombre_img1 = $_FILES['imagen1']['name'];
        echo $nombre_img;
        echo "<br>";
        echo $nombre_img1;
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        exit();*/

        $session = session();
        $id = $session->get('user_id');
        date_default_timezone_set('America/Mexico_City');
        setlocale(LC_TIME, "spanish");

        $asisModel = new AsistenciaModel();

        $user_id = $this->request->getPost('user_id');
        $id_dato = $this->request->getPost('dato_id');
        $actividades = $this->request->getPost('actividades');

        $nombre_img = $_FILES['imagen']['name'];
        $nombre_img1 = $_FILES['imagen1']['name'];



        if (($nombre_img == !NULL) && ($_FILES['imagen']['size'] <= 200000000)) {

            if (
                ($_FILES["imagen"]["type"] == "image/gif")
                || ($_FILES["imagen"]["type"] == "image/jpeg")
                || ($_FILES["imagen"]["type"] == "image/jpg")
                || ($_FILES["imagen"]["type"] == "image/png")
            ) {

                $directorio = $_SERVER['DOCUMENT_ROOT'] . 'Turing-IA/public/dias/'; // ruta local en el servidor
                //$directorio = '/home/u378733989/domains/turing-latam.com/public_html/portal/public/fotos_colab/';
                /*IMPORTANTE! EL DIRECTORIO LOCAL NO ES EL MISMO QUE EL DEL DOMINIO, VALIDAR EL CODIGO COMENTADO DE $DIRECTORIO, PARA 
                SEGUIR ESA ESTRUCTURA DE DIRECTOTIOS PARA IMG, PDF Y DOC */

                if (!file_exists($directorio)) {
                    mkdir($directorio, 0777, true); // Crea el directorio si no existe 
                    //EL PERMISO 0777 es para acrhivos locales y el 0755 es para el del servidor 
                }
                $nombre_img = $_FILES['imagen']['name']; // Nombre del archivo

                //move_uploaded_file($_FILES['imagen']['tmp_name'],$directorio.$nombre_img);

                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio . $nombre_img) && move_uploaded_file($_FILES['imagen1']['tmp_name'], $directorio . $nombre_img1)) {
                    //echo 'Archivo movido con éxito.';
                } else {
                    //echo 'Error al mover el archivo.';
                }


                $true = $asisModel->saveDias($nombre_img, $nombre_img1, $actividades, $id_dato);


                if ($true) {
                    $message = "Evidencias registradas correctamente.";
                    $session->setFlashdata('success_message', $message);
                    return redirect()->to(base_url("home/hours/$user_id"));
                } //fin tercer if


            } //fin segundo if
            else {
                //si no cumple con el formato
                $mensaje = "No se puede subir el archivo de imagen con ese formato, verifique";
                $session->setFlashdata('error_message', $mensaje);
                return redirect()->to(base_url("home/hours/$user_id"));
            }

        } //fin primer if
        else {
            //si existe la variable pero se pasa del tamaño permitido
            if ($nombre_img == !NULL)
                $mensaje = "La imagen es demasiado grande";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/hours/$user_id"));
        }
    }

    public function extras()
    {

        $asisModel = new AsistenciaModel();
        $data = $asisModel->getAllDias();

        $array = ['data' => $data];
        return view("comercial/capitalHumanoGeneral/asistencia/extras", $array);
    }


    public function market()
    {

        $asisModel = new AsistenciaModel();
        $data = $asisModel->getAllDias();

        $array = ['data' => $data];
        return view("direccion/asistencia/dias", $array);

    }

    public function list($año = NULL, $mes = NULL)
    {

        $año = trim($año);
        $asisModel = new AsistenciaModel();
        $data = $asisModel->getAllDiass($año, $mes);
        /*echo "<pre>";
        print_r($data);
        echo "</pre>";*/
        $array = ['año' => $año, 'mes' => $mes, 'data' => $data];


        return view("comercial/capitalHumanoGeneral/asistencia/extrasColabs", $array);

    }

    public function incidencias()
    {


        $colabModel = new ColaboratorsModel();
        $asisModel = new AsistenciaModel();
        $people = $colabModel->getPeople();
        $reporte = $asisModel->getIncidencias();
        $repo = $asisModel->getRepo();

        $array = ['info' => $people, 'reporte' => $reporte, 'repo' => $repo];

        return view("direccion/asistencia/incidencias", $array);

    }

    public function vacations($id_user = NULL)
    {

        date_default_timezone_set('America/Mexico_City');
        setlocale(LC_TIME, "spanish");
        $user_id = trim($id_user);
        $asisModel = new AsistenciaModel();
        $session = session();
        $info = $asisModel->getInfo1($user_id);
        $vacaciones = $asisModel->getVacaciones($user_id);
        $vacacioness = $asisModel->getVacacioness($user_id);

        $data = $info[0];
        $name = $data->nombre . " " . $data->apellido_paterno . " " . $data->apellido_materno;
        $mail = $data->correo;
        $desc = $data->descripcion;
        $puesto = $data->puesto;
        $ingreso = $data->fecha_ingreso;

        // Calcula la fecha actual y la fecha de ingreso en timestamps
        $fecha_actual = time();
        $fecha_ingreso = strtotime($ingreso);

        // Calcula la diferencia en segundos entre la fecha actual y la fecha de ingreso
        $diferencia_segundos = $fecha_actual - $fecha_ingreso;

        // Convierte la diferencia en segundos a años
        $anios_pasados = floor($diferencia_segundos / (60 * 60 * 24 * 365));


        $dias_vacaciones = '';

        // Realizar la validación y calcular la cantidad de días de vacaciones
        if ($anios_pasados == 0) {
            //echo "No tienes derecho a vacaciones aún.";
            $dias_vacaciones = '0';
        } else {
            // Calcular la cantidad de días de vacaciones según los años de antigüedad
            $dias_vacaciones = 12 + ($anios_pasados - 1) * 2;
            //echo "Tienes derecho a $dias_vacaciones días de vacaciones.";
        }


        $doc = ""; // Nombre del directorio
        $directorio = FCPATH . 'd_vacas/' . $doc;

        if (is_dir($directorio)) { // Verificar si el directorio existe
            $archivos = scandir($directorio);

            // Eliminar los elementos "." y ".." del array (que representan el directorio actual y el directorio padre)
            $archivos = array_diff($archivos, array('.', '..'));

            // Mostrar los nombres de los archivos
            foreach ($archivos as $archivo) {
                //echo $archivo . "<br>";
            }
        } else {
            //echo "El directorio $directorio no existe.";
        }


        if (empty($archivo)) {


            $array = [

                'name' => $name,
                'mail' => $mail,
                'desc' => $desc,
                'puesto' => $puesto,
                'id' => $user_id,
                'años' => $anios_pasados,
                'ingreso' => $dias_vacaciones,
                'vacaciones' => $vacaciones,
                'vacacioness' => $vacacioness,
                'archivo' => ''
            ];

        } else {

            $array = [

                'name' => $name,
                'mail' => $mail,
                'desc' => $desc,
                'puesto' => $puesto,
                'id' => $user_id,
                'años' => $anios_pasados,
                'ingreso' => $dias_vacaciones,
                'vacaciones' => $vacaciones,
                'vacacioness' => $vacacioness,
                'archivo' => $archivo
            ];
        }



        /*echo "<pre>";
        print_r($array);
        echo "</pre>";
        exit();*/

        return view("colaboradores/asistencia/vacaciones", $array);

    }

    public function savevacas()
    {

        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        $session = session();
        $asisModel = new AsistenciaModel();

        $user_id = $this->request->getPost('user_id');
        $totales = $this->request->getPost('totales');
        $restantes = $this->request->getPost('restantes');
        $f_inicio = $this->request->getPost('f_inicio');
        $f_fin = $this->request->getPost('f_fin');
        $d_solicitados = $this->request->getPost('d_solicitados');

        $nombre_doc = $_FILES['documento']['name'];
        $tipo = $_FILES['documento']['type'];
        $tamano = $_FILES['documento']['size'];
        $directorio = $_SERVER['DOCUMENT_ROOT'] . 'Turing-IA/public/d_vacas/';



        if (
            ($nombre_doc != '') && ($tipo == 'application/msword' || $tipo ==
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || $tipo == 'application/pdf')
        ) {

            //$directorio = $_SERVER['DOCUMENT_ROOT'] . 'frameworkCD/public/documentos/'; // Ruta local en el servidor
            $directorio = $_SERVER['DOCUMENT_ROOT'] . 'Turing-IA/public/d_vacas/';

            if (!file_exists($directorio)) {
                mkdir($directorio, 0777, true);
            }

            $nombre_archivo = $_FILES['documento']['name'];
            if (move_uploaded_file($_FILES['documento']['tmp_name'], $directorio . $nombre_archivo)) {
               
            } else {
                
            }



            $asisModel->savevacas($user_id, $totales, $restantes, $f_inicio, $f_fin, $d_solicitados, $nombre_doc);


            if ($asisModel):
                $mensaje = "Formato registrado con éxito.";
                $session->setFlashdata('success_message', $mensaje);
                return redirect()->to(base_url("home/vacations/$user_id"));
            else:
                $mensaje = "Algo salió mal, inténtelo más tarde.";
                $session->setFlashdata('error_message', $mensaje);
                return redirect()->to(base_url("home/vacations/$user_id"));
            endif;


        } else {

            $mensaje = "Algo salió mal, inténtelo más tarde.";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/vacaciones"));
        }

    }

    public function edit($id_user = NULL, $id_dato = NULL, $dias = NULL, $f_inicio = NULL, $f_fin = NULL, $restantes = NULL, $d_solicitados = NULL)
    {

        $array = [
            'id_user' => $id_user,
            'id_dato' => $id_dato,
            'dias' => $dias,
            'f_inicio' => $f_inicio,
            'f_fin' => $f_fin,
            'restantes' => $restantes,
            'd_solicitados' => $d_solicitados,

        ];
        return view("colaboradores/asistencia/editvacaciones", $array);

    }

    public function savevacasedit()
    {


        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        $session = session();
        $asisModel = new AsistenciaModel();


        $user_id = $this->request->getPost('user_id');
        $id_dato = $this->request->getPost('id_dato');
        $restantes = $this->request->getPost('restantes');
        $f_inicio = $this->request->getPost('f_inicio');
        $f_fin = $this->request->getPost('f_fin');
        $d_solicitados = $this->request->getPost('d_solicitados');

        $asisModel->savevacasedit($restantes, $f_inicio, $f_fin, $d_solicitados, $id_dato);

        if ($asisModel):
            $mensaje = "Formato editado con éxito.";
            $session->setFlashdata('success_message', $mensaje);
            return redirect()->to(base_url("home/vacations/$user_id"));
        else:
            $mensaje = "Algo salió mal, inténtelo más tarde.";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/vacations/$user_id"));
        endif;


    }


    public function eliminarV($id = NULL)
    {

        $id_per = trim($id);
        $session = session();
        $user_id = session('user_id');
        $asisModel = new AsistenciaModel();
        $delete = $asisModel->eliminarV($id_per);

        if ($delete) {

            $mensaje = "Solicitud eliminada con éxito.";
            $session->setFlashdata('success_message', $mensaje);
            return redirect()->to(base_url("home/vacations/$user_id"));
        } else {

            $mensaje = "Algo salió mal, inténtelo más tarde.";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/vacations/$user_id"));

        }

    }

    public function vacaciones()
    {


        $asisModel = new AsistenciaModel();
        $info = $asisModel->getVacacionesAdm();

        $doc = ""; // Nombre del directorio
        $directorio = FCPATH . 'd_vacas/' . $doc;

        if (is_dir($directorio)) { // Verificar si el directorio existe
            $archivos = scandir($directorio);

            // Eliminar los elementos "." y ".." del array (que representan el directorio actual y el directorio padre)
            $archivos = array_diff($archivos, array('.', '..'));

            // Mostrar los nombres de los archivos
            foreach ($archivos as $archivo) {
                //echo $archivo . "<br>";
            }
        } else {
            //echo "El directorio $directorio no existe.";
        }

        if (empty($archivo)) {

            $array = ['info' => $info, 'archivo' => ''];

        } else {
            $array = ['info' => $info, 'archivo' => $archivo];
        }



        /*echo "<pre>";
        print_r($array);
        echo "</pre>";
        exit();*/

        //$array = ['info' => $info];
        return view("comercial/capitalHumanoGeneral/asistencia/vacaciones", $array);

    }

    public function savevacasadmin()
    {

        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";

        $id_periodo = $this->request->getPost('id_periodo');
        $estado_seleccionado = $this->request->getPost('estado_seleccionado');

        $estado = "";

        if ($estado_seleccionado == 'Aprobar') {

            $estado = "1";

        } else if ($estado_seleccionado == 'Rechazar') {

            $estado = "2";
        } else if ($estado_seleccionado == 'Pendiente') {

            $estado = "3";
        }

        $session = session();
        $asisModel = new AsistenciaModel();
        $info = $asisModel->setUpdates($estado, $id_periodo);

        if ($info):
            $mensaje = "Formato guardado con éxito.";
            $session->setFlashdata('success_message', $mensaje);
            return redirect()->to(base_url("home/vacaciones"));
        else:
            $mensaje = "Algo salió mal, inténtelo más tarde.";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/vacaciones"));
        endif;

    }

    public function editvaccap($id_dato = NULL, $dias_totales = NULL, $f_inicio = NULL, $f_fin = NULL, $restantes = NULL, $d_solicitados = NULL)
    {


        $array = [
            'id_dato' => $id_dato,
            'dias' => $dias_totales,
            'f_inicio' => $f_inicio,
            'f_fin' => $f_fin,
            'restantes' => $restantes,
            'd_solicitados' => $d_solicitados,

        ];
        //return view("colaboradores/asistencia/editvacaciones", $array);

        return view("comercial/capitalHumanoGeneral/asistencia/editvacaciones", $array);

    }

    public function savevacaseditadmin()
    {


        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        $session = session();
        $asisModel = new AsistenciaModel();


        $id_dato = $this->request->getPost('id_dato');
        $restantes = $this->request->getPost('restantes');
        $f_inicio = $this->request->getPost('f_inicio');
        $f_fin = $this->request->getPost('f_fin');
        $d_solicitados = $this->request->getPost('d_solicitados');

        $nombre_doc = $_FILES['documento']['name'];
        $tipo = $_FILES['documento']['type'];
        $tamano = $_FILES['documento']['size'];
        $directorio = $_SERVER['DOCUMENT_ROOT'] . 'Turing-IA/public/d_vacas/';



        
        if (
            ($nombre_doc != '') && ($tipo == 'application/msword' || $tipo ==
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || $tipo == 'application/pdf')
        ) {

            //$directorio = $_SERVER['DOCUMENT_ROOT'] . 'frameworkCD/public/documentos/'; // Ruta local en el servidor
            $directorio = $_SERVER['DOCUMENT_ROOT'] . 'Turing-IA/public/d_vacas/';

            if (!file_exists($directorio)) {
                mkdir($directorio, 0777, true);
            }

            $nombre_archivo = $_FILES['documento']['name'];
            if (move_uploaded_file($_FILES['documento']['tmp_name'], $directorio . $nombre_archivo)) {
               
            } else {
                
            }


        $asisModel->savevacasedit($restantes, $f_inicio, $f_fin, $d_solicitados,  $nombre_doc ,$id_dato);

        if ($asisModel):
            $mensaje = "Formato editado con éxito.";
            $session->setFlashdata('success_message', $mensaje);
            return redirect()->to(base_url("home/vacaciones"));
        else:
            $mensaje = "Algo salió mal, inténtelo más tarde.";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/vacaciones"));
        endif;


        } else {

            $mensaje = "Algo salió mal, inténtelo más tarde.";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/vacaciones"));
        }
        


    }


    public function deleteVacax($id = NULL)
    {

        $id_per = trim($id);
        $session = session();
        $user_id = session('user_id');
        $asisModel = new AsistenciaModel();
        $delete = $asisModel->eliminarV($id_per);

        if ($delete) {

            $mensaje = "Solicitud eliminada con éxito.";
            $session->setFlashdata('success_message', $mensaje);
            return redirect()->to(base_url("home/vacaciones"));
        } else {

            $mensaje = "Algo salió mal, inténtelo más tarde.";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/vacations"));

        }

    }

    public function document()
    {
        $session = session();

        $nombre_doc = $_FILES['documento']['name'];
        $tipo = $_FILES['documento']['type'];
        $tamano = $_FILES['documento']['size'];

        $directorio = $_SERVER['DOCUMENT_ROOT'] . 'Turing-IA/public/d_vacas/';

        // Obtener el nombre del archivo existente (si existe)
        $archivo_existente = $directorio . $nombre_doc;

        // Verificar si el archivo existente debe eliminarse
        if (file_exists($archivo_existente)) {
            // Intentar eliminar el archivo existente
            if (unlink($archivo_existente)) {
                // El archivo existente se eliminó correctamente
                // Continuar con la subida del nuevo archivo
            } else {
                // No se pudo eliminar el archivo existente
                $mensaje = "No se pudo eliminar el archivo existente.";
                $session->setFlashdata('error_message', $mensaje);
                return redirect()->to(base_url("home/vacaciones"));
            }
        }

        // Verificar si se recibió un archivo y si es un tipo válido
        if (
            !empty($nombre_doc) && (
                $tipo == 'application/msword' ||
                $tipo == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ||
                $tipo == 'application/pdf'
            )
        ) {
            // Verificar si el directorio existe y, si no, crearlo
            if (!file_exists($directorio)) {
                mkdir($directorio, 0777, true);
            }

            // Subir el nuevo archivo
            if (move_uploaded_file($_FILES['documento']['tmp_name'], $directorio . $nombre_doc)) {
                $mensaje = "Formato guardado con éxito.";
                $session->setFlashdata('success_message', $mensaje);
            } else {
                // Ocurrió un error al subir el nuevo archivo
                $mensaje = "Algo salió mal al subir el archivo.";
                $session->setFlashdata('error_message', $mensaje);
            }
        } else {
            // No se recibió un archivo o es un tipo no válido
            $mensaje = "Por favor, seleccione un archivo válido.";
            $session->setFlashdata('error_message', $mensaje);
        }

        // Redirigir de vuelta a la página de vacaciones
        return redirect()->to(base_url("home/vacaciones"));
    }

}