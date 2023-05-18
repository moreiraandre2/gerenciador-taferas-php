<?php
require __DIR__ . '/connect.php';

session_start();

$stmt = $conn->prepare('SELECT * FROM tasks;');
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$data = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Tarefas</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="header">
            <?php
                if(isset($_SESSION['status']) && $_SESSION['status'] == 'success') {
                    echo '<div class="alert-success">'.
                        $_SESSION['message']
                    .'</div>';
                }

                if(isset($_SESSION['status']) && $_SESSION['status'] == 'error') {
                    echo '<div class="alert-error">'.
                        $_SESSION['message']
                    .'</div>';
                }
            ?>
            <h1>Gerenciador de Tarefas</h1>
        </div>
        <div class="form">
            <form action="task.php" method="post" enctype="multipart/form-data">
                <label for="task_name">Tarefa: </label>
                <input type="text" name="task_name" placeholder="Nome da Tarefa">
                <label for="task_description">Descrição: </label>
                <input type="text" name="task_description" placeholder="Descrição da Tarefa">
                <label for="task_date">Data: </label>
                <input type="datetime-local" name="task_date">
                <label for="task_image">Imagem: </label>
                <input type="file" name="task_image">
                <button type="submit">Cadastrar</button>
            </form>
        </div>
        <div class="separator">

        </div>        
        <div class="list-tasks">
            <a class="btn-calendar" href="calendario.php">Abrir Calendario</a>
            <ul>
                <?php
                foreach($data as $task) {
                echo '<li>
                        <a class="a" href="details.php?task='.$task['id'].'">'. $task['task_name'].'</a>
                        <button type="button" onclick="remove'.$task['id'].'('.$task['id'].')">Remover</button>
                    </li>
                    <script>
                        function remove'.$task['id'].'(id) {
                            if(confirm("Deseja remover?")) {
                                window.location = "http://localhost:10000/task.php?task='.$task['id'].'"
                            }
                        }
                    </script>
                    ';
                }
                ?>
            </ul>
        </div>
        <div class="footer">
            <p>Desenvolvido por @andremoreira360</p>
        </div>
    </div>
</body>
</html>