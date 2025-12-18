<?php
require_once __DIR__ . '/functions.php';
require_login();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Appointments Calendar</title>
  <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.css' rel='stylesheet' />
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
  <style>
    #calendar { max-width: 1100px; margin: 40px auto; }
  </style>
</head>
<body>
  <div style="max-width:1200px; margin:20px auto; padding:10px;">
    <h2>Appointments Calendar</h2>
    <div id="calendar"></div>
  </div>

  <script>
  document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      events: '/HMS/appointments_api.php',
      eventClick: function(info) {
        // optional: follow event's URL if set
        if (info.event.url) {
          window.open(info.event.url, '_blank');
          info.jsEvent.preventDefault();
        }
      }
    });
    calendar.render();
  });
  </script>
</body>
</html>
