<?php

if(isset($_POST['Email_Address'])) {
	
	include 'contacto_config.php';
	
	function died($error) {
		echo "Lo sentimos, pero se ha encontrado errores en la información entregada. ";
		echo "El error aparece debajo!.<br /><br />";
		echo $error."<br /><br />";
		echo "Por favor vaya atras y corrija este error.<br /><br />";
		die();
	}
	
	if(!isset($_POST['Full_Name']) ||
		!isset($_POST['Email_Address']) ||
		!isset($_POST['Telephone_Number']) ||
		!isset($_POST['Your_Message'])) {
		died('Lo sentimos, pero se ha encontrado errores en la información entregada.');		
	}
	
	$full_name = $_POST['Full_Name']; // required
	$email_from = $_POST['Email_Address']; // required
	$telephone = $_POST['Telephone_Number']; // not required
	$comments = $_POST['Your_Message']; // required
	
	$error_message = "";
	$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
  if(preg_match($email_exp,$email_from)==0) {
  	$error_message .= 'El correo no es válido!.<br />';
  }
  if(strlen($full_name) < 2) {
  	$error_message .= 'Su nombre no es válido.<br />';
  }
  if(strlen($comments) < 2) {
  	$error_message .= 'Su mensaje no es válido.<br />';
  }
  
  if(strlen($error_message) > 0) {
  	died($error_message);
  }
	$email_message = "Detalles del formulario abajo.\r\n";
	
	function clean_string($string) {
	  $bad = array("content-type","bcc:","to:","cc:","href");
	  return str_replace($bad,"",$string);
	}
	
	$email_message .= "Nombre: ".clean_string($full_name)."\r\n";
	$email_message .= "Email: ".clean_string($email_from)."\r\n";
	$email_message .= "Telefono: ".clean_string($telephone)."\r\n";
	$email_message .= "Mensaje: ".clean_string($comments)."\r\n";
	
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);
header("Location: $gracias");
?>
<script>location.replace('<?php echo $../paginas/pag_gracias;?>')</script>
<?php
}
die();
?>