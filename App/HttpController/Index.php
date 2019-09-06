<?php

namespace App\HttpController;

use EasySwoole\Http\AbstractInterface\Controller;

class Index extends Controller
{
    public function index()
    {
        $this->response()->write('hello');
    }
    public function admin()
    {
        $this->response()->redirect('/admin.html');
    }

}