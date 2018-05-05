<?php
class Conesth{
		

//***********************exportado de cde***************************************
	
public static function dbselect($id,$fields,$table,$conditions,$value,$class,$action='index/index',$update='page-wrapper',$name=NULL,$si='l',$order='asc',$array='',$inactivo=NULL){
		$name=($name==NULL) ? $id : $name;
		$code = "<select name=\"".$name."\"".$inactivo." class=\"js-remote ".$class."\" data-to=\"".$update."\" action=\"".$action."\" $array >";
		$code .="<option value=\"\">SELECCIONE UNA...</option>";
		$Cetable = Load::model($table); 
		if($si!='0'){
			$sql=$Cetable->find_all_by_sql("select distinct $id,$fields from $table  $conditions order by $id $order");
			foreach($sql as $tab):
				$campod = ($id!=$fields) ? $tab->$fields : "";
				$select = ($value==$tab->$id) ? " selected=\"selected\"" : "";
				$code .= "<option value=\"".$tab->$id."\" ".$select.">".$tab->$id."  ".$campod." </option>";
			endforeach;
		}
		$code .= "</select>";
		return $code; 
}

public static function estadoSelect($id, $value=null, $disable=0)
    {
    $code = "<select name=\"$id\" id=\"$id\" class='form-control'>";
    if(($value == "0") or ($value == ""))
      {$code .= "<option value=\"0\">Seleccione...</option>";
       $code .= "<option value=\"A\">ACTIVO</option>";
       $code .= "<option value=\"I\">INACTIVO</option>";}
    elseif($value=="A")
      {$code .= "<option value=\"A\">ACTIVO</option>";
       $code .= "<option value=\"I\">INACTIVO</option>";}
    elseif($value=="I")
      {$code .= "<option value=\"I\">INACTIVO</option>";
       $code .= "<option value=\"A\">ACTIVO</option>";}
    $code .= "</select>";
    echo $code; 
    } 

public static function sinoSelect($id, $value=null)
    {
   $code = "<select name=\"$id\" id=\"$id\" class='form-control'>";
    if(($value == "0") or ($value == ""))
      {$code .= "<option value=\"0\">Seleccione...</option>";
       $code .= "<option value=\"S\">Si</option>";
       $code .= "<option value=\"N\">No</option>";}
    elseif($value=="S")
      {$code .= "<option value=\"S\">Si</option>";
       $code .= "<option value=\"N\">No</option>";}
    elseif($value=="N")
      {$code .= "<option value=\"N\">No</option>";
       $code .= "<option value=\"S\">Si</option>";}
    $code .= "</select>";
    echo $code; 
    }


public static function ruta($ruta){
		$g = explode('/',$ruta);
		$x = count($g);
		$code="<section class='content-header'>";
     	$code.="<h1>".$g[$x-1]." <small> </small></h1>";
     	$code.="<ol class='breadcrumb'>";
		for($i=0;$i<count($g);$i++){
     		$code.="<li>".$g[$i]."</li>";
		}
	 	$code.="</ol>";
     	$code.="</section></br>";
	 return $code;
	}
	
public static function estado($id, $value=null)
    {
    $code = "<select name=\"$id\" id=\"$id\"  class='form-control'>";
    if(($value == "0") or ($value == ""))
      {$code .= "<option value=\"0\">Seleccione...</option>";
       $code .= "<option value=\"A\">ACTIVO</option>";
       $code .= "<option value=\"I\">INACTIVO</option>";}
    elseif($value=="A")
      {$code .= "<option value=\"A\">ACTIVO</option>";
       $code .= "<option value=\"I\">INACTIVO</option>";}
    elseif($value=="I")
      {$code .= "<option value=\"I\">INACTIVO</option>";
       $code .= "<option value=\"A\">ACTIVO</option>";}
    $code .= "</select>";
    echo $code; 
    } 

public static function sexo($id, $value=null)
    {
    $code = "<select name=\"$id\" id=\"$id\" class='form-control'>";
    if(($value == "0") or ($value == ""))
      {$code .= "<option value=\"0\">Seleccione...</option>";
       $code .= "<option value=\"M\">MASCULINO</option>";
       $code .= "<option value=\"F\">FEMENINO</option>";}
    elseif($value=="M")
      {$code .= "<option value=\"M\">MASCULINO</option>";
       $code .= "<option value=\"F\">FEMENINO</option>";}
    elseif($value=="F")
      {$code .= "<option value=\"F\">FEMENINO</option>";
       $code .= "<option value=\"M\">MASCULINO</option>";}
    $code .= "</select>";
    echo $code; 
    }

public static function sexoSelect($id, $value=null){
		$cepsex=Load::model('cepsex');
		$options = "<option value=\"\">SELECCIONE</option>";
        foreach ($cepsex->find() as $c) {
            $options .= "<option value=\"$c->codsex\"";
            if ($c->codsex==$value) {
                    $options .= " selected=\"selected\"";
            } 
            $options .= ">$c->dessex</option>";
        }
        return "<select id=\"$id\" name=\"$id\" class=\"form-control\" required >$options</select>";
		}


