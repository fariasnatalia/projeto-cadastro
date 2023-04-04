<?php
    include_once('services.php');
    
    $service = new Service();

    $erros = false;

    $campoObrigatorio = 'Campo obrigatório!';

    $nomeObrigatorio = '';
    $emailObrigatorio = '';
    $senhaObrigatorio = '';   

    if(isset($_POST["enviar"])){
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
       
        if(empty($nome)){
            $nomeObrigatorio = $campoObrigatorio;
            $erros = true;
        }

        if(empty($email)){
            $emailObrigatorio = $campoObrigatorio;
            $erros = true;
        }

        if(empty($senha)){
            $senhaObrigatorio = $campoObrigatorio;
            $erros = true;
        }

        if(!$erros){
            if(isset($_GET['id'])){
                $id = $_GET['id'];                
                $service->editarUsuario($id, $nome, $email, $senha); 
            }else {
                $service->criarUsuario($nome, $email, $senha);
            }

            $nome = '';
            $email = '';
            $senha = '';
            
            $_GET['id'] = null;
        }
    }

    $usuario = null;

    if(isset($_GET['id'])){
       $usuario = $service->mostrarUsuario($_GET['id']);
    }

    if(isset($_GET['removerId'])){
       $service->removerUsuario($_GET['removerId']);
     }

    $usuarios = $service->listarUsuarios(); 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
   
    <title>Cadastro de Usuário</title>
</head>
<body>
    <div class="d-flex flex-column align-items-center justify-content-center">
        <h1>Cadastro de usuários</h1>

        <?php
            if(isset($_GET['id'])){
                $id = $_GET['id'];
                echo "<form class='w-25 p-3' action=index.php?id=$id method='POST' class='was-validated' novalidate>";
            }else {
                echo "<form class='w-25 p-3' action='index.php' method='POST' class='was-validated' novalidate>";
            }
        ?>
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <?php
                    if(!empty($nomeObrigatorio)){
                        echo '<div class="input-group has-validation was-validated">';
                    }else {
                        echo '<div class="input-group has-validation">';
                    }                   
                ?>
                    <input 
                        type="text" 
                        name="nome"                        
                        class="form-control" 
                        id="nome" 
                        placeholder="Digite seu nome" 
                        required
                        value="<?php isset($usuario)? print $usuario->nome: ''; ?>"
                    >

                    <div class="invalid-feedback">
                       <?php echo $nomeObrigatorio; ?>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <?php
                    if(!empty($emailObrigatorio)){
                        echo '<div class="input-group has-validation was-validated">';
                    }else {
                        echo '<div class="input-group has-validation">';
                    }                   
                ?>
                    <input 
                        type="email" 
                        name="email" 
                        class="form-control" 
                        id="email" 
                        placeholder="Digite seu email" 
                        required
                        value="<?php isset($usuario)? print $usuario->email: ''; ?>"
                    >

                    <div class="invalid-feedback">
                       <?php echo $campoObrigatorio; ?>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                
                <?php
                    if(!empty($senhaObrigatorio)){
                        echo '<div class="input-group has-validation was-validated">';
                    }else {
                        echo '<div class="input-group has-validation">';
                    }                   
                ?>
                    <input 
                        type="password" 
                        name="senha" 
                        class="form-control" 
                        id="senha" 
                        placeholder="Digite sua senha" 
                        required
                        value="<?php isset($usuario)? print $usuario->senha: ''; ?>"
                    >

                    <div class="invalid-feedback">
                       <?php echo $campoObrigatorio; ?>
                    </div>
                </div>
            </div>

            <button type="submit" name="enviar" id="enviar" class="btn btn-primary btn-block"> 
                <?php 
                    if(isset($_GET['id'])){
                        echo 'Editar Usuário';
                    }else {
                        echo 'Salvar Usuário';

                    }
                ?>
            </button>
        </form>
        <?php
            if((count($usuarios) < 1)) return;
        ?>
        <h1>Lista de usuários</h1>

        <table class="table w-25 p-3">
            <thead>
                <tr>
                    <th scope="col">
                        Nome
                    </th>

                    <th scope="col">
                        E-mail
                    </th>

                    <th scope="col">
                        Ações
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                    for($i=0; $i < count($usuarios); $i++){
                        echo "<tr>";
                            echo "<td>";
                                echo $usuarios[$i]->nome; 
                            echo "</td>";
                            
                            echo "<td>";
                                echo $usuarios[$i]->email; 
                            echo "</td>";

                            echo "<td class='d-flex justify-content-between'>";
                                echo "<a class='btn btn-info btn-sm' href=?id={$usuarios[$i]->id} data-toggle='tooltip' data-placement='top' title='Editar usuário' >";
                                    echo "<i class='bi bi-pencil-square'></i>";
                                echo "</a>";

                                echo "<a href=?removerId={$usuarios[$i]->id} class='btn btn-danger btn-sm' data-toggle='tooltip' data-placement='top' title='Remover usuário'>";
                                    echo "<i class='bi bi-trash3'></i>";
                                echo "</a>";
                            echo "</td>";
                        echo "</tr>"; 
                    }                   
                ?>
            </tbody>
        </table>

        <?php 
        ?>
    </div> 
    
    <script>
        function removerUsuario(id){
          const confirmar = confirm('Tem certeza que deseja remover este usuário?')

           if (confirmar) {
                const formData = new FormData()
                formData.append('id', id)

                fetch(`index.php`, {
                    method: 'POST',
                    body: formData
                })
                .then(data => console.log(data))
                .catch(error => console.log({ error }))
            } 
        }
    </script>
</body>
</body>
</html>