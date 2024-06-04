<?php

namespace App\Middleware;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\RequestInterface;
use Firebase\JWT\JWT;

class JWTMiddleware extends \CodeIgniter\HTTP\BaseMiddleware 
{
    use ResponseTrait;

    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $jwtToken = $session->get('jwt_token');

        if (empty($jwtToken)) {
            return $this->failUnauthorized('Token not provided');
        }

        $key = 'r2n$VzL6!sB*7aQpQSN/!s4.&sMcsA';

        try {
            $decodedToken = JWT::decode($jwtToken, $key, ['HS256']);
            // Verifica otros datos del token según tus necesidades
        } catch (\Exception $e) {
            return $this->failUnauthorized('Invalid token');
        }

        // Agrega datos del token decodificado al request para que puedan ser utilizados en los controladores
        $request->decodedToken = $decodedToken;

        return $request;
    }
}
