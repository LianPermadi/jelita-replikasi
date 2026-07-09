<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Istana Djaya Plaza</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
</head>
<style type="text/css">
    #pageloader
    {
      background: rgba( 255, 255, 255, 0.8 );
      display: none;
      height: 100%;
      position: fixed;
      width: 100%;
      z-index: 9999;
    }

    #pageloader img
    {
      left: 50%;
      margin-left: -32px;
      margin-top: -32px;
      position: absolute;
      top: 50%;
    }


    #fuelBarContainer {
  width: 200px;
  height: 20px;
  border: 1px solid #000;
  margin-top: 20px;
}

#fuelBar {
  height: 100%;
  background-color: green;
}

#fuelForm {
  margin-top: 20px;
}

  </style>
    <div id="content">
        <div class="post">
            <div class="title">
                <h2><span style="font-family: Cursive; color: navy;"><b><span id="page_name"></span></b></span></h2>
            </div>
            <div style="margin:10px">
            <h2>Form Input Keberangkatan</h2>

                <form action='/jelita/backoffice/peminjamanmobil/mobilkeluar/<?php echo $id; ?>' id="optionForm" method="POST" enctype="multipart/form-data">
                
                <div id="input-container">
                    <label for="jumlah_penumpang_1">Nama Penumpang:</label>
                    <input type="text" class="input-wrc" name="jumlah_penumpang_1[]" required>
                    <button type="button" onclick="hapusInput('input-1')" class="button-wrc"><img src="https://cdn-icons-png.flaticon.com/512/1345/1345874.png" alt="hapus" width="15px"></button>
                </div>
                <label for=""></label>
                <button type="button" onclick="tambahInput()" class="button-wrc">Tambah penumpang</button><br>
                <label for="">Tujuan Keberangkatan</label>
                <input type="hidden" class="input-wrc" name="id_peminjam" value="<?= $id_peminjam ?>" required>
                <input type="text" class="input-wrc" name="tujuan" value="" required><br>
                <label for="">Bensin Awal</label>

                <img class="img-preview img-fluid mb-3 col-sm-5" style="max-height: 250px; max-width: 250px;">
                <input type="file" class="submit-wrc" id="foto" onchange="previewImage()" name="foto1" style="width:70%;" accept=".jpg,.jpeg,.png,.JPG,.JPEG,.PNG" required="required">
                <br>
                <label for="">Bar Status</label>
                
                <table>
                    <tr>
                        <td>
                            <span>0</span>
                            <input type="radio" id="0" name="fuel" value="0" onchange="updateFuelLevel()">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>1</span>
                            <input type="radio" id="1" name="fuel" value="1" onchange="updateFuelLevel()">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>2</span>
                            <input type="radio" id="2" name="fuel" value="2" onchange="updateFuelLevel()">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>3</span>
                            <input type="radio" id="3" name="fuel" value="3" onchange="updateFuelLevel()">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>4</span>
                            <input type="radio" id="4" name="fuel" value="4" onchange="updateFuelLevel()">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>5</span>
                            <input type="radio" id="5" name="fuel" value="5" onchange="updateFuelLevel()">
                        </td>
                    </tr>
                </table>
                   <label for="">Bar Level</label>
                <table>
                    <tr>
                        <td>
                            <div id="fuelBarContainer">
                                <div id="fuelBar"></div>
                            </div>
                        </td>
                    </tr>
                </table>
                <br><br>

                <label for="chooseOption">Kondisi:</label><br>

                    <table>
                        <tr>
                            <td><label for="yes">Baik</label></td>
                            <td><input type="radio" id="01" name="kondisi" value="1" onchange="toggleTextarea()"></td>
                        </tr>
                        <tr>
                            <td><label for="no">Tidak Baik</label></td>
                            <td><input type="radio" id="02" name="kondisi" value="0" onchange="toggleTextarea()"></td>
                        </tr>
                    </table>
                
                

                
                


                <div style="display:none;" id="additionalInfo">
                <label for="additionalInfo">Catatan kondisi:</label><br>
                <textarea name="catatan_kondisi" rows="4" cols="50"></textarea><br>
                </div>

                <label for="chooseOption2">kelengkapan:</label><br>

                <table>
                        <tr>
                            <td><label for="yes1">Lengkap</label></td>
                            <td><input type="radio" id="03" name="kelengkapan" value="1" onchange="toggleTextarea2()"></td>
                        </tr>
                        <tr>
                            <td><label for="no1">Tidak Lengkap</label></td>
                            <td><input type="radio" id="04"name="kelengkapan" value="0" onchange="toggleTextarea2()"></td>
                        </tr>
                    </table>

                <br><br>

                <div style="display:none;" id="additionalInfo2">
                <label for="additionalInfo">Catatan kelengkapan:</label>
                <textarea name="catatan_kelengkapan" rows="4" cols="50"></textarea>
                </div><br>
                <!-- <label for="">Keterangan</label>
                <textarea type="text" class="input-wrc" name="keterangan_berangkat"style="background-color: white; width: 80%; border: 1px solid blue;"></textarea><br> -->
                <input type="hidden" name="keterangan_berangkat" value="-">
                <label for="">Catatan Keberangkatan</label>
                <textarea type="text" class="input-wrc" name="catatan_berangkat"style="background-color: white; width: 80%; border: 1px solid blue;"></textarea><br>

                <br><br><br><br>
                <button type="submit" class="button-wrc">Simpan</button>

                </form> 
            </div>
            </div>
        </div>
    </div>


    <script>
function toggleTextarea() {
  var optionValue = document.querySelector('input[name="kondisi"]:checked').value;
  var textarea = document.getElementById('additionalInfo');

  if (optionValue === '0') {
    textarea.style.display = 'block';
  } else {
    textarea.style.display = 'none';
  }
}


function toggleTextarea2() {
  var optionValue = document.querySelector('input[name="kelengkapan"]:checked').value;
  var textarea = document.getElementById('additionalInfo2');

  if (optionValue === '0') {
    textarea.style.display = 'block';
  } else {
    textarea.style.display = 'none';
  }
}

        function updateFuelLevel() {
  var fuelLevel = document.querySelector('input[name="fuel"]:checked').value;
  var fuelBar = document.getElementById('fuelBar');

  switch (fuelLevel) {
    case '0':
      fuelBar.style.width = '0%';
      break;
    case '1':
      fuelBar.style.width = '10%';
      break;
    case '2':
      fuelBar.style.width = '25%';
      break;
    case '3':
      fuelBar.style.width = '50%';
      break;
    case '4':
      fuelBar.style.width = '75%';
      break;
    case '5':
      fuelBar.style.width = '100%';
      break;
    default:
      fuelBar.style.width = '0%';
  }
}
    </script>
    <script>
        var counter = 2;

        function tambahInput() {
            var container = document.getElementById('input-container');

            var div = document.createElement('div');
            div.id = 'input-' + counter;

            var label = document.createElement('label');
            label.for = 'jumlah_penumpang_' + counter;
            // label.textContent = 'Nama Penumpang ' + counter + ':';
            label.textContent = 'Nama Penumpang :';

            var input = document.createElement('input');
            input.type = 'text';
            // input.name = 'jumlah_penumpang_' + counter;
            input.name = 'jumlah_penumpang_1[]';
            input.className = 'input-wrc';
            input.required = true;

            var button = document.createElement('button');
            button.className = 'button-wrc';
            button.type = 'button';

            // Membuat elemen gambar
            var img = document.createElement('img');
            img.src = 'https://cdn-icons-png.flaticon.com/512/1345/1345874.png';
            img.alt = 'hapus';
            img.width = '15';

            // Menambahkan elemen gambar ke dalam tombol
            button.appendChild(img);

            button.onclick = function() { hapusInput(div.id); };

            div.appendChild(label);
            div.appendChild(input);
            div.appendChild(button);

            container.appendChild(document.createElement('br'));
            container.appendChild(div);

            counter++;
        }

        function hapusInput(id) {
            var element = document.getElementById(id);
            element.parentNode.removeChild(element);
        }
    </script>
    
<script>
    function previewImage() {
        const image = document.querySelector('#foto');
        const imgPreview = document.querySelector('.img-preview')

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);
        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }

    var currencyInput = document.querySelectorAll( 'input[type="currency"]' );

    for ( var i = 0; i < currencyInput.length; i++ ) {

        var currency = 'IDR'
        onBlur( {
            target: currencyInput[ i ]
        } )

        currencyInput[ i ].addEventListener( 'focus', onFocus )
        currencyInput[ i ].addEventListener( 'blur', onBlur )

        function localStringToNumber( s ) {
            return Number( String( s ).replace( /[^0-9.-]+/g, "" ) )
        }

        function onFocus( e ) {
            var value = e.target.value;
            e.target.value = value ? localStringToNumber( value ) : ''
        }

        function onBlur( e ) {
            var value = e.target.value

            var options = {
                maximumFractionDigits: 0,
                currency: currency,
                style: "currency",
                currencyDisplay: "symbol"
            }

            e.target.value = ( value || value === 0 ) ?
                localStringToNumber( value ).toLocaleString( undefined, options ) :
                ''
        }
    }
</script>