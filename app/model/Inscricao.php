<?php

include_once '../lib/ModelBasico.php';

/**
 * Description of Inscricao
 *
 * @author thalysonluiz
 */
class Inscricao extends ModelBasico{
    private $id_inscricao;
    private $nome_servidor;
    private $cpf_servidor;
    private $cep;
    private $endereco;
    private $telefone;
    private $email;
    private $cargo;
    private $funcao;
    private $unidade_atual;
    private $data_chegada;
    private $experiencia_saude;
    private $motivo_sair;    
    private $data_chegada_sms;    
    private $data_chegada_setor;
    private $unidade_vai1;
    private $unidade_vai2;
    private $unidade_vai3;
    
    private $unidade_foi1;
    private $data_chegada_foi1;
    private $data_saida_foi1;
    private $motivo_foi1;
    private $unidade_foi2;
    private $data_chegada_foi2;
    private $data_saida_foi2;
    private $motivo_foi2;
    private $unidade_foi3;
    private $data_chegada_foi3;
    private $data_saida_foi3;
    private $motivo_foi3;
    
    private $solicitado_por;
    private $data_solicitacao;


//    function __construct($id_inscricao, $nome_servidor, $cpf_servidor, $cep, $endereco,
//                         $telefone, $email, $cargo, $funcao, $unidade_atual, $data_chegada,
//                         $motivo_sair, $unidade_vai1, $unidade_vai2, $unidade_vai3, 
//                         $unidade_foi1, $data_chegada_foi1, $data_saida_foi1, $motivo_foi1, 
//                         $unidade_foi2, $data_chegada_foi2, $data_saida_foi2, $motivo_foi2, 
//                         $unidade_foi3, $data_chegada_foi3, $data_saida_foi3, $motivo_foi3) {
//        $this->id_inscricao;
//        $this->nome_servidor;
//        $this->cpf_servidor;
//        $this->cep;
//        $this->endereco;
//        $this->telefone;
//        $this->email;
//        $this->cargo;
//        $this->funcao;
//        $this->unidade_atual;
//        $this->data_chegada;
//        $this->motivo_sair;
//        $this->unidade_vai1;
//        $this->unidade_vai2;
//        $this->unidade_vai3;
//
//        $this->unidade_foi1;
//        $this->data_chegada_foi1;
//        $this->data_saida_foi1;
//        $this->motivo_foi1;
//        $this->unidade_foi2;
//        $this->data_chegada_foi2;
//        $this->data_saida_foi2;
//        $this->motivo_foi2;
//        $this->unidade_foi3;
//        $this->data_chegada_foi3;
//        $this->data_saida_foi3;
//        $this->motivo_foi3;
//    }
    
