<?php
    
    class Usuario {
        public $id;
        public $nome;
        public $email;
    }


    class Service{
        public function __construct(){
            include_once('config.php');

            $this->conexao = $conexao;
        }

        private function close(){
            mysqli_close($this->conexao);
        }

        public function criarUsuario($nome, $email, $senha){
            $senhaEncriptada = md5($senha);

            $query = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senhaEncriptada')";
    
            $res = mysqli_query( $this->conexao, $query);

            if($res){
                print "<script> alert('Usuário criado com sucesso!')</script>)";
            }else {
                print "<script> alert('Ocorreu um erro na hora de criar o usuário!')</script>)";
            }
        } 
        
        public function listarUsuarios(){
            $query= "SELECT * FROM usuarios;";

            $resultado =  mysqli_query( $this->conexao, $query);

            $usuarios = array();
            $count = 0;
           
            while($usuario = mysqli_fetch_array($resultado)){
               $usuarios[$count] = new Usuario();

               $usuarios[$count]->id = $usuario['id'];
               $usuarios[$count]->nome = $usuario['nome'];
               $usuarios[$count]->email = $usuario['email'];

               $count++;
            }

            return $usuarios;
        }

        public function mostrarUsuario($id){
            if(isset($id)){
                $query= "SELECT * FROM usuarios WHERE id=$id;";

                $result =  mysqli_query( $this->conexao, $query);

                return mysqli_fetch_object($result);
            }else {
                return null;
            }            
        }

        public function editarUsuario($id, $nome, $email, $senha){
            $senhaEncriptada = md5($senha);

            $query= "UPDATE usuarios 
                SET 
                    nome = '$nome',  
                    email = '$email',  
                    senha = '$senhaEncriptada' 
            WHERE id=$id;";
            
            $res = mysqli_query( $this->conexao, $query);

            if($res){
                print "<script> alert('Usuário editado com sucesso!')</script>)";
            }else{
                print "<script> alert('Ocorreu um erro na hora de editar o usuário!')</script>)";
            }
        }


        public function removerUsuario($id){
            $query= "DELETE FROM usuarios WHERE id=$id;";

            $res = mysqli_query( $this->conexao, $query);

            if($res){
                print "<script> alert('Usuário removido com sucesso!')</script>)";
            }else{
                print "<script> alert('Ocorreu um erro na hora de remover o usuário!')</script>)";
            }
        }
    }
   
?>