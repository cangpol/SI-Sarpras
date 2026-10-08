<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Room Booking - SIM Sarpras</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .container { display: flex; gap: 20px; }
        .form-panel { flex: 1; }
        .calendar-panel { flex: 2; }
        form div { margin-bottom: 10px; }
        label { display: block; margin-bottom: 5px; }
        input, select { width: 100%; padding: 8px; box-sizing: border-box; }
        button { padding: 10px 20px; background: #007bff; color: #fff; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <h2>Form Peminjaman Ruangan</h2>
    <div class="container">
        <div class="form-panel">
            <form id="bookingForm">
                <div>
                    <label>Pilih Ruangan</label>
                    <select id="room_id" name="room_id" required>
                        <option value="">-- Pilih Ruangan --</option>
                        <option value="1">Excellence</option>
                        <option value="2">Compassion</option>
                        <option value="3">Integrity</option>
                        <option value="4">Auditorium</option>
                        <option value="5">Multi Function Hall</option>
                    </select>
                </div>
                <div>
                    <label>Nama Acara</label>
                    <input type="text" name="event_name" required>
                </div>
                <div>
                    <label>Mulai</label>
                    <input type="datetime-local" name="start_time" required>
                </div>
                <div>
                    <label>Selesai</label>
                    <input type="datetime-local" name="end_time" required>
                </div>
                <div>
                    <label>Jumlah Peserta</label>
                    <input type="number" name="total_attendees">
                </div>
                <button type="submit">Ajukan Peminjaman</button>
            </form>
            <p id="message"></p>
        </div>
        <div class="calendar-panel">
            <div id="calendar"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: []
            });
            calendar.render();

            document.getElementById('room_id').addEventListener('change', function() {
                var roomId = this.value;
                if(roomId) {
                    calendar.removeAllEventSources();
                    calendar.addEventSource('/api/booked-slots?room_id=' + roomId);
                } else {
                    calendar.removeAllEventSources();
                }
            });

            document.getElementById('bookingForm').addEventListener('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                fetch('/api/rooms/bookings', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json().then(data => ({status: response.status, body: data})))
                .then(result => {
                    if (result.status === 201) {
                        document.getElementById('message').innerHTML = '<span style="color:green;">' + result.body.message + '</span>';
                        calendar.refetchEvents();
                    } else {
                        document.getElementById('message').innerHTML = '<span style="color:red;">' + result.body.messages.error + '</span>';
                    }
                });
            });
        });
    </script>
</body>
</html>

