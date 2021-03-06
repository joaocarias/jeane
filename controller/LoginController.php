<?php
session_start();

include_once '../app/model/Servidor.php';
include_once '../app/model/LogAcesso.php';

$btnLogin = filter_input(INPUT_POST, 'btnLogin', FILTER_SANITIZE_STRING);
$loginUsername = filter_input(INPUT_POST, 'loginUsername', FILTER_SANITIZE_STRING);
$loginPassword = filter_input(INPUT_POST, 'loginPassword', FILTER_SANITIZE_STRING);

if($btnLogin){
    $servidor = new Servidor();
    $dados = $servidor->getObjPorLogin($loginUsername);

    if($servidor->pussiu_vinculo_ativo($dados->getId_servidor())){        
        if (md5(sha1(sha1($loginPassword . 'pontobio'))) == $dados->getSenha_servidor()){
            $_SESSION['id_servidor'] = $dados->getId_servidor();
            $_SESSION['nome_servidor'] = $dados->getNome_servidor();       
            $_SESSION['cpf_servidor'] = $dados->getCpf_servidor();
            $_SESSION['logado'] = '1';

            //var_dump($_SESSION);
            
            $logAcesso = new LogAcesso();
            $retorno = $logAcesso->insertObj($dados->getId_servidor(), $loginUsername,  'PERMITIDO');
            header('Location: ../page/dashboard.php?r='.$retorno['id']);    
        }else{
            $_SESSION['logado'] = '0';
            $logAcesso = new LogAcesso();
            $retorno = $logAcesso->insertObj(null, $loginUsername,'NEGADO');
   
            header('Location: ../page/login.php?msg=senha_invalida&r='.$retorno['id']);
        }
    }else{
        $_SESSION['logado'] = '0';
            $logAcesso = new LogAcesso();
            $retorno = $logAcesso->insertObj(null, $loginUsername,'NEGADO');
    
            header('Location: ../page/login.php?msg=senha_invalida&r='.$retorno['id']);        
    } 
}else{
    header('Location: ../page/login.php?msg=nao_logado');
}