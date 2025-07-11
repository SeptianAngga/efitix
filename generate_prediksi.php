<?php
// generate_prediksi.php
date_default_timezone_set('Asia/Jakarta');
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'efitix';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

$today = date('Y-m-d');

// 1. Cek apakah sudah ada prediksi hari ini
$cek = $conn->query("SELECT * FROM prediksi WHERE tanggal = '$today'");
if ($cek->num_rows > 0) {
    echo "Prediksi hari ini sudah ada.";
    exit;
}

// 2. Ambil data historis (3 bulan terakhir)
$data = [];
$sql = "SELECT tanggal, jumlah_terjual FROM penjualan_tiket WHERE tanggal >= DATE_SUB('$today', INTERVAL 90 DAY)";
$res = $conn->query($sql);
while ($row = $res->fetch_assoc()) {
    $data[] = $row;
}

// Hitung rata-rata terjual (Regresi Linier simulasi)
$rata2 = count($data) > 0 ? array_sum(array_column($data, 'jumlah_terjual')) / count($data) : 100;

// 3. Cek cuaca dari OpenWeatherMap
$cuaca = 'Clear';
$cuaca_api = @file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=Magelang&appid=bdca3eb1263309ab55bc411ad826d6fb&units=metric");
if ($cuaca_api) {
    $weather = json_decode($cuaca_api);
    if (isset($weather->weather[0]->main)) {
        $cuaca = $weather->weather[0]->main;
    }
}

// 4. Tambahkan pengaruh cuaca dan weekend (Random Forest simulasi)
$adjustment = 1.0;
if (in_array($cuaca, ['Rain', 'Thunderstorm'])) $adjustment -= 0.2;
elseif ($cuaca == 'Clouds') $adjustment -= 0.1;

$hari_ini = date('N');
if ($hari_ini >= 6) $adjustment += 0.25; // Sabtu/Minggu naik

// 5. Cek hari serupa dalam histori (KNN simulasi)
$cuaca_hari_ini = $cuaca;
$knn_total = 0;
$knn_count = 0;
foreach ($data as $d) {
    $tgl = $d['tanggal'];
    $cuaca_hist = 'Clear'; // dummy sementara (jika kamu ingin buat tabel cuaca harian, bisa upgrade)
    if (date('N', strtotime($tgl)) == $hari_ini) {
        $knn_total += $d['jumlah_terjual'];
        $knn_count++;
    }
}
$knn_avg = $knn_count > 0 ? $knn_total / $knn_count : $rata2;

// 6. Gabungkan
$final = intval((($rata2 + $knn_avg) / 2) * $adjustment);

// 7. Simpan
$conn->query("INSERT INTO prediksi (tanggal, jumlah_pengunjung) VALUES ('$today', $final)");
echo "Prediksi berhasil disimpan untuk tanggal $today: $final pengunjung";
