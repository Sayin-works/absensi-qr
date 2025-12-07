<!DOCTYPE html>
<html>
<head>
    <title>Scan QR Siswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
</head>
<body style="font-family: Arial, sans-serif; padding: 20px;">

    <h2>📷 Scan Kartu Siswa</h2>
    <p>Arahkan kamera ke QR Code pada kartu siswa untuk absen.</p>

    <div id="reader" style="width: 100%; max-width: 400px; margin-top: 10px;"></div>

    <div id="result" style="margin-top: 20px; font-weight: bold;"></div>

    <script>
        function onScanSuccess(decodedText, decodedResult) {
            fetch("{{ route('scan.absen') }}", { // pastikan route ini ada
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ qr_code_id: decodedText })
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById("result").innerHTML = 
                    `<span style="color:green;">✅ ${data.message}</span>`;
            })
            .catch(err => {
                document.getElementById("result").innerHTML = 
                    `<span style="color:red;">❌ Gagal menyimpan absensi</span>`;
            });
        }

        Html5Qrcode.getCameras().then(devices => {
            if (devices.length) {
                let cameraId = devices.find(d => d.label.toLowerCase().includes("back"))?.id || devices[0].id;
                const html5QrCode = new Html5Qrcode("reader");
                html5QrCode.start(cameraId, { fps: 10, qrbox: 250 }, onScanSuccess);
            } else {
                alert("Tidak ada kamera terdeteksi!");
            }
        }).catch(err => alert("Kamera gagal diakses: " + err));
    </script>

</body>
</html>
