<?php
class Horario extends ActiveRecord
	{
        public function initialize ()
        {$this->primary_key=array('codcar', 'tiphor', 'codsed','numano','numper','codmat','codsec');}

        
        public function dias($codcar,$codsed,$tiphor,$numano,$numper,$codmat,$codsec){
            return $this->find_all_by_sql("select distinct coddia from horario where codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor' and numano='$numano' and numper='$numper' and codmat='$codmat' and codsec='$codsec' order by coddia");
        }


         public function horas($codcar,$codsed,$tiphor,$numano,$numper,$codmat,$codsec,$coddia){
         	
            return $this->find_all_by_sql("select codhor,codaul from horario where codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor' and numano='$numano' and numper='$numper' and codmat='$codmat' and codsec='$codsec' and coddia='$coddia' order by coddia");
        }

        public function verifica($codcar,$codsed,$tiphor,$numano,$numper,$codmat,$codsec){
            return $this->find_first("codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor' and numano='$numano' and numper='$numper' and codmat='$codmat' and codsec='$codsec'");
        }

      	public function choque($numcar,$codcar, $codsed, $tiphor,$codmat,$codsec, $numano, $numper){
			$sql = "select distinct a.codmat,c.nommat,b.codsec from horario a,ceinse b,cemmat c  where a.codcar=c.codcar 
								and a.codmat=c.codmat and a.codcar=b.codcar and a.codsed=b.codsed 
								and a.tiphor=b.tiphor and a.numano=b.numano and a.numper=b.numper and a.codmat=b.codmat
								and a.codsec=b.codsec 
								and b.numcar='$numcar' and b.codcar='$codcar' and b.codsed='$codsed' 
							  	and b.tiphor='$tiphor' and b.numper='$numper' and b.numano='$numano' 
							  	and b.codmat!='$codmat' and a.coddia||a.codhor in(select coddia||codhor
							  	from horario where numcar='$numcar' and codcar='$codcar' and codsed='$codsed' 
							  	and tiphor='$tiphor' and numper='$numper' and numano='$numano' 
							  	and codmat='$codmat' and codsec='$codsec')";
			return $this->find_all_by_sql($sql); 
		}

		
	}
?>
