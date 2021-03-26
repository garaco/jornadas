<?php
require_once 'app/Lib/tcpdf/tcpdf.php';
use App\Models\EmpleadosModel;
use App\Models\HorariosModel;
use App\Models\DescansosModel;
use App\Models\JornadasModel;

class VisualizaController extends TCPDF {

	public function Header() {
    $html='
			<table width="100%">
			<tr>
				<td>
				 <p style="color:white" >.<p>
				</td>
			</tr>
			<tr>
			<td width="100%">
			<p style="color:white" >.<p>
			</td>
		</tr>
			</table>
		';


		$this->SetFont('helvetica', 'B', 10);

		$this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = 0, $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);

	}

}

		if($_POST['type']=='horarios'){
			$pdf = new VisualizaController('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		}elseif($_POST['type']=='horas_extras'){
				$pdf = new VisualizaController('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		}else{
			error_reporting(0);
			$pdf = new VisualizaController(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		}

  // set document information
  $pdf->SetCreator(PDF_CREATOR);
  $pdf->SetTitle('Reportes');

  // set header and footer fonts
  $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
  $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

  // set default monospaced font
  $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

  // set margins
  $pdf->SetMargins(7, 0, 7);
  $pdf->setPrintHeader(true);
  // $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
  // $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

  // // set auto page breaks
  $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

  // set image scale factor
  $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
  // remove default

  // set some language-dependent strings (optional)
  if (@file_exists(dirname(__FILE__).'/lang/spa.php')) {
  	require_once(dirname(__FILE__).'/lang/spa.php');
  	$pdf->setLanguageArray($l);
  }

  // ---------------------------------------------------------
  // comienza el cuerpo de los reportes
  // set font
  $pdf->SetFont('Helvetica', '', 8);

  // add a page
  $pdf->AddPage();
  $posicionY=0;


		if($_POST['type']=='horarios'){

			$titulo="Horarios";

			$html ='<br><br><br><br><br><br><br>';
			$empleado = new EmpleadosModel();
			$empleado = $empleado->getAllEmpleados();
			$cont=1;

			foreach ($empleado as $g) {
				$horas = new HorariosModel();
				$horas = $horas->getByEmpleado($g->id);
				$hours='';$aux='';
				$l='n/a';$m='n/a';$mi='n/a';$j='n/a';$v='n/a';$s='n/a';$d='n/a';$f='n/a';$de='n/a';

				foreach ($horas as $i) {
					if('Lunes'==$i->dia){
						$l="$i->entrada a $i->salida";
					}elseif ('Martes'==$i->dia) {
						$m="$i->entrada a $i->salida";
					}elseif ('Miercoles'==$i->dia) {
						$mi="$i->entrada a $i->salida";
					}elseif ('Jueves'==$i->dia) {
						$j="$i->entrada a $i->salida";
					}elseif ('Viernes'==$i->dia) {
						$v="$i->entrada a $i->salida";
					}elseif ('Sabados'==$i->dia) {
						$s="$i->entrada a $i->salida";
					}elseif ('Domingos'==$i->dia) {
						$d="$i->entrada a $i->salida";
					}elseif ('Festivos'==$i->dia) {
						$f="$i->entrada a $i->salida";
					}

				}


				$descanso = new DescansosModel();
				$descanso = $descanso->getByEmpleado($g->id);
				if(isset($descanso)){
					foreach ($descanso as $i) {
						$de=$i->dias;
					}
				}


				$name = explode(' ',$g->nombre);
				$html .='
					<table style="width:100%; font-size:9;"  >
							<tr>
							<td width="8%" >'.$name[0].'</td>
							<td width="2%">'.$g->codigo.'</td>
							<td width="25%">'.$g->nombre.' '.$g->apellidos.'</td>
							<td width="10%">'.$g->rfc.'</td>
							<td width="42%" >
							<table style="font-size:6;"> <tr> <th>Lunes</th> <th>Martes</th> <th>Miercoles</th> <th>Jueves</th> <th>Viernes</th> <th>Sabados</th> <th>Domingos</th> <th>Festivos</th> <th>Descansos</th> </tr>
							<tr> <td>'.$l.'</td> <td>'.$m.'</td> <td>'.$mi.'</td> <td>'.$j.'</td> <td>'.$v.'</td> <td>'.$s.'</td> <td>'.$d.'</td> <td>'.$f.'</td> <td>'.$de.'</td> </tr> </table>
							</td>
							<td width="13%">'.$g->categoria.'</td>
							</tr>
							</table>';
			}




	}else if($_POST['type']=='horas_extras'){
		$mes= array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Septiembre','Agosto','Octubre','Noviembre','Diciembre');
		$titulo="horas extras";
		$firstday = date('d-m-Y', strtotime($_POST['semana']));
		$firstday =	date("d",strtotime($firstday."- 1 days"));
		$fecha = date('Y-m-j', strtotime($_POST['semana']));
		$nuevafecha = strtotime ( '+5 day' , strtotime ( $fecha ) ) ;
		$lastday = date ('d', $nuevafecha );


		$html ='<table width="100%" align="center" ><br>
			<tr style="font-weight: bold;" >
			<td align="left" style="width:50%;"><img src="public/img/logopdf.png" style="width:40px;" ></td>
			<td align="right" style="width:50%;"><img src="public/img/logo2.png" style="width:75px;" ></td>
			</tr>
			</table>
			<hr style="height: 3px; background-color: black;">

			<table width="100%" align="center" style="padding-top:10px;" ><br>
				<tr>
				<td align="left" style="width:60%;">
					<p style="padding-top:0px;padding-bottom:0px;" >
					<strong> LIC. CLAUDIA A. CANELA GALVAN </strong> <br>
					 SECRETARIA ADMINISTRATIVA <br>
					 INTITUTO BIOLOGIA- UNAM <br>
					 PRESENTE:<br>
					 Anexo al presente me permito enviarle la siguiente relacion de tiempo extra </p>
				</td>
				<td align="right" style="width:40%;">
				<p style="padding-top:0px;padding-bottom:0px;" >
				<strong>  '.$_POST['coment'].' </strong> <br>
				 Asunto: Se reporta tiempo extra Semana '.(date('W', strtotime($_POST['semana']))+1).'/'.date('Y').' </p>
				</td>
				</tr>
				<tr>
				<td align="right" style="width:50%;"> Semana: <font style="color:red; font-size:40px;"> '.(date('W', strtotime($_POST['semana']))+1).'</font> </td>
				<td style="width:50%;"> </td>
				</tr>
				<tr>
				<td style="width:50%;"> </td>
				<td align="left" style="width:50%;"> DEL '.$firstday.' AL '.$lastday.' DE '. $mes[ (int)date('m', strtotime($_POST['semana']))].' DEL '.date('Y').' </td>
				</tr>
				</table>';


		$html .='
			<table align="center" style="padding-top:10px; width:100%; font-size:7; border: 1px solid #000;"  >
					<tr style="border: 1px solid #000;">
					<td width="10%" style="border: 1px solid #000;" >RCF</td>
					<td width="20%" style="border: 1px solid #000;" >NOMBRES</td>
					<td width="10%" style="border: 1px solid #000;" >TIEMPO EXTRA DIAS LABORADOS</td>
					<td width="5%" style="border: 1px solid #000;" >HORAS DOBLES</td>
					<td width="5%" style="border: 1px solid #000;" >HORAS TRIPLES</td>
					<td width="20%" style="border: 1px solid #000;" >DOMINGOS Y FEST. DIAS LABORADOS</td>
					<td width="5%" style="border: 1px solid #000;" >HORAS</td>
					<td width="20%" style="border: 1px solid #000;" >PRIMA DOMINICAL DIAS LABORADOS</td>
					<td width="5%" style="border: 1px solid #000;" >HORAS</td>
					</tr>';


					$jornada = new JornadasModel();
					$jornadas = $jornada->getByExtras(date('W', strtotime($_POST['semana'])));
					$hrs_dt='';$hrs_d='';$hrs_t='';
					$em='';$count=0;
					$hrs_sd='';$hrs_sdf='';
					$hrs_do='';$hrs_dom='';

					$ext_dt='';

					$sum_d='';$sum_t='';$sum_f='';$sum_dom='';
					$doble="TIME_TO_SEC('00:00')"; $triple="TIME_TO_SEC('00:00')";
					if(isset($jornadas)){
						foreach ($jornadas as $i) {

							if($i->empleado != $em){
								$em = $i->empleado;
								$count++;
							}
							 if($i->tipo=='Horas Extras'){
								 if($i->sexo=='M'){
									 if($i->horas_extras >= '02:00'){
										 $hrs_d = '02:00';
										 $doble.=" + TIME_TO_SEC('02:00')";
									}elseif($i->horas_extras < '02:00'){
										$hrs_d = $i->horas_extras;
										$doble.=" + TIME_TO_SEC('".$i->horas_extras."')";
									}
								}else{
									$hrs_t = $i->horas_extras;
									 $triple.=" + TIME_TO_SEC('".$i->horas_extras."')";
									 $hrs_d = '';
								}

							 }else {
								 $hrs_d = '';
							 }

							 if($i->tipo=='Horas Extras'){
								 if($i->sexo=='M'){
									 if($i->horas_extras > '02:00'){
										$horas =  $jornada->resatar($i->horas_extras);
										$hrs_t = $horas->horas_extras;
										$triple.=" + TIME_TO_SEC('".$horas->horas_extras."')";
									}
								 }

							 }else {
								 $hrs_t = '';
							 }

							 $hrs_sdf=($i->tipo=='Festivos' or $i->tipo=='Domingos') ? $i->horas_extras : '';
							 $hrs_dom=($i->tipo=='Prima Dominical' or $i->tipo=='Prima Dominical') ? $i->horas_extras : '';

								if($i->tipo=='Horas Extras')
								{
									$hrs_dt = "DIA ".date('d', strtotime($i->fecha))."(DE $i->inicio_extra A $i->final_extra HRS)";
								}
								else{
									$hrs_dt = 'XXXXXXXXXX';
								}

								if($i->tipo=='Festivos' or $i->tipo=='Domingos')
								{
									$hrs_sd = "DIA ".date('d', strtotime($i->fecha))."(DE $i->inicio_extra A $i->final_extra HRS)";
								}
								else{
									$hrs_sd = 'XXXXXXXXXX';
								}

								if($i->tipo=='Prima Dominical')
								{
									$hrs_do = "DIA ".date('d', strtotime($i->fecha))."(DE $i->inicio_extra A $i->final_extra HRS)";
								}
								else{
									$hrs_do = 'XXXXXXXXXX';
								}

								if($i->tipo=='Horas Extras')
								{
										$sum_d = $jornada->getSumHoursh($doble);
										$sum_d = $sum_d->horas_extras;
								}

								if($i->tipo=='Horas Extras')
								{
										$sum_t = $jornada->getSumHoursh($triple);
										$sum_t = $sum_t->horas_extras;

								}

								if($i->tipo=='Prima Dominical')
								{
									$sum_f = $jornada->getSumHours(date('W', strtotime($_POST['semana'])),$i->id_empleado,'Prima Dominical');
									$sum_f = $sum_f->horas_extras;

								}if($i->tipo=='Domingos' or $i->tipo=='Festivos'){
									$sum_dom = $jornada->getSumHours(date('W', strtotime($_POST['semana'])),$i->id_empleado,'Domingos,Festivos');
									$sum_dom = $sum_dom->horas_extras;

								}



									$html .='
												<tr style="border: 1px solid #000;">
												<td width="10%" style="border: 1px solid #000;" >'.$i->rfc.'</td>
												<td width="20%" style="border: 1px solid #000;" >'.$i->empleado.'</td>
												<td width="10%" style="border: 1px solid #000;" >'.$hrs_dt.'</td>

												<td width="5%" style="border: 1px solid #000;" >'.$hrs_d.'</td>
												<td width="5%" style="border: 1px solid #000;" >'.$hrs_t.'</td>
												<td width="20%" style="border: 1px solid #000;" >'.$hrs_sd.'</td>
												<td width="5%" style="border: 1px solid #000;" >'.$hrs_sdf.' </td>
												<td width="20%" style="border: 1px solid #000;" >'.$hrs_do.'</td>
												<td width="5%" style="border: 1px solid #000;" >'.$hrs_dom.'</td>
												</tr>';
						}


					}


					$html .='<tr style="border: 1px solid #000;">
					<td colspan="2" width="30%" style="border: 1px solid #000;" >TOTAL DE EMPLEADOS </td>
					<td width="10%" style="border: 1px solid #000;" >'.$count.'</td>
					<td width="5%" style="border: 1px solid #000;" >'.$sum_d.'</td>
					<td width="5%" style="border: 1px solid #000;" >'.$sum_t.'</td>
					<td width="20%" style="border: 1px solid #000;" >TOTAL DE HORAS S.D.Y FESTIVOS</td>
					<td width="5%" style="border: 1px solid #000;" >'.$sum_dom.'</td>
					<td width="20%" style="border: 1px solid #000;" >TOTAL DE HORAS PRIMA DOMINICAL</td>
					<td width="5%" style="border: 1px solid #000;" >'.$sum_f.'</td>
					</tr>
					</table>

					<table align="center" style="padding-top:70px; width:100%;">
					<tr>
					<td> Km. 30 carretera Catemaco – Montepio Codigo Postal 95701. – San Andrés Tuxla, Veracruz, México. <br>
					Tels: Jefatura 01 200 125 54 09 - J.servicio: 01 200 125 54 08 Fax: 01 200 54 07 <br>
					E-mail: reservtux@ib.unam.mx - www.ib.unam.mx <br>
					</td>
					</tr>
					</table>
					';


	}else if($_POST['type']=='horas_extras_empleado'){

				$titulo="horas extras empleado";

				$mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

				$jornada = new JornadasModel();
				$jornadas = $jornada->getByExtrasxEmpleados(date('W', strtotime($_POST['semana'])), $_POST['empleado']);

					$dia='';
					$lun='<br>L<br>U<br>N<br>E<br>S|||||'; $mar='<br>M<br>A<br>R<br>T<br>E<br>S|||||'; $mie='<br>M<br>I<br>E<br>R<br>C<br>O<br>L<br>E<br>S|||||';
					$jue='<br>J<br>U<br>E<br>V<br>E<br>S|||||';$vie='<br>V<br>I<br>E<br>R<br>N<br>E<br>S|||||';$sab='<br>S<br>A<br>B<br>A<br>D<br>O<br>S|||||';
					$dom='<br>D<br>O<br>M<br>I<br>N<br>G<br>O<br>S|||||';
					$name='';$cat='';$rfc='';
					$id_e='';
					foreach ($jornadas as $g) {
						$name = $g->empleado;
						$cat = $g->categoria;
						$rfc = $g->rfc;
						$id_e = $g->id_empleado;
						if(date('D', strtotime($g->fecha))=='Mon'){

							$lun="<br>L<br>U<br>N<br>E<br>S|$g->fecha|".date('d-m', strtotime($g->fecha)).'--'.$g->entrada."|
							".date('d-m', strtotime($g->fecha)).'--'.$g->salida."|".date('d-m', strtotime($g->fecha)).'--'.$g->inicio_extra."|
							".date('d-m', strtotime($g->fecha)).'--'.$g->final_extra;

						}else if(date('D', strtotime($g->fecha))=='Tue'){

							$mar="<br>M<br>A<br>R<br>T<br>E<br>S|$g->fecha|".date('d-m', strtotime($g->fecha)).'--'.$g->entrada."|
							".date('d-m', strtotime($g->fecha)).'--'.$g->salida."|".date('d-m', strtotime($g->fecha)).'--'.$g->inicio_extra."|
							".date('d-m', strtotime($g->fecha)).'--'.$g->final_extra;

						}else if(date('D', strtotime($g->fecha))=='Wed'){

							$mie="<br>M<br>I<br>E<br>R<br>C<br>O<br>L<br>E<br>S|$g->fecha|".date('d-m', strtotime($g->fecha)).'--'.$g->entrada."|
							".date('d-m', strtotime($g->fecha)).'--'.$g->salida."|".date('d-m', strtotime($g->fecha)).'--'.$g->inicio_extra."|
							".date('d-m', strtotime($g->fecha)).'--'.$g->final_extra;

						}else if(date('D', strtotime($g->fecha))=='Thu'){

							$jue="<br>J<br>U<br>E<br>V<br>E<br>S|$g->fecha|".date('d-m', strtotime($g->fecha)).'--'.$g->entrada."|
							".date('d-m', strtotime($g->fecha)).'--'.$g->salida."|".date('d-m', strtotime($g->fecha)).'--'.$g->inicio_extra."|
							".date('d-m', strtotime($g->fecha)).'--'.$g->final_extra;

						}else if(date('D', strtotime($g->fecha))=='Fri'){

							$vie="<br>V<br>I<br>E<br>R<br>N<br>E<br>S|$g->fecha|".date('d-m', strtotime($g->fecha)).'--'.$g->entrada."|
							".date('d-m', strtotime($g->fecha)).'--'.$g->salida."|".date('d-m', strtotime($g->fecha)).'--'.$g->inicio_extra."|
							".date('d-m', strtotime($g->fecha)).'--'.$g->final_extra;

						}else if(date('D', strtotime($g->fecha))=='Sat'){

							$sab="<br>S<br>A<br>B<br>A<br>D<br>O<br>S|$g->fecha|".date('d-m', strtotime($g->fecha)).'--'.$g->entrada."|
							".date('d-m', strtotime($g->fecha)).'--'.$g->salida."|".date('d-m', strtotime($g->fecha)).'--'.$g->inicio_extra."|
							".date('d-m', strtotime($g->fecha)).'--'.$g->final_extra;

						}else if(date('D', strtotime($g->fecha))=='Sun'){

							$dom="<br>D<br>O<br>M<br>I<br>N<br>G<br>O<br>S|$g->fecha|".date('d-m', strtotime($g->fecha)).'--'.$g->entrada."|
							".date('d-m', strtotime($g->fecha)).'--'.$g->salida."|".date('d-m', strtotime($g->fecha)).'--'.$g->inicio_extra."|
							".date('d-m', strtotime($g->fecha)).'--'.$g->final_extra;

						}
					}
					$lun = explode("|",$lun);
					$mar = explode("|",$mar);
					$mie = explode("|",$mie);
					$jue = explode("|",$jue);
					$vie = explode("|",$vie);
					$sab = explode("|",$sab);
					$dom = explode("|",$dom);

					$horas = new HorariosModel();
					$horas = $horas->getByEmpleado($id_e);
					$hours='';
					$ea='';$sa='';

					// foreach ($horas as $i) {
					//
					// 	if($i->entrada != $ea && $i->salida != $sa){
					// 		if($i->dia != $i->dia_fin){
					// 			$hours.="$i->entrada a $i->salida $i->dia a $i->dia_fin ";
					// 		}else{
					// 			$hours.="$i->entrada a $i->salida $i->dia ";
					// 		}
					// 	}
					//
					// }

					$var = date('m', strtotime($_POST['semana']));
					settype($var, 'int');
					$dias1=date("d",strtotime(date('d-m-Y', strtotime($_POST['semana']))."+ 1 days"));
					$dias2=date("d",strtotime(date('d-m-Y', strtotime($_POST['semana']))."+ 2 days"));
					$dias3=date("d",strtotime(date('d-m-Y', strtotime($_POST['semana']))."+ 3 days"));
					$dias4=date("d",strtotime(date('d-m-Y', strtotime($_POST['semana']))."+ 4 days"));
					$dias5=date("d",strtotime(date('d-m-Y', strtotime($_POST['semana']))."+ 5 days"));
					$dias6=date("d",strtotime(date('d-m-Y', strtotime($_POST['semana']))."+ 6 days"));
					$html ='
					<br><br><br><br><br><br><br>
					<table width="100%" ><br>
						<tr >
						<td align="left" style="width:25%;"> </td>
						<td align="left" style="width:50%;">


							<table width="100%" align="center" style="padding-top:10px; border: 1px solid #000;" ><br>
								<tr>
								<td align="left" style="width:50%;">
									 '.$name.' <br>
									 RFC  <br>
									 HORARIO <br>
									 CATEGORIA <br>
									 '.$mes[$var].'
								</td>
								<td align="right" style="width:50%; ">
								'.$rfc.' <br>
								'.$hours.' <br>
								'.$cat.' <br>
								 '.date('Y', strtotime($_POST['semana'])).'
								</td>

								</tr>

								<tr>
								<td  style="width:50%;"><img src="public/img/logopdf.png" style="width:40px;" ></td>
								<td  style="width:50%;"><img src="public/img/logo2.png" style="width:75px;" ></td>
								</tr>
								</table>

						</td>

						<td align="right" style="width:25%;"> </td>
						</tr>

					';


					$html .='
						<tr >
						<td align="left" style="width:25%;"> </td>
						<td align="left" style="width:50%;">


							<table width="100%" align="center" style="border: 1px solid #000;" ><br>
								<tr>
								<td align="center" style="width:40%;">
								SDT-TE
								</td>

								<td align="center" style="width:20%;">
								</td>

								<td align="center" style="width:40%;">
								TIEMPO REGULAR
								</td>

								</tr>

								';


									$html.='
									<tr style="border: 1px solid #000; padding-bottom:30px;">

									<td align="center" style="width:35%; padding:0px;">
										<table>
												<tr ><td style="border: 1px solid #000;"> </td></tr>
												<tr ><td style="border: 1px solid #000;"> </td></tr>
												<tr ><td style="border: 1px solid #000;"> '.$lun[4].' </td></tr>
												<tr ><td style="border: 1px solid #000;"> '.$lun[5].' </td></tr>
										</table>
									</td>

									<td align="center" style="width:30%; padding:0px;">
										<table style="border: 1px solid #000;">

												<tr ><td rowspan="3"><p style="font-size:10px;" >'.$lun[0].'</p> </td> <td > <font style="font-size:10px;"> 1ER TURNO </font> </td> <td></td> </tr>
												<tr > <td > <font style="font-size:30px;"> '.date('d', strtotime($_POST['semana'])).'</font> </td> <td></td> </tr>
												<tr >   <td> <font style="font-size:10px;"> 2DO TURNO </font> </td> <td></td></tr>

										</table>
									</td>

									<td align="center" style="width:35%; padding:0px;">
									<table style="border: 1px solid #000;">
											<tr ><td width="10%" style="border: 1px solid #000;">S</td> <td width="90%" style="border: 1px solid #000;">'.$lun[2].'</td></tr>
											<tr ><td width="10%" style="border: 1px solid #000;">E</td> <td width="90%" style="border: 1px solid #000;">'.$lun[4].'</td></tr>
											<tr ><td width="10%" style="border: 1px solid #000;">S</td> <td width="90%" style="border: 1px solid #000;"> </td></tr>
											<tr ><td width="10%" style="border: 1px solid #000;">E</td> <td width="90%" style="border: 1px solid #000;"> </td></tr>
									</table>
									</td>

									</tr>

									<tr style="border: 1px solid #000; ">

									<td align="center" style="width:35%; padding:0px;">
										<table>
												<tr ><td style="border: 1px solid #000;"> </td></tr>
												<tr ><td style="border: 1px solid #000;"> </td></tr>
												<tr ><td style="border: 1px solid #000;"> '.$mar[4].' </td></tr>
												<tr ><td style="border: 1px solid #000;"> '.$mar[5].' </td></tr>
										</table>
									</td>

									<td align="center" style="width:30%; padding:0px;">
										<table style="border: 1px solid #000;">

												<tr ><td rowspan="3"><p style="font-size:10px;" >'.$mar[0].'</p> </td> <td > <font style="font-size:10px;"> 1ER TURNO </font> </td> <td></td> </tr>
												<tr > <td > <font style="font-size:30px;"> '.$dias1.' </font> </td> <td></td> </tr>
												<tr >   <td> <font style="font-size:10px;"> 2DO TURNO </font> </td> <td></td></tr>

										</table>
									</td>

									<td align="center" style="width:35%; padding:0px;">
									<table style="border: 1px solid #000;">
									<tr ><td width="10%" style="border: 1px solid #000;">S</td> <td width="90%" style="border: 1px solid #000;">'.$mar[2].'</td></tr>
									<tr ><td width="10%" style="border: 1px solid #000;">E</td> <td width="90%" style="border: 1px solid #000;">'.$mar[4].'</td></tr>
											<tr ><td width="10%" style="border: 1px solid #000;">S</td> <td width="90%" style="border: 1px solid #000;"> </td></tr>
											<tr ><td width="10%" style="border: 1px solid #000;">E</td> <td width="90%" style="border: 1px solid #000;"> </td></tr>
									</table>
									</td>

									</tr>

									<tr style="border: 1px solid #000; ">

									<td align="center" style="width:35%; padding:0px;">
										<table>
												<tr ><td style="border: 1px solid #000;"> </td></tr>
												<tr ><td style="border: 1px solid #000;"> </td></tr>
												<tr ><td style="border: 1px solid #000;"> '.$mie[4].' </td></tr>
												<tr ><td style="border: 1px solid #000;"> '.$mie[5].' </td></tr>
										</table>
									</td>

									<td align="center" style="width:30%; padding:0px;">
										<table style="border: 1px solid #000;">

												<tr ><td rowspan="3"><p style="font-size:10px;" >'.$mie[0].'</p> </td> <td > <font style="font-size:10px;"> 1ER TURNO </font> </td> <td></td> </tr>
												<tr > <td > <font style="font-size:30px;"> '.$dias2.' </font> </td> <td></td> </tr>
												<tr >   <td> <font style="font-size:10px;"> 2DO TURNO </font> </td> <td></td></tr>

										</table>
									</td>

									<td align="center" style="width:35%; padding:0px;">
									<table style="border: 1px solid #000;">
									<tr ><td width="10%" style="border: 1px solid #000;">S</td> <td width="90%" style="border: 1px solid #000;">'.$mie[2].'</td></tr>
									<tr ><td width="10%" style="border: 1px solid #000;">E</td> <td width="90%" style="border: 1px solid #000;">'.$mie[4].'</td></tr>
											<tr ><td width="10%" style="border: 1px solid #000;">S</td> <td width="90%" style="border: 1px solid #000;"> </td></tr>
											<tr ><td width="10%" style="border: 1px solid #000;">E</td> <td width="90%" style="border: 1px solid #000;"> </td></tr>
									</table>
									</td>

									</tr>

									<tr style="border: 1px solid #000; ">

									<td align="center" style="width:35%; padding:0px;">
										<table>
												<tr ><td style="border: 1px solid #000;"> </td></tr>
												<tr ><td style="border: 1px solid #000;"> </td></tr>
												<tr ><td style="border: 1px solid #000;"> '.$jue[4].' </td></tr>
												<tr ><td style="border: 1px solid #000;"> '.$jue[5].' </td></tr>
										</table>
									</td>

									<td align="center" style="width:30%; padding:0px;">
										<table style="border: 1px solid #000;">

												<tr ><td rowspan="3"><p style="font-size:10px;" >'.$jue[0].'</p> </td> <td > <font style="font-size:10px;"> 1ER TURNO </font> </td> <td></td> </tr>
												<tr > <td > <font style="font-size:30px;"> '.$dias3.' </font> </td> <td></td> </tr>
												<tr >   <td> <font style="font-size:10px;"> 2DO TURNO </font> </td> <td></td></tr>

										</table>
									</td>

									<td align="center" style="width:35%; padding:0px;">
									<table style="border: 1px solid #000;">
									<tr ><td width="10%" style="border: 1px solid #000;">S</td> <td width="90%" style="border: 1px solid #000;">'.$jue[2].'</td></tr>
									<tr ><td width="10%" style="border: 1px solid #000;">E</td> <td width="90%" style="border: 1px solid #000;">'.$jue[4].'</td></tr>
											<tr ><td width="10%" style="border: 1px solid #000;">S</td> <td width="90%" style="border: 1px solid #000;"> </td></tr>
											<tr ><td width="10%" style="border: 1px solid #000;">E</td> <td width="90%" style="border: 1px solid #000;"> </td></tr>
									</table>
									</td>

									</tr>
									<tr style="border: 1px solid #000; ">

									<td align="center" style="width:35%; padding:0px;">
										<table>
												<tr ><td style="border: 1px solid #000;"> </td></tr>
												<tr ><td style="border: 1px solid #000;"> </td></tr>
												<tr ><td style="border: 1px solid #000;"> '.$vie[4].' </td></tr>
												<tr ><td style="border: 1px solid #000;"> '.$vie[5].' </td></tr>
										</table>
									</td>

									<td align="center" style="width:30%; padding:0px;">
										<table style="border: 1px solid #000;">

												<tr ><td rowspan="3"><p style="font-size:10px;" >'.$vie[0].'</p> </td> <td > <font style="font-size:10px;"> 1ER TURNO </font> </td> <td></td> </tr>
												<tr > <td > <font style="font-size:30px;"> '.$dias4.' </font> </td> <td></td> </tr>
												<tr >   <td> <font style="font-size:10px;"> 2DO TURNO </font> </td> <td></td></tr>

										</table>
									</td>

									<td align="center" style="width:35%; padding:0px;">
									<table style="border: 1px solid #000;">
									<tr ><td width="10%" style="border: 1px solid #000;">S</td> <td width="90%" style="border: 1px solid #000;">'.$vie[2].'</td></tr>
									<tr ><td width="10%" style="border: 1px solid #000;">E</td> <td width="90%" style="border: 1px solid #000;">'.$vie[4].'</td></tr>
											<tr ><td width="10%" style="border: 1px solid #000;">S</td> <td width="90%" style="border: 1px solid #000;"> </td></tr>
											<tr ><td width="10%" style="border: 1px solid #000;">E</td> <td width="90%" style="border: 1px solid #000;"> </td></tr>
									</table>
									</td>

									</tr>
									<tr style="border: 1px solid #000; ">

									<td align="center" style="width:35%; padding:0px;">
										<table>
												<tr ><td style="border: 1px solid #000;"> </td></tr>
												<tr ><td style="border: 1px solid #000;"> </td></tr>
												<tr ><td style="border: 1px solid #000;"> '.$sab[4].' </td></tr>
												<tr ><td style="border: 1px solid #000;"> '.$sab[5].' </td></tr>
										</table>
									</td>

									<td align="center" style="width:30%; padding:0px;">
										<table style="border: 1px solid #000;">

												<tr ><td rowspan="3"><p style="font-size:10px;" >'.$sab[0].'</p> </td> <td > <font style="font-size:10px;"> 1ER TURNO </font> </td> <td></td> </tr>
												<tr > <td > <font style="font-size:30px;"> '.$dias5.' </font> </td> <td></td> </tr>
												<tr >   <td> <font style="font-size:10px;"> 2DO TURNO </font> </td> <td></td></tr>

										</table>
									</td>

									<td align="center" style="width:35%; padding:0px;">
									<table style="border: 1px solid #000;">
									<tr ><td width="10%" style="border: 1px solid #000;">S</td> <td width="90%" style="border: 1px solid #000;">'.$sab[2].'</td></tr>
									<tr ><td width="10%" style="border: 1px solid #000;">E</td> <td width="90%" style="border: 1px solid #000;">'.$sab[4].'</td></tr>
											<tr ><td width="10%" style="border: 1px solid #000;">S</td> <td width="90%" style="border: 1px solid #000;"> </td></tr>
											<tr ><td width="10%" style="border: 1px solid #000;">E</td> <td width="90%" style="border: 1px solid #000;"> </td></tr>
									</table>
									</td>

									</tr>
									<tr style="border: 1px solid #000; ">

									<td align="center" style="width:35%; padding:0px;">
										<table>
												<tr ><td style="border: 1px solid #000;"> </td></tr>
												<tr ><td style="border: 1px solid #000;"> </td></tr>
												<tr ><td style="border: 1px solid #000;"> '.$dom[4].' </td></tr>
												<tr ><td style="border: 1px solid #000;"> '.$dom[5].' </td></tr>
										</table>
									</td>

									<td align="center" style="width:30%; padding:0px;">
										<table style="border: 1px solid #000;">

												<tr ><td rowspan="3"><p style="font-size:10px;" >'.$dom[0].'</p> </td> <td > <font style="font-size:10px;"> 1ER TURNO </font> </td> <td></td> </tr>
												<tr > <td > <font style="font-size:30px;"> '.$dias6.' </font> </td> <td></td> </tr>
												<tr >   <td> <font style="font-size:10px;"> 2DO TURNO </font> </td> <td></td></tr>

										</table>
									</td>

									<td align="center" style="width:35%; padding:0px;">
									<table style="border: 1px solid #000;">
									<tr ><td width="10%" style="border: 1px solid #000;">S</td> <td width="90%" style="border: 1px solid #000;">'.$dom[2].'</td></tr>
									<tr ><td width="10%" style="border: 1px solid #000;">E</td> <td width="90%" style="border: 1px solid #000;">'.$dom[4].'</td></tr>
											<tr ><td width="10%" style="border: 1px solid #000;">S</td> <td width="90%" style="border: 1px solid #000;"> </td></tr>
											<tr ><td width="10%" style="border: 1px solid #000;">E</td> <td width="90%" style="border: 1px solid #000;"> </td></tr>
									</table>
									</td>

									</tr>
									';



								$html.='</table>

						</td>

						<td align="right" style="width:25%;"> </td>
						</tr>

						</table>

					';

	}


    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = 165, $html_footer, $border = 0, $ln = 2, $fill = 0, $reseth = false, $align = 'C', $autopadding = false);

	ob_end_clean();
	 $pdf->Output($titulo.'.pdf', 'I');
