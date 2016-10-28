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

        $nav = [];
        $nav[] = ['href' => route('sessions.index'), 'label' => 'Home'];

        if (\Auth::user() && \Auth::user()->can('create', \App\Session::class)) {
            $nav[] = ['href' => route('sessions.create'), 'label' => 'Create'];
        }

        return view($this->layout, [
            'content' => $content,
            'nav' => $nav,
            'error' => $error,
        ]);
    }
}
