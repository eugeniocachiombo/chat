<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<title>Formulário de Login</title>

	<script src="js/novoJquery.js"></script>
	
	<script src="js/jquery.js"></script>
	<script src="js/jquery.mask.js"></script>

	<link rel="stylesheet" href="estrutura.css">
	<style type="text/css">
		

		#campoNome{
			background: white;
			color: black;
			
		}

		#campoCodigo{
			background: white;
			color: black;
			
		}

		input{
			font-size: 20px;
		}

		#btnEntrar{
			background: rgb(0, 204, 17);
			color: white;
			width: 94px;
			border-color: white;
			border-style: double;
			border-radius: 50px;
			font-size: 25px;
		}

		#btnEntrar:hover{
			background-image: url("icones/envio.jpg");
			background:   rgba(1, 207, 207, 0.788);
			cursor: pointer;
			color: white;
			width: 94px;
			border-color: white;
			border-style: double;
			border-radius: 50px;
			font-size: 25px;
		}

		#btnCdastrar{
			background:  rgba(1, 207, 207, 0.788);
			color: white;
			width: 200px;
			border-color: white;
			border-style: double;
			border-radius: 50px;
			font-size: 25px;
			margin: 15px;
		}

		#btnCdastrar:hover{
			background-image: url("icones/envio.jpg");
			background:  rgba(158, 48, 94, 0.904);
			cursor: pointer;
			color: white;
			width: 200px;
			border-color: white;
			border-style: double;
			border-radius: 50px;
			font-size: 25px;
		}
		
	

		#erroUser{
			margin: 5px;
			text-align: center;
			color: white;
			background: rgb(211, 23, 23);
			width: content;
		}
	</style>
</head>
<body>

		<header>
		
			<p id="slogan">Génio Pró Chat</p>
		</header>
	
	<main>
	<form method="POST">
		<fieldset style="text-align: center">

		<?php
	include 'Conexao.php';

	$con = getConexao();

	$validar = true;

	if (isset($_POST["entrar"])) {
			
		$nome = mb_convert_case($_POST["nome"], MB_CASE_LOWER);
		$codigo = $_POST["codigo"];
		
		$sql = "select * from usuario where nome = ? and codigo = ?";

		$stmt = $con->prepare($sql);
		$stmt->bindValue(1, $nome);
		$stmt->bindValue(2, $codigo);
		$stmt->execute();
		$result = $stmt->fetch();


		 
		if($result["nome"] == $nome && $result["codigo"] == $codigo){

			session_start();

			$_SESSION["id"] = $result["id"];
			$_SESSION["nome"] = $result["nome"];
			$_SESSION["codigo"] = $result["codigo"];

			if(empty($_SESSION["nome"]) || empty($_SESSION["codigo"]) ){
				$validar = false;
				?>
	  <p id="erroUser">
	<?php echo "Introduza correctamente os seus dados, não deve conter campo vazio"; ?>
	 </p>
		
	<?php
			}else{
			?>
			
			<script type="text/javascript">
				
				window.location = "inicio.php";
			</script>
			<?php
			}
		}else{ 
			$validar = false;
			?>
	  <p id="erroUser">
	<?php echo "Usuario Não Encontrado"; ?>
	 </p>
		
	<?php
		}	
	}

	if (isset($_POST["cadastrar"])) {
		?>
			<script type="text/javascript">
				
				window.location = "Cadastro.php";
			</script>
			<?php
	}

?>

			<legend>Login</legend>
		<label>Nome:</label> <br><br>
		<input  id="campoNome" style="width: 175px" type="text" name="nome" placeholder="Nome"><br><br>

		<label>Código:</label><br><br>
		<input  id="campoCodigo" style="width: 175px" type="password" name="codigo" placeholder="Código"><br><br>

		<input id="btnEntrar"  type="submit" name="entrar" value="Logar"> <br>

		
		<input id="btnCdastrar" type="submit" name="cadastrar" value="Cadastrar">
			
	</fieldset>
	</form>
	</main>

		<footer>
		<p id="att">Att: Versão de teste, criado por Génio Pró</p>
		</footer>

		<script>
		var nome = "<?php echo $_POST["nome"] ?>";
		var codigo = "<?php echo $_POST["codigo"]?>";
		var validar = "<?php echo $validar?>";

		if(validar == false){
			$("#campoNome").val(nome);
		$("#campoCodigo").val(codigo);
		}
		
	</script>
</body>
</html>