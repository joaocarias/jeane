<?php

include_once '../lib/ModelBasico.php';

/**
 * Description of Avaliacao
 *
 * @author joao.franca
 */
class Avaliacao extends ModelBasico{
    private $id_avaliacao;
    private $id_inscricao;
    private $nota1;
    private $nota2;
    private $nota3;
    private $nota4;
    private $nota5;
    private $pergunta6;
    private $pergunta7;
    private $pergunta8;
    private $pergunta9;
    private $pergunta10;
    private $id_avaliador;
    private $data_da_avaliacao;
    private $modificador_por;
    private $data_da_modificacao;
    private $id_status;
    
    public function getObjPorInscricao($idInscricao){
        $sql = " SELECT * FROM tb_avaliacao WHERE id_inscricao = '{$idInscricao}' AND id_status = '1' ";
        
        $dados = $this->select($sql);        
        $obj = new Avaliacao();
        
        foreach ($dados as $row){           
            $obj->setData_da_avaliacao($row->data_da_avaliacao);
            $obj->setData_da_modificacao($row->data_da_modificacao);
            $obj->setId_avaliacao($row->id_avaliacao);
            $obj->setId_avaliador($row->id_avaliador);
            $obj->setId_inscricao($row->id_inscricao);
            $obj->setId_status($row->id_status);
            $obj->setModificador_por($row->modificado_por);
            $obj->setNota1($row->nota1);
            $obj->setNota2($row->nota2);
            $obj->setNota3($row->nota3);
            $obj->setNota4($row->nota4);
            $obj->setNota5($row->nota5);
            $obj->setPergunta6($row->pergunta6);
            $obj->setPergunta7($row->pergunta7);
            $obj->setPergunta8($row->pergunta8);
            $obj->setPergunta9($row->pergunta9);
            $obj->setPergunta10($row->pergunta10);
        }       
        
        return $obj;        
    }
    
    public function getPontuacao($idInscricao){        
        $sql = " SELECT * FROM tb_avaliacao WHERE id_inscricao = '{$idInscricao}' AND id_status = '1' ";
        
        $dados = $this->select($sql);        
        $nota = 0;    
        
        foreach ($dados as $row){                        
            $nota = $row->nota1 + $row->nota2 + $row->nota3 + $row->nota4 + $row->nota5;            
        }      
        
        $objInscricao1 = new Inscricao();
        $servidor1 = $objInscricao1->selectObj($idInscricao);
                
        $tempoAdmissao = $this->tempoDeServico($servidor1->getDataChegadaSms());
        $tempoUnidade = $this->tempoDeServico($servidor1->getDataChegadaAtual());
        $tempoSetor = $this->tempoDeServico($servidor1->getDataChegadaSetor());
                
        $nota += $this->pontuacaoTempo($tempoAdmissao, 1);
        $nota += $this->pontuacaoTempo($tempoUnidade, 2);
        $nota += $this->pontuacaoTempo($tempoSetor, 3);
        
        if($nota > 0) return $nota;
        else return 0;        
    }
    
    public function tempoDeServico($data) {
                
        $tempo = "";
                
        list($ano, $mes, $dia) = explode('-', $data);
                
        $tempo = mktime( 0, 0, 0, $mes, $dia, $ano);
                
        $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));

        $tempo = floor((((($hoje - $tempo) / 60) / 60) / 24) / 365.25);
