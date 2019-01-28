<?php
SESSION_START();
function SendMail($From,$FromName,$To,$ToName,$Subject,$Text,$Html,$AttmFiles){
      $OB="----=_OuterBoundary_000";
      $IB="----=_InnerBoundery_001";
      $Html=$Html?$Html:preg_replace("/\n/","{br}",$Text)
      or die("neither text nor html part present.");
      $Text=$Text?$Text:"Sorry, but you need an html mailer to read this mail.";
      $From or die("sender address missing");
      $To or die("recipient address missing");

      $headers ="MIME-Version: 1.0\r\n";
      $headers.="From: ".$FromName." <".$From.">\n";
      $headers.="To: ".$ToName." <".$To.">\n";
      $headers.="Reply-To: ".$FromName." <".$From.">\n";
      $headers.="X-Priority: 1\n";
      $headers.="X-MSMail-Priority: High\n";
      $headers.="X-Mailer: My PHP Mailer\n";
      $headers.="Content-Type: multipart/mixed;\n\tboundary=\"".$OB."\"\n";

      //Messages start with text/html alternatives in OB
      $Msg ="This is a multi-part message in MIME format.\n";
      $Msg.="\n--".$OB."\n";
      $Msg.="Content-Type: multipart/alternative;\n\tboundary=\"".$IB."\"\n\n";

      //plaintext section
      $Msg.="\n--".$IB."\n";
      $Msg.="Content-Type: text/plain;\n\tcharset=\"iso-8859-1\"\n";
      $Msg.="Content-Transfer-Encoding: quoted-printable\n\n";
      // plaintext goes here
      $Msg.=$Text."\n\n";

      // html section
      $Msg.="\n--".$IB."\n";
      $Msg.="Content-Type: text/html;\n\tcharset=\"iso-8859-1\"\n";
      $Msg.="Content-Transfer-Encoding: base64\n\n";
      // html goes here
      $Msg.=chunk_split(base64_encode($Html))."\n\n";

      // end of IB
      $Msg.="\n--".$IB."--\n";

      // attachments
      if($AttmFiles){
          foreach($AttmFiles as $AttmFile){
                $patharray = explode ("/", $AttmFile);
                $FileName=$patharray[count($patharray)-1];
                $Msg.= "\n--".$OB."\n";
                $Msg.="Content-Type: application/octetstream;\n\tname=\"".$FileName."\"\n";
                $Msg.="Content-Transfer-Encoding: base64\n";
                $Msg.="Content-Disposition: attachment;\n\tfilename=\"".$FileName."\"\n\n";

                //file goes here
                $fd=fopen ($AttmFile, "r");
                $FileContent=fread($fd,filesize($AttmFile));
                fclose ($fd);
                $FileContent=chunk_split(base64_encode($FileContent));
                $Msg.=$FileContent;
                $Msg.="\n\n";
          }
      }

      $Msg.="\n--".$OB."--\n";
      mail($To,$Subject,$Msg,$headers);
}

function c_hora($n)
{
	$i = ( strlen($n) == "1" ? "0".$n : $n );
	return $i; 
} 

$data=getdate(); 
$hora = array (c_hora($data["hours"]),c_hora($data["minutes"]),c_hora($data["seconds"]));

//formatando Data da Decoração
$data      = explode("-",$HTTP_POST_VARS[data_decoracao]);
$data      = $data[2]."/".$data[1]."/".$data[0];
$num_inscr = $HTTP_POST_VARS[cod_imovel];



// CONFIGURACAO REMETENTE / DESTINATÁRIO
$Subject        = "Licitacçoes - Prefeitura Munucipal de Campinas";
$NameRecipient  = "Prefeitura Municipal de Campinas";
$EmailRecipient = "roselia.mesquita@campinas.sp.gov.br";

$primName       = explode(" ",$nome_responsavel);    // primeiro nome do cliente
$nomeCliente    = ucfirst(strtolower($primName[0])); // formata o primeiro nome do cliente
$emailCliente   = $HTTP_POST_VARS['email'];

// RECEBIDO PELO INSCRITO: STATUS INICIAL SOBRE O PREENCHIMENTO DO FORMULÁRIO



$html_cliente = '
<html>
<body>
<TABLE WIDTH=909 BORDER=0 CELLPADDING=0 CELLSPACING=0>
	<TR>
		<TD COLSPAN=3>
			<IMG SRC="http://www.ima.sp.gov.br/images/ficha_retorno_01.jpg" WIDTH=909 HEIGHT=92 ALT=""></TD>
	</TR>
	<TR>
		<TD>
			<IMG SRC="http://www.ima.sp.gov.br/images/ficha_retorno_02.jpg" WIDTH=72 HEIGHT=190 ALT=""></TD>
		<TD style="width:763px;height:190px;text-align:center;">
			Prezado(a) '.$responsavel_imovel.', sua ficha de inscri&ccedil;&atilde;o para o &quot;Concurso de Decora&ccedil;&atilde;o Natal 2008&quot; <b>foi aprovada</b>.<br />		
			Seu n&uacute;mero de inscri&ccedil;&atilde;o &eacute; <b>'.$cod_imovel.'</b>.<br />
			Estamos a disposi&ccedil;&atilde;o para eventuais esclarecimentos enquanto desejamos um Feliz Natal e Pr&oacute;spero Ano Novo!!!<br/>
			</TD>
		<TD>
			<IMG SRC="http://www.ima.sp.gov.br/images/ficha_retorno_04.jpg" WIDTH=74 HEIGHT=190 ALT=""></TD>
	</TR>
	<TR>
		<TD COLSPAN=3>
			<IMG SRC="http://www.ima.sp.gov.br/images/ficha_retorno_05.jpg" WIDTH=909 HEIGHT=367 ALT=""></TD>
	</TR>
</TABLE>
</body>
</html>
';


// Enviar email de retorno ao cliente
SendMail($EmailRecipient,$NameRecipient,$email,$responsavel_imovel,$Subject,$Text,$html_cliente,$Arquivo);

//echo "<META http-equiv=\"REFRESH\" content=\"0;URL='agradecimento.htm'\">";
//exit;
?>


