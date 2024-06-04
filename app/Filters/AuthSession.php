<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;

//AuthorizationMiddleware 
class AuthSession implements FilterInterface
{
    use ResponseTrait;
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
		$datosPost = $session->get('datosPost');
        $jwtToken = $session->get('jwt_token'); /*VALIDA LA FIRMA DEL JWT*/

        if (!$datosPost && !$jwtToken) {
            // El usuario no está autenticado, redirige a la página de inicio de sesión
            $mensaje = "Ocurrió algun error, o tu sesión expiro.";
            $session->setFlashdata('error_message', $mensaje);
            return redirect()->to(base_url('/'));
        } /*else {
            return redirect()->to(base_url('home/index'));
        }*/
        
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}