<?php
class ReportesController extends AppController
	{
	//public $template = "plantilla";
	
		
		function idioma(){
		//Windows con apache
		setlocale(LC_TIME, 'Spanish');
		//Apache con linux
		//setlocale(LC_TIME, 'es_VE.UTF-8');	
		}
		
		public function mes($mes=0){
 			switch($mes){
				case 1: return "Enero";break;
				case 2: return "Febrero";break;
				case 3: return "Marzo";break;
				case 4: return "Abril";break;
				case 5: return "Mayo";break;
				case 6: return "Junio";break;
				case 7: return "Julio";break;
				case 8: return "Agosto";break;
				case 9: return "Septiembre";break;
				case 10: return "Octubre";break;
				case 11: return "Noviembre";break;
				case 12: return "Diciembre";break;
		}//fin function mes
		}


		function titulo($title){
			$this->pdf->Image('img/logocolegio.jpg',15,10,154,20);
			$this->pdf->Image('img/logocolegio1.jpg',80,10,70,23);
			$this->pdf->Image('img/logocolegio2.jpg',170,10,21,23);
			$this->pdf->Ln();
			$this->pdf->Ln();
			$this->pdf->SetFont('Arial', 'B', 16);
			$this->pdf->Cell(0,20,utf8_decode($title),0,1,'C');
		}
		
		function firma(){
			$this->pdf->SetFont('Arial', '', 12);
			$this->pdf->Ln();
			$this->pdf->Ln();		
			$this->pdf->JLCell(utf8_decode('     Certificación que se expide, en Santa Ana de Coro, a los '.date("d").' de '.$m=$this->mes(date("m")).' de '.date("Y").'.'),175,'j',8); 
			$this->pdf->Ln();
			$this->pdf->Ln();
			$this->pdf->Ln();
			$this->pdf->Cell(0, 4, 'FIRMA',0,1,'C');
			$this->pdf->Ln();
			$this->pdf->Ln();
			$this->pdf->Ln();
			$this->pdf->Ln();
			$this->pdf->Ln();
			$this->pdf->Cell(0, 4, '_____________________________________',0,1,'C');
			$this->pdf->Cell(0, 4, utf8_decode('DIRECTOR'),0,1,'C');
			$this->pdf->Ln();
			$this->pdf->Cell(0, 4, 'TELEF:_________________',0,1,'C');
			$this->pdf->Ln();
			$this->pdf->Cell(0, 4, 'C.I.N:_________________',0,1,'C');
			$this->pdf->Ln();
			$this->pdf->SetY(250);
			$this->pdf->Cell(0, 4, utf8_decode('U.E. Colegio Pequeño Mundo. Av. Rafael Gallardo. Telefono (0268)2516584'),0,1,'C');
		}
		
		public function tot_ing(){
		View::template(NULL);
		if(Input::hasPost("factura")){
			$this->fecini = Input::request("fecini");
			$this->fecfin = Input::request("fecfin");
				if(Conests::valid_todate($this->fecini)==1){
					flash::error("Fecha Invalidad");
				}elseif(Conests::valid_todate($this->fecfin)==1){
					flash::error("Fecha Invalidad");
				}else{
					Load::lib('jlpdf');
					 $this->pdf = new JLPDF();
					 $this->pdf->SetTopMargin(20);
	   				 $this->pdf->SetLeftMargin(15);
					 $this->pdf->SetRightMargin(15);
					 $this->pdf->AddPage('P','letter');
					 $this->pdf->SetXY(10,40);
					 $this->idioma();
					 
					 $this->titulo("TOTAL INGRESOS (".$this->fecini." - ".$this->fecfin.")");
					
						$this->fecini=date("Y-m-d",strtotime($this->fecini));
						$this->fecfin=date("Y-m-d",strtotime($this->fecfin));
					 	$sql=load::model('factura')->find_all_by_sql("select sum(efefac),sum(debfac),sum(depfac),sum(chefac) from factura where nrodeb<>'1' and fecfac>='$this->fecini' and fecfac<='$this->fecfin'");
						$sql1=load::model('ingegr')->find_all_by_sql("select sum(efeingegr),sum(debingegr),sum(depingegr),sum(cheingegr) from ingegr where fecingegr>='$this->fecini' and fecingegr<='$this->fecfin' and tipingegr='I'");
						$sql2=load::model('ingegr')->find_all_by_sql("select sum(efeingegr),sum(debingegr),sum(depingegr),sum(cheingegr) from ingegr where fecingegr>='$this->fecini' and fecingegr<='$this->fecfin' and tipingegr='E'");
							
					 	$tot=$db->fetch_array($sql);
						$totI=$db->fetch_array($sql1);
						$totE=$db->fetch_array($sql2);
						$this->pdf->SetX(60);
						$this->pdf->Cell(60, 10,'Efectivo Matricula ',1,0);
						$this->pdf->Cell(50, 10,$tot[0],1,1,'R');
						$this->pdf->SetX(60);
						$this->pdf->Cell(60, 10,'Efectivo Ingreso ',1,0);
						$this->pdf->Cell(50, 10,$totI[0],1,1,'R');
						$this->pdf->SetX(60);
						$this->pdf->Cell(60, 10,'Efectivo Egreso ',1,0);
						$this->pdf->Cell(50, 10,$totE[0],1,1,'R');
						$this->pdf->SetX(60);
						$this->pdf->Cell(60, 10,'Efectivo Total ',1,0);
						$this->pdf->Cell(50, 10,$tot[0]+$totI[0]-$totE[0],1,1,'R');
						$this->pdf->SetX(60);
						$this->pdf->Cell(60, 10,'Debito Matricula ',1,0);
						$this->pdf->Cell(50, 10,$tot[1],1,1,'R');
						$this->pdf->SetX(60);
						$this->pdf->Cell(60, 10,'Debito Ingreso ',1,0);
						$this->pdf->Cell(50, 10,$totI[1],1,1,'R');
						$this->pdf->SetX(60);
						$this->pdf->Cell(60, 10,'Debito Egreso ',1,0);
						$this->pdf->Cell(50, 10,$totE[1],1,1,'R');
						$this->pdf->SetX(60);
						$this->pdf->Cell(60, 10,'Debito Total ',1,0);
						$this->pdf->Cell(50, 10,$tot[1]+$totI[1]-$totE[1],1,1,'R');
						$this->pdf->SetX(60);
						$this->pdf->Cell(60, 10,'Deposito Matricula ',1,0);
						$this->pdf->Cell(50, 10,$tot[2],1,1,'R');
						$this->pdf->SetX(60);
						$this->pdf->Cell(60, 10,'Deposito Ingreso ',1,0);
						$this->pdf->Cell(50, 10,$totI[2],1,1,'R');
						$this->pdf->SetX(60);
						$this->pdf->Cell(60, 10,'Deposito Egreso ',1,0);
						$this->pdf->Cell(50, 10,$totE[2],1,1,'R');
						$this->pdf->SetX(60);
						$this->pdf->Cell(60, 10,'Deposito Total ',1,0);
						$this->pdf->Cell(50, 10,$tot[2]+$totI[2]-$totE[2],1,1,'R');
						$this->pdf->SetX(60);
						$this->pdf->Cell(60, 10,'Cheque Matricula ',1,0);
						$this->pdf->Cell(50, 10,$tot[3],1,1,'R');
						$this->pdf->SetX(60);
						$this->pdf->Cell(60, 10,'Cheque Ingreso ',1,0);
						$this->pdf->Cell(50, 10,$totI[3],1,1,'R');
						$this->pdf->SetX(60);
						$this->pdf->Cell(60, 10,'Cheque Egreso ',1,0);
						$this->pdf->Cell(50, 10,$totE[3],1,1,'R');
						$this->pdf->SetX(60);
						$this->pdf->Cell(60, 10,'Cheque Total ',1,0);
						$this->pdf->Cell(50, 10,$tot[3]+$totI[3]-$totE[3],1,1,'R');						
						$this->pdf->SetX(60);
						$this->pdf->Cell(60, 10,'Total: ',0,0);
						$this->pdf->Cell(50, 10,$tot[0]+$totI[0]-$totE[0]+$tot[1]+$totI[1]-$totE[1]+$tot[2]+$totI[2]-$totE[2]+$tot[3]+$totI[3]-$totE[3],0,1,'R');
						$this->pdf->Ln();
					 
					$this->fecini=date("d-m-Y",strtotime($this->fecini));
					$this->fecfin=date("d-m-Y",strtotime($this->fecfin));
					$file = "files/informe".$this->fecini."_".$this->fecfin.".pdf";
					$this->pdf->Output($file, null);
					if ($file != null) {
						echo "<script type='text/javascript'> " . "window.open('" . PUBLIC_PATH . "$file', false); </script>";
						Flash::success("<h4><font color='navy'>Reporte Generado...</font></h4>");
					 }
				}
				
			
		}
		
		}
		
		
		public function con_est($cedrep=0,$codalu=0,$codcon=0){
			View::template(NULL);
			$ins=Load::model('inscripcion')->busca_uno($cedrep,$codalu);
			//$xx=load::model('inscripcion')->find_first("$cedrep='$cedrep' and codalu='$codalu'");
			if($ins){
				 Load::lib('jlpdf');
				 $this->pdf = new JLPDF();
				 $this->pdf->SetTopMargin(20);
	   			 $this->pdf->SetLeftMargin(15);
				 $this->pdf->SetRightMargin(15);
				 if($codcon=='1'){
				 	$this->con_est_est($cedrep,$codalu);
				 }elseif($codcon=='2'){
					$this->con_ins_est($cedrep,$codalu);
				 }elseif($codcon=='3'){
					$this->con_ret_est($cedrep,$codalu);
				 }elseif($codcon=='4'){
					$this->con_bue_est($cedrep,$codalu);
				 }


				 $files = $codalu;
				 $file = "files/".$files.".pdf";
				 $this->pdf->Output($file, null);
				 if ($file != null) {
					echo "<script type='text/javascript'> " . "window.open('" . PUBLIC_PATH . "$file', false); </script>";
					Flash::success("<h4><font color='navy'>Reporte Generado...</font></h4>");
				 }
			}else{
				Flash::error("El estudiante no esta inscrito $codalu ");
			}
		
		}
		
		public function con_est_est($cedrep=0,$codalu=0){
		$this->idioma();
						$this->pdf->AddPage('P','letter');
						$this->pdf->SetXY(10,50);
						$this->titulo("CONSTANCIA DE ESTUDIO");
						$alu=Load::model('alumno')->busca_uno($cedrep,$codalu);
						$ins=Load::model('inscripcion')->busca_uno($cedrep,$codalu);
						$nombres = $alu->apealu.', '.$alu->nomalu;
						$edad=Conests::calcularedad($alu->fecnacalu);
						$niv=Load::model('nivel')->busca_nivel($ins->codniv);
						$cur=Load::model('curso')->busca_curso($ins->codcur);
						$per=Load::model('periodo')->busca_per($ins->codper);
						$this->pdf->SetFont('Arial', '', 12);
						$this->pdf->JLCell(utf8_decode('     Quién suscribe [b][u]PROF. MANUEL SALVADOR POLANCO ROBLES[/u][/b] portador de la Cédula de Identidad Nº [b][u]7.483.933[/u][/b] en mi condición de Director de la U.E. COLEGIO "PEQUEÑO MUNDO" inscrito en el Ministerio de Educación bajo el Nº. 142, certifico por medio de la presente que el (la) estudiante [b][u]'.$nombres.'[/u][/b], portador(a) de la Cédula de Identidad (ESCOLAR) [b][u]Nº '.$alu->cedest.'[/u][/b] nacido(a) en  [b][u]'.$alu->lugnac.'[/u][/b] en la fecha: [b][u]'.date("d/m/Y",strtotime($alu->fecnacalu)).'[/u][/b], cursa estudio en este plantel en el [b][u]'.$cur.'[/u][/b] del Nivel de Educación [b][u]'.$niv.'[/u][/b] durante el Año Escolar [b][u]'.$per.'[/u][/b]. Previo cumplimiento de los requisitos exigidos en la normativa legal vigente.'),175,'j',8); 
						$this->firma();
		
		}//fin con_est_Est
		
		public function con_ins_est($cedrep=0,$codalu=0){
		$this->idioma();
						$this->pdf->AddPage('P','letter');
						$this->pdf->SetXY(10,50);
						$this->titulo("CONSTANCIA DE INSCRIPCIÓN");
						$alu=Load::model('alumno')->busca_uno($cedrep,$codalu);
						$ins=Load::model('inscripcion')->busca_uno($cedrep,$codalu);
						$nombres = $alu->apealu.', '.$alu->nomalu;
						$edad=Conests::calcularedad($alu->fecnacalu);
						$niv=Load::model('nivel')->busca_nivel($ins->codniv);
						$cur=Load::model('curso')->busca_curso($ins->codcur);
						$per=Load::model('periodo')->busca_per($ins->codper);
						$this->pdf->SetFont('Arial', '', 12);
						$this->pdf->JLCell(utf8_decode('     Quién suscribe [b][u]PROF. MANUEL SALVADOR POLANCO ROBLES[/u][/b] portador de la Cédula de Identidad Nº [b][u]7.483.933[/u][/b] en mi condición de Director de la U.E. Colegio "Pequeño Mundo" inscrito en el Ministerio de Educación bajo el Nº. 142, certifico por medio de la presente que el (la) estudiante, [b][u]'.$nombres.'[/u][/b], portador(a) de la Cédula de Identidad (ESCOLAR) [b][u]Nº '.$alu->cedest.'[/u][/b] nacido(a) en  [b][u]'.$alu->lugnac.'[/u][/b] en la fecha: [b][u]'.date("d/m/Y",strtotime($alu->fecnacalu)).'[/u][/b], esta inscrito en este plantel en el [b][u]'.$cur.'[/u][/b] del Nivel de Educación [b][u]'.$niv.'[/u][/b] durante el Año Escolar [b][u]'.$per.'[/u][/b]. Previo cumplimiento de los requisitos exigidos en la normativa legal vigente. Por su representante___________________________ C.I.Nro._______________'),175,'j',8); 
						$this->firma();
		
		}//fin con_ins_Est

		public function con_ret_est($cedrep=0,$codalu=0){
		$this->idioma();
						$this->pdf->AddPage('P','letter');
						$this->pdf->SetXY(10,50);
						$this->titulo("CONSTANCIA DE RETIRO");
						$alu=Load::model('alumno')->busca_uno($cedrep,$codalu);
						$ins=Load::model('inscripcion')->busca_uno($cedrep,$codalu);
						$nombres = $alu->apealu.', '.$alu->nomalu;
						$edad=Conests::calcularedad($alu->fecnacalu);
						$niv=Load::model('nivel')->busca_nivel($ins->codniv);
						$cur=Load::model('curso')->busca_curso($ins->codcur);
						$per=Load::model('periodo')->busca_per($ins->codper);
						$this->pdf->SetFont('Arial', '', 12);
						$this->pdf->JLCell(utf8_decode('     Quién suscribe [b][u]PROF. MANUEL SALVADOR POLANCO ROBLES[/u][/b] portador de la Cédula de Identidad Nº [b][u]7.483.933[/u][/b] en mi condición de Director de la U.E. Colegio "Pequeño Mundo" inscrito en el Ministerio de Educación bajo el Nº. 142 y con Nº de Rif. J-31374267-8, hace constar por medio de la presente que el/la alumno(a) [b][u]'.$nombres.'[/u][/b] nacido el [b][u]'.date("d/m/Y",strtotime($alu->fecnacalu)).'[/u][/b] de [b][u]'.$edad.' AÑOS[/u][/b] de edad, cursa estudios en este plantel  [b][u]'.$cur.' DE EDUCACIÓN '.$niv.'[/u][/b] durante el año escolar [b][u]'.$per.'[/u][/b], y será retirado de nuestra base de datos SINACOES cuyo [b][u]Nº es '.$codalu.'[/u][/b]'),175,'j',8); 
						$this->firma();
		
		}//fin con_ret_Est
		
		public function con_bue_est($cedrep=0,$codalu=0){
		$this->idioma();
						$this->pdf->AddPage('P','letter');
						$this->pdf->SetXY(10,50);
						$this->titulo("CONSTANCIA DE BUENA CONDUCTA");
						$alu=Load::model('alumno')->busca_uno($cedrep,$codalu);
						$ins=Load::model('inscripcion')->busca_uno($cedrep,$codalu);
						$nombres = $alu->apealu.', '.$alu->nomalu;
						$edad=Conests::calcularedad($alu->fecnacalu);
						$niv=Load::model('nivel')->busca_nivel($ins->codniv);
						$cur=Load::model('curso')->busca_curso($ins->codcur);
						$per=Load::model('periodo')->busca_per($ins->codper);
						$this->pdf->SetFont('Arial', '', 12);
						$this->pdf->JLCell(utf8_decode('     Quién suscribe [b][u]PROF. MANUEL SALVADOR POLANCO ROBLES[/u][/b] Titular de la Cédula de Identidad Nº [b][u]16.103.140[/u][/b] Directora(E) de la U.E. Colegio "Pequeño Mundo" inscrito en el Ministerio de Educación bajo el Nº. 142 y con Nº de Rif. J-31374267-8, hace constar por medio de la presente que el/la alumno(a) [b][u]'.$nombres.',[/u][/b] cuya Fecha de Nacimiento es [b][u]'.date("d/m/Y",strtotime($alu->fecnacalu)).'[/u][/b] a demostrado [b]Buena Coducta[/b] en el Plantel durante el año escolar [b]'.$per.'[/b].'),175,'j',8); 
						$this->firma();
		
		}//fin con_bue_Est
		
		
		public function actualizacion(){
			View::template(NULL);
		}
		
		public function alumnosporseccion($codniv="0",$codcur="0",$codsec="0",$codper="0"){
			View::template(NULL);
			$this->codniv=$codniv;
			$this->codcur=$codcur;
			$this->codsec=$codsec;
			$this->codper=$codper;
			if(Input::hasPost("concepto")){
			 	$observ="";
				$per="";
				$this->codniv = Input::request("codniv");
				$this->codcur = Input::request("codcur");
				$this->codsec = Input::request("codsec");
				$this->codper = Input::request("codper");
				if($this->codniv!="0"){
					$observ.="codniv='$this->codniv'";
				}
				if($this->codcur!="0"){
					$observ.=" and codcur='$this->codcur'";
				}
				if($this->codsec!="0"){
					$observ.=" and codsec='$this->codsec'";
				}
				if($this->codper!="0"){
					$per=" where codper='$this->codper'";
				}
				if($observ==""){
					$alumno=Load::model('inscripcion')->find_all_by_sql("select distinct codniv,codcur,codsec from inscripcion where codper in(select codper from periodo $per) order by codniv,codcur,codsec");
				}else{
					$alumno=Load::model('inscripcion')->find_all_by_sql("select distinct codniv,codcur,codsec from inscripcion where $observ and codper in(select codper from periodo $per)  order by codniv,codcur,codsec");
				}
					 Load::lib('jlpdf');
					 $this->pdf = new JLPDF();
					 $this->pdf->SetTopMargin(20);
	   				 $this->pdf->SetLeftMargin(15);
					 $this->pdf->SetRightMargin(15);
					 	$this->idioma();
						foreach($alumno as $a){ 
						$this->pdf->AddPage('P','letter');
						$this->pdf->SetXY(10,50);
						$this->titulo("ALUMNOS INSCRITOS");
						$this->pdf->SetFont('Arial', '', 12);
						Load::model('nivel')->find_first("codniv='$a->codniv'");
						$this->pdf->Cell(45, 6, utf8_decode('NIVEL: ').$a->codniv."-".Load::model('nivel')->desniv,0,0,'C');
						$this->pdf->Cell(45, 6, utf8_decode('CURSO: ').$a->codcur,0,0,'C');
						$this->pdf->Cell(45, 6, utf8_decode('SECCIÓN: ').$a->codsec,0,0,'C');
						$this->pdf->Cell(45, 6, utf8_decode('PERIODO: ').$this->codper,0,1,'C');
						$this->pdf->Ln();
						$this->pdf->Ln();
						$this->pdf->Cell(10, 6, utf8_decode('Nº'),1,0,'C');
						$this->pdf->Cell(120, 6, utf8_decode('APELLIDOS Y NOMBRES'),1,0,'L');
						$this->pdf->Cell(50, 6, utf8_decode('OBSERVACIÓN'),1,1,'L');
						//$this->pdf->Cell(30, 6, utf8_decode('DESCUENTO'),1,1,'C');
						
						$inscritos=Load::model('inscripcion')->find_all_by_sql("select * from alumno where cedrep||codalu in(select cedrep||codalu from inscripcion where codcur='$a->codcur' and codniv='$a->codniv' and codsec='$a->codsec' and codper in(select codper from periodo $per)) order by apealu,nomalu");
						
						$x=1;
						foreach($inscritos as $i){
							$this->pdf->Cell(10, 6, $x,1,0,'R');
							$this->pdf->Cell(120, 6, utf8_decode($i->apealu.', '.$i->nomalu),1,0,'L');
							$this->pdf->Cell(50, 6,'',1,1,'L');
							//$this->pdf->Cell(30, 6, utf8_decode($i->desfac),1,1,'C');
							$x++;
						}
						
						}

				 	$files = "Nominas_de_Alumnos".$codniv.$codcur.$codsec;
				 	$file = "files/".$files.".pdf";
				 	$this->pdf->Output($file, null);
				 	if ($file != null) {
						echo "<script type='text/javascript'> " . "window.open('" . PUBLIC_PATH . "$file', false); </script>";
						Flash::success("<h4><font color='navy'>Reporte Generado...</font></h4>");
					 }
				
			
			}
			
		}
		
		public function constancias($cedrep="0",$codigo="0"){
		View::template(NULL);
		$this->cedrep=$cedrep;
		$this->codigo=$codigo;
		}
		
		public function representantescondescuentos(){
			View::template(NULL);
			$alumno=Load::model('inscripcion')->find_all_by_sql("select distinct cedrep,count(cedrep) from inscripcion where codper in(select codper from periodo) group by cedrep having count(cedrep)>1");
					 $this->pdf = new JLPDF();
					 $this->pdf->SetTopMargin(20);
	   				 $this->pdf->SetLeftMargin(15);
					 $this->pdf->SetRightMargin(15);
					 	$this->idioma();
						 
						$this->pdf->AddPage('P','letter');
						$this->pdf->SetXY(10,50);
						$this->titulo("REPRESENTANTES CON VARIOS HIJOS INSCRITOS");
						$this->pdf->SetFont('Arial', '', 12);
						$x=1;
						foreach($alumno as $a){
						$r=Load::model('representante')->find_first("cedrep='$a->cedrep'");
						$this->pdf->Cell(60, 6, utf8_decode($x.'-'.$r->aperep.', '.$r->nomrep.' '.$r->cedrep),0,1,'C');
						$this->pdf->Ln();
						$inscritos=Load::model('inscripcion')->find_all_by_sql("select * from alumno where cedrep||codalu in(select cedrep||codalu from inscripcion where cedrep='$a->cedrep' and codper in(select codper from periodo)) order by apealu,nomalu");
						
							foreach($inscritos as $i){
								$this->pdf->Cell(20, 6, '*',0,0,'R');
								$this->pdf->Cell(90, 6, utf8_decode($i->apealu.', '.$i->nomalu),0,0,'L');
								$this->pdf->Cell(40, 6, utf8_decode($i->codalu),0,0,'L');
								$this->pdf->Cell(30, 6, utf8_decode($i->desfac),0,1,'C');
							
							}
						$x++;
						$this->pdf->Ln();
						}

				 	$files = "Representantes_con_descuentos";
				 	$file = "files/".$files.".pdf";
				 	$this->pdf->Output($file, null);
				 	if ($file != null) {
						echo "<script type='text/javascript'> " . "window.open('" . PUBLIC_PATH . "$file', false); </script>";
						Flash::success("<h4><font color='navy'>Reporte Generado...</font></h4>");
					 }
		}
		
		public function listaderepresentantes(){
			View::template(NULL);
			$alumno=Load::model('inscripcion')->find_all_by_sql("select * from representante where cedrep in(select distinct cedrep from inscripcion where codper in(select codper from periodo)) order by aperep,nomrep");
					 $this->pdf = new JLPDF();
					 $this->pdf->SetTopMargin(20);
	   				 $this->pdf->SetLeftMargin(15);
					 $this->pdf->SetRightMargin(15);
					 	$this->idioma();
						 
						$this->pdf->AddPage('P','letter');
						$this->pdf->SetXY(10,50);
						$this->titulo("LISTADO DE REPRESENTANTES");
						$this->pdf->SetFont('Arial', '', 12);
						$x=1;
						$this->pdf->Cell(20, 6, utf8_decode('Nº'),1,0,'C');
						$this->pdf->Cell(60, 6, 'APELLIDOS',1,0,'L');
						$this->pdf->Cell(60, 6, 'NOMBRES',1,0,'L');
						$this->pdf->Cell(40, 6, 'CEDULA',1,1,'C');
						
						foreach($alumno as $a){
							$this->pdf->Cell(20, 6, utf8_decode($x),1,0,'C');
							$this->pdf->Cell(60, 6, utf8_decode($a->aperep),1,0,'L');
							$this->pdf->Cell(60, 6, utf8_decode($a->nomrep),1,0,'L');
							$this->pdf->Cell(40, 6, utf8_decode($a->cedrep),1,1,'C');
							$x++;
							
						}

				 	$files = "Lista_de_Representantes";
				 	$file = "files/".$files.".pdf";
				 	$this->pdf->Output($file, null);
				 	if ($file != null) {
						echo "<script type='text/javascript'> " . "window.open('" . PUBLIC_PATH . "$file', false); </script>";
						Flash::success("<h4><font color='navy'>Reporte Generado...</font></h4>");
					 }
		}
		
		public function ingresos($numano="0"){
		View::template(NULL);
		$this->numano=$numano;

		}
		
}