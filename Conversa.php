<?php
	
	include 'Conexao.php';
	require_once 'Mensagem.php';
	session_start();

	$id = $_SESSION["id"];
	$codigo = $_SESSION["id"];
	$usuario = ucwords($_SESSION["nome"]);

	$Logado = new Usuario();
	$Logado->setId($id);
	$Logado->setNome($usuario);
	$Logado->setCodigo($codigo);

	$con = getConexao();	
	
	if (isset($_POST["BotaoEnviar"])) {


		$emissorId = $id;
		$receptorId = $_POST["destinatário"];
		$texto = $_POST["texto"];

		$_SESSION["destino"] = $receptorId;


		$sqlNome = "select * from usuario where id = ? ";
		$stmt = $con->prepare($sqlNome);
		$stmt->bindvalue(1, $receptorId);
		$stmt->execute();
		$result = $stmt->fetch();
		$ReceptorNome = ucwords($result["nome"]);
		$RecptorLogado = new Usuario();
		$RecptorLogado->setNome($ReceptorNome);

		$_SESSION["Nomedestino"] = $RecptorLogado->getNome();

	$sms2 = new Mensagem($Logado, $RecptorLogado, $texto);
	

		$insertSms = "insert into mensagem(texto, Emissor, Receptor, Enviante, Recebido)
		values(?, ?, ?, ?, ?) ";

		$stmt= $con->prepare($insertSms);
		$stmt->bindvalue(1, $texto);
		$stmt->bindvalue(2, $emissorId);
		$stmt->bindvalue(3, $receptorId);
		$stmt->bindvalue(4, $Logado->getNome());
		$stmt->bindvalue(5, $RecptorLogado->getNome());

		if($stmt->execute()){
			$sms2->enviarSms();
			
		}else{
			echo "Erro ao enviar na base de dados";
		}
	} 

	if (isset($_POST["cancelar"])) {
	
		//header("location:inicio.php");

?>
		<script type="text/javascript">
				
				window.location = "inicio.php";
			</script>
			<?php
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Conversa</title>

	<script src="js/novoJquery.js"></script>
	
	<script src="js/jquery.js"></script>
	<script src="js/jquery.mask.js"></script>

	<link rel="stylesheet" href="estrutura.css">


	<style type="text/css">

		input{
			font-size: 20px;
		}

		#belezaDaSmsEnviante{
			color: white;
			background: rgba(1, 207, 207, 0.788);
			padding: 50px;
			text-align: center;
			width: content;
			border-radius: 50px;
		}

		#belezaDaSmsReceptor{
			color: white;
			background: rgba(171, 173, 0, 0.623);
			padding: 50px;
			text-align: center;
			width: content;
			border-radius: 50px;
		}

		#btnDel{
			color: white;
			background: rgb(211, 23, 23);
			margin: 5px;
			padding: 5px;
			text-align: center;
			width: content;
			width: 180px;
			height: 35px;
			border-color: white;
			border-style: double;
			border-radius: 50px;
			
		}

		#btnDel:hover{
			color: white;
			background: rgb(0, 204, 17);
			margin: 5px;
			padding: 5px;
			cursor: pointer;
			text-align: center;
			width: 150px;
			height: 35px;
			border-color: white;
			border-style: double;
			border-radius: 50px;
		}

		#smsExcluida{
			color: white;
			background: rgb(211, 23, 23);
			width: content;
		}

		#btnEnviar{
			background: rgb(0, 204, 17);
			color: white;
			width: 500px;
			border-color: white;
			border-style: double;
			border-radius: 50px;
			font-size: 25px;
		}

		#btnEnviar:hover{
			background-image: url("icones/envio.jpg");
			background:   rgba(158, 48, 94, 0.904);
			cursor: pointer;
			color: white;
			width: 500px;
			border-color: white;
			border-style: double;
			border-radius: 50px;
			font-size: 25px;
		}

		#btnActualizar{
			background: rgba(1, 207, 207, 0.788);
			color: white;
			width: 150px;
			border-color: white;
			border-style: double;
			border-radius: 50px;
			font-size: 25px;
			margin: 20px;
		}

		#btnActualizar:hover{
			background-image: url("icones/envio.jpg");
			background:   rgba(158, 48, 94, 0.904);
			cursor: pointer;
			color: white;
			width: 150px;
			border-color: white;
			border-style: double;
			border-radius: 50px;
			font-size: 25px;
		}

		#btnTerminarConversa{
			background: rgba(1, 207, 207, 0.788);
			color: white;
			width: 300px;
			border-color: white;
			border-style: double;
			border-radius: 50px;
			font-size: 25px;
			margin: 20px;
		}

		#btnTerminarConversa:hover{
			background-image: url("icones/envio.jpg");
			background:   rgba(158, 48, 94, 0.904);
			cursor: pointer;
			color: white;
			width: 300px;
			border-color: white;
			border-style: double;
			border-radius: 50px;
			font-size: 25px;
		}
	</style>
</head>
<body>
		<header><p id="slogan">Génio Pró Chat</p>

		<p align="center" 
		style="font-weight: bold; color:white;">
		<?php echo "Usuário: ".$usuario;?>
		</p>

		</header>
		<main>

	<form method="POST">

		<fieldset style="text-align: center">

<legend style="font-weight: bold;">Em chat com <?php echo $_SESSION["Nomedestino"] ?></legend>
			
			<div id="buscarSms">

			</div>
			<script>

				setInterval(() => {
					$("#buscarSms").load("buscarSms.php");
				}, 1000);

			
			</script>	
				
				<?php  if (isset($_POST["BotaoDel_Sms"])) {
                    
                    echo "clicado";
                    $idDeletar = $_POST["Del"];
            
                    $Ms = "Esta Mensagem foi excluida por: ".$usuario;
                    //$sql = "delete from mensagem where codsms = ?";
            
                    $sql = "update mensagem set texto = ?
                    where codsms = ?";
            
                    $stmt = $con->prepare($sql);
                    $stmt->bindValue(1, $Ms);
                    $stmt->bindValue(2, $idDeletar);
                  	$stmt->execute();
                }
                    ?>	
			

				
			 <br> <br>
			
		<input id="btnActualizar" type="hidden" name="exibir" value="Actualizar"> <br>
		<textarea placeholder="Escreva aqui a sua Mensagem" name="texto" id="textarea" cols="30" rows="10" style="width: 500px; height: 250px; font-size: 40px; background-color: black; color: white;" ></textarea>
		

		<?php

		$User1 = "select * from usuario where nome not like ? ";
		$stmt = $con->prepare($User1);
		$stmt->bindvalue(1, $usuario);
		$stmt->execute();
		$result = $stmt->fetchAll(); ?>


		
<input type="hidden" name="destinatário" value="<?php echo $_SESSION["destino"] ?>">

<br>
	

	<input id="btnEnviar" type="submit" name="BotaoEnviar" value="Enviar"><br>

		
		<input id="btnTerminarConversa" type="submit" name="cancelar" value="Terminar conversa">
		</fieldset>


	</form>
	</main>


	<footer>
	<p id="att">Att: Versão de teste, criado por Génio Pró</p>
	</footer>

</body>
</html>


