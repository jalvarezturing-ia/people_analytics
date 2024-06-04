<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\NominaModel;
use App\Models\ColaboratorsModel;



class ColaboratorsController extends BaseController
{
    public function newcolab()
    {
        //obtiene la lista de areas disponibles para guardar al colab
        $colabsModel = new ColaboratorsModel();
        $check = $colabsModel->getAreas();

        $longitud = 10;
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $passTemporal = '';

        for ($i = 0; $i < $longitud; $i++) {
            $indice = rand(0, strlen($caracteres) - 1);
            $passTemporal .= $caracteres[$indice];
        }

        $data = ['areas' => $check, 'passwordT' => $passTemporal];

        return view("comercial/administracionGeneral/nomina/colaborators/index", $data); //pasa las areas a la vista

    }
    public function savecolab()
    {

        //obtiene la lista de datos por POST para guardae los datos en la base de datos 

        /*echo "<pre>";
        print_r($_POST);
        echo "<pre>";
        exit();*/
        $session = session();
        $foto_perfil = "perfil.png";
        $nombre = $this->request->getPost('nombre');
        $apellido_paterno= $this->request->getPost('apellido_paterno');
        $apellido_materno = $this->request->getPost('apellido_materno');
        $telefono = $this->request->getPost('telefono');
        $fecha_nacimiento = $this->request->getPost('fecha_nacimiento');
        $sexo = $this->request->getPost('sexo');
        $direccion = $this->request->getPost('direccion');
        $correo = $this->request->getPost('correo');
        $nombre_area = $this->request->getPost('nombre_area');
        $descripcion = $this->request->getPost('descripcion');
        $puesto = $this->request->getPost('puesto');
        $fecha_ingreso = $this->request->getPost('fecha_ingreso');
        $new_password = $this->request->getPost('new_password');
        $v_password = $this->request->getPost('v_password');
        $rol = "colab";
        $title = "Portal Turing-IA People Analytics";

        $longitud = 45 ;
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $token = '';

        for ($i = 0; $i < $longitud; $i++) {
            $indice = rand(0, strlen($caracteres) - 1);
            $token .= $caracteres[$indice];
        }

        // Verificar que el correo tiene el dominio "@turing-ia.com y @turing-latam.com"
        if (strpos($correo, '@turing-ia.com') === false && strpos($correo, '@turing-latam.com') === false) {
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
            return redirect()->to(base_url('home/newcolab'));
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
            return redirect()->to(base_url('home/newcolab'));
        } else {

            //encripta la contraseña del colaborador
            $nuevo_pass = password_hash($new_password, PASSWORD_DEFAULT);
            $colabModel = new ColaboratorsModel();
            //$insertedId almacena el ultimo id del colaborador
            $insertedId = $colabModel->saveColab($nombre,  $apellido_paterno, $apellido_materno, $correo, $nuevo_pass, $rol, $token);

            if ($insertedId !== false) {
                //si el ultimo id no es nulo o falso, inserta en los demas models los datos
                $insert = $colabModel->saveArea($insertedId, $nombre_area, $descripcion, $puesto);
                $insert2 = $colabModel->saveData($insertedId, $foto_perfil, $fecha_nacimiento, $fecha_ingreso, $direccion, $telefono, $sexo);

                if ($insert && $insert2) 
                {
                    /* MANDAR ACCESO DE CORREOS */
                    $email = \Config\Services::email();
                    $email->setTo($correo);
                    $email->setFrom('soportepeopleanalytics@gmail.com');
                    $email->setSubject('BIENVENIDO A: ' . $title . '-doNotReply');
                    $namee = strtoupper($nombre ." ". $apellido_paterno. " ". $apellido_materno);
                    $email->setMessage('¡Hola  <strong>' . $namee . '</strong>!, has sido registrado en <strong>'. $title . '</strong> para acceder al portal da
                    click aqui: <br><strong>' . base_url('/') . '</strong><br>
                    Tus credenciales de acceso son correo: <strong> '. $correo . '</strong> <br>
                    Contraseña de acceso: <strong>'.$new_password.'</strong><br>
                    Se recomienda cambiar tu contraseña una vez que accedas. <br><br>
                    Att: Soporte People Analitycs.');

                    if ($email->send()) { //enviar correo
                        $mensaje = "El usuario se registro con éxito, se le han mandado sus credenciales.";
                        $session->setFlashdata('success_message', $mensaje);
                        return redirect()->to(base_url('home/newcolab'));
                    } else {
                        return 'Error al enviar el correo: ' . $email->printDebugger();
                    }
                       
                }

            } else {

                $mensaje = "Error al insertar el registro.";
                $session->setFlashdata('error_message', $mensaje);
                return redirect()->to(base_url('home/newcolab'));
            }


        }
    }
    public function people()
    {
        //obtiene la lista de los colabs dados de alta y de baja
        $colabsModel = new ColaboratorsModel();
        $data = $colabsModel->getPeople();
        $baja = $colabsModel->getPeopleBaja();

        $colab = ['colabs' => $data, 'baja' =>$baja];

      
        return view("comercial/administracionGeneral/nomina/colaborators/vistaColabs", $colab);
    }
    public function collaborators($id_user)
    {
        $session = session();
        $id_user = trim($id_user);

        $colabsModel = new ColaboratorsModel();
        $consulta = $colabsModel->getColabId($id_user); //obtiene información por colaborador mediante su id(ver en model)
        $consulta1 = $colabsModel->getNominaId($id_user); //obtiene la informacion de la nomina por id de colaborador

        $data = $consulta[0]; //almacena los datos de la consulta en el objeto para extraer el nombre y el ap del usuario al que se esta editando
        $name = $data->nombre;
        $ap = $data->apellido_paterno;
        $puesto = $data->puesto;
        
        /*echo "<pre>";
        print_r($consulta);
        echo "</pre>";
        exit();*/

        if($puesto != "Practicante")
        {
            
            $data = ['colaborador' => $consulta, 'nombre' => $name, 'ap' => $ap, 'nomina' => $consulta1, 'puesto' =>$puesto];
            return view("comercial/administracionGeneral/nomina/colaborators/editColabs", $data);

        } else {

            $data = ['colaborador' => $consulta, 'nombre' => $name, 'ap' => $ap, 'nomina' => $consulta1, 'puesto' =>$puesto];
            return view("comercial/administracionGeneral/nomina/colaborators/editColabs1", $data);
           
        }
        
        

    }
    public function updatecolab()
    {

        /*echo "<pre>";
        print_r($_POST);
        echo "<pre>";
        exit();*/
        $session = session();
        $id_usuario = $this->request->getPost('id_usuario');
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
        $foto_perfil= "Captura.PNG";
        $sexo = $this->request->getPost('sexo');

        $colabsModel = new ColaboratorsModel();
        $updte = $colabsModel->updatecolab($nombre, $apellido_paterno, $apellido_materno, $telefono, $correo, $fecha_nacimiento, $fecha_ingreso, $fecha_egreso, $direccion, $nombre_area, $descripcion, $puesto, $sexo, $id_usuario);
        if ($updte) {

            $mensaje = "Colaborador editado con éxito.";
            $session->setFlashdata('success_message', $mensaje);
            return redirect()->to(base_url("home/nomina/collaborators/$id_usuario"));

        } else {

            $mensaje = "Algo salió mal.";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/nomina/collaborators/$id_usuario"));

        }

    }

    public function deletecolab($id_user)
    {

        //obtiene la informacion de la fecha para insertarla en el model cuando un colab se da de baja
        $session = session();
        date_default_timezone_set('America/Mexico_City');
        setlocale(LC_TIME, "spanish");
        $fecha = new \DateTime();
        $fechaFormateada = $fecha->format('Y-m-d');

        $colabsModel = new ColaboratorsModel();
        $date = $colabsModel->deleteColab($fechaFormateada, $id_user);

        if($date){

            $mensaje = "Colaborador dado de baja con éxito.";
            $session->setFlashdata('success_message', $mensaje);
            return redirect()->to(base_url("home/nomina/collaborators/$id_user"));

        } else {

            $mensaje = "Algo salió mal, intentelo de nuevo más tarde.";
            $session->setFlashdata('success_message', $mensaje);
            return redirect()->to(base_url("home/nomina/collaborators/$id_user"));

        }



    } 


    public function deleteColabsMult()
    {

    }

    public function altacolab($id_user)
    {
        //vuelve a dar de alta al colaborador si es el caso
        $session = session();
        $colabsModel = new ColaboratorsModel();
        $fecha_egreso = "0";

        $alta = $colabsModel->altaPeople($fecha_egreso, $id_user);

        if($alta){

            $mensaje = "Colaborador dado de alta con éxito.";
            $session->setFlashdata('success_message', $mensaje);
            return redirect()->to(base_url("home/nomina/people"));

        } else {

            $mensaje = "Algo salió mal, intentelo de nuevo más tarde.";
            $session->setFlashdata('success_message', $mensaje);
            return redirect()->to(base_url("home/nomina/people"));

        }
    

    }

    /* */
    public function editpicture()
    {
        //retorna a la vista para la selección de una imagen de perfil 
        $session = session();
        $user_id = $session->get('user_id');
        $data = ['user_id' => $user_id];

        return view("general/picture", $data);

    }
    public function savepicture()
    {
        //validaciones de imagen desde nombre, tamaño, tipo, etc.
        $session = session();
        $nombre_img = $_FILES['imagen']['name'];
        $tipo = $_FILES['imagen']['type'];
        $tamano = $_FILES['imagen']['size'];
        $user_id = $this->request->getPost('user_id'); //la el id se valida como usuario

        if (($nombre_img == !NULL) && ($_FILES['imagen']['size'] <= 200000000)) {

            if (
                ($_FILES["imagen"]["type"] == "image/gif")
                || ($_FILES["imagen"]["type"] == "image/jpeg")
                || ($_FILES["imagen"]["type"] == "image/jpg")
                || ($_FILES["imagen"]["type"] == "image/png")
            ) {

                $directorio = $_SERVER['DOCUMENT_ROOT'] . 'Turing-IA/public/fotos_colab/'; // ruta local en el servidor
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

                $authModel = new AuthModel();
                $upload = $authModel->savephoto($nombre_img, $user_id);

                if ($upload) {
                    return redirect()->to(base_url('home/account'));
                } //fin tercer if


            } //fin segundo if
            else {
                //si no cumple con el formato
                $mensaje = "No se puede subir el archivo de imagen con ese formato, verifique";
                $session->setFlashdata('error_message', $mensaje);
                return redirect()->to(base_url('home/account/editpicture'));
            }

        } //fin primer if
        else {
            //si existe la variable pero se pasa del tamaño permitido
            if ($nombre_img == !NULL)
                $mensaje = "La imagen es demasiado grande";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url('home/account/editpicture'));
        }

    }
    public function cv($id_usuario)
    {
        $authModel = new AuthModel();
        $consult = $authModel->verDoc($id_usuario);

        if ($consult) 
        {
            $data = $consult[0];
            $name_doc = $data->curriculum_vitae;
            $id_doc = $data->id;
            $datos = ['name_doc' => $name_doc, 'id_doc' => $id_doc, 'id_usuario' =>$id_usuario];
            return view("general/documents", $datos);

        } else {

            $datos = ['id_usuario' => $id_usuario];
            return view("general/documents", $datos);
       
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


        
        $authModel = new AuthModel();

        if (($nombre_doc != '') && ($tipo == 'application/msword' || $tipo == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || $tipo == 'application/pdf') && ($tamano <= 200000000))
            {

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

                if($total_count > 0)
                {

                    $subir = $authModel->updatedoc($nombre_archivo, $id_usuario);
                    if ($subir) 
                    {
                        $mensaje = "Archivo actualizado con éxito";
                        $session->setFlashdata('success_message', $mensaje);
                        return redirect()->to(base_url("/home/nomina/collaborators/$id_usuario"));
                    } 

                } else {

                    $upload = $authModel->uploaddoc($id_usuario, $nombre_archivo);
                    if ($upload) 
                    {
                        $mensaje = "Archivo subido con éxito";
                        $session->setFlashdata('success_message', $mensaje);
                        return redirect()->to(base_url("/home/nomina/collaborators/$id_usuario"));

                    } 
                }
            
            
    
            } else {
                  
            }

    }
    public function contract($id_usuario)
    {
        $authModel = new AuthModel();
        $consult = $authModel->verContrato($id_usuario);

        if ($consult) 
        {
            $data = $consult[0];
            $name_doc = $data->contrato_vitae;
            $id_doc = $data->id;
            $datos = ['name_doc' => $name_doc, 'id_doc' => $id_doc, 'id_usuario' =>$id_usuario];
            return view("general/document", $datos);

        } else {

            $datos = ['id_usuario' => $id_usuario];
            return view("general/document", $datos);
       
    }

    }
    public function uploadcontract()
    {

        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";*/
        $session = session();
        $id_usuario = $this->request->getPost('id_usuario'); //la el id se valida como usuario
        $nombre_doc = $_FILES['documento']['name'];
        $tipo = $_FILES['documento']['type'];
        $tamano = $_FILES['documento']['size'];
        $authModel = new AuthModel();

        if (($nombre_doc != '') && ($tipo == 'application/msword' || $tipo == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || $tipo == 'application/pdf') && ($tamano <= 200000000))
            {

                $directorio = $_SERVER['DOCUMENT_ROOT'] . "Turing-IA/public/contratos/"; // Ruta local en el servidor
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

                if($total_count > 0)
                {

                    $subir = $authModel->updatecontract($nombre_archivo, $id_usuario);
                    if ($subir) 
                    {
                        $mensaje = "Archivo actualizado con éxito";
                        $session->setFlashdata('success_message', $mensaje);
                        return redirect()->to(base_url("home/nomina/collaborators/$id_usuario"));
                    } 

                } else {

                    $upload = $authModel->uploadcontract($id_usuario, $nombre_archivo);
                    if ($upload) 
                    {
                        $mensaje = "Archivo subido con éxito";
                        $session->setFlashdata('success_message', $mensaje);
                        return redirect()->to(base_url("home/nomina/collaborators/$id_usuario"));

                    } 
                }
            
            
    
            } else {
                  
            }

    }
    /* */

    public function savedatabank()
    {

            /*echo "<pre>";
            print_r($_POST);
            echo "</pre>";*/
        $session = session();
        $id_usuario = $this->request->getPost('id_usuario');
        $nombre_banco = $this->request->getPost('nombre_banco');
        $numero_cuenta = $this->request->getPost('numero_cuenta');
        $clabe_interbancaria = $this->request->getPost('clabe_interbancaria');
        $pago_mensual_base = $this->request->getPost('pago_mensual_base'); /* */
        $pago_quincenal = $this->request->getPost('pago_quincenal');
        $sueldo_diario = $this->request->getPost('sueldo_diario');

        $colabsModel = new ColaboratorsModel();


        $colabsModel->savedataa($pago_mensual_base, $id_usuario);
        $insert = $colabsModel->savedatabank($id_usuario, $nombre_banco, $numero_cuenta, $clabe_interbancaria, $pago_mensual_base, $pago_quincenal, $sueldo_diario);

        if($insert){

            $mensaje = "Exito en la actualización de datos de nómina.";
            $session->setFlashdata('success_message', $mensaje);
            return redirect()->to(base_url("home/nomina/collaborators/$id_usuario"));

        } else {

            $mensaje = "Error en la actualización, intentelo de nuevo más tarde";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/nomina/collaborators/$id_usuario"));

        }

    }

    public function uploaddomicilio()
    {

        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";*/
        $session = session();
        $id_usuario = $this->request->getPost('id_usuario'); //la el id se valida como usuario
        $nombre_doc = $_FILES['documento']['name'];
        $tipo = $_FILES['documento']['type'];
        $tamano = $_FILES['documento']['size'];
        $colabModel = new ColaboratorsModel();
        $authModel = new AuthModel();

        if (($nombre_doc != '') && ($tipo == 'application/msword' || $tipo == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || $tipo == 'application/pdf') && ($tamano <= 200000000))
            {

                $directorio = $_SERVER['DOCUMENT_ROOT'] . "Turing-IA/public/cpdomicilio/"; // Ruta local en el servidor

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

                if($total_count > 0)
                {

                    $subir = $colabModel->updatedomicilio($nombre_archivo, $id_usuario);
                    if ($subir) 
                    {
                        $mensaje = "Archivo actualizado con éxito";
                        $session->setFlashdata('success_message', $mensaje);
                        return redirect()->to(base_url("home/nomina/collaborators/$id_usuario"));
                    } 

                } else {

                    $upload = $colabModel->uploaddomicilio($id_usuario, $nombre_archivo);
                    if ($upload) 
                    {
                        $mensaje = "Archivo subido con éxito";
                        $session->setFlashdata('success_message', $mensaje);
                        return redirect()->to(base_url("home/nomina/collaborators/$id_usuario"));

                    } 
                }
            
            
    
            } else {
                  
            }

    }
    public function uploadestudios()
    {

        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";*/
        $session = session();
        $id_usuario = $this->request->getPost('id_usuario'); //la el id se valida como usuario
        $nombre_doc = $_FILES['documento']['name'];
        $tipo = $_FILES['documento']['type'];
        $tamano = $_FILES['documento']['size'];
        $colabModel = new ColaboratorsModel();
        $authModel = new AuthModel();

        if (($nombre_doc != '') && ($tipo == 'application/msword' || $tipo == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || $tipo == 'application/pdf') && ($tamano <= 200000000))
            {

                $directorio = $_SERVER['DOCUMENT_ROOT'] . "Turing-IA/public/cpestudios/"; // Ruta local en el servidor

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

                if($total_count > 0)
                {

                    $subir = $colabModel->updateestudios($nombre_archivo, $id_usuario);
                    if ($subir) 
                    {
                        $mensaje = "Archivo actualizado con éxito";
                        $session->setFlashdata('success_message', $mensaje);
                        return redirect()->to(base_url("home/nomina/collaborators/$id_usuario"));
                    } 

                } else {

                    $upload = $colabModel->uploadestudios($id_usuario, $nombre_archivo);
                    if ($upload) 
                    {
                        $mensaje = "Archivo subido con éxito";
                        $session->setFlashdata('success_message', $mensaje);
                        return redirect()->to(base_url("home/nomina/collaborators/$id_usuario"));

                    } 
                }
            
            
    
            } else {
                  
            }

    }
    public function uploadrfc()
    {

        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";*/
        $session = session();
        $id_usuario = $this->request->getPost('id_usuario'); //la el id se valida como usuario
        $nombre_doc = $_FILES['documento']['name'];
        $tipo = $_FILES['documento']['type'];
        $tamano = $_FILES['documento']['size'];
        $colabModel = new ColaboratorsModel();
        $authModel = new AuthModel();

        if (($nombre_doc != '') && ($tipo == 'application/msword' || $tipo == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || $tipo == 'application/pdf') && ($tamano <= 200000000))
            {

                $directorio = $_SERVER['DOCUMENT_ROOT'] . "Turing-IA/public/rfcs/"; // Ruta local en el servidor

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

                if($total_count > 0)
                {

                    $subir = $colabModel->updaterfc($nombre_archivo, $id_usuario);
                    if ($subir) 
                    {
                        $mensaje = "Archivo actualizado con éxito";
                        $session->setFlashdata('success_message', $mensaje);
                        return redirect()->to(base_url("home/nomina/collaborators/$id_usuario"));
                    } 

                } else {

                    $upload = $colabModel->uploadrfc($id_usuario, $nombre_archivo);
                    if ($upload) 
                    {
                        $mensaje = "Archivo subido con éxito";
                        $session->setFlashdata('success_message', $mensaje);
                        return redirect()->to(base_url("home/nomina/collaborators/$id_usuario"));

                    } 
                }
            
            
    
            } else {
                  
            }

    }
    public function uploadbancarios()
    {

        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";*/
        $session = session();
        $id_usuario = $this->request->getPost('id_usuario'); //la el id se valida como usuario
        $nombre_doc = $_FILES['documento']['name'];
        $tipo = $_FILES['documento']['type'];
        $tamano = $_FILES['documento']['size'];
        $colabModel = new ColaboratorsModel();
        $authModel = new AuthModel();

        if (($nombre_doc != '') && ($tipo == 'application/msword' || $tipo == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || $tipo == 'application/pdf') && ($tamano <= 200000000))
            {

                $directorio = $_SERVER['DOCUMENT_ROOT'] . "Turing-IA/public/d_bancarios/"; // Ruta local en el servidor

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

                if($total_count > 0)
                {

                    $subir = $colabModel->updatebancarios($nombre_archivo, $id_usuario);
                    if ($subir) 
                    {
                        $mensaje = "Archivo actualizado con éxito";
                        $session->setFlashdata('success_message', $mensaje);
                        return redirect()->to(base_url("home/nomina/collaborators/$id_usuario"));
                    } 

                } else {

                    $upload = $colabModel->uploadbancarios($id_usuario, $nombre_archivo);
                    if ($upload) 
                    {
                        $mensaje = "Archivo subido con éxito";
                        $session->setFlashdata('success_message', $mensaje);
                        return redirect()->to(base_url("home/nomina/collaborators/$id_usuario"));

                    } 
                }
            
            
    
            } else {
                  
            }

    }
    public function uploadbeneficiario()
    {

        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";*/
        $session = session();
        $id_usuario = $this->request->getPost('id_usuario'); //la el id se valida como usuario
        $nombre_doc = $_FILES['documento']['name'];
        $tipo = $_FILES['documento']['type'];
        $tamano = $_FILES['documento']['size'];
        $colabModel = new ColaboratorsModel();
        $authModel = new AuthModel();

        if (($nombre_doc != '') && ($tipo == 'application/msword' || $tipo == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || $tipo == 'application/pdf') && ($tamano <= 200000000))
            {

                $directorio = $_SERVER['DOCUMENT_ROOT'] . "Turing-IA/public/beneficiario/"; // Ruta local en el servidor

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

                if($total_count > 0)
                {

                    $subir = $colabModel->updatebeneficiario($nombre_archivo, $id_usuario);
                    if ($subir) 
                    {
                        $mensaje = "Archivo actualizado con éxito";
                        $session->setFlashdata('success_message', $mensaje);
                        return redirect()->to(base_url("home/nomina/collaborators/$id_usuario"));
                    } 

                } else {

                    $upload = $colabModel->uploadbeneficiario($id_usuario, $nombre_archivo);
                    if ($upload) 
                    {
                        $mensaje = "Archivo subido con éxito";
                        $session->setFlashdata('success_message', $mensaje);
                        return redirect()->to(base_url("home/nomina/collaborators/$id_usuario"));

                    } 
                }
            
            
    
            } else {
                  
            }

    }

    public function uploadine()
    {

        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";*/
        $session = session();
        $id_usuario = $this->request->getPost('id_usuario'); //la el id se valida como usuario
        $nombre_doc = $_FILES['documento']['name'];
        $tipo = $_FILES['documento']['type'];
        $tamano = $_FILES['documento']['size'];
        $colabModel = new ColaboratorsModel();
        $authModel = new AuthModel();

        if (($nombre_doc != '') && ($tipo == 'application/msword' || $tipo == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || $tipo == 'application/pdf') && ($tamano <= 200000000))
            {

                $directorio = $_SERVER['DOCUMENT_ROOT'] . "Turing-IA/public/ine/"; // Ruta local en el servidor

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

                if($total_count > 0)
                {

                    $subir = $colabModel->updateine($nombre_archivo, $id_usuario);
                    if ($subir) 
                    {
                        $mensaje = "Archivo actualizado con éxito";
                        $session->setFlashdata('success_message', $mensaje);
                        return redirect()->to(base_url("home/nomina/collaborators/$id_usuario"));
                    } 

                } else {

                    $upload = $colabModel->uploadine($id_usuario, $nombre_archivo);
                    if ($upload) 
                    {
                        $mensaje = "Archivo subido con éxito";
                        $session->setFlashdata('success_message', $mensaje);
                        return redirect()->to(base_url("home/nomina/collaborators/$id_usuario"));

                    } 
                }
            
            
    
            } else {
                  
            }

    }
    public function uploadcurp()
    {

        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";*/
        $session = session();
        $id_usuario = $this->request->getPost('id_usuario'); //la el id se valida como usuario
        $nombre_doc = $_FILES['documento']['name'];
        $tipo = $_FILES['documento']['type'];
        $tamano = $_FILES['documento']['size'];
        $colabModel = new ColaboratorsModel();
        $authModel = new AuthModel();

        if (($nombre_doc != '') && ($tipo == 'application/msword' || $tipo == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || $tipo == 'application/pdf') && ($tamano <= 200000000))
            {

                $directorio = $_SERVER['DOCUMENT_ROOT'] . "Turing-IA/public/curp/"; // Ruta local en el servidor

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

                if($total_count > 0)
                {

                    $subir = $colabModel->updatecurp($nombre_archivo, $id_usuario);
                    if ($subir) 
                    {
                        $mensaje = "Archivo actualizado con éxito";
                        $session->setFlashdata('success_message', $mensaje);
                        return redirect()->to(base_url("home/nomina/collaborators/$id_usuario"));
                    } 

                } else {

                    $upload = $colabModel->uploadcurp($id_usuario, $nombre_archivo);
                    if ($upload) 
                    {
                        $mensaje = "Archivo subido con éxito";
                        $session->setFlashdata('success_message', $mensaje);
                        return redirect()->to(base_url("home/nomina/collaborators/$id_usuario"));

                    } 
                }
            
            
    
            } else {
                  
            }

    }
    public function uploadactaNacimiento()
    {

        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";*/
        $session = session();
        $id_usuario = $this->request->getPost('id_usuario'); //la el id se valida como usuario
        $nombre_doc = $_FILES['documento']['name'];
        $tipo = $_FILES['documento']['type'];
        $tamano = $_FILES['documento']['size'];
        $colabModel = new ColaboratorsModel();
        $authModel = new AuthModel();

        if (($nombre_doc != '') && ($tipo == 'application/msword' || $tipo == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || $tipo == 'application/pdf') && ($tamano <= 200000000))
            {

                $directorio = $_SERVER['DOCUMENT_ROOT'] . "Turing-IA/public/actasNacimiento/"; // Ruta local en el servidor

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

                if($total_count > 0)
                {

                    $subir = $colabModel->updateacta($nombre_archivo, $id_usuario);
                    if ($subir) 
                    {
                        $mensaje = "Archivo actualizado con éxito";
                        $session->setFlashdata('success_message', $mensaje);
                        return redirect()->to(base_url("home/nomina/collaborators/$id_usuario"));
                    } 

                } else {

                    $upload = $colabModel->uploadacta($id_usuario, $nombre_archivo);
                    if ($upload) 
                    {
                        $mensaje = "Archivo subido con éxito";
                        $session->setFlashdata('success_message', $mensaje);
                        return redirect()->to(base_url("home/nomina/collaborators/$id_usuario"));

                    } 
                }
            
            
    
            } else {
                  
            }

    }

    public function deletesistema($id_usuario = NULL)
    {
        $session = session();
        $colabModel = new ColaboratorsModel();
        $deleteColab = $colabModel->deletesistema($id_usuario);

        if($deleteColab)
        {

            $mensaje = "Colaborador eliminado con éxito.";
            $session->setFlashdata('sucess_message', $mensaje);
            return redirect()->to(base_url("home/nomina/people"));

        } else {
            $mensaje = "Algo salio mal.";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url("home/nomina/terminations"));
        }
    }

    

}