<?php

namespace App\Controllers;

use App\Models\AuthModel;

class EmailController extends BaseController
{

  public function validmail()
  {
    /* obtiene los servicios del email para recuperacion de contraseña */
    $email = \Config\Services::email();
    $session = session();

    $correo = $this->request->getPost('email');
    $telefono = $this->request->getPost('telefono');
    $title = "Turing-IA People Analytics";

    $longitud = 45;
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $token = '';

    for ($i = 0; $i < $longitud; $i++) {
      $indice = rand(0, strlen($caracteres) - 1);
      $token .= $caracteres[$indice];
    }

    $authModel = new AuthModel();
    $user = $authModel->search($correo, $telefono);
    $authModel->saveToken($token, $telefono);

    if ($user) {
      //busca en el modelo, si este existe, ent0nces se enviuara un correo de recuperación
      $data = $user[0];
      $name = $data->nombre;
      $id = $data->id;
      $searchToken = $authModel->searchToken($id);
      $data1 = $searchToken[0];
      $token1 = $data1->token_password;
      $email->setTo($correo);
      $email->setFrom('capitalhumano@turing-latam.com');
      $email->setSubject('RESTABLECIMIENTO DE CONTRASEÑA: ' . $title . '-doNotReply');
      $namee = strtoupper($name);

      $message = '<!DOCTYPE html>
            <html lang="es">
              <head>
                <meta charset="UTF-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                <title>Correo electrónico</title>
                <style>
                  /* Estilos CSS */
                  body {
                    font-family: "Century Gothic";
                    background: #f8fafc;
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
                    <img
                      src="https://portal.turing-latam.com/public/gifs/fondo.png"
                      alt="logo_turing"
                      width="110px"
                      height="100px"
                    />
                  </div>
                  <h1>RESTABLECIMIENTO DE CONTRASEÑA</h1>
                  <p style="text-align: center">Hola <strong>' . $namee . '</strong> 🤭</p>
                  <p>
                     Para verificación de identidad y 
                        el reestablecimiento de tu contraseña en el <strong>Portal People Analytics.</strong> 
                  </p>
                  <p>Puedes click en la siguiente dirección 👉:</p>
                  <p style="text-align: center">
                    <a
                      href="' . base_url('/resetpassword' . "/$id/$token1") . '"
                      class="btn ver-periodo-btn"
                      target="_blank"
                      >Cambiar contraseña</a
                    >
                  </p>
                </div>
              </body>
            </html>
            ';

      // $email->setMessage('Hola  <strong>' . $namee . '</strong> 🤭, para verificación de identidad y 
      // el reestablecimiento de tu contraseña en el Portal People Analytics, puedes dar click en la siguiente dirección 👉: <br><strong>' . base_url('/resetpassword' . "/$id/$token1") . '</strong><br><br>
      // Si no fuiste tu, has caso omiso a este correo.');
      $email->setMessage($message);

      if ($email->send()) { //enviar correo
        $mensaje = "Correo enviado exitosamente a la dirección: " . $correo . " verifique su buzón de entrada/spam.";
        $session->setFlashdata('success_message', $mensaje);
        return redirect()->to(base_url('/forget'));
      } else {
        return 'Error al enviar el correo: ' . $email->printDebugger();
      }

    } else {
      $mensaje = "Correo/telefono invalidos.";
      $session->setFlashdata('error_message', $mensaje);
      return redirect()->to(base_url('/forget'));
    }

  }

  public function resetpassword($id_usuario = NULL, $token = NULL)
  {
    $authModel = new AuthModel();
    $searchToken = $authModel->searchToken($id_usuario);
    $data1 = $searchToken[0];
    $token1 = $data1->token_password;

    if ($token1 != $token) {
      echo "<script> alert (\"token expirado, envia de nuevo la validación \"); </script>";
      echo "<script language=Javascript> location.href=\"http://localhost/Turing-IA/public/forget\"; </script>";
      //echo "<script language=Javascript> location.href=\"https://portal.turing-latam.com/public/forget\"; </script>"; 
    } else {

      $data = ['id_usuario' => $id_usuario];
      return view("auth/reset", $data);
    }
  }

  public function validpass()
  {
    $session = session();
    $id_usuario = $this->request->getPost('id_usuario');
    $new_password = $this->request->getPost('password');
    $v_password = $this->request->getPost('vpassword');

    if ($new_password != $v_password) {
      $mensaje = "Verifica tus contraseñas, no coinciden.";
      $session->setFlashdata('error_message', $mensaje);
      return redirect()->to(base_url("resetpassword/$id_usuario"));
    } else {

      //encripta la contraseña del colaborador
      $nuevo_pass = password_hash($new_password, PASSWORD_DEFAULT);
      $longitud = 45;
      $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $token = '';

      for ($i = 0; $i < $longitud; $i++) {
        $indice = rand(0, strlen($caracteres) - 1);
        $token .= $caracteres[$indice];
      }

      $authModel = new AuthModel();
      $update = $authModel->savePassword($nuevo_pass, $token, $id_usuario);

      if ($update) {

        $mensaje = "Contraseña recuperada con éxito, ya puedes acceder";
        $session->setFlashdata('success_message', $mensaje);
        return redirect()->to(base_url("resetpassword/$id_usuario/$token"));

      } else {

        $mensaje = "Algo salio mal, contactate con el admin del sitio.";
        $session->setFlashdata('success_message', $mensaje);
        return redirect()->to(base_url("resetpassword/$id_usuario/$token"));
      }

    }

  }


  public function mailareas($array)
  {

    if (!isset($array['calendly'])) {

      $nombre = $array['nombre'];
      $correo = $array['correo'];

      $this->no_viable($nombre, $correo);
      $variable = true;

    } else {

      $calendly = $array['calendly'];
      $nombre = $array['nombre'];
      $correo = $array['correo'];

      $this->viable($calendly, $nombre, $correo);
      $variable = true;

    }

    return $variable;

  }

  public function viable($calendly, $nombre, $correo)
  {

    $email = \Config\Services::email();
    $session = session();

    $email->setTo($correo);
    $email->setFrom('capitalhumano@turing-latam.com');
    $email->setSubject('TURING-IA, está interesado en ti -doNotReply');
    //$namee = strtoupper($nombre);

    $message = '<!DOCTYPE html>
    <html lang="es">
      <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Correo electrónico</title>
        <style>
          /* Estilos CSS */
          body {
            font-family: "Century Gothic";
            background: #f8fafc;
            color: #333;
            margin: 0;
            padding: 0;
          }
          .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
          }
          h3 {
            color: #333;
            text-align: center;
          }
          p {
            margin-bottom: 20px;
            text-align: justify;
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
          <img
          src="https://portal.turing-latam.com/public/gifs/Captura.PNG"
          alt="logo_turing"
          width="625px"
          height="162px"
        />
          </div>
          
          <p style="text-align: center">Hola <strong>' . $nombre . '</strong> 🤭</p>
          <p>
            <strong>TURING-IA,</strong> revisó tu CV, estamos muy interesados en tu
            postulación, por favor selecciona en <strong>My Calendly</strong> un
            horario para realizar tu entrevista vía zoom de preferencia agenda para
            el día de hoy.
          </p>
          <p>
            Puedes click en la siguiente dirección 👉:
            <a href="' . $calendly . '" class="btn ver-periodo-btn" target="_blank"
              >Agendar mi sesión</a
            >
          </p>
          <p>
            *Importante no dejar pasar más de medio día <br /><br />
            Si tienes dudas envíanos un WhatsApp al: <br /><br />
            +52 5613512436 con la Lic. Citlaly Paz <br /><br />
            +52 561663 1953 con la Lic. Mayte López <br /><br />
            Menciona tu nombre y la vacante para la cual te postulaste. <br /><br />
            Quedamos al pendiente de tus comentarios <br /><br />
            ¡Saludos Cordiales! <br /><br />
            Además, <strong>Turing-IA</strong>, te invita a formar parte la
            comunidad en nuestras nuevas redes sociales.
          </p>
          <p>
            ➡Apóyanos dando like y follow e invita a tus amigos a seguirnos.
            <br /><br />
            Aquí los links: <br /><br />
            👉Facebook:
            <a href="https://www.facebook.com/turing.mx/"
              >https://www.facebook.com/turing.mx/</a
            >
            <br /><br />
            👉 Instagram:
            <a href="https://www.instagram.com/turing.ia_/"
              >https://www.instagram.com/turing.ia_/</a
            >
            <br /><br />
            👉 LinkedIn:
            <a href="https://www.linkedin.com/company/turing-ia/"
              >https://www.linkedin.com/company/turing-ia/</a
            >
            <br /><br />
            👉 YouTube:
            <a href="https://www.youtube.com/@turing-ia6828/ "
              >https://www.youtube.com/@turing-ia6828/ </a
            ><br /><br />
            👉 Twitter:
            <a href="https://twitter.com/IaTuring/"
              >https://twitter.com/IaTuring/</a
            >
            <br /><br />
            👉 Sitio Web:
            <a href="https://www.turing-ia.com/ ">https://www.turing-ia.com/ </a
            ><br /><br />
            👉Tiktok:
            <a href="https://www.tiktok.com/@turing.ia_"
              >https://www.tiktok.com/@turing.ia_</a
            >
            <br /><br />
            ➡Pronto seremos la comunidad más valiosa de Business Intelligence en
            México. <br /><br />
            ✨¡Muchas gracias por tu apoyo!✨
          </p>
        </div>
      </body>
    </html>';
    $email->setMessage($message);
    if ($email->send()) { //enviar correo
      // $mensaje = "Correo enviado exitosamente a la dirección: " . $correo . " verifique su buzón de entrada/spam.";
      // $session->setFlashdata('success_message', $mensaje);
      //return redirect()->to(base_url('/forget'));

      echo "correo enviado";
    } else {
      return 'Error al enviar el correo: ' . $email->printDebugger();
    }



  }

  public function no_viable($nombre, $correo)
  {


    
    $email = \Config\Services::email();
    $session = session();

    $email->setTo($correo);
    $email->setFrom('capitalhumano@turing-latam.com');
    $email->setSubject('Agradecemos mucho por tu Postulación -doNotReply');
    //$namee = strtoupper($nombre);

    $message = '<!DOCTYPE html>
    <html lang="es">
      <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Correo electrónico</title>
        <style>
          /* Estilos CSS */
          body {
            font-family: "Century Gothic";
            background: #f8fafc;
            color: #333;
            margin: 0;
            padding: 0;
          }
          .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
          }
          h3 {
            color: #333;
            text-align: center;
          }
          p {
            margin-bottom: 20px;
            text-align: justify;
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
            <img
              src="https://portal.turing-latam.com/public/gifs/Captura.PNG"
              alt="logo_turing"
              width="625px"
              height="162px"
            />
          </div>
         
          <p style="text-align: center">Hola <strong>' . $nombre . '</strong> 😊</p>
          <p>
            <strong>TURING-IA,</strong> reviso tu CV y agradecemos mucho tu interés en nuestra vacante y postularte con nosotros, desafortunadamente tu perfil no ha sido seleccionado en esta ocasión.
    <br><br>
            ¡Por favor continúa esforzándote, adquiriendo nuevos conocimientos, te deseamos la mejor de las suertes en tu búsqueda laboral y poder adquirir mayor experiencia!
            
          </p>
          <p>
            Quedamos al pendiente de tus comentarios.
    
          </p>
          <p>
            ¡Saludos Cordiales! <br /><br />
            Además, <strong>Turing-IA</strong>, te invita a formar parte la
            comunidad en nuestras nuevas redes sociales.
          </p>
          <p>
            ➡Apóyanos dando like y follow e invita a tus amigos a seguirnos.
            <br /><br />
            Aquí los links: <br /><br />
            👉Facebook:
            <a href="https://www.facebook.com/turing.mx/"
              >https://www.facebook.com/turing.mx/</a
            >
            <br /><br />
            👉 Instagram:
            <a href="https://www.instagram.com/turing.ia_/"
              >https://www.instagram.com/turing.ia_/</a
            >
            <br /><br />
            👉 LinkedIn:
            <a href="https://www.linkedin.com/company/turing-ia/"
              >https://www.linkedin.com/company/turing-ia/</a
            >
            <br /><br />
            👉 YouTube:
            <a href="https://www.youtube.com/@turing-ia6828/ "
              >https://www.youtube.com/@turing-ia6828/ </a
            ><br /><br />
            👉 Twitter:
            <a href="https://twitter.com/IaTuring/"
              >https://twitter.com/IaTuring/</a
            >
            <br /><br />
            👉 Sitio Web:
            <a href="https://www.turing-ia.com/ ">https://www.turing-ia.com/ </a
            ><br /><br />
            👉Tiktok:
            <a href="https://www.tiktok.com/@turing.ia_"
              >https://www.tiktok.com/@turing.ia_</a
            >
            <br /><br />
            ➡Pronto seremos la comunidad más valiosa de Business Intelligence en
            México. <br /><br />
            ✨¡Muchas gracias por tu apoyo!✨
          </p>
        </div>
      </body>
    </html>';
    $email->setMessage($message);
    if ($email->send()) { //enviar correo
      // $mensaje = "Correo enviado exitosamente a la dirección: " . $correo . " verifique su buzón de entrada/spam.";
      // $session->setFlashdata('success_message', $mensaje);
      //return redirect()->to(base_url('/forget'));

      echo "correo enviado";
    } else {
      return 'Error al enviar el correo: ' . $email->printDebugger();
    }


  }

}