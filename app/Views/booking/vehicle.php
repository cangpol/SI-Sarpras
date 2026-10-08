<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vehicle Booking - SIM Sarpras</title>
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
    <h2>Form Peminjaman Mobil</h2>
    <div class="container">
        <div class="form-panel">
            <form id="bookingForm">
                <div>
                    <label>Pilih Mobil</label>
                    <select id="vehicle_id" name="vehicle_id" required>
                        <option value="">-- Pilih Mobil --</option>
                        <option value="1">Avanza</option>
                        <option value="2">Innova</option>
                    </select>
                </div>
                <div>
                    <label>Tujuan</label>
                    <input type="text" name="destination" required>
                </div>
                <div>
                    <label>Waktu Berangkat</label>
                    <input type="datetime-local" name="departure_time" required>
                </div>
                <div>
                    <label>Waktu Kembali</label>
                    <input type="datetime-local" name="return_time" required>
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

            document.getElementById('vehicle_id').addEventListener('change', function() {
                var vehicleId = this.value;
                if(vehicleId) {
                    calendar.removeAllEventSources();
                    calendar.addEventSource('/api/booked-slots?vehicle_id=' + vehicleId);
                } else {
                    calendar.removeAllEventSources();
                }
            });

            document.getElementById('bookingForm').addEventListener('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                fetch('/api/vehicles/bookings', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json().then(data => ({status: response.status, body: data})))
                .then(result => {
                    if (result.status === 201) {
                        document.getElementById('message').innerHTML = '<span style="color:green;">' + result.body.message + '</span>';
                        calendar.refetchEvents();
                    } else {
                        document.getElementById('message').innerHTML = '<span style="color:red;">' + (result.body.messages ? result.body.messages.error : result.body.message) + '</span>';
                    }
                });
            });
        });
    </script>
</body>
</html>