//        print "data: $data, tempo : $tempo <br>";
        
        return $tempo;
    }
    
    public function pontuacaoTempo($tempo, $chave) {
        $potuacao = 0;
        
        if($chave == 1){
            if($tempo >= 4 && $tempo <= 10){
                $potuacao = 4;
            }
            elseif($tempo >= 11 && $tempo <= 15){
                $potuacao = 6;
            }
            elseif($tempo >= 16 && $tempo <= 20){
                $potuacao = 8;
            }
            elseif($tempo >= 21){
                $potuacao = 10;
            }
        }
        else{
            if($tempo >= 1 && $tempo <= 2){
                $potuacao = 2;
            }
            elseif($tempo >= 3 && $tempo <= 4){
                $potuacao = 4;
            }
            elseif($tempo >= 5 && $tempo <= 6){
                $potuacao = 6;
            }
            elseif($tempo >= 7 && $tempo <= 8){
                $potuacao = 8;
            }
            elseif($tempo >= 9){
                $potuacao = 10;
            }
        }
        
        return $potuacao;
    }

    public function insertObj($tabela, array $params){       
        $i = 0;
        
        $colunas = "";        
        $valores = "";
        foreach ($params as $coluna => $valor){
            if($i == 0){
                $colunas .= "{$coluna}";
                $valores .= "'{$valor}'";
            }else{
                $colunas .= ", {$coluna}";
                $valores .= ", '{$valor}'";
            }
            $i++;
        }
        
        $sql = " INSERT INTO {$tabela} ( {$colunas} ) "
        . " VALUES ({$valores}); ";         
               
        return $this->insert($sql);
    }
    
    public function is_avaliado($id_inscricao){
        $sql = " SELECT count(id_inscricao) as cont FROM tb_avaliacao WHERE id_inscricao = '{$id_inscricao}' AND id_status = '1' ";
        
        $dados = $this->select($sql);        
        $cont = 0;    
        
        foreach ($dados as $row){                        
            $cont = $row->cont;            
        }       
        
        if($cont > 0) return true;
        else return false;
    }
    
    public function getDadosClassificacao($arrayFiltro){
        
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
        
        $sql = " SELECT id_avaliacao, ava.id_inscricao as id_inscricao, (nota1 + nota2 + nota3 + nota4 + nota5) as pontuacao, ava.pergunta8 "
                . " FROM `tb_avaliacao` as ava "
                . " INNER JOIN inscricao as ins ON ins.id_inscricao = ava.id_inscricao  "
                . $string_filtro
                . " ORDER BY pontuacao DESC";
       
        $dados = $this->select($sql);
        
        return $dados;
    }
    
    function getId_avaliacao() {
        return $this->id_avaliacao;
    }

    function getId_inscricao() {
        return $this->id_inscricao;
    }

    function getNota1() {
        return $this->nota1;
    }

    function getNota2() {
        return $this->nota2;
    }

    function getNota3() {
        return $this->nota3;
    }

    function getNota4() {
        return $this->nota4;
    }

    function getNota5() {
        return $this->nota5;
    }

    function getPergunta6() {
        return $this->pergunta6;
    }

    function getPergunta7() {
        return $this->pergunta7;
    }

    function getPergunta8() {
        return $this->pergunta8;
    }

    function getPergunta9() {
        return $this->pergunta9;
    }
    
    function getPergunta10() {
        return $this->pergunta10;
    }

    function getId_avaliador() {
        return $this->id_avaliador;
    }

    function getData_da_avaliacao() {
        return $this->data_da_avaliacao;
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

    function setId_avaliacao($id_avaliacao) {
        $this->id_avaliacao = $id_avaliacao;
    }

    function setId_inscricao($id_inscricao) {
        $this->id_inscricao = $id_inscricao;
    }

    function setNota1($nota1) {
        $this->nota1 = $nota1;
    }

    function setNota2($nota2) {
        $this->nota2 = $nota2;
    }

    function setNota3($nota3) {
        $this->nota3 = $nota3;
    }

    function setNota4($nota4) {
        $this->nota4 = $nota4;
    }

    function setNota5($nota5) {
        $this->nota5 = $nota5;
    }

    function setPergunta6($pergunta6) {
        $this->pergunta6 = $pergunta6;
    }

    function setPergunta7($pergunta7) {
        $this->pergunta7 = $pergunta7;
    }

    function setPergunta8($pergunta8) {
        $this->pergunta8 = $pergunta8;
    }

    function setPergunta9($pergunta9) {
        $this->pergunta9 = $pergunta9;
    }
    
    function setPergunta10($pergunta10) {
        $this->pergunta10 = $pergunta10;
    }

    function setId_avaliador($id_avaliador) {
        $this->id_avaliador = $id_avaliador;
    }

    function setData_da_avaliacao($data_da_avaliacao) {
        $this->data_da_avaliacao = $data_da_avaliacao;
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
