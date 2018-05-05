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
/prueba/
/prueba2/
class AlumnoController extends AppController{

    protected function before_filter(){
      if(Load::model('usuarios')->logged()==true){
         $this->cedusu = Session::get('cedusu');
      }else{
        return Redirect::route_to("controller: index", "action: logout");
      }
    }
  
    public function index($cedrep=0,$codalu=0){
      View::template(NULL);
      $this->cedrep=$cedrep;
      $this->codalu=$codalu;
      $this->bus_alu($cedrep,$codalu);
      $this->bus_ins($cedrep,$codalu);
    }

    public function dat_ins($codniv='0',$codtar='0',$codcur='0',$codsec='0'){
        View::template(NULL);
        $this->codniv=$codniv;
        $this->codtar=$codtar;
        $this->codcur=$codcur;
        $this->codsec=$codsec;
    }

    public function bus_alu($cedrep=0,$codalu=0){
      $alu=load::model('alumno')->encuentra($cedrep,$codalu); 
      if($alu){
            $this->cedest=$alu->cedest;
            $this->codalu=$alu->codalu;
            $this->apealu=$alu->apealu;
            $this->nomalu=$alu->nomalu;
            $this->fecnacalu=date("d-m-Y",strtotime($alu->fecnacalu));
            $this->codsexalu=$alu->codsexalu;
            $this->status=$alu->status;
      }else{
        $this->clear_r();
      }
    }  

    public function clear_r(){
      $this->cedest=input::request('cedest');
      $this->codalu=input::request('codalu');
      $this->apealu=input::request('apealu');
      $this->nomalu=input::request('nomalu');
      $this->fecnacalu=input::request('fecnacalu');
      $this->codsexalu=input::request('codsexalu');
      $this->status=input::request('status');
    }

    public function bus_ins($cedrep=0,$codalu=0){
      $ins=load::model('inscripcion')->encuentra($cedrep,$codalu); 
      if($ins){
            $this->codniv=$ins->codniv;
            $this->codtar=$ins->codtar;
            $this->codcur=$ins->codcur;
            $this->codsec=$ins->codsec;
            $this->codper=$ins->codper;
            $this->desfac=$ins->desfac;
      }else{
        $this->clear_a();
      }
    }
    public function clear_a(){
      $this->codniv=input::request('codniv');
      $this->codtar=input::request('codtar');
      $this->codcur=input::request('codcur');
      $this->codsec=input::request('codsec');
      $this->codper=input::request('codper');
      $this->desfac=input::request('desfac');
    }

    public function sal_alu(){
      View::template(NULL);
      if(Input::hasPost("alumno")){
      $this->clear_r();
      $this->vist=0;
      $this->cedrep=input::request('cedrep');
      $this->fecreg=date("Y-m-d");
      $this->horreg=date("H:i:s");
      $this->ususis=trim(strtoupper(Session::get('ceusualogin')));
        
        $fields="Cedula Estudiantil=>{$this->cedest},Nombres=>{$this->nomalu},Apellidos=>{$this->apealu},sexo=>{$this->codsexalu},fecha de Nacimiento=>{$this->fecnacalu}";
        $valida = Conests::validate($fields);
          if($valida!="0"){
            flash::error("Error: el campo {$valida} es obligatorio");
          }else{
             $ano=Conests::valid_todate($this->fecnacalu);
             if($ano==1){
                flash::error("Fecha Invalidad");
            }else{
                 $alu=load::model('alumno')->encuentra($this->cedrep,$this->codalu); 
                if($alu){
                   load::model('alumno')->find_all_by_sql("update Alumno set nomalu=upper('$this->nomalu'),apealu=upper('$this->apealu'),fecnacalu='$this->fecnacalu',codsexalu='$this->codsexalu',status='$this->status',cedest='$this->cedest' where cedrep='$this->cedrep' and codalu='$this->codalu'");
                   $this->vist=1;
                   //flash::warning("Registro Modificado Correctamente");
                }else{
                    $this->codalu = load::model('alumno')->count("cedrep='$this->cedrep'").$this->cedrep.$ano;
                    load::model('alumno')->find_all_by_sql("INSERT INTO alumno(cedrep, codalu,nomalu, apealu, fecnacalu, codsexalu, ususis, fecreg, horreg, status, cedest) VALUES ('$this->cedrep','$this->codalu', upper('$this->nomalu'), upper('$this->apealu'), '$this->fecnacalu', '$this->codsexalu', '$this->ususis', '$this->fecreg', '$this->horreg', '$this->status', '$this->cedest');");
                    $this->vist=1;
                }
            }
          }

      }
    }

    public function ir_a($cedrep=0){
      View::template(NULL);
      $this->cedrep=$cedrep;
    }

    public function sal_ins(){
      View::template(NULL);
      if(Input::hasPost("alumno")){
      $this->clear_a();
      $this->cedrep=input::request('cedrep');
      $this->codalu=input::request('codalu');
      $this->fecreg=date("Y-m-d");
      $this->horreg=date("H:i:s");
      $this->ususis=trim(strtoupper(Session::get('ceusualogin')));
        
        $fields="Nivel=>{$this->codniv},Tarifa=>{$this->codtar},Curso=>{$this->codcur},Sección=>{$this->codsec}";
        $valida = Conests::validate($fields);
          if($valida!="0"){
            flash::error("Error: el campo {$valida} es obligatorio");
          }else{
              if($this->desfac=="" or $this->desfac< 0 or $this->desfac>100){
                flash::error("Error: El descuento debe ser mayor o igual que 0 y menor o igual que 100"); 
              }else{ 

                if(!load::model('seccion')->find_first("codniv='$this->codniv' and codcur='$this->codcur' and codsec='$this->codsec' and codper='$this->codper'")){
                  flash::error("Error: no existe la Sección en el periodo activo");
                }else{
                  if(load::model('detalle')->find_first("cedrep='$this->cedrep' and codalu='$this->codalu' and (codtar!='$this->codtar' or desfac!='$this->desfac') and stafac='F'")){        
                    flash::error("Error no se puede modificar porque existen detalle(s) de factura");
                  
                  }else{
                      $ins=load::model('inscripcion')->encuentra($this->cedrep,$this->codalu); 
                      if($ins){
                          load::model('inscripcion')->find_all_by_sql("update Inscripcion set codsec='$this->codsec',codcur='$this->codcur',codniv='$this->codniv',codtar='$this->codtar',desfac='$this->desfac',codper='$this->codper' where cedrep='$this->cedrep' and codalu='$this->codalu'");
                          flash::warning("Registro Modificado Correctamente");
                      }else{
                          load::model('inscripcion')->find_all_by_sql("INSERT INTO inscripcion(codsec, codcur, codalu, cedrep, codniv, codtar, ususis, fecreg, horreg, codper,desfac) VALUES ('$this->codsec', '$this->codcur', '$this->codalu', '$this->cedrep', '$this->codniv', '$this->codtar', '$this->ususis', '$this->fecreg', '$this->horreg','$this->codper','$this->desfac')");
                          flash::warning("Registro Insertado Correctamente");
                      }
                  }
                }  
              }
          }
          

      }
    }


}

  ?>