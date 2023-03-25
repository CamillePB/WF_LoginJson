<?php
	/* prepara o documento para comunicação com o JSON, as duas linhas a seguir são obrigatórias 
	  para que o PHP saiba que irá se comunicar com o JSON, elas sempre devem estar no ínicio da página */
	header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=utf-8"); 
	
	clearstatcache(); // limpa o cache
    // Dados do servidor de banco de dados, neste exemplo uso o servidor da escola
	$servidor = 'localhost';
	$usuario  = 'aluno';
	$senha    = 'etec@147';
	$banco    = 'aluno_2DS_Camille_login_DS';

	try {
		$conecta = new PDO("mysql:host=$servidor;dbname=$banco", $usuario , $senha);
		$conecta->exec("set names utf8"); //permite caracteres latinos.
		$consulta = $conecta->prepare("SELECT * FROM tb01_login WHERE tb01_usuario = '{$_GET["user"]}' AND  tb01_senha = '{$_GET["pwd"]}'");
		$consulta->execute(array());  
		$resultadoDaConsulta = $consulta->fetchAll();
		
		$StringJson = "[";
		
		if (count($resultadoDaConsulta) === 0)
		{
			echo '[{"erro":"Usuário não encontrado!"}]';
		}
		
		if ( count($resultadoDaConsulta) ) {
		foreach($resultadoDaConsulta as $registro) {
			
			if ($StringJson != "[") {$StringJson .= ",";}
            $StringJson .= '"user":"' . $registro['tb01_usuario']  . '",';
            $StringJson .= '"pwd":"' . $registro['tb01_senha'] . '"}';
		}  
		echo $StringJson . "]"; // Exibe o vettor JSON
		
  } 
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage(); // opcional, apenas para teste
}
?>