<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'data.php';

/* ======================
   AMBIL PILIHAN USER
====================== */
$pilihan = $_POST['mk'] ?? [];

$mk_terpilih = [];
foreach ($pilihan as $kode) {
    if (isset($mata_kuliah[$kode])) {
        $mk_terpilih[$kode] = $mata_kuliah[$kode];
    }
}

/* ======================
   BACKTRACKING
====================== */
$hasil = [];

function valid($mk, $w, $r, $jadwal, $mk_data) {
    foreach ($jadwal as $mk_lain => $data) {
        if ($data['waktu'] === $w && $data['ruang'] === $r) return false;
        if ($data['waktu'] === $w &&
            $mk_data[$mk_lain]['dosen'] === $mk_data[$mk]['dosen']) {
            return false;
        }
    }
    return true;
}

function backtrack($i, $mk_keys, &$jadwal, &$hasil, $mk_data, $waktu, $ruang) {
    if (count($hasil) >= 10) return;

    if ($i === count($mk_keys)) {
        $hasil[] = $jadwal;
        return;
    }

    $mk = $mk_keys[$i];

    foreach ($waktu as $w) {
        foreach ($ruang as $r) {
            if (valid($mk, $w, $r, $jadwal, $mk_data)) {
                $jadwal[$mk] = ['waktu' => $w, 'ruang' => $r];
                backtrack($i + 1, $mk_keys, $jadwal, $hasil, $mk_data, $waktu, $ruang);
                unset($jadwal[$mk]);
            }
        }
    }
}

$mk_keys = array_keys($mk_terpilih);
$jadwal = [];
backtrack(0, $mk_keys, $jadwal, $hasil, $mk_terpilih, $waktu, $ruang);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Hasil Jadwal</title>

<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: Arial, sans-serif;
}

body {
  height: 100vh;
  overflow: hidden;
  background: #f2f7f4;
}

/* LAYOUT */
.page-fixed {
  height: 100vh;
  display: flex;
  flex-direction: column;
}

/* HEADER */
.header-fixed {
  background: #0b6b43;
  color: white;
  padding: 16px 24px;
}

.header-fixed h1 {
  font-size: 22px;
}

.header-fixed p {
  font-size: 14px;
  opacity: 0.9;
}

/* CONTENT */
.content-scroll {
  flex: 1;
  overflow-y: auto;
  padding: 20px;
}

/* GRID */
.solutions-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
  gap: 20px;
}

/* CARD */
.solution-card {
  background: white;
  border-radius: 12px;
  padding: 14px;
  box-shadow: 0 4px 10px rgba(0,0,0,.08);
}

.solution-card h3 {
  margin-bottom: 10px;
  color: #0b6b43;
  font-size: 16px;
}

/* TABLE */
table {
  width: 100%;
  border-collapse: collapse;
  font-size: 13px;
}

th {
  background: #0b6b43;
  color: white;
  padding: 6px;
}

td {
  padding: 6px;
  border-bottom: 1px solid #ddd;
  text-align: center;
}

tr:nth-child(even) {
  background: #f6f6f6;
}
</style>
</head>

<body>

<div class="page-fixed">

  <div class="header-fixed">
    <h1>Hasil Jadwal Mata Kuliah</h1>
    <p>Scroll ke bawah untuk melihat Solusi 1 – 10</p>
  </div>

  <div class="content-scroll">
    <div class="solutions-grid">

      <?php if (empty($hasil)): ?>
        <p>Tidak ada solusi jadwal.</p>
      <?php endif; ?>

      <?php foreach ($hasil as $i => $solusi): ?>
      <div class="solution-card">
        <h3>Solusi <?= $i + 1 ?></h3>

        <table>
          <tr>
            <th>Mata Kuliah</th>
            <th>Dosen</th>
            <th>Waktu</th>
            <th>Ruang</th>
          </tr>

          <?php foreach ($solusi as $kode => $jad): ?>
          <tr>
            <td><?= $mk_terpilih[$kode]['nama'] ?></td>
            <td><?= $mk_terpilih[$kode]['dosen'] ?></td>
            <td><?= $jam[$jad['waktu']] ?></td>
            <td><?= $jad['ruang'] ?></td>
          </tr>
          <?php endforeach; ?>
        </table>
      </div>
      <?php endforeach; ?>

    </div>
  </div>

</div>

</body>
</html>