    public function inserir($cadastrado_por, $nome_servidor, $cpf_servidor, $cep, $endereco,
                         $telefone, $email, $cargo, $funcao, $unidade_atual, $data_chegada, $data_chegada_sms, $data_chegada_setor,
                         $motivo_sair, $unidade_vai1, $unidade_vai2, $unidade_vai3, $experiencia,
                         $unidade_foi1, $data_chegada_foi1, $data_saida_foi1, $motivo_foi1, 
                         $unidade_foi2, $data_chegada_foi2, $data_saida_foi2, $motivo_foi2, 
                         $unidade_foi3, $data_chegada_foi3, $data_saida_foi3, $motivo_foi3, $admissao_igual) {
        
        
        $coluna = "";
        $valor = "";
        
        if(!empty($unidade_vai2)){
            $coluna .= ", `unidade_desejo2`";
            $valor .= ", '{$unidade_vai2}'";
        }
        if(!empty($unidade_vai3)){
            $coluna .= ", `unidade_desejo3`";
            $valor .= ", '{$unidade_vai3}'";
        }
        if(!empty($unidade_foi1)){
            $coluna .= ", `unidade_anterior1`, `data_chegada_anterior1`, `data_saida_anterior1`, `motivo_saida_anterior1`";
            $valor .= ", '{$unidade_foi1}', '{$data_chegada_foi1}', '{$data_saida_foi1}', '{$motivo_foi1}'";
        }
        if(!empty($unidade_foi2)){
            $coluna .= ", `unidade_anterior2`, `data_chegada_anterior2`, `data_saida_anterior2`, `motivo_saida_anterior2`";
            $valor .= ", '{$unidade_foi2}', '{$data_chegada_foi2}', '{$data_saida_foi2}', '{$motivo_foi2}'";
        }
        if(!empty($unidade_foi3)){
            $coluna .= ", `unidade_anterior3`, `data_chegada_anterior3`, `data_saida_anterior3`, `motivo_saida_anterior3`";
            $valor .= ", '{$unidade_foi3}', '{$data_chegada_foi3}', '{$data_saida_foi3}', '{$motivo_foi3}'";
        }
        
        $sql = " INSERT INTO `inscricao` (`nome_servidor`, `cpf_servidor`, `cep`, `admissao_igual`,
                    `endereco`, `telefone`, `email`, `cargo`, `funcao`, `unidade_atual`, `data_chegada_atual`, `data_chegada_sms`,
                    `data_chegada_setor`, `motivo_solicitacao`, `unidade_desejo1`, `experiencia_saude`, `solicitado_por` ".$coluna.") 
                    VALUES ( '{$nome_servidor}', '{$cpf_servidor}', '{$cep}', '{$admissao_igual}', '{$endereco}', 
                            '{$telefone}', '{$email}', '{$cargo}', '{$funcao}', '{$unidade_atual}', '{$data_chegada}', '{$data_chegada_sms}',
                            '{$data_chegada_setor}', '{$motivo_sair}', '{$unidade_vai1}', '{$experiencia}', '{$cadastrado_por}' ".$valor.");";
        
//        echo $sql;
//        die();
        $arrayRetorno = $this->insert($sql);
        return $arrayRetorno;
    }
    
    public function selectObj($id){
        $sql = " SELECT * FROM `inscricao` WHERE id_inscricao = '{$id}' ORDER BY nome_servidor ASC ";
                
        $dados = $this->select($sql);        
        $obj = new Inscricao();
        
        foreach ($dados as $row){                        
            $obj->setIdInscricao($row->id_inscricao);
            $obj->setNomeServidor($row->nome_servidor);
            $obj->setCpfServidor($row->cpf_servidor);
            $obj->setCargo($row->cargo);
            $obj->setFuncao($row->funcao);
            $obj->setCep($row->cep);
            $obj->setEndereco($row->endereco);
            $obj->setEmail($row->email);
            $obj->setTelefone($row->telefone);
            $obj->setUnidadeAtual($row->unidade_atual);
            $obj->setDataChegadaAtual($row->data_chegada_atual);
            $obj->setDataChegadaSetor($row->data_chegada_setor);
            $obj->setDataChegadaSms($row->data_chegada_sms);
            $obj->setExperienciaSaude($row->experiencia_saude);
            $obj->setMotivoSolicitacao($row->motivo_solicitacao);
            $obj->setUnidadeDesejo1($row->unidade_desejo1);
            $obj->setUnidadeDesejo2($row->unidade_desejo2);
            $obj->setUnidadeDesejo3($row->unidade_desejo3);
            $obj->setUnidadeAnterior1($row->unidade_anterior1);
            $obj->setChegadaUnidadeAnterior1($row->data_chegada_anterior1);
            $obj->setSaidaUnidadeAnterior1($row->data_saida_anterior1);
            $obj->setMotivoUnidadeAnterior1($row->motivo_saida_anterior1);
            $obj->setUnidadeAnterior2($row->unidade_anterior2);
            $obj->setChegadaUnidadeAnterior2($row->data_chegada_anterior2);
            $obj->setSaidaUnidadeAnterior2($row->data_saida_anterior2);
            $obj->setMotivoUnidadeAnterior2($row->motivo_saida_anterior2);
            $obj->setUnidadeAnterior3($row->unidade_anterior3);
            $obj->setChegadaUnidadeAnterior3($row->data_chegada_anterior3);
            $obj->setSaidaUnidadeAnterior3($row->data_saida_anterior3);
            $obj->setMotivoUnidadeAnterior3($row->motivo_saida_anterior3);
            $obj->setSolicitadoPor($row->solicitado_por);
            $obj->setDataSolicitacao($row->data_solicitacao);
        }                
        return $obj;
    }
        
    public function selectObjCPF($cpf){
        $sql = " SELECT * FROM `inscricao` WHERE cpf_servidor = '{$cpf}' ORDER BY nome_servidor ASC ";
                
        $dados = $this->select($sql);        
        $obj = new Inscricao();
//        $array = array();
        
        foreach ($dados as $row){   
//            array_push($array, $row);
            $obj->setIdInscricao($row->id_inscricao);
            $obj->setNomeServidor($row->nome_servidor);
            $obj->setCpfServidor($row->cpf_servidor);
            $obj->setCargo($row->cargo);
            $obj->setFuncao($row->funcao);
            $obj->setCep($row->cep);
            $obj->setEndereco($row->endereco);
            $obj->setEmail($row->email);
            $obj->setTelefone($row->telefone);
            $obj->setUnidadeAtual($row->unidade_atual);
            $obj->setDataChegadaAtual($row->data_chegada_atual);
            $obj->setDataChegadaSetor($row->data_chegada_setor);
            $obj->setDataChegadaSms($row->data_chegada_sms);
            $obj->setExperienciaSaude($row->experiencia_saude);
            $obj->setMotivoSolicitacao($row->motivo_solicitacao);
            $obj->setUnidadeDesejo1($row->unidade_desejo1);
            $obj->setUnidadeDesejo2($row->unidade_desejo2);
            $obj->setUnidadeDesejo3($row->unidade_desejo3);
            $obj->setUnidadeAnterior1($row->unidade_anterior1);
            $obj->setChegadaUnidadeAnterior1($row->data_chegada_anterior1);
            $obj->setSaidaUnidadeAnterior1($row->data_saida_anterior1);
            $obj->setMotivoUnidadeAnterior1($row->motivo_saida_anterior1);
            $obj->setUnidadeAnterior2($row->unidade_anterior2);
            $obj->setChegadaUnidadeAnterior2($row->data_chegada_anterior2);
            $obj->setSaidaUnidadeAnterior2($row->data_saida_anterior2);
            $obj->setMotivoUnidadeAnterior2($row->motivo_saida_anterior2);
            $obj->setUnidadeAnterior3($row->unidade_anterior3);
            $obj->setChegadaUnidadeAnterior3($row->data_chegada_anterior3);
            $obj->setSaidaUnidadeAnterior3($row->data_saida_anterior3);
            $obj->setMotivoUnidadeAnterior3($row->motivo_saida_anterior3);
            $obj->setSolicitadoPor($row->solicitado_por);
            $obj->setDataSolicitacao($row->data_solicitacao);
        }                
        return $obj;
    }
    
    public function getObjsPorUnidadeAtual($params, $arrayFiltro = null){
        $cont = 0;
        $string_id_unidade = "";
        foreach ($params as $v){
            if($cont == 0){
                $string_id_unidade .= " unidade_atual = '{$v}' ";
            }else{
                $string_id_unidade .= " OR unidade_atual = '{$v}' ";
            }
            $cont++;
        }
        
        $string_filtro = "";
        if(!is_null($arrayFiltro)){
            foreach ($arrayFiltro as $col => $value){
                $string_filtro = " AND {$col} = '{$value}'  ";
            }
        }
        
        $sql = " SELECT * FROM inscricao WHERE ({$string_id_unidade}) {$string_filtro} ORDER BY nome_servidor ASC ; ";
                       
        $dados = array();
        $dados = $this->select($sql);
        
        $array = array();
        
        foreach ($dados as $row){
            
            $obj = new Inscricao();
            
            $obj->setIdInscricao($row->id_inscricao);
            $obj->setNomeServidor($row->nome_servidor);
            $obj->setCpfServidor($row->cpf_servidor);
            $obj->setCargo($row->cargo);
            $obj->setFuncao($row->funcao);
            $obj->setCep($row->cep);
            $obj->setEndereco($row->endereco);
            $obj->setEmail($row->email);
            $obj->setTelefone($row->telefone);
            $obj->setUnidadeAtual($row->unidade_atual);
            $obj->setDataChegadaAtual($row->data_chegada_atual);
            $obj->setDataChegadaSetor($row->data_chegada_setor);
            $obj->setDataChegadaSms($row->data_chegada_sms);
            $obj->setExperienciaSaude($row->experiencia_saude);
            $obj->setMotivoSolicitacao($row->motivo_solicitacao);
            $obj->setUnidadeDesejo1($row->unidade_desejo1);
            $obj->setUnidadeDesejo2($row->unidade_desejo2);
            $obj->setUnidadeDesejo3($row->unidade_desejo3);
            $obj->setUnidadeAnterior1($row->unidade_anterior1);
            $obj->setChegadaUnidadeAnterior1($row->data_chegada_anterior1);
            $obj->setSaidaUnidadeAnterior1($row->data_saida_anterior1);
            $obj->setMotivoUnidadeAnterior1($row->motivo_saida_anterior1);
            $obj->setUnidadeAnterior2($row->unidade_anterior2);
            $obj->setChegadaUnidadeAnterior2($row->data_chegada_anterior2);
            $obj->setSaidaUnidadeAnterior2($row->data_saida_anterior2);
            $obj->setMotivoUnidadeAnterior2($row->motivo_saida_anterior2);
            $obj->setUnidadeAnterior3($row->unidade_anterior3);
            $obj->setChegadaUnidadeAnterior3($row->data_chegada_anterior3);
            $obj->setSaidaUnidadeAnterior3($row->data_saida_anterior3);
            $obj->setMotivoUnidadeAnterior3($row->motivo_saida_anterior3);
            $obj->setSolicitadoPor($row->solicitado_por);
            $obj->setDataSolicitacao($row->data_solicitacao);
            
            array_push($array, $obj);
        }        
        
        return $array;
    }

    public function getArrayBasic(){
        $list = $this->getListObjActive();
        
        $array = array();
        
        $i = 0;
        foreach ($list as $item){
            
            $array[$i]['id_incricao'] = $item->getIdInscricao();
            $array[$i]['nome_servidor'] = $item->getNomeServidor();
            $array[$i]['cpf_servidor'] = $item->getCpfServidor();
            $array[$i]['cargo'] = $item->getCargo();
            $array[$i]['funcao'] = $item->getFuncao();
            $array[$i]['cep'] = $item->getCep();
            $array[$i]['endereco'] = $item->getEndereco();
            $array[$i]['email'] = $item->getEmail();
            $array[$i]['telefone'] = $item->getTelefone();
            $array[$i]['unidade_atual'] = $item->getUnidadeAtual();
            $array[$i]['data_chegada'] = $item->getDataChegadaAtual();
            $array[$i]['data_chegada_setor'] = $item->getDataChegadaSetor();
            $array[$i]['data_chegada_sms'] = $item->getDataChegadaSms();
            $array[$i]['experiencia_saude'] = $item->getExperienciaSaude();
            $array[$i]['motivo_sair'] = $item->getMotivoSolicitacao();
            $array[$i]['unidade_vai1'] = $item->getUnidadeDesejo1();
            $array[$i]['unidade_vai2'] = $item->getUnidadeDesejo2();
            $array[$i]['unidade_vai3'] = $item->getUnidadeDesejo3();
            $array[$i]['unidade_foi1'] = $item->getUnidadeAnterior1();
            $array[$i]['data_chegada_foi1'] = $item->getChegadaUnidadeAnterior1();
            $array[$i]['data_saida_foi1'] = $item->getSaidaUnidadeAnterior1();
            $array[$i]['motivo_foi1'] = $item->getMotivoUnidadeAnterior1();
            $array[$i]['unidade_foi2'] = $item->getUnidadeAnterior2();
            $array[$i]['data_chegada_foi2'] = $item->getChegadaUnidadeAnterior2();
            $array[$i]['data_saida_foi2'] = $item->getSaidaUnidadeAnterior2();
            $array[$i]['motivo_foi2'] = $item->getMotivoUnidadeAnterior2();
            $array[$i]['unidade_foi3'] = $item->getUnidadeAnterior3();
            $array[$i]['data_chegada_foi3'] = $item->getChegadaUnidadeAnterior3();
            $array[$i]['data_saida_foi3'] = $item->getSaidaUnidadeAnterior3();
            $array[$i]['motivo_foi3'] = $item->getMotivoUnidadeAnterior3();
            $array[$i]['solicitado_por'] = $item->getSolicitadoPor();
            $array[$i]['data_solicitacao'] = $item->getDataSolicitacao();
            $i++;
        }
        
        return $array;
    }
    
    public function getArrayPorCPF($cpf){
        $list = $this->selectObjCPF($cpf);
        
        $array = array();
        
        foreach ($list as $item){
            
            $array['id_incricao'] = $item->getIdInscricao();
            $array['nome_servidor'] = $item->getNomeServidor();
            $array['cpf_servidor'] = $item->getCpfServidor();
            $array['cargo'] = $item->getCargo();
            $array['funcao'] = $item->getFuncao();
            $array['cep'] = $item->getCep();
            $array['endereco'] = $item->getEndereco();
            $array['email'] = $item->getEmail();
            $array['telefone'] = $item->getTelefone();
            $array['unidade_atual'] = $item->getUnidadeAtual();
            $array['data_chegada'] = $item->getDataChegadaAtual();
            $array['data_chegada_setor'] = $item->getDataChegadaSetor();
            $array['data_chegada_sms'] = $item->getDataChegadaSms();
            $array['experiencia_saude'] = $item->getExperienciaSaude();
            $array['motivo_sair'] = $item->getMotivoSolicitacao();
            $array['unidade_vai1'] = $item->getUnidadeDesejo1();
            $array['unidade_vai2'] = $item->getUnidadeDesejo2();
            $array['unidade_vai3'] = $item->getUnidadeDesejo3();
            $array['unidade_foi1'] = $item->getUnidadeAnterior1();
            $array['data_chegada_foi1'] = $item->getChegadaUnidadeAnterior1();
            $array['data_saida_foi1'] = $item->getSaidaUnidadeAnterior1();
            $array['motivo_foi1'] = $item->getMotivoUnidadeAnterior1();
            $array['unidade_foi2'] = $item->getUnidadeAnterior2();
            $array['data_chegada_foi2'] = $item->getChegadaUnidadeAnterior2();
            $array['data_saida_foi2'] = $item->getSaidaUnidadeAnterior2();
            $array['motivo_foi2'] = $item->getMotivoUnidadeAnterior2();
            $array['unidade_foi3'] = $item->getUnidadeAnterior3();
            $array['data_chegada_foi3'] = $item->getChegadaUnidadeAnterior3();
            $array['data_saida_foi3'] = $item->getSaidaUnidadeAnterior3();
            $array['motivo_foi3'] = $item->getMotivoUnidadeAnterior3();
            $array['solicitado_por'] = $item->getSolicitadoPor();
            $array['data_solicitacao'] = $item->getDataSolicitacao();
            
        }
        
        return $array;
    }
    
    public function getListNaoAvaliados($arrayFiltro = null){
        $string_filtro = "";
        $cont = 0;
        if(!is_null($arrayFiltro)){
            foreach ($arrayFiltro as $col => $value){               
                    $string_filtro .= " AND {$col} = '{$value}'  ";               
            }
        }
        
        $sql = " SELECT * FROM `inscricao` WHERE id_inscricao NOT IN (SELECT id_inscricao FROM tb_avaliacao WHERE id_status = '1' ) {$string_filtro}  ORDER BY nome_servidor ASC ";
        
        $dados = array();
        $dados = $this->select($sql);
        
        $array = array();
        
        foreach ($dados as $row){
            
            $obj = new Inscricao();
            
            $obj->setIdInscricao($row->id_inscricao);
            $obj->setNomeServidor($row->nome_servidor);
            $obj->setCpfServidor($row->cpf_servidor);
            $obj->setCargo($row->cargo);
            $obj->setFuncao($row->funcao);
            $obj->setCep($row->cep);
            $obj->setEndereco($row->endereco);
            $obj->setEmail($row->email);
            $obj->setTelefone($row->telefone);
            $obj->setUnidadeAtual($row->unidade_atual);
            $obj->setDataChegadaAtual($row->data_chegada_atual);
            $obj->setDataChegadaSetor($row->data_chegada_setor);
            $obj->setDataChegadaSms($row->data_chegada_sms);
            $obj->setExperienciaSaude($row->experiencia_saude);
            $obj->setMotivoSolicitacao($row->motivo_solicitacao);
            $obj->setUnidadeDesejo1($row->unidade_desejo1);
            $obj->setUnidadeDesejo2($row->unidade_desejo2);
            $obj->setUnidadeDesejo3($row->unidade_desejo3);
            $obj->setUnidadeAnterior1($row->unidade_anterior1);
            $obj->setChegadaUnidadeAnterior1($row->data_chegada_anterior1);
            $obj->setSaidaUnidadeAnterior1($row->data_saida_anterior1);
            $obj->setMotivoUnidadeAnterior1($row->motivo_saida_anterior1);
            $obj->setUnidadeAnterior2($row->unidade_anterior2);
            $obj->setChegadaUnidadeAnterior2($row->data_chegada_anterior2);
            $obj->setSaidaUnidadeAnterior2($row->data_saida_anterior2);
            $obj->setMotivoUnidadeAnterior2($row->motivo_saida_anterior2);
            $obj->setUnidadeAnterior3($row->unidade_anterior3);
            $obj->setChegadaUnidadeAnterior3($row->data_chegada_anterior3);
            $obj->setSaidaUnidadeAnterior3($row->data_saida_anterior3);
            $obj->setMotivoUnidadeAnterior3($row->motivo_saida_anterior3);
            $obj->setSolicitadoPor($row->solicitado_por);
            $obj->setDataSolicitacao($row->data_solicitacao);
            
            array_push($array, $obj);
        }        
        
        return $array;
    }
    
    public function getListObjActive($arrayFiltro = null){
        
        $string_filtro = "";
        $cont = 0;
        if(!is_null($arrayFiltro)){
            foreach ($arrayFiltro as $col => $value){
                if($cont == 0 ){
                    $string_filtro .= " WHERE {$col} = '{$value}'  ";
                }else{
                    $string_filtro .= " AND {$col} = '{$value}'  ";
                }    
                $cont++;
            }
        }
        
        $sql = " SELECT * FROM `inscricao` {$string_filtro} ORDER BY nome_servidor ASC ";
              
        $dados = array();
        $dados = $this->select($sql);
        
        $array = array();
        
        foreach ($dados as $row){
            
            $obj = new Inscricao();
            
            $obj->setIdInscricao($row->id_inscricao);
            $obj->setNomeServidor($row->nome_servidor);
            $obj->setCpfServidor($row->cpf_servidor);
            $obj->setCargo($row->cargo);
            $obj->setFuncao($row->funcao);
            $obj->setCep($row->cep);
            $obj->setEndereco($row->endereco);
            $obj->setEmail($row->email);
            $obj->setTelefone($row->telefone);
            $obj->setUnidadeAtual($row->unidade_atual);
            $obj->setDataChegadaAtual($row->data_chegada_atual);
            $obj->setDataChegadaSetor($row->data_chegada_setor);
            $obj->setDataChegadaSms($row->data_chegada_sms);
            $obj->setExperienciaSaude($row->experiencia_saude);
            $obj->setMotivoSolicitacao($row->motivo_solicitacao);
            $obj->setUnidadeDesejo1($row->unidade_desejo1);
            $obj->setUnidadeDesejo2($row->unidade_desejo2);
            $obj->setUnidadeDesejo3($row->unidade_desejo3);
            $obj->setUnidadeAnterior1($row->unidade_anterior1);
            $obj->setChegadaUnidadeAnterior1($row->data_chegada_anterior1);
            $obj->setSaidaUnidadeAnterior1($row->data_saida_anterior1);
            $obj->setMotivoUnidadeAnterior1($row->motivo_saida_anterior1);
            $obj->setUnidadeAnterior2($row->unidade_anterior2);
            $obj->setChegadaUnidadeAnterior2($row->data_chegada_anterior2);
            $obj->setSaidaUnidadeAnterior2($row->data_saida_anterior2);
            $obj->setMotivoUnidadeAnterior2($row->motivo_saida_anterior2);
            $obj->setUnidadeAnterior3($row->unidade_anterior3);
            $obj->setChegadaUnidadeAnterior3($row->data_chegada_anterior3);
            $obj->setSaidaUnidadeAnterior3($row->data_saida_anterior3);
            $obj->setMotivoUnidadeAnterior3($row->motivo_saida_anterior3);
            $obj->setSolicitadoPor($row->solicitado_por);
            $obj->setDataSolicitacao($row->data_solicitacao);
            
            array_push($array, $obj);
        }        
        
        return $array;
    }
    
    function getIdInscricao() {
        return $this->id_inscricao;
    }

    function getNomeServidor() {
        return $this->nome_servidor;
    }
    
    function getCpfServidor() {
        return $this->cpf_servidor;
    }
    
    function getCep() {
        return $this->cep;
    }
    
    function getEndereco() {
        return $this->endereco;
    }
    
    function getTelefone() {
        return $this->telefone;
    }
    
    function getEmail() {
        return $this->email;
    }
    
    function getCargo() {
        return $this->cargo;
    }
    
    function getFuncao() {
        return $this->funcao;
    }
    
    function getUnidadeAtual() {
        return $this->unidade_atual;
    }
    
    function getDataChegadaAtual() {
        return $this->data_chegada;
    }
    
    function getDataChegadaSetor() {
        return $this->data_chegada_setor;
    }
    
    function getDataChegadaSms() {
        return $this->data_chegada_sms;
    }
    
    function getExperienciaSaude() {
        return $this->experiencia_saude;
    }
    
    function getMotivoSolicitacao() {
        return $this->motivo_sair;
    }
    
    function getUnidadeDesejo1() {
        return $this->unidade_vai1;
    }
    
    function getUnidadeDesejo2() {
        return $this->unidade_vai2;
    }
    
    function getUnidadeDesejo3() {
        return $this->unidade_vai3;
    }
    
    function getUnidadeAnterior1() {
        return $this->unidade_foi1;
    }
    
    function getChegadaUnidadeAnterior1() {
        return $this->data_chegada_foi1;
    }
    
    function getSaidaUnidadeAnterior1() {
        return $this->data_saida_foi1;
    }
    
    function getMotivoUnidadeAnterior1() {
        return $this->motivo_foi1;
    }
    
    function getUnidadeAnterior2() {
        return $this->unidade_foi2;
    }
    
    function getChegadaUnidadeAnterior2() {
        return $this->data_chegada_foi2;
    }
    
    function getSaidaUnidadeAnterior2() {
        return $this->data_saida_foi2;
    }
    
    function getMotivoUnidadeAnterior2() {
        return $this->motivo_foi2;
    }
    
    function getUnidadeAnterior3() {
        return $this->unidade_foi3;
    }
    
    function getChegadaUnidadeAnterior3() {
        return $this->data_chegada_foi3;
    }
    
    function getSaidaUnidadeAnterior3() {
        return $this->data_saida_foi3;
    }
    
    function getMotivoUnidadeAnterior3() {
        return $this->motivo_foi3;
    }
    
    function getDataSolicitacao() {
        return $this->data_solicitacao;
    }
    
    function getSolicitadoPor() {
        return $this->solicitado_por;
    }
    
    function setIdInscricao($id_incricao) {
        $this->id_inscricao = $id_incricao;
    }

    function setNomeServidor($nome_servidor) {
        $this->nome_servidor = $nome_servidor;
    }
    
    function setCpfServidor($cpf_servidor) {
        $this->cpf_servidor = $cpf_servidor;
    }
    
    function setCep($cep) {
        $this->cep = $cep;
    }
    
    function setEndereco($endereco) {
        $this->endereco = $endereco;
    }
    
    function setTelefone($telefone) {
        $this->telefone = $telefone;
    }
    
    function setEmail($email) {
        $this->email = $email;
    }
    
    function setCargo($cargo) {
        $this->cargo = $cargo;
    }
    
    function setFuncao($funcao) {
        $this->funcao = $funcao;
    }
    
    function setUnidadeAtual($unidade_atual) {
        $this->unidade_atual = $unidade_atual;
    }
    
    function setDataChegadaAtual($data_chegada) {
        $this->data_chegada = $data_chegada;
    }
    
    function setDataChegadaSetor($data_chegada_setor) {
        $this->data_chegada_setor = $data_chegada_setor;
    }
    
    function setDataChegadaSms($data_chegada_sms) {
        $this->data_chegada_sms = $data_chegada_sms;
    }
    
    function setExperienciaSaude($experiencia_saude) {
        $this->experiencia_saude = $experiencia_saude;
    }
    
    function setMotivoSolicitacao($motivo_sair) {
        $this->motivo_sair = $motivo_sair;
    }
    
    function setUnidadeDesejo1($unidade_vai1) {
        $this->unidade_vai1 = $unidade_vai1;
    }
    
    function setUnidadeDesejo2($unidade_vai2) {
        $this->unidade_vai2 = $unidade_vai2;
    }
    
    function setUnidadeDesejo3($unidade_vai3) {
        $this->unidade_vai3 = $unidade_vai3;
    }
    
    function setUnidadeAnterior1($unidade_foi1) {
        $this->unidade_foi1 = $unidade_foi1;
    }
    
    function setChegadaUnidadeAnterior1($data_chegada_foi1) {
        $this->data_chegada_foi1 = $data_chegada_foi1;
    }
    
    function setSaidaUnidadeAnterior1($data_saida_foi1) {
        $this->data_saida_foi1 = $data_saida_foi1;
    }
    
    function setMotivoUnidadeAnterior1($motivo_foi1) {
        $this->motivo_foi1 = $motivo_foi1;
    }
    
    function setUnidadeAnterior2($unidade_foi2) {
        $this->unidade_foi2 = $unidade_foi2;
    }
    
    function setChegadaUnidadeAnterior2($data_chegada_foi2) {
        $this->data_chegada_foi2 = $data_chegada_foi2;
    }
    
    function setSaidaUnidadeAnterior2($data_saida_foi2) {
        $this->data_saida_foi2 = $data_saida_foi2;
    }
    
    function setMotivoUnidadeAnterior2($motivo_foi2) {
        $this->motivo_foi2 = $motivo_foi2;
    }
    
    function setUnidadeAnterior3($unidade_foi3) {
        $this->unidade_foi3 = $unidade_foi3;
    }
    
    function setChegadaUnidadeAnterior3($data_chegada_foi3) {
        $this->data_chegada_foi3 = $data_chegada_foi3;
    }
    
    function setSaidaUnidadeAnterior3($data_saida_foi3) {
        $this->data_saida_foi3 = $data_saida_foi3;
    }
    
    function setMotivoUnidadeAnterior3($motivo_foi3) {
        $this->motivo_foi3 = $motivo_foi3;
    }
    
    function setDataSolicitacao($data_solicitacao) {
        $this->data_solicitacao;
    }
    
    function setSolicitadoPor($solicitado_por) {
        $this->solicitado_por = $solicitado_por;
    }
    
    function getLabelMotivoAnterior($label) {
        if($label == 1){
            return "A Pedido";
        }
        else{
            return "Devolução";
        }
        
    }
}
