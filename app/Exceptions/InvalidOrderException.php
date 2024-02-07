<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class InvalidOrderException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render(Request $request)
    {
        return Redirect::route('home')
            ->withInput()
            ->withErrors([
                'message' => $this->getMessage()
            ])
            ->with('info', $this->getMessage());
    }
}

