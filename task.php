<?php
require __DIR__ . '/connect.php';

session_start();

if(isset($_POST['task_name'])){
    try{
        //preparando o arquivo
        if(isset($_FILES['task_image'])) {
            $ext = strtolower( substr( $_FILES['task_image']['name'], -4 ) );
            $file_name = md5( date('Y.m.d.H.i.s') ) . $ext;
            move_uploaded_file($_FILES['task_image']['tmp_name'], 'uploads/'.$file_name);
        }

        $stmt = $conn->prepare('INSERT INTO tasks (task_name, task_description, task_date, task_image) VALUES (:task_name, :task_description, :task_date, :task_image)');
        $stmt->bindParam(':task_name', $_POST['task_name']);
        $stmt->bindParam(':task_description', $_POST['task_description']);
        $stmt->bindParam(':task_date', $_POST['task_date']);

        $stmt->bindParam(':task_image', $file_name);
        $stmt->execute();

        $_SESSION['status'] = 'success';
        $_SESSION['message'] = 'Cadastrado efetuado com sucesso';
        header('Location: index.php');
    
    } catch(PDOException $e) {

        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Cadastrado não efetuado';
        header('Location: index.php');
    }
}

if(isset($_GET['task'])) {
    try{
        $stmt = $conn->prepare('DELETE FROM tasks WHERE id = :id');
        $stmt->bindParam(':id', $_GET['task']);
        $stmt->execute();
    
        $_SESSION['status'] = 'success';
        $_SESSION['message'] = 'Tarefa removida com sucesso';
        header('Location: index.php');
    
    } catch(PDOException $e) {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Erro ao Remover tarefa';
        header('Location: index.php');
    }
}



