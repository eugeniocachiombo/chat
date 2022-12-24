
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<title>Formulário de Cadastro</title>

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
			width: 200px;
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
			width: 200px;
			border-color: white;
			border-style: double;
			border-radius: 50px;
			font-size: 25px;
		}

		#btnLogar{
			background:  rgba(1, 207, 207, 0.788);
			color: white;
			width: 300px;
			border-color: white;
			border-style: double;
			border-radius: 50px;
			font-size: 25px;
			margin: 15px;
		}

		#btnLogar:hover{
			background-image: url("icones/envio.jpg");
			background:  rgba(158, 48, 94, 0.904);
			cursor: pointer;
			color: white;
			width: 300px;
			border-color: white;
			border-style: double;
			border-radius: 50px;
			font-size: 25px;
		}
		
		#att2{
			font-family: Bookman Old Style;
			font-size: 30px;
			font-weight: lighter;
			text-align: center;
			color: rgb(0, 204, 17);
		}
		
		#erroUser{
			text-align: center;
			color: white;
			background: rgb(211, 23, 23);
			width: content;
		}

		#cadastroUser{
			text-align: center;
			color: white;
			background: rgb(0, 204, 17);
			width: content;
		}
	</style>

</head>
<body>
	
	<header><p id="slogan">Génio Pró Chat</p></header>
		<main>
	<form method="POST">

		<fieldset style="text-align: center">
		<?php
	include 'Conexao.php';

	$con = getConexao();

	$validar = true;

	if (isset($_POST["cadastrar"])) {

		$nome = mb_convert_case($_POST["nome"], MB_CASE_LOWER);
		$codigo = $_POST["codigo"];
		
		if(empty($nome) || empty($codigo) ){
			$validar = false;
			?>
  <p id="erroUser">
<?php echo "Introduza correctamente os seus dados, não deve conter campo vazio"; ?>
 </p>

 	
	
<?php
		}else{
			/*************** */

			$sql = "select nome from usuario where nome = ?";

			$stmt = $con->prepare($sql);
			$stmt->bindValue(1, $nome);
			$stmt->execute();
			$result = $stmt->fetch();
	
	
			
			if($result["nome"] == $nome){
				$validar = false;
				?>
  <p id="erroUser">
<?php echo "Já existe um usuário com este nome"; ?>
 </p>
				
 	
	
<?php
			}
			else{
		
				
			
		$sql = "insert into usuario(nome, codigo) 
		values(?, ?)";

		
		$stmt = $con->prepare($sql);
		$stmt->bindValue(1, $nome);
		$stmt->bindValue(2, $codigo);

		if ($stmt->execute()) {
			
			

			?>
  <p id="cadastroUser">
<?php echo "Cadastrado com sucesso"; ?>
 </p>
	
<?php
		} else{

			echo "Erro ao cadastrar";

		} }	
		/******************* */
	}

	}

	if (isset($_POST["logar"])) {
		?>
			<script type="text/javascript">
				
				window.location = "index.php";
			</script>
			<?php
	}



?>
			<legend>Formulário de Cadastro</legend>
		<label>Nome:</label> <br><br>
		<input  id="campoNome" style="width: 175px" type="text" name="nome" placeholder="Nome"><br><br>

		<label>Código:</label><br><br>
		<input  id="campoCodigo" style="width: 175px" type="password" name="codigo" placeholder="Código"><br><br>

		<input id="btnEntrar" type="submit" name="cadastrar" value="Cadastrar">

		<br>
	<a href="index.php">
		<input id="btnLogar" type="submit" name="logar" value="Já tem uma conta?">
		</a>
	</fieldset>
	</form>

	<p id="att2">Att: Por questões de segurança é bom anotar o seu Nome e o Código </p>
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