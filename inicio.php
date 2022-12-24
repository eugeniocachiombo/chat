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
	
	

	if (isset($_POST["cancelar"])) {
		session_destroy();


		//header("location:Index.php");
		?>
		<script type="text/javascript">
				
				window.location = "index.php";
			</script>
			<?php
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Inicio</title>
	<link rel="stylesheet" href="estrutura.css">
	<style type="text/css">
	

		textarea{
			color: white;
			background: black;
			font-size: 20px;
		}

		input{
			font-size: 20px;
		}

		#conversar{
			background: rgb(0, 204, 17);
			color: white;
			width: 500px;
			border-color: white;
			border-style: double;
			border-radius: 50px;
			font-size: 25px;
		}

		#conversar:hover{
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

		#btnTerminarSessão{
			background: rgba(1, 207, 207, 0.788);
			color: white;
			width: 300px;
			border-color: white;
			border-style: double;
			border-radius: 50px;
			font-size: 25px;
			margin: 20px;
		}

		#btnTerminarSessão:hover{
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

		#Destinatários{
			background: rgb(0, 204, 17);;
			color: white;
			margin: 15px;
			font-size: 30px;
		}

		#ErroDestinatário{
			color: white;
			background: rgb(211, 23, 23);
			width: content;
		}
	</style>
</head>
<body>

		<header>
		<p id="slogan">Génio Pró Chat</p>

		<p align="center" 
		style="font-weight: bold; color:white;">
		<?php echo "Usuário: ".$usuario;?>
		</p>
		</header>


		<main>

	<form method="POST">

		<fieldset style="text-align: center">

			<legend style="font-weight: bold;">Criar uma conversa</legend>
			
				
				<?php
	if(isset($_POST["exibir"]) || isset($_POST["BotaoEnviar"])){

		if($_POST["destinatário"] == "Selecione um destinatário"){

			?> <p id="ErroDestinatário">
		<?php	echo "Selecione um destinatário"; ?>
			</p>
			<?php

		}else{ 

		$receptorId2 = $_POST["destinatário"];
		$_SESSION["destino"] = $receptorId2;
		$sqlNome2 = "select * from usuario where id = ? ";
		$stmt = $con->prepare($sqlNome2);
		$stmt->bindvalue(1, $receptorId2);
		$stmt->execute();
		$result = $stmt->fetch();
		$ReceptorNome2 = ucwords($result["nome"]);
		$RecptorLogado2 = new Usuario();
		$RecptorLogado2->setNome($ReceptorNome2);

		$_SESSION["Nomedestino"] = $RecptorLogado2->getNome();
		

$sqlSms = "select * from mensagem 
where Enviante=? and Recebido=? or Recebido=? and Enviante=?";
				$stmt = $con->prepare($sqlSms);
				$stmt->bindValue(1, $usuario);
				$stmt->bindValue(2, $RecptorLogado2->getNome());
				$stmt->bindValue(3, $usuario);
				$stmt->bindValue(4, $RecptorLogado2->getNome());
				$stmt->execute();
				$result = $stmt->fetchAll();

				foreach ($result as $value) {?>
					<fieldset>
					<hr>
				<?php	echo $value["Enviante"]; ?> <br> <br>
				<?php	echo $value["texto"];    ?>
					<hr>
					</fieldset>
			<?php	} //header("Location:Conversa.php");

				?>
		<script type="text/javascript">
				
				window.location = "Conversa.php";
			</script>
			<?php

			 } }
				?>
				
			 <br> <br>

		

		<label>Destinatário:</label> <br>
	

		<?php

		$User1 = "select * from usuario where nome not like ? ";
		$stmt = $con->prepare($User1);
		$stmt->bindvalue(1, $usuario);
		$stmt->execute();
		$result = $stmt->fetchAll(); ?>


		<select id="Destinatários" name="destinatário">
			 <option>Selecione um destinatário</option>
		<?php	
		foreach ($result as $value) {?>

			<option  value="<?php echo $value["id"] ?>"><?php echo ucwords($value["nome"])?></option>
			<?php	} ?>

		</select>
	<br>
		<input id="conversar" type="submit" name="exibir" value="Conversar"> <br>
		<input id="btnTerminarSessão" type="submit" name="cancelar" value="Terminar Sessão">
		</fieldset>


	</form>
	</main>

	<footer>
	<p id="att">Att: Versão de teste, criado por Génio Pró</p>
	</footer>

</body>
</html>
