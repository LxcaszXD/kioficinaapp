<?php

class RecuperarSenhaController extends Controller
{

    public function index()
    {
        $dados = array();
        $dados['titulo'] = 'KiOficina - Login';

        $this->carregarViews('recuperar_senha', $dados);
    }
 
}