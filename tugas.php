<?php
// fungsi keamanan
function safe($v) {
    return htmlspecialchars(trim($v ?? ""), ENT_QUOTES, 'UTF-8');
}

// ============== PROSES FORM BIODATA (POST) ==================
$nama = $nim = $prodi = $jk = $alamat = "";
$hobi_str = " - ";
$show_result = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama   = safe($_POST['nama'] ?? '');
    $nim    = safe($_POST['nim'] ?? '');
    $prodi  = safe($_POST['prodi'] ?? '');
    $jk     = safe($_POST['jk'] ?? '-');
    $alamat = safe($_POST['alamat'] ?? '');

    if (isset($_POST['hobi']) && is_array($_POST['hobi'])) {
        $hobi_clean = array_map('safe', $_POST['hobi']);
        $hobi_str = implode(", ", $hobi_clean);
    }

    if ($nama !== "") {
        $show_result = true;
    }
}

// ============== PROSES FORM PENCARIAN (GET) ==================
$pesan_cari = "";
if (isset($_GET['keyword']) && trim($_GET['keyword']) !== "") {
    $keyword = safe($_GET['keyword']);
    $pesan_cari = "Anda mencari data dengan kata kunci: <b>{$keyword}</b>";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biodata Mahasiswa & Pencarian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin:0;
            padding:20px;
            background:#f9f9f9;

            /* Center layout */
            display:flex;
            flex-direction:column;
            align-items:center;      /* center horizontal */
            justify-content:flex-start; /* kalau mau pas di tengah layar ubah ke center */
            min-height:100vh;
        }

        h2 { color:#333; }

        form, table, .result-box {
            margin-bottom:20px; 
            padding:15px; 
            border:1px solid #ccc; 
            border-radius:8px; 
            background:#fff; 
            max-width:600px; 
            width:100%;                 /* biar responsif */
            box-shadow:0 2px 5px rgba(0,0,0,0.1);
        }

        label { font-weight:bold; }

        input[type=text], select, textarea {
            width:95%; padding:8px; margin-top:5px;
            border:1px solid #aaa; border-radius:5px;
        }

        button {
            background:#4CAF50; color:white; border:none;
            padding:10px 15px; border-radius:5px; cursor:pointer;
        }
        button:hover { background:#45a049; }

        table { border-collapse: collapse; width:100%; margin-top:20px; }
        table, th, td { border:1px solid #444; padding:8px; }
        th { background:#4CAF50; color:white; text-align:left; }

        .result-box {
            margin-top:20px; padding:15px;
            border:1px solid #4CAF50; border-radius:8px;
            background:#e8f5e9;
        }
    </style>
</head>
<body>
    <h2>Form Biodata</h2>
    <form method="POST" action="">
        <label>Nama Lengkap: </label><br>
        <input type="text" name="nama" placeholder="Masukkan Nama" required><br><br>

        <label>NIM: </label><br>
        <input type="text" name="nim" placeholder="Masukkan NIM" required><br><br>

        <label>Program Studi:</label><br>
        <select name="prodi">
            <option value="Informatika">Informatika</option>
            <option value="Sistem Informasi">Sistem Informasi</option>
            <option value="Teknik Komputer">Teknik Komputer</option>
        </select><br><br>

        <label>Jenis Kelamin: </label><br>
        <input type="radio" name="jk" value="Laki-laki" required> Laki - laki
        <input type="radio" name="jk" value="Perempuan"> Perempuan <br><br>

        <label>Hobi:</label><br>
        <input type="checkbox" name="hobi[]" value="Olahraga"> Olahraga
        <input type="checkbox" name="hobi[]" value="Mancing"> Mancing
        <input type="checkbox" name="hobi[]" value="Gaming"> Gaming<br><br>

        <label>Alamat: </label><br>
        <textarea name="alamat" rows="4" cols="30"></textarea><br><br>

        <button type="submit">Kirim</button>
    </form>

    <?php if ($show_result): ?>
        <h3>Hasil Biodata:</h3>
        <table>
            <tr><th>Field</th><th>Isi</th></tr>
            <tr><td>Nama Lengkap</td><td><?php echo $nama; ?></td></tr>
            <tr><td>NIM</td><td><?php echo $nim; ?></td></tr>
            <tr><td>Program Studi</td><td><?php echo $prodi; ?></td></tr>
            <tr><td>Jenis Kelamin</td><td><?php echo $jk; ?></td></tr>
            <tr><td>Hobi</td><td><?php echo $hobi_str; ?></td></tr>
            <tr><td>Alamat</td><td><?php echo $alamat; ?></td></tr>
        </table>
    <?php endif; ?>

    <h2>Form Pencarian</h2>
    <form method="GET" action="">
        <label>Kata Kunci: </label><br>
        <input type="text" name="keyword" placeholder="Masukkan kata kunci">
        <button type="submit">Cari</button>
    </form>

    <?php if ($pesan_cari !== ""): ?>
        <div class="result-box">
            <?php echo $pesan_cari; ?>
        </div>
    <?php endif; ?>
</body>
</html>
