<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\DocumentosModel;
use App\Models\NominaModel;

class DocumentosController extends BaseController
{

    public function save_new()
    {
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        // exit();

        $session = session();
        $id_form = $this->request->getPost('id_form');
        $id_usuario = $this->request->getPost('id_candidato');
        $nombre = $this->request->getPost('nombre');
        $apellido_paterno = $this->request->getPost('apellido_paterno');
        $apellido_materno = $this->request->getPost('apellido_materno');
        $telefono = $this->request->getPost('telefono');
        $correo = $this->request->getPost('correo');
        $nombre_area = $this->request->getPost('nombre_area');
        $descripcion = $this->request->getPost('descripcion');
        $puesto = $this->request->getPost('puesto');
        $fecha_nacimiento = $this->request->getPost('fecha_nacimiento');
        $fecha_ingreso = $this->request->getPost('fecha_ingreso');
        $direccion = $this->request->getPost('direccion');
        $fecha_egreso = "0";
        $foto_perfil = "Captura.PNG";
        $sexo = $this->request->getPost('sexo');
        $new_password = "Turing-IA1People";
        $v_password = "Turing-IA1People";
        $rol = "colab";
        $title = "Portal Turing-IA People Analytics";

        $nombre_banco = $this->request->getPost('nombre_banco');
        $numero_cuenta = $this->request->getPost('numero_cuenta');
        $clabe_interbancaria = $this->request->getPost('clabe_interbancaria');
        $pago_mensual_base = $this->request->getPost('pago_mensual_base');
        $pago_quincenal = $this->request->getPost('pago_quincenal');
        $sueldo_diario = $this->request->getPost('sueldo_diario');

        $longitud = 45;
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $token = '';

        for ($i = 0; $i < $longitud; $i++) {
            $indice = rand(0, strlen($caracteres) - 1);
            $token .= $caracteres[$indice];
        }

        // Verificar que el correo tiene el dominio "@turing-ia.com y @turing-latam.com"
        if (strpos($correo, '@turing-ia.com') === false && strpos($correo, '@turing-latam.com') === false && strpos($correo, '@gmail.com') === false) {
            $mensaje = "El correo debe pertenecer al dominio de: @turing-ia.com o @turing-latam.com";
            $session->setFlashdata('nombre1', $nombre);
            $session->setFlashdata('telefono', $telefono);
            $session->setFlashdata('apellido_paterno', $apellido_paterno);
            $session->setFlashdata('apellido_materno', $apellido_materno);
            $session->setFlashdata('nombre_area', $nombre_area);
            $session->setFlashdata('descripcion', $descripcion);
            $session->setFlashdata('puesto', $puesto);
            $session->setFlashdata('fecha_nacimiento', $fecha_nacimiento);
            $session->setFlashdata('fecha_ingreso', $fecha_ingreso);
            $session->setFlashdata('direccion', $direccion);
            $session->setFlashdata('sexo', $sexo);
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/ats/candidat/$id_form/$id_usuario"));
        }

        if ($new_password != $v_password) {
            $mensaje = "Verifica tus contraseñas, no coinciden.";
            $session->setFlashdata('nombre1', $nombre);
            $session->setFlashdata('telefono', $telefono);
            $session->setFlashdata('apellido_paterno', $apellido_paterno);
            $session->setFlashdata('apellido_materno', $apellido_materno);
            $session->setFlashdata('correo', $correo);
            $session->setFlashdata('nombre_area', $nombre_area);
            $session->setFlashdata('descripcion', $descripcion);
            $session->setFlashdata('puesto', $puesto);
            $session->setFlashdata('fecha_nacimiento', $fecha_nacimiento);
            $session->setFlashdata('fecha_ingreso', $fecha_ingreso);
            $session->setFlashdata('direccion', $direccion);
            $session->setFlashdata('sexo', $sexo);
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/ats/candidat/$id_form/$id_usuario"));
        } else {

            //encripta la contraseña del colaborador
            $nuevo_pass = password_hash($new_password, PASSWORD_DEFAULT);
            $colabModel = new DocumentosModel();
            $nominaModel = new NominaModel();
            //$insertedId almacena el ultimo id del colaborador
            $insertedId = $colabModel->saveColab($nombre, $apellido_paterno, $apellido_materno, $correo, $nuevo_pass, $rol, $token);

            if ($insertedId !== false) {
                //si el ultimo id no es nulo o falso, inserta en los demas models los datos
                $insert = $colabModel->saveArea($insertedId, $nombre_area, $descripcion, $puesto);
                $insert2 = $colabModel->saveData($insertedId, $foto_perfil, $fecha_nacimiento, $fecha_ingreso, $direccion, $telefono, $sexo);
                $insert = $nominaModel->saveNomina($insertedId, $nombre_banco, $numero_cuenta, $clabe_interbancaria, $pago_mensual_base, $pago_quincenal, $sueldo_diario);

                if ($insert && $insert2) {
                    // /* MANDAR ACCESO DE CORREOS */
                    // $email = \Config\Services::email();
                    // $email->setTo($correo);
                    // $email->setFrom('soportepeopleanalytics@gmail.com');
                    // $email->setSubject('BIENVENIDO A: ' . $title . '-doNotReply');
                    // $namee = strtoupper($nombre . " " . $apellido_paterno . " " . $apellido_materno);
                    // $email->setMessage('¡Hola  <strong>' . $namee . '</strong>!, has sido registrado en <strong>' . $title . '</strong> para acceder al portal da
                    // click aqui: <br><strong>' . base_url('/') . '</strong><br>
                    // Tus credenciales de acceso son correo: <strong> ' . $correo . '</strong> <br>
                    // Contraseña de acceso: <strong>' . $new_password . '</strong><br>
                    // Se recomienda cambiar tu contraseña una vez que accedas. <br><br>
                    // Att: Soporte People Analitycs.');

                    // if ($email->send()) { //enviar correo
                    //     $mensaje = "El usuario se registro con éxito, se le han mandado sus credenciales.";
                    //     $session->setFlashdata('success_message', $mensaje);
                    //     return redirect()->to(base_url('home/newcolab'));
                    // } else {
                    //     return 'Error al enviar el correo: ' . $email->printDebugger();
                    // }

                    $mensaje = "El usuario se registro con éxito, administración ahora lo puede ver";
                    $session->setFlashdata('success_message', $mensaje);
                    return redirect()->to(base_url("home/nomina/collaborators/$insertedId"));
                }

            } else {

                $mensaje = "Error al insertar el registro.";
                $session->setFlashdata('error_message', $mensaje);
                return redirect()->to(base_url("home/ats/candidat/$id_form/$id_usuario"));
            }


        }


    }

