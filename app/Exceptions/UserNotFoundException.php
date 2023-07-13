<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Request;

class UserNotFoundException extends Exception
{
    protected $code = 404;
    protected $id;
    protected $message;

    public function __construct(int $id)
    {
        $this->id = $id;
        $this->message = 'User with ID ' . $id . ' not found.';
    }

    public function render(Request $request)
    {
        $response['message'] = $this->message;
        return response()->json($response, $this->code);
    }

}
