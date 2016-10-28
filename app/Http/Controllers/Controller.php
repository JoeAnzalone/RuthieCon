<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $layout = 'layouts.master';
    protected function setPageContent($content)
    {
        $error = \Session::get('error');

        return view($this->layout, [
            'content' => $content,
            'error' => $error,
        ]);
    }
}
