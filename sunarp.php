<?php
	class Sunarp
	{
		var $path = "";
		function __construct()
		{
			$this->path = dirname(__FILE__);
			$this->cc = new cURL(true,'https://m.sunarp.gob.pe/mobile/m_ConsultaVehicularResultado.aspx',$this->path.'/cookies.txt');
		}
		function BuscaDatosSunarp($NroPlaca="")
		{
			$rtn = array();
			if( $NroPlaca!="" )
			{
				$data = array(
					"__VIEWSTATE"=>"/wEPDwUJOTAwNTk2NzQ0D2QWAmYPZBYCAgMPZBYCAgEPZBYCAgEPZBYEAgMPZBYCAgEPZBYCZg9kFgICAQ8PFgQeBFRleHRlHgdWaXNpYmxlaGRkAgUPZBYGAgQPZBYCZg9kFgJmDw8WAh4KRm9udEZhbWlseQUFQXJpYWwWBB4Dc3JjBU8vbW9iaWxlL21fQ29uc3VsdGFWZWhpY3VsYXIuYXNweD9vYm91dGNhcHRjaGFndWlkPTU2OTA0ODc2MCZ3aWR0aD0yMDAmaGVpZ2h0PTQwHgNhbHRlZAIGD2QWAmYPZBYCZg8PFgIfAWhkZAIHD2QWAmYPZBYCAgEPDxYCHwFoZGQYAQUeX19Db250cm9sc1JlcXVpcmVQb3N0QmFja0tleV9fFgIFG2N0bDAwJE1haW5Db250ZW50JGNhcHRjaF9jdgUbY3RsMDAkTWFpbkNvbnRlbnQkY2FwdGNoX2N2H2ldI7DyAngwECZTd1U79GI290ztSbTZD5P5PmUb71c=",
					"__PREVIOUSPAGE"=>"CGolXNipllt7008RVjwRwVUPsJjzqakvftncQWB1YeLs4pQ9sAhI_I1iJ7OcuG9KxT707ObZH6YVUeOqlA8QGEIneeQuFyaDWZMLa-waidWfhGg_gNR16evOBOG3fmM30",
					"__EVENTVALIDATION"=>"/wEdAASMigw6pSf3K8Nm1w9k0CL+59mJmXNO3y9sk6D61NuALCn6OpuFFlvdwEvkvuq15aT53d8HLcsMPPSWw23i74K4CP5+pgd/vniyS3xFY4VxwMdXEH1LWJ8QFMjsjlfNWc8=",
					"ctl00\$MainContent\$txtNoPlac"=>$NroPlaca
				);
				$url = "https://m.sunarp.gob.pe/mobile/m_ConsultaVehicularResultado.aspx";
				$this->cc->referer($url);
				$Page = $this->cc->post($url,$data);
				//$Page = utf8_encode($Page);
				//file_put_contents("./page.html",$Page);

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
				if(count($rtn) > 2)
					return $rtn;
			}
			return false;
		}
	}
