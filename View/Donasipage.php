<!DOCTYPE html>
<html>
<head>
  <title>Donasi</title>
  <link rel="stylesheet" href="../css/styleberanda.css">
  <style>
    body {
      text-align: center;
    }

    .container {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    .donation-text {
      font-size: 24px;
      margin-bottom: 20px;
    }

    .qr-code {
      width: 200px;
      height: 200px;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
    <div class="navbar">
        <?php include(__DIR__ . "/navbar.php"); ?>
    </div>

    <div class="container">
        <h1>Donasi</h1>
        <p class="donation-text">Scan kode QR di bawah untuk melakukan donasi:</p>
        <img class="qr-code" src="../image/qris.png" alt="QR Code for donation">
        <p class="donation-text">Terima kasih atas bantuan anda!</p>
    </div>

    <br><br><br><br>
    <div class="footer">
        <p>Hak Cipta &copy; 2023 Rubbish Buster. Semua hak dilindungi.</p>
        <p>Kontak: info@rubbishbuster.com | Telepon: 0856-4849-9655</p>
    </div>
</body>
</html>
