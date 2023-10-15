<?php

namespace App\Exceptions\ModelNotFound;
use Exception;
use Symfony\Component\HttpFoundation\Request;

class EmailNotFoundException extends Exception
{
    protected $code = 404;
    protected $email;
    protected $message;

    public function __construct(string $email)
    {
        $this->email = $email;
        $this->message = 'The user with email: ' . $email . ' doesnt exist.';
    }

    public function render(Request $request)
    {
        $response['message'] = $this->message;
        return response()->json($response, $this->code);
    }

}
