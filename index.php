<?php include 'data.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pilih Mata Kuliah</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="page">

    <h1 class="page-title">Pilih Mata Kuliah</h1>

    <div class="hero">

        <!-- GAMBAR KIRI -->
        <div class="hero-image">
            <img src="img/hero.jpg" alt="Jadwal Kuliah">
        </div>

        <!-- TABEL KANAN -->
        <div class="hero-form">
            <form method="post" action="proses.php">
                <table>
                    <tr>
                        <th>Pilih</th>
                        <th>Mata Kuliah</th>
                        <th>Dosen</th>
                    </tr>

                    <?php foreach ($mata_kuliah as $kode => $mk): ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="mk[]" value="<?= $kode ?>" checked>
                        </td>
                        <td><?= $mk['nama'] ?></td>
                        <td><?= $mk['dosen'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>

                <button type="submit">Generate Jadwal</button>
            </form>
        </div>

    </div>
</div>

</body>
</html>
