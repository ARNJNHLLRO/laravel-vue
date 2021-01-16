<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <script src="{{ asset('js/app.js') }}" defer></script> 
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" >
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.min.css" />
    

</head>
<body> 
    <div id="app">
        <nav class="navbar nabnar-dark bg-dark mb-3">
            <a class="navbar-brand" href="#">Calendar</a>
        </nav>

        <div class="view-container" style="padding: 10px;">
            <calendar-component />
        </div>
        <!-- <calendar-component /> -->
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>    
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.min.js" defer></script>
    <script>
    $(document).ready(function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth'
        });
        calendar.render();
    });
        
            
    </script>
</body>
</html>