<?php
	class Sunarp
	{
		var $path = "";
		function __construct()
		{
			$this->path = dirname(__FILE__);
			$this->cc = new cURL(false);
		}
		function BuscaDatosSunarp($NroPlaca="")
		{
			$rtn = array();
			if( $NroPlaca!="" )
			{
				$data = array(
					'ctl00_MainContent_captch_cv_ClientState' => '{"TextLength":8,"Width":200,"Height":40,"FontFamily":"Arial","ForeColor":-26368,"BackColor":-1,"BrushFillerColor":-1015680,"TextBrush":1,"BackBrush":1,"LineNoise":2,"BackgroundNoise":1,"FontWarpLevel":2,"CharSet":"1;2;3;4;5;6;7;8;9;0;a;b;c;d;e;f;g;h;i;j;k;l;m;n;o;p;q;r;s;t;u;v;w;x;y;z"}',
					'_CurrentGuid_ctl00_MainContent_captch_cv' => '1645764843',
					'__EVENTTARGET'=>'',
					'__EVENTARGUMENT'=>'',
					'__VIEWSTATE' => '/wEPDwUJOTAwNTk2NzQ0D2QWAmYPZBYCAgMPZBYCAgEPZBYCAgEPZBYEAgMPZBYCAgEPZBYCZg9kFgICAQ8PFgQeBFRleHRlHgdWaXNpYmxlaGRkAgUPZBYGAgQPZBYCZg9kFgJmDw8WAh4KRm9udEZhbWlseQUFQXJpYWwWBB4Dc3JjBVAvbW9iaWxlL21fQ29uc3VsdGFWZWhpY3VsYXIuYXNweD9vYm91dGNhcHRjaGFndWlkPTE2NDU3NjQ4NDMmd2lkdGg9MjAwJmhlaWdodD00MB4DYWx0ZWQCBg9kFgJmD2QWAmYPDxYCHwFoZGQCBw9kFgJmD2QWAgIBDw8WAh8BaGRkGAEFHl9fQ29udHJvbHNSZXF1aXJlUG9zdEJhY2tLZXlfXxYCBRtjdGwwMCRNYWluQ29udGVudCRjYXB0Y2hfY3YFG2N0bDAwJE1haW5Db250ZW50JGNhcHRjaF9jdhzEcEivP4VEFJXfTG4pjhN5KXBBvaQnhicRu2YaJdqc',
					'__VIEWSTATEGENERATOR'=>'17FC25E2',
					'__EVENTVALIDATION'=>'/wEdAAT59uW4F5zPqYJGXKWDGMz459mJmXNO3y9sk6D61NuALCn6OpuFFlvdwEvkvuq15aSaIpqfKYoPHD7Q+iVupJLCzofVjalkkCLvYtx1WuvZj6ol/7atHSY1s50lrfMOgCU=',
					'ctl00$MainContent$txtNoPlac' => $NroPlaca,
					'ctl00$MainContent$txtCaptcha' => 'tn1u8ker',
					'ctl00$MainContent$btnFireBtn'=>'+++Buscar+++'
				);
				$url = "https://m.sunarp.gob.pe/mobile/m_ConsultaVehicular.aspx";
				$this->cc->referer($url);
				$Page = $this->cc->post($url,$data);
				if($Page)
				{
					// Busca Nro Placa
					$patron='/<span id="MainContent_lblNuPlac">(.*)<\/span>/';
					$output = preg_match_all($patron, $Page, $matches, PREG_SET_ORDER);
					if(isset($matches[0]))
					{
						$rtn += array("NroPlaca"=>trim($matches[0][1]));
					}
					// Busca Nro Serie
					$patron='/<span id="MainContent_lblNoSeri">(.*)<\/span>/';
					$output = preg_match_all($patron, $Page, $matches, PREG_SET_ORDER);
					if(isset($matches[0]))
					{
						$rtn += array("NroSerie"=>trim($matches[0][1]));
					}
					// Busca Nro Vin
					$patron='/<span id="MainContent_lblNoVin">(.*)<\/span>/';
					$output = preg_match_all($patron, $Page, $matches, PREG_SET_ORDER);
					if(isset($matches[0]))
					{
						$rtn += array("NroVin"=>trim($matches[0][1]));
					}
					// Busca Nro Serie Motor
					$patron='/<span id="MainContent_lblNoMotr">(.*)<\/span>/';
					$output = preg_match_all($patron, $Page, $matches, PREG_SET_ORDER);
					if(isset($matches[0]))
					{
						$rtn += array("NroMotor"=>trim($matches[0][1]));
					}
					// Busca Color
					$patron='/<span id="MainContent_lblColr">(.*)<\/span>/';
					$output = preg_match_all($patron, $Page, $matches, PREG_SET_ORDER);
					if(isset($matches[0]))
					{
						$rtn += array("Color"=>trim($matches[0][1]));
					}
					// Busca Marca
					$patron='/<span id="MainContent_lblMarca">(.*)<\/span>/';
					$output = preg_match_all($patron, $Page, $matches, PREG_SET_ORDER);
					if(isset($matches[0]))
					{
						$rtn += array("Marca"=>trim($matches[0][1]));
					}
					// Busca Modelo
					$patron='/<span id="MainContent_lblModelo">(.*)<\/span>/';
					$output = preg_match_all($patron, $Page, $matches, PREG_SET_ORDER);
					if(isset($matches[0]))
					{
						$rtn += array("Modelo"=>trim($matches[0][1]));
					}
					// Busca Placa Anterior
					$patron='/<span id="MainContent_lblPlacAnte">(.*)<\/span>/';
					$output = preg_match_all($patron, $Page, $matches, PREG_SET_ORDER);
					if(isset($matches[0]))
					{
						$rtn += array("PlacaAnterior"=>trim($matches[0][1]));
					}
					// Busca Placa Vigente
					$patron='/<span id="MainContent_lblPlacVige">(.*)<\/span>/';
					$output = preg_match_all($patron, $Page, $matches, PREG_SET_ORDER);
					if(isset($matches[0]))
					{
						$rtn += array("PlacaVigente"=>trim($matches[0][1]));
						if($rtn["PlacaVigente"]=="")
							$rtn["PlacaVigente"]=$NroPlaca;
					}
					// Busca Sede
					$patron='/<span id="MainContent_lblSede">(.*)<\/span>/';
					$output = preg_match_all($patron, $Page, $matches, PREG_SET_ORDER);
					if(isset($matches[0]))
					{
						$rtn += array("Sede"=>trim($matches[0][1]));
					}
					// Busca Propietarios
					$patron='/<td class="Message" align="left"><span>(.*)<\/span><\/td>/';
					$output = preg_match_all($patron, $Page, $matches, PREG_SET_ORDER);
					if(isset($matches[0]))
					{
						$p = array();
						foreach($matches as $prop)
						{
							$p[]["name"]=trim(htmlentities($prop[1]));
						}
						$rtn += array("Propietario"=>$p);
					}
				}
				if(count($rtn) > 2)
				{
					return $rtn;
				}
			}
			return false;
		}
	}
