<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class AppException extends Exception
{
    /**
     * The http status code that will be sent in response.
     * 400 Bad Request | The server cannot or will not process the request due to an apparent client error (e.g., malformed request syntax, size too large, invalid request message framing, or deceptive request routing).
     *
     * @var int
     */
    protected $code = Response::HTTP_BAD_REQUEST;

    protected $message = 'A solicitação nao pôde ser concluida.';
}
