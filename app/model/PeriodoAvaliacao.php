<?php

include_once '../lib/ModelBasico.php';

/**
 * Description of PeriodoAvalicao
 *
 * @author joao.franca
 */
class PeriodoAvaliacao extends ModelBasico {
    private $id_periodo_avaliacao;
    private $inicio;
    private $fim;
    private $criador_por;
    private $data_do_cadastro;
    private $modificador_por;
    private $data_da_modificacao;
    private $id_status;
    
    public function is_periodo_inscricao($id_periodo){
        $sql = " SELECT count(id_periodo_avaliacao) as cont FROM tb_periodo_avaliacao WHERE id_periodo_avaliacao = '1' and ( inicio <= NOW() and fim >= NOW()) ";
        
        $dados = $this->select($sql);        
        $cont = 0;    
        
        foreach ($dados as $row){                        
            $cont = $row->cont;            
        }       
        
        if($cont > 0)
            return true;
        else
            return false;
    }
    
    public function getObjPorID($idPeriodo){
        $sql = " SELECT * FROM tb_periodo_avaliacao WHERE id_periodo_avaliacao = '{$idPeriodo}' AND id_status = '1' ";
        
        $dados = $this->select($sql);        
        $obj = new PeriodoAvaliacao();
        
        foreach ($dados as $row){                       
            $obj->setCriador_por($row->criado_por);
            $obj->setData_da_modificacao($row->data_da_modificacao);
            $obj->setData_do_cadastro($row->data_do_cadastro);
            $obj->setFim($row->fim);
            $obj->setId_periodo_avaliacao($row->id_periodo_avaliacao);
            $obj->setInicio($row->inicio);
            $obj->setModificador_por($row->modificador_por);
            $obj->setId_status($row->id_status);               
        }       
        
        return $obj;        
    }    
    
    function getId_periodo_avaliacao() {
        return $this->id_periodo_avaliacao;
    }

    function getInicio() {
        return $this->inicio;
    }

    function getFim() {
        return $this->fim;
    }

    function getCriador_por() {
        return $this->criador_por;
    }

    function getData_do_cadastro() {
        return $this->data_do_cadastro;
    }

    function getModificador_por() {
        return $this->modificador_por;
    }

    function getData_da_modificacao() {
        return $this->data_da_modificacao;
    }

    function getId_status() {
        return $this->id_status;
    }

    function setId_periodo_avaliacao($id_periodo_avaliacao) {
        $this->id_periodo_avaliacao = $id_periodo_avaliacao;
    }

    function setInicio($inicio) {
        $this->inicio = $inicio;
    }

    function setFim($fim) {
        $this->fim = $fim;
    }

    function setCriador_por($criador_por) {
        $this->criador_por = $criador_por;
    }

    function setData_do_cadastro($data_do_cadastro) {
        $this->data_do_cadastro = $data_do_cadastro;
    }

    function setModificador_por($modificador_por) {
        $this->modificador_por = $modificador_por;
    }

    function setData_da_modificacao($data_da_modificacao) {
        $this->data_da_modificacao = $data_da_modificacao;
    }

    function setId_status($id_status) {
        $this->id_status = $id_status;
    }


}
