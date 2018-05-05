<?php
class Conest{

	static function sexo($codsex='M'){
		return $sexo=($codsex=='M')?'Masculino':'Femenino';
	}
	
	static function estadocivil($estciv='S'){
		switch($estciv){
				case 'S': return "Soltero(a)";break;
				case 'C': return "Casado(a)";break;
				case 'V': return "Viudo(a)";break;
				case 'D': return "Divorciado(a)";break;
				default: return "Por Definir"; break;
		}
	}

	static function obtiene($n){
		$q=explode(',',$n);
		$y = array();
		$s= Session::get('su');
		for($i=0;$i<count($q);$i++){
			$y[$i]=$s[$q[$i]];
		}
		return $y;
	}

}

?>