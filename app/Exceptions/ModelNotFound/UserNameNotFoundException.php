<?php

namespace App\Exceptions\ModelNotFound;

use Exception;
use Symfony\Component\HttpFoundation\Request;

class UserNameNotFoundException extends Exception
{
    protected $code = 404;
    protected $name;
    protected $message;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->message = 'The user: ' . $name . ' doesnt exist.';
    }

    public function render(Request $request)
    {
        $response['message'] = $this->message;
        return response()->json($response, $this->code);
    }

}
