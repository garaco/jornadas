<?php
require_once 'app/Lib/tcpdf/tcpdf.php';
use App\Models\VentaModel;
use App\Models\EmpresaModel;
use App\Models\UsuariosModel;

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

		if($_POST['type']=='Ticket'){
			$medidas = array(90, 180); // Ajustar aqui segun los milimetros necesarios;
	  	$pdf = new VisualizaController('P', 'mm', $medidas, true, 'UTF-8', false);
		}else{
			$pdf = new VisualizaController(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		}

  // set document information
  $pdf->SetCreator(PDF_CREATOR);
  $pdf->SetTitle('Ticket');

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


		$venta = new VentaModel();
		$ventas = $venta->getById($_POST['id'],'id');
		if($_POST['type']=='Ticket'){
			$pago=0;
		  $html ='<table width="100%" align="center"><br>
				<tr><td><img src="'.$_SESSION['Logo'] .'" style="width:120px;" ></td>
				</tr><tr><td width="100%"><h4 style="text-align:center;">'.$_SESSION['Empresa'].'</h4></td>
				</tr></table>
		     <table style="width:100%; font-size:10;" cellpadding="5" >
		      <br>
					<tr><td>Referencia: '.$ventas->referencia.'</td></tr>
					<tr><td>Fecha: '.$ventas->fecha.'</td></tr>
		    	</table> ';
			$pago=$ventas->pago;
			$html .='
				<table style="width:100%; font-size:10;"  >
						<tr><td style="width:20%;" >Cant.</td>
						<td style="width:40%;">Producto</td>
						<td style="width:20%;" align="right">Precio</td>
						<td style="width:20%;" align="right">Total</td></tr> <hr>';
						$vent = $venta->getVentaDetail($_POST['id'],'id');
						 // var_dump($ventas);
						 $sum = 0;
					foreach ($vent as $p) {
						$html .='<tr style="font-size:30px;" ><td style="width:20%;">'.$p->Cantidad.'</td>
										<td  style="width:40%;"><p>'.$p->Producto.'</p></td>
										<td style="width:20%;" align="right" > $'.number_format($p->Precio, 2, '.', ',').'</td>
										<td style="width:20%;" align="right" ><strong>$'.number_format($p->Total, 2, '.', ',').'</strong></td></tr>';
										$sum=$sum+$p->Total;
					}

					$html .='</table> <hr> <table style="width:100%; font-size:9;"> <br> <tr><td colspan="2">Sumatoria Total</td> <td></td> <td align="right" ><strong>$'.number_format($sum, 2, '.', ',').'</strong></td></tr>
					<tr><td colspan="2">Pago</td> <td></td> <td align="right" ><strong>$'.number_format($pago, 2, '.', ',').'</strong></td></tr>
					<tr><td colspan="2">Cambio</td> <td></td> <td align="right" ><strong>$'.number_format(($pago-$sum), 2, '.', ',').'</strong></td></tr> </table> ';
	}else{

		$ep = new EmpresaModel();
		$datos = $ep->getById($ventas->id_empresa,'IdEmpresa');
		$pago=0;
		$html ='<table width="100%" align="center" ><br>
			<tr style="background-color:#1565c0; color:#fff; font-weight: bold;" >

			<td align="left" style=" font-size:35px;width:70%;">
			<table width="100%" style="font-size:11;">
				<br>
				<tr > <td> Nombre: '.$_SESSION['Empresa'].' </td> </tr>
				<tr> <td> Razón social: '.$datos->RazonSocial.' </td> </tr>
				<tr> <td> R.F.C: '.$datos->Rfc.' </td> </tr>
				<tr> <td> Telefono: '.$datos->Telefono.' </td> </tr>
				<tr> <td> Correo: '.$datos->Email.' </td> </tr>
			</table>
			</td>
			<td align="right" style="width:30%;"><img src="'.$_SESSION['Logo'] .'" style="width:120px;" ></td>
			</tr></table>
			<table  width="100%" align="center"> <tr> <td> <h2 style="color:#1565c0;"> DATOS DE VENTA  </h2> </td> </tr> </table>
			 <table style="width:100%; font-size:10;" cellpadding="5" >
				<br>
				<tr><td><h4>Referencia: '.$ventas->referencia.'</h4></td>
				<td align="right"><h4>Fecha: '.$ventas->fecha.'</h4></td></tr>
				</table><br>';
		$pago=$ventas->pago;
		$html .='
			<table style="width:100%; font-size:12;"  >
					<tr style="background-color:#1565c0; color:#fff; font-weight: bold;"  ><td >Cant.</td>
					<td >Producto</td>
					<td align="right">Precio</td>
					<td align="right">Total</td></tr>';
					$vent = $venta->getVentaDetail($_POST['id'],'id');
					 // var_dump($ventas);
					 $sum = 0;
				foreach ($vent as $p) {
					$html .='<tr style="background-color:#eceff1;" > <td >'.$p->Cantidad.'</td>
									<td ><p>'.$p->Producto.'</p></td>
									<td align="right" > $'.number_format($p->Precio, 2, '.', ',').'</td>
									<td align="right" ><strong>$'.number_format($p->Total, 2, '.', ',').'</strong> </td></tr>';
									$sum=$sum+$p->Total;
				}

				$html .='</table> <table style="width:100%; font-size:12;"> <br> <tr><td colspan="2">Sumatoria Total</td> <td></td> <td align="right" ><strong>$'.number_format($sum, 2, '.', ',').'</strong> <hr> </td></tr>
				<tr><td colspan="2">Pago</td> <td></td> <td align="right" ><strong>$'.number_format($pago, 2, '.', ',').'</strong> <hr> </td></tr>
				<tr><td colspan="2">Cambio</td> <td></td> <td align="right" ><strong>$'.number_format(($pago-$sum), 2, '.', ',').'</strong> </td></tr> </table> ';
	}
    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = 165, $html_footer, $border = 0, $ln = 2, $fill = 0, $reseth = false, $align = 'C', $autopadding = false);

	ob_end_clean();

  $pdf->Output('venta.pdf', 'I');
