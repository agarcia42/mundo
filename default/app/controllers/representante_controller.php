<?php

/********************************************************************
 * Menu: Representante                                       *
 *                                                  *
 * Esta es la clase ReportesController del Conest que contiene      *
 * métodos para generar constancias en formato PDF.               *    
 *                                                                  *
 * @category   Conest                                               *
 * @package    Controller                                           *
 * @copyright  Copyright (c) 2010-2014 CONEST EQUIPO DE SISTEMA     *
 * @sitio      http://localhost/mundo                              *  
 * @license    UNEFM                                                *
/*******************************************************************/
class RepresentanteController extends AppController{

    protected function before_filter(){
      if(Load::model('usuarios')->logged()==true){
         $this->cedusu = Session::get('cedusu');
      }else{
        return Redirect::route_to("controller: index", "action: logout");
      }
    }
  
    public function portal($cedrep='0',$codalu='0',$codesq='0',$codcon='0',$accion='N',$desfac=0,$pagpar=0){
      View::template(NULL);
      $this->cedrep=$cedrep;
      $this->codalu=$codalu;
      $this->codesq=$codesq;
      $this->codcon=$codcon;


    $ins=load::model('inscripcion')->busca_uno($cedrep,$codalu);
    if($ins){
        $this->codniv=$ins->codniv;
        $this->codcur=$ins->codcur;
        $this->codsec=$ins->codsec;
        $this->codtar=$ins->codtar;
        $this->codper=$ins->codper;
        $this->desfac=$ins->desfac;
    }

    if($accion=="E"){
      load::model('detalle')->find_all_by_sql("delete from detalle where cedrep='$cedrep' and codalu='$codalu' and codniv='$this->codniv' and codtar='$this->codtar' and codcon='$codcon' and stafac='E' and codper='$this->codper'");
    }
    if($accion=="ED"){
      load::model('detalle')->find_all_by_sql("delete from detalle where cedrep='$cedrep' and codalu='$codalu' and codniv='$this->codniv' and codtar='$this->codtar' and codcon='$codcon' and stafac='F' and codper='$this->codper'");
    }
    if($accion=="EX"){
      load::model('detalle')->find_all_by_sql("update detalle set stafac='E' where cedrep='$cedrep' and codalu='$codalu' and codniv='$this->codniv' and codtar='$this->codtar' and codcon='$codcon' and stafac='F' and codper='$this->codper'");
    }
    if($accion=="SE"){
      load::model('detalle')->find_all_by_sql("update detalle set stafac='P' where cedrep='$cedrep' and codalu='$codalu' and codniv='$this->codniv' and codtar='$this->codtar' and codcon='$codcon' and stafac='F' and codper='$this->codper'");
    }
    if($accion=="P"){
      load::model('detalle')->find_all_by_sql("delete from detalle where cedrep='$cedrep' and codalu='$codalu' and codniv='$this->codniv' and codtar='$this->codtar' and codcon='$codcon' and stafac='P' and codper='$this->codper'");
    }
    if($accion=='DS'){
      $con=load::model('monto')->find_first("codniv='$this->codniv' and codtar='$this->codtar' and codcon='$this->codcon' and codper='$this->codper'");
      $det=load::model('Detalle')->sum("mondet","conditions: cedrep='$cedrep'and stafac!='E' and stafac!='P' and stafac='C' and codalu='$this->codalu' AND codniv='$this->codniv' and codtar='$this->codtar' and codcon='$this->codcon' and codper='$this->codper'"); 
      if($con){ 
        $totpar=$con->monto-($det+($con->monto*$desfac)/100); 
      } else {
        $totpar=0;
      } 
      $totpar=round($totpar,0);
      load::model('detalle')->find_all_by_sql("update detalle set desfac='$desfac',mondet='$totpar' where cedrep='$cedrep' and codalu='$codalu' and codniv='$this->codniv' and codtar='$this->codtar' and codcon='$codcon' and stafac='F' and codper='$this->codper'");
    }
    
    if($accion=='PP'){
      $con=load::model('monto')->find_first("codniv='$this->codniv' and codtar='$this->codtar' and codcon='$this->codcon' and codper='$this->codper'");
      $det=load::model('Detalle')->sum("mondet","conditions: cedrep='$cedrep'and stafac!='E' and stafac!='P' and stafac='C' and codalu='$this->codalu' AND codniv='$this->codniv' and codtar='$this->codtar' and codcon='$this->codcon' and codper='$this->codper'"); 
      if($con){ 
        $totpar=$con->monto-($det+($con->monto*$desfac)/100); 
      } else {
        $totpar=0;
      } 
      $totpar=round($totpar,0);
      $mondet=round($pagpar,0);
      load::model('detalle')->find_all_by_sql("update detalle set desfac='$desfac',mondet='$mondet' where cedrep='$cedrep' and codalu='$codalu' and codniv='$this->codniv' and codtar='$this->codtar' and codcon='$codcon' and stafac='F' and codper='$this->codper'");
    }

    if($accion=="S"){
      $ultima=load::model('detalle')->ultima_factura($cedrep);
      $fecreg=date("Y-m-d");
      $horreg=date("H:i:s");
      $ususis=trim(strtoupper(Session::get('ceusualogin')));
        if(!load::model('detalle')->find_first("cedrep='$cedrep' and codalu='$codalu' and codniv='$this->codniv' and codtar='$this->codtar' and codcon='$codcon' and stafac='F' and codper='$this->codper'")){
        $con=load::model('concepto')->find_first("codniv='$this->codniv' and codtar='$this->codtar' and codcon='$codcon'");
        $mon=load::model('monto')->find_first("codniv='$this->codniv' and codtar='$this->codtar' and codcon='$codcon' and codper='$this->codper'");
        $detal=load::model('detalle')->sum("mondet","conditions: cedrep='$cedrep' and stafac='C' and codalu='$codalu' AND codniv='$this->codniv' and codtar='$this->codtar' and codcon='$codcon'  and codper='$this->codper'");
         if ($mon){ $totpar=$mon->monto-($detal+($mon->monto*$this->desfac)/100); } else {$totpar=0;} 
          if($totpar!=0){
            $totpar=round($totpar,0);
            load::model('detalle')->find_all_by_sql("INSERT INTO detalle(
            numfact, codsec, codcur, codalu, cedrep, codniv, codtar, desdet, 
            mondet, codcon, ususis, fecreg, horsis, codper,stafac,desfac)
    VALUES ('$ultima', '$ins->codsec', '$ins->codcur', '$ins->codalu', '$ins->cedrep', '$ins->codniv', '$ins->codtar', '$con->descon', '$totpar', '$codcon', '$ususis', '$fecreg', '$horreg', '$ins->codper','F', '$this->desfac')");
          }
        }
    }


    }




public function nuevo($cedula=0,$accion='N'){
  View::template(NULL);

  $this->valida="0";
 // $this->data="0";
 // $this->ver=$ver;
  
  
  if($accion=='M'){ //busca datos en la base de datos
    $this->encuentra($cedula);
  }else{
    $this->buscar();
  }
  
  if(Input::hasPost("representante")){
      $fields="Cedula=>{".str_replace(',', ' ',$this->cedula).",Nombres=>".str_replace(',', ' ',$this->nombres).",Apellidos=>".str_replace(',', ' ',$this->apellidos).",Dirección=>".str_replace(',', ' ',$this->direccion).",Telefono Principal=>".str_replace(',', ' ',$this->telef1);
      $this->valida = Conests::validate($fields);
      if($this->valida=="0"){
        if(load::model('representante')->busca_uno($this->cedula)){
         load::model('representante')->find_all_by_sql("update representante set nomrep='$this->nombres', aperep='$this->apellidos', dirrep='$this->direccion', telcasrep='$this->telef1', telcelrep='$this->telef2', teltrarep='$this->telef3',corelerep='$this->correo',ususis='$this->ususis', fecreg='$this->fecreg', horreg='$this->horreg' where cedrep='$this->cedula'");
            flash::notice("Registro Modificado Correctamente");
        }else{
          load::model('representante')->find_all_by_sql("INSERT INTO representante(cedrep, nomrep, aperep, dirrep, telcasrep, teltrarep, telcelrep, 
            corelerep, cedreppri, ususis, fecreg, horreg) VALUES ('$this->cedula', UPPER('$this->nombres'), UPPER('$this->apellidos'), UPPER('$this->direccion'), '$this->telef1', '$this->telef2', '$this->telef3','$this->correo', '$this->cedula', '$this->ususis', '$this->fecreg', '$this->horreg')");
          flash::notice("Registro Insertado Correctamente");
        }
      }else{
        flash::error("Error: el campo ".$this->valida." es obligatorio");
      }
    }
    
    
  }
  
  public function buscar(){
      $this->cedula = input::request("cedula");
      $this->nombres = input::request("nombres"); 
      $this->apellidos = input::request("apellidos");
      $this->direccion = input::request("direccion");
      $this->telef1 = input::request("telef1");
      $this->telef2 = input::request("telef2");
      $this->telef3 = input::request("telef3");
      $this->correo = input::request("correo");
      $this->fecreg=date("Y-m-d");
      $this->horreg=date("H:i:s");
      $this->ususis=trim(strtoupper(Session::get('ceusualogin')));
  }

  public function encuentra($cedula="0"){
      if($rep=load::model('representante')->busca_uno($cedula)){
        $this->cedula = $rep->cedrep;
        $this->nombres = $rep->nomrep; 
        $this->apellidos = $rep->aperep;
        $this->direccion = $rep->dirrep;
        $this->telef1 = $rep->telcasrep;
        $this->telef2 = $rep->telcelrep;
        $this->telef3 = $rep->teltrarep;
        $this->correo = $rep->corelerep;
      }
  }

}

  ?>