	public static function estcivSelect($id, $value=null)
		{
		$cepciv=Load::model('cepciv');
		$options = "<option value=\"\">SELECCIONE</option>";
        foreach ($cepciv->find() as $c) {
            $options .= "<option value=\"$c->estciv\"";
            if ($c->estciv==$value) {
                    $options .= " selected=\"selected\"";
            } 
            $options .= ">$c->desciv</option>";
        }
        return "<select id=\"$id\" name=\"$id\" class=\"form-control\" required>$options</select>";
		}

	public static function tipoActo($id, $value=null)
		{
		$cepact=Load::model('cepact');
		$options = "<option value=\"\">SELECCIONE</option>";
        foreach ($cepact->find() as $c) {
            $options .= "<option value=\"$c->codact\"";
            if ($c->codact==$value) {
                    $options .= " selected=\"selected\"";
            } 
            $options .= ">$c->desact</option>";
        }
        return "<select id=\"$id\" name=\"$id\" class=\"form-control\"  onchange=\"getfecgra(this)\" required>$options</select>";
		}


	public static function horario($codcar,$codsed,$tiphor,$numano,$numper,$codmat,$codsec){
		$code="<table class='table table-bordered table-condensed'><tr>
        		<td>DÍA</td>
        		<td>HORARIO</td>
        	   </tr>";
        $dia='0';
        foreach(Load::model('horario')->dias($codcar,$codsed,$tiphor,$numano,$numper,$codmat,$codsec) as $d) { 
          	if($dia!=$d->coddia){ 
          	$code.="<tr>";
            $code.="<td>".$d->coddia."</td>";
            $code.="<td>";
                  $x=0; $hora=0; 
                   foreach(Load::model('horario')->horas($codcar, $codsed, $tiphor, $numano, $numper,$codmat,$codsec,$d->coddia) as $h) { 
                          
                          if($x!=$h->codhor) { 
                             $x=$h->codhor; 
                             if($hora!=0){ 
                                $code.="<div class='col-xs-2 col-md-2'>".load::model('cehora')->hora($codcar,$codsed,$tiphor,$hora,'horfin')."</div>";
                                $code.="<div class='col-xs-2 col-md-2'>".$h->codaul."</div>";
                                $code.="<div class='col-xs-2 col-md-2'>(".$h->codhor.")</div>";
                                $code.="</div>"; 
                             }
                            $code.="<div class='row'><div class='col-xs-2 col-md-2'>".load::model('cehora')->hora($codcar,$codsed,$tiphor,$h->codhor)."</div>";
                            $code.="<div class='col-xs-2 col-md-2'> - </div>"; 
                            $hora=$h->codhor; 
                          }else{ 
                            $hora=$h->codhor; 
                          } 
                          
                          $x++;
                          
                   } 
                  if($hora!=0){ 
                                $code.="<div class='col-xs-2 col-md-2'>".load::model('cehora')->hora($codcar,$codsed,$tiphor,$hora,'horfin')."</div>";
                                $code.="<div class='col-xs-2 col-md-2'>".$h->codaul."</div>";
                                $code.="<div class='col-xs-2 col-md-2'>(".$h->codhor.")</div>";
                                $code.="</div>"; 
                  }
            $code.="</td>";
            $code.="</tr>";
           $dia=$d->coddia;
           }               
        } 
         $code.="</table>";                                   
         return $code;
     	
	}


	public static function uc_cursar($numcar,$codcar,$codsed,$tiphor,$numano,$numper,$codmat,$codsec=0,$name='field',$condicion="",$requiere=""){
	  		$mat=Load::model('cemmat')->busca_uno($codcar,$codmat); 
	  		$codmat1=0;$codsec1=0;
            //$code="<div class='row' id=\"$codmat\">";
            	$code="<div class='col-xs-12 col-md-8'>".$mat->codmat."-".$mat->nommat."</div>";
           		$code.="<div class='col-xs-6 col-md-2' align='center'>".$mat->numcre."</div>";
            	$code.="<div class='col-xs-6 col-md-2' align='center'>";
            	$cetela=Load::model('cetela')->find_first("conditions: codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor' and codequ='$codmat'");
            	if($cetela){
                	$requiere="required=''";
                	$ceinse = Load::model('ceinse')->find_first("numcar='$numcar' and codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor' and numano='$numano' and numper='$numper' and codmat='$cetela->codmat'");
                	$codsec1 = ($ceinse) ? $ceinse->codsec : $codsec;
                	$codmat1 = ($cetela) ? $cetela->codmat : $codmat;
                }
            	if(Load::model('cesela')->find_first("conditions: codmat='$codmat1' and codsec='$codsec1'") ){ 
                    $condicion=" and codmat||codsec in(select codlab||seclab from cesela where codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor' and numano='$numano' and numper='$numper' and codmat='$codmat1' and codsec='$codsec1')"; 
                }
                
                $code.=self::dbselect("codsec","dessec","ceseca","where codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor' and numano='$numano' and numper='$numper' and codmat='$codmat' and cupdis>0 $condicion",$codsec,"form-control","procesos/labteo/".$codmat."/".$name,$codmat,$name,NULL,NULL,$requiere); 
                $code.="</div>";
            //$code.="</div>";
        return $code;
	}


}