    public function uploadarchive()
    {

        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";*/
        $session = session();
        $id_usuario = $this->request->getPost('id_usuario'); //la el id se valida como usuario
        $nombre_doc = $_FILES['documento']['name'];
        $tipo = $_FILES['documento']['type'];
        $tamano = $_FILES['documento']['size'];



        $authModel = new DocumentosModel();

        if (($nombre_doc != '') && ($tipo == 'application/msword' || $tipo == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || $tipo == 'application/pdf') && ($tamano <= 200000000)) {

            $directorio = $_SERVER['DOCUMENT_ROOT'] . "Turing-IA/public/cvs/"; // Ruta local en el servidor
            /*IMPORTANTE! EL DIRECTORIO LOCAL NO ES EL MISMO QUE EL DEL DOMINIO, VALIDAR EL CODIGO COMENTADO DE $DIRECTORIO, PARA 
            SEGUIR ESA ESTRUCTURA DE DIRECTOTIOS PARA IMG, PDF Y DOC */

            if (!file_exists($directorio)) {
                mkdir($directorio, 0777, true);
            }

            $nombre_archivo = $_FILES['documento']['name'];
            if (move_uploaded_file($_FILES['documento']['tmp_name'], $directorio . $nombre_archivo)) {
                // Éxito al subir el archivo
            } else {
                $mensaje = "Error al mover el archivo.";
                $session->setFlashdata('error_message', $mensaje);
                return redirect()->to(base_url("home/nomina/collaborators/$id_usuario"));
            }

            $contar = $authModel->countdoc($id_usuario);
            $total = $contar[0];
            $total_count = $total->total;

            if ($total_count > 0) {

                $subir = $authModel->updatedoc($nombre_archivo, $id_usuario);
                if ($subir) {
                    $mensaje = "Archivo actualizado con éxito";
                    $session->setFlashdata('success_message', $mensaje);
                    return redirect()->to(base_url("/home/nomina/collaborators/$id_usuario"));
                }

            } else {

                $upload = $authModel->uploaddoc($id_usuario, $nombre_archivo);
                if ($upload) {
                    $mensaje = "Archivo subido con éxito";
                    $session->setFlashdata('success_message', $mensaje);
                    return redirect()->to(base_url("/home/nomina/collaborators/$id_usuario"));

                }
            }



        } else {

        }

    }


}