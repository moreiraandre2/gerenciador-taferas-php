<?php
require __DIR__ . '/connect.php';

session_start();

$stmt = $conn->prepare('SELECT * FROM tasks;');
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$data = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Tarefas</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
    <link href='../lib/main.css' rel='stylesheet' />
    <script src='../lib/main.js'></script>
    <script src='../lib/locales/pt-br.js'></script>
    <script>

    document.addEventListener('DOMContentLoaded', function() {
        var events = [];
        
        <?php
            foreach($data as $task) {
                echo "events.push( { title: '".$task['task_name']."', start: '".$task['task_date']."', url: 'details.php?task=".$task['id']."' } ); ";
            }

            
        ?>

        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
        height: '80%',
        expandRows: true,
        slotMinTime: '08:00',
        slotMaxTime: '20:00',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        initialView: 'dayGridMonth',
        initialDate: Date.now(),
        navLinks: true, // can click day/week names to navigate views
        // editable: true,
        // selectable: true,
        nowIndicator: true,
        dayMaxEvents: true, // allow "more" link when too many events
        locale: 'pt-br',
        events: events
        });

        calendar.render();
    });

    </script>

</head>
<body>

    <div id='calendar-container'>
        <div class="header">
            <h1>Gerenciador de Tarefas</h1>
            <h2>Calendario</h2>
        </div>
        
        <div id='calendar'></div>
    </div>

  

</body>
</html>
