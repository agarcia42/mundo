<?php
class Detalle extends ActiveRecord
	{
	public function initialize ()
    {
        $this->primary_key=array('numfact', 'codalu', 'codcon', 'codper');
    }
	
	public function ultima_factura($id=0){
			if($this->find_first("cedrep='$id' and stafac='F'")){
				return $this->numfact;
			}else{
				if($this->find_first("order: numfact desc")){
					return ($this->numfact+1);
				}else{
					return 1;
				}
			}
		}
}
?>
  
