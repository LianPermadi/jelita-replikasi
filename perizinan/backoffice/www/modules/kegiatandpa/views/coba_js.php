<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Inputs</title>
    <style>
        .input-group {
            margin-bottom: 10px;
        }
        label {
            display: block;
        }
        input[type="text"] {
            width: 100%;
            box-sizing: border-box;
        }
    </style>
</head>
<body>

    <table id="aktivitasTable">
  <tr>
    <td align="left" width="15%" class="bg-grid">
      <b>Kegiatan</b>
    </td>
    <td class="bg-grid">
      <textarea name="aktivitas[]" style="width:100%" class="input-area-wrc" required readonly><?php echo $aktivitas; ?></textarea>
    </td>
  </tr>
  <tr>
    <td align="left" width="15%">
      <b>Aktivitas</b>
    </td>
    <td>
      <textarea name="renaksi[]" style="width:100%" class="input-area-wrc" required><?php echo $renaksi; ?></textarea>
    </td>
  </tr>
</table>
<button type="button" onclick="tambahBaris()">Tambah Baris</button>

<script>
  function tambahBaris() {
    var table = document.getElementById("aktivitasTable");
    var row = table.insertRow(-1);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    cell1.innerHTML = '<textarea name="aktivitas[]" style="width:100%" class="input-area-wrc" required readonly></textarea>';
    cell2.innerHTML = '<textarea name="renaksi[]" style="width:100%" class="input-area-wrc" required></textarea>';
  }
</script>

    <table id="dynamicTable">
    <thead>
        <tr>
            <th>No</th>
            <th>Aktivitas</th>
            <th>Pelaksana Tugas</th>
            <th>Realisasi Anggaran</th>
            <th>Target Aktivitas</th>
            <th>Satuan</th>
            <th>Tanggal Rencana</th>
            <th>Tanggal Realisasi</th>
        </tr>
    </thead>
    <tbody>
        <!-- Data awal -->
<!--         <tr>
            <td>1</td>
            <td>Barang 1</td>
            <td>Deskripsi 1</td>
        </tr> -->
    </tbody>
</table>

<button onclick="addRow()">Tambah Baris</button>

<script>
    function addRow() {
        var table = document.getElementById("dynamicTable").getElementsByTagName('tbody')[0];
        var newRow = table.insertRow(table.rows.length);

        var cell1 = newRow.insertCell(0);
        var cell2 = newRow.insertCell(1);
        var cell3 = newRow.insertCell(2);
        var cell4 = newRow.insertCell(3);
        var cell5 = newRow.insertCell(4);
        var cell6 = newRow.insertCell(5);
        var cell7 = newRow.insertCell(6);
        var cell8 = newRow.insertCell(7);

        cell1.innerHTML = table.rows.length;
        cell2.innerHTML = "<input type='text' name='aktivitas[]'>";
        cell3.innerHTML = "<input type='text' name='pelaksana[]'>";
        cell4.innerHTML = "<input type='text' name='realisasi[]'>";
        cell5.innerHTML = "<input type='text' name='terget[]'>";
        cell6.innerHTML = "<input type='text' name='satuan[]'>";
        cell7.innerHTML = "<input type='text' name='rencana[]'>";
        cell8.innerHTML = "<input type='text' name='selesai[]'>";
    }
</script>



<label for="jumlahInput">Masukkan jumlah input: </label>
<input type="number" id="jumlahInput" min="1" onchange="generateInputs()">

<div id="inputContainer">
    <!-- Tempat untuk menampilkan inputan dinamis -->
</div>

<script>
    function generateInputs() {
        // Mendapatkan nilai dari input jumlahInput
        var jumlahInput = document.getElementById('jumlahInput').value;

        // Mengosongkan container input
        document.getElementById('inputContainer').innerHTML = '';

        // Membuat inputan sebanyak jumlahInput
        for (var i = 1; i <= jumlahInput; i++) {
            var inputGroup = document.createElement('div');
            inputGroup.className = 'input-group';

            var inputLabel1 = document.createElement('label');
            inputLabel1.textContent = 'Target';

            var inputTarget = document.createElement('input');
            inputTarget.type = 'text';
            inputTarget.name = 'target_' + i;
            inputTarget.placeholder = 'Target ' + i;

            var inputLabel2 = document.createElement('label');
            inputLabel2.textContent = 'Realisasi';

            var inputRealisasi = document.createElement('input');
            inputRealisasi.type = 'text';
            inputRealisasi.name = 'realisasi_' + i;
            inputRealisasi.placeholder = 'Realisasi ' + i;

            // Menambahkan label dan input ke dalam container
            inputGroup.appendChild(inputLabel1);
            inputGroup.appendChild(inputTarget);
            inputGroup.appendChild(inputLabel2);
            inputGroup.appendChild(inputRealisasi);

            document.getElementById('inputContainer').appendChild(inputGroup);
        }
    }
</script>

</body>
</html>