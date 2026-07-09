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

    <table id="dynamicTable">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Deskripsi</th>
        </tr>
    </thead>
    <tbody>
        <!-- Data awal -->
        <tr>
            <td>1</td>
            <td>Barang 1</td>
            <td>Deskripsi 1</td>
        </tr>
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

        cell1.innerHTML = table.rows.length;
        cell2.innerHTML = "<input type='text' name='nama[]'>";
        cell3.innerHTML = "<input type='text' name='deskripsi[]'>";
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