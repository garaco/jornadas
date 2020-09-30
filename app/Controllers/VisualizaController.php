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


		// $venta = new VentaModel();
		// $ventas = $venta->getById($_POST['id'],'id');
		if($_POST['type']=='horarios'){

			$titulo="Horarios";

			$html ='<br><br><br><br><br><br><br>';
			$empleado = new EmpleadosModel();
			$empleado = $empleado->getAllEmpleados();
			$cont=1;

			foreach ($empleado as $g) {
				$horas = new HorariosModel();
				$horas = $horas->getByEmpleado($g->id);
				$hours='';
				$ea='';$sa='';
				foreach ($horas as $i) {

					if($i->entrada != $ea && $i->salida != $sa){
							$hours.="$i->entrada a $i->salida $i->dia ";
							$ea=$i->entrada;
							$sa=$i->salida;
					}

				}

				$descanso = new DescansosModel();
				$descanso = $descanso->getByEmpleado($g->id);
				if(isset($descanso)){
					foreach ($descanso as $i) {
						$hours.=" x $i->dias descanso";
					}
				}


				$name = explode(' ',$g->nombre);
				$html .='
					<table style="width:100%; font-size:9;"  >
							<tr>
							<td width="8%" >'.$name[0].'</td>
							<td width="2%">'.$cont++.'</td>
							<td width="25%">'.$g->nombre.' '.$g->apellidos.'</td>
							<td width="10%">'.$g->rfc.'</td>
							<td width="42%" >'.$hours.'</td>
							<td width="13%">'.$g->categoria.'</td>
							</tr>
							</table>';
			}




	}else if($_POST['type']=='horas_extras'){
		$titulo="horas extras";

		$firstday = date('d', strtotime($_POST['semana']));
		$fecha = date('Y-m-j', strtotime($_POST['semana']));
		$nuevafecha = strtotime ( '+6 day' , strtotime ( $fecha ) ) ;
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
				<strong>  Oficio EBTT-DA-142-2020 </strong> <br>
				 Asunto: Se reporta tiempo extra Semana '.date('W', strtotime($_POST['semana'])).'/'.date('Y', strtotime($_POST['semana'])).' </p>
				</td>
				</tr>
				<tr>
				<td align="right" style="width:50%;"> Semana: <font style="color:red; font-size:40px;"> '.date('W', strtotime($_POST['semana'])).'</font> </td>
				<td style="width:50%;"> </td>
				</tr>
				<tr>
				<td style="width:50%;"> </td>
				<td align="left" style="width:50%;"> DEL '.$firstday.' AL '.$lastday.' DE SEPTIEMBRE DEL 2020 </td>
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

					if(isset($jornadas)){
						foreach ($jornadas as $i) {

							if($i->empleado != $em){
								$em = $i->empleado;
								$count++;
							}

							 $hrs_d=($i->tipo=='Horas Dobles') ? $i->horas_extras : '';
							 $hrs_t=($i->tipo=='Horas Triples') ? $i->horas_extras : '';

							 $hrs_sdf=($i->tipo=='Festivos' or $i->tipo=='Domingos') ? $i->horas_extras : '';
							 $hrs_dom=($i->tipo=='Prima Dominical' or $i->tipo=='Prima Dominical') ? $i->horas_extras : '';

								if($i->tipo=='Horas Dobles' or $i->tipo=='Horas Triples')
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

								if($i->tipo=='Horas Dobles')
								{
									$sum_d = $jornada->getSumHours(date('W', strtotime($_POST['semana'])),$i->id_empleado,'Horas Dobles');
									$sum_d = $sum_d->horas_extras;

								}
								if($i->tipo=='Horas Triples' )
								{
									$sum_t = $jornada->getSumHours(date('W', strtotime($_POST['semana'])),$i->id_empleado,'Horas Triples');
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
					E-mail: resertux@unam.mx - www.ib.unam.mx <br>
					</td>
					</tr>
					</table>
					';


	}
    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = 165, $html_footer, $border = 0, $ln = 2, $fill = 0, $reseth = false, $align = 'C', $autopadding = false);

	ob_end_clean();

  $pdf->Output($titulo.'.pdf', 'I');
