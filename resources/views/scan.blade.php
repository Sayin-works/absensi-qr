<!DOCTYPE html>
<html>
<head>
    <title>Scan QR Siswa</title>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
</head>
<body>
    <h2>Scan Kartu Siswa</h2>
    <div id="reader" style="width: 400px;"></div>

    <script>
        function onScanSuccess(decodedText, decodedResult) {
            fetch("/scan-absen", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ qr_code_id: decodedText })
            })
            .then(res => res.json())
            .then(data => alert(data.message))
            .catch(err => alert("Gagal menyimpan absensi"));
        }

        const html5QrCode = new Html5Qrcode("reader");
        html5QrCode.start({ facingMode: "environment" }, { fps: 10, qrbox: 250 }, onScanSuccess);
    </script>
</body>
</html>