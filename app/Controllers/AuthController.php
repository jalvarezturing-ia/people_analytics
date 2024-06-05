<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;
use App\Models\AuthModel;
use App\Models\NotificationModel;

class AuthController extends BaseController
{
    use ResponseTrait;
    public function login()
    {
        //$clave = $this->logged();
        if ($this->logged()) {
            //echo "Con sesion";
            return redirect()->to(base_url('home/index'));

        } else {
            //echo "Logueate";
            return view('auth/login_t');
        }
    }
    public function logged()
    {
        /*funcion que valida si ya esta autenticado para mandarlo a la página de inicio */
        $session = session();
        $datosPost = $session->get('datosPost');
        $jwtToken = $session->get('jwt_token');
        $status = true;

        if (!$datosPost && !$jwtToken) {
            $status = false;
        } else {
            $status = true;
        }
        return $status;
    }
    public function home()
    {

        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        exit();

        /* obtiene los valores que llegan del login y los almacena en sesiones */
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $datosPost = ['password' => $password, 'email' => $email];
        $session = session();
        $session->set('datosPost', $datosPost);

        return redirect()->to(base_url('home/index'));

        //echo ($this->security());

    }
    public function index()
    {

        /* funcion auth, esta obtiene los datos por sesion y los valida en el model */
        $session = session();
        $datosPost = $session->get('datosPost');

        $email = $datosPost['email'];
        $password = $datosPost['password'];

        $authModel = new AuthModel();
        $check = $authModel->login($email);  /* busca en el model con el correo que se esta ingresando */


        if ($check) {
            $user = $check[0]; //almacenamos el valor de los objetos que llegan de la consulta si el usuario existe
            $passwordVerify = $user->password;
            $descripcion = $user->descripcion;
            $user_id = $user->id;
            $rol = $user->rol;
            $ip = $user->ip;

            //si el usuario si existe, en la posicion de la contraseña se hace un "password_verify" para validar la contraseña que llega
            //con la que esta encriptada en la bd 
            if (password_verify($password, $passwordVerify)) {
                $dataPersonal = $authModel->userPerfil($email);
                $nombreCompleto = explode(" ", $user->nombre);
                $nombre = $nombreCompleto[0];
                $data2 = $dataPersonal[0];
                $foto = $data2->foto_perfil;
                $key = 'r2n$VzL6!sB*7aQpQSN/!s4.&sMcsA'; //una vez validada la contraseña, se firma un JWT para seguridad de la sesión
                $modulo = $authModel->modulo();
                $inf = $modulo[0];
                $estado = $inf->estado;
                // if($this->security() === $ip)
                // {
                $tokenData =
                    [
                        'user_id' => $user->id,
                        'email' => $email,
                        'descripcion' => $descripcion,
                        'password' => $passwordVerify,
                    ]; //array de parametros para firmar y validar el token

                $token = JWT::encode($tokenData, $key, 'HS256'); //codifica el token
                $session->set('jwt_token', $token);
                $session->set('foto', $foto);
                $session->set('nombre', $nombre);
                $session->set('descripcion', $descripcion);
                $session->set('user_id', $user_id);
                $session->set('rol', $rol);
                $session->set('estado', $estado);

                $not = $this->notifications();

                $msj = $not['msj'];
                $delimiter = "\n";
                $messages = explode($delimiter, $msj);
                $count = count($messages);
                $s = $count - 1;

                $array = ['token_access' => $token, 'not' => $msj, 'tot' => $s];
                // echo $rol;
                // exit();

                // echo "<pre>";
                // print_r($not);
                // echo "</pre>";
                // exit();

                /*REDIRIGIR AL USER DEPENDIENDO EL ROL*/

                if ($rol == 'admin1') {
                    return view('comercial/administracionGeneral/index', $array);

                } elseif ($rol == 'admin2') {
                    // return view('comercial/capitalHumanoGeneral/header', $array);
                    return view('comercial/capitalHumanoGeneral/index', $array);

                } elseif ($rol == 'directivo') {

                    return view('direccion/index', $array);

                } elseif ($rol == 'colab') {

                    return view('colaboradores/index', $array);

                } else {

                    //si el usuario no existe manda mensajde de error 
                    $message = "No existe el usuario, contáctate con el administrador del sitio.";
                    $session->setFlashdata('email', $email);
                    $session->setFlashdata('error_message', $message);
                    return view('auth/login_t');
                    //return redirect()->to(base_url('/'));
                }
                // hasta aquí
                // } else {

                //    //$this->sendmail($email, $nombre);    
                //    return view('auth/login_t');                    
                // }

            } else {
                //si el usuario no existe manda mensajde de error 

                $message = "Contraseña incorrecta, revisala por favor.";
                $session->setFlashdata('email', $email);
                $session->setFlashdata('error_message', $message);
                return view('auth/login_t');
                //return redirect()->to(base_url('/'));
            }

        } //si el usuario no existe manda mensajde de error 
        else {
            $message = "El correo es inválido, revisalo por favor.";
            $session->setFlashdata('error_message', $message);
            return view('auth/login_t');
            //return redirect()->to(base_url('/'));
        }
        //}

    }
    public function destroy()
    {

        //destruye la sesión y manda al login auth
        $session = session();
        $session->destroy();

        return redirect()->to(base_url('/'));
    }
    public function account()
    {
        /* OBTIENE LA INFORMACIÓN DE USUARIO PERSONAL PARA VISUALIZARLA EN LA VISTA */
        $session = session();
        $user_id = $session->get('user_id');
        $rol = $session->get('rol');

        $authModel = new AuthModel();
        $account = $authModel->account($user_id);

        $data = ['cuenta' => $account, 'id_usuario' => $user_id, 'rol' => $rol];
        return view("general/account", $data); //PASA LOS DATOS Y ATRIBUTOS A LA VISTA 
        //carpeta/archivo.php  

    }
    public function upContra()
    {
        /* obtiene datos por post para actualizar contraseña, nombre, id, fecha, etc */
        $session = session();
        $user_id = $this->request->getPost('user_id');
        $nombre = $this->request->getPost('nombre');
        $telefono = $this->request->getPost('telefono');
        $correo = $this->request->getPost('correo');
        $descripcion = $this->request->getPost('descripcion');
        $puesto = $this->request->getPost('puesto');
        $fecha_nacimiento = $this->request->getPost('fecha_nacimiento');
        $fecha_ingreso = $this->request->getPost('fecha_ingreso');
        $direccion = $this->request->getPost('direccion');
        $new_password = $this->request->getPost('new_password');
        $v_password = $this->request->getPost('v_password');


        if (!hash_equals($new_password, $v_password)) {
            $mensaje = "Verifica tus contraseñas, no coinciden.";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url('home/account'));

        } else {

            //si la contraseña coincide encripta la contraseña con "password_hash", y se la pasa al modelo
            $nuevo_pass = password_hash($new_password, PASSWORD_DEFAULT);
            $authModel = new AuthModel();
            $account = $authModel->updatausers($nuevo_pass, $user_id, $correo);

            if ($account) {

                $datosPost = ['password' => $new_password, 'email' => $correo];
                $session->set('datosPost', $datosPost); /* para que no se cierre la sesión se inserta de nuevo la contraseña en la sesion actual */
                $mensaje = "La contraseña se actualizó correctamente.";
                $session->setFlashdata('success_message', $mensaje);
                return redirect()->to(base_url('home/account'));

            } else {

                $mensaje = "Algo salió mal.";
                $session->setFlashdata('error_message', $mensaje);
                return redirect()->to(base_url('home/account'));

            }


        }
    }
    public function forget()
    {

        return view("auth/password");

    }
    public function notifications()
    {
        $asisModel = new NotificationModel();
        $datos = $asisModel->asistencia();

        $asistencia = $datos['asistencia'];
        $incidencias_permisos = $datos['incidencias_permisos'];

        $msj = '';

        if ($asistencia) {

            $count = count($datos['asistencia']);

            if($count == 1 ){
                $msj .= "\n<a href=' " . base_url("/home/attendance") . " '>Se registro una nueva asistencia</a>";
            } else if ($count >= 1 ){
                $msj .= "\n<a href=' " . base_url("/home/attendance") . " '>Se registraron nuevas asistencias hoy </a>";
            }
           
        } else {

            $msj .= "\n<a href='#!'>No hay asistencias registradas</a>";
        }

        if ($incidencias_permisos) {

            $count = count($datos['incidencias_permisos']);

            if($count == 1 ){
                $msj .= "\n<a href=' " . base_url("/home/permit") . " '>Se registro un nuevo permiso</a>";
            } else if ($count >= 1 ){
                $msj .= "\n<a href=' " . base_url("/home/permit") . " '>Se registraron nuevos permisos hoy</a>";
            }

            

        } else {

            //$msj .= "\n<a href='www.google.com' target='_blank'>No hay permisos registrados</a>";
        }

        return [
            'datos' => $datos,
            'msj' => $msj
        ];

    }

}
