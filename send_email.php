<?php
require __DIR__ . '/vendor/autoload.php'; // Sesuaikan path dengan kebutuhan Anda

// Setelah pengguna berhasil login dengan Google, token OAuth akan tersimpan di session
session_start();
if (!isset($_SESSION['access_token'])) {
    echo "Error: Anda belum login dengan Google.";
    exit();
}

// Buat klien Gmail
$client = new Google_Client();
$client->setAuthConfig('path/to/client_secret.json'); // Sesuaikan dengan path ke file Client Secret Anda
$client->setAccessToken($_SESSION['access_token']);

$service = new Google_Service_Gmail($client);

// Buat pesan email
$email = new Google_Service_Gmail_Message();
$email->setRaw(base64_encode("From: {$_POST['Name']} <{$_POST['Email']}>\r\n" .
    "To: farodisazhari4@gmail.com\r\n" .
    "Subject: New Comment\r\n" .
    "\r\n" .
    "{$_POST['Comment']}"));

// Kirim email
try {
    $message = $service->users_messages->send("me", $email);
    echo "Email berhasil dikirim!";
} catch (Exception $e) {
    echo "Terjadi kesalahan: " . $e->getMessage();
}
?>
