<?php

namespace app\core;

class Controller
{
    public function model($model)
    {
        require './app/model/' . $model . '.php';
        $classe = 'app\\model\\' . $model;
        return new $classe();
    }

    public function view(string $view, $data_content = [])
    {
        require './app/view/' . $view . '.php';
    }

    public function pageAccessDined()
    {
        $this->view('erro401');
    }

    public function pageNotFound()
    {
        $this->view('erro404');
    }

    public function methodNotAllowed()
    {
        $this->view('erro405');
    }

    public function noContent()
    {
        $this->view('status204');
    }
}
