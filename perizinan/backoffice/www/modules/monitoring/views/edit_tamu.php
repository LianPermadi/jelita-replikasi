<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>
    
    <?php 
    $alert = $this->session->flashdata("sukses");
    if(!empty($alert)){
      ?>
      <br>
      <div style="color: green; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
      <?php
    }
    ?>
    
    <?php 
    $alert = $this->session->flashdata("gagal");
    if(!empty($alert)){
    }
    ?>
    <?php
    if ($this->session->flashdata('error')) {
      ?>
      <div class="alert alert-danger" role="alert" style="text-align:center;">
        <?php echo $this->session->flashdata('error'); ?>
      </div>
      <br>
      <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
      <?php
    }
    if ($this->session->flashdata('success')) {
      ?>
      <div class="alert alert-danger" role="alert" style="text-align:center;">
        <?php echo $this->session->flashdata('success'); ?>
      </div>
      <?php
    }
    ?>
    
    <form method="post" action="<?php echo site_url().'monitoring/wjisguest/update_guest_information/'.$data_tamu->id; ?>" enctype="multipart/form-data">
      <div class="entry">
        <div id="tabs">
          <ul>
            <li><a href="#tabs-1">Ubah Data</a></li>
          </ul>
          <div id="tabs-1">
            <table cellpadding="0" cellspacing="0" border="0" class="display">
              <tbody>
              	<tr>
                  <td align="left" width="15%">
                    <b></b>
                  </td>
                  <td>
                    <b>
                      <?php
                      echo '<span style="color: Red">';
                      if(empty($data_user) && $data_tamu->status == '0'){
                      	echo 'Data Belum Dikonfirmasi';
                      }else{
                      	if($data_tamu->status == '1'){ //proses konfirmasi
                          echo 'Dalam Proses Konfirmasi oleh : '.$data_user->oriname;
                        }else{
                          echo 'Telah dikonfirmasi oleh : '.$data_user->oriname;
                        }
                      }
                      echo '</span>';
                      ?>
                    </b>
                  </td>
                </tr>
                <tr>
                  <td><b></b></td>
                  <td><b></b></td>
                </tr>
                <tr>
                  <td align="left" width="15%">
                    <b>Nama Pemohon</b>
                  </td>
                  <td>
                    <input type="text" class="input-wrc" style="width:100%" name="full_name" value="<?php echo $data_tamu->full_name; ?>">
                  </td>
                </tr>
                <!-- <tr>
                  <td align="left" width="15%" class="bg-grid"><b>Tanggal lahir</b></td>
                  <td class="bg-grid">
                      <input type="text" class="input-wrc" style="width:100%" name="date_of_birth" value="<?= $data_tamu->date_of_birth ?>">
                  </td>
                </tr> -->
                <tr>
                  <td align="left" width="15%"><b>Nomor WA (Whatsapp)</b></td>
                  <td>
                    <input type="text" class="input-wrc" style="width:100%" name="phone_number" value="<?= $data_tamu->phone_number ?>">
                  </td>
                </tr>
                <tr>
                  <td align="left" width="15%"><b>Position</b></td>
                  <td>
                    <input type="text" class="input-wrc" style="width:100%" name="position" value="<?= $data_tamu->position ?>">
                  </td>
                </tr>
                <tr>
                  <td align="left" width="15%"><b>Company</b></td>
                  <td>
                    <input type="text" class="input-wrc" style="width:100%" name="company" value="<?= $data_tamu->company ?>">
                  </td>
                </tr>
                <tr>
                  <td align="left" width="15%"><b>Countries</b></td>
                  <td>
                    <input type="text" class="input-wrc" style="width:100%" name="countries" value="<?= $data_tamu->countries ?>">
                  </td>
                </tr>
                <tr>
                    <td align="left" width="15%"><b>Investation</b></td>
                    <td>
                        <input type="text" class="input-wrc" style="width:100%" name="investation" value="<?= $data_tamu->investation ?>">
                    </td>
                </tr>
                <tr>
                  <td align="left" width="15%"><b>Alamat</b></td>
                  <td>
                    <input type="text" class="input-wrc" style="width:100%" name="address" value="<?= $data_tamu->address ?>">
                  </td>
                </tr>
                <tr>
                  <td align="left" width="15%"><b>Alamat Email</b></td>
                  <td>
                    <input type="text" class="input-wrc" style="width:100%" name="email" value="<?= $data_tamu->email ?>">
                  </td>
                </tr>
                <tr>
                    <td align="left" width="15%"><b>Nomor Kursi</b></td>
                    <td>
                        <input type="text" class="input-wrc" style="width:100%; text-transform: uppercase;" name="no_kursi" value="<?= htmlspecialchars($data_tamu->no_kursi) ?>">
                    </td>
                </tr>

                <tr>
                  <td align="left" width="15%"><b>RSVP Information</b></td>
                  <td>
                    <?php
                    // Data RSVP_Information dari database
                    $rsvp_data = explode(", ", $data_tamu->RSVP_Information);
                    
                    // Daftar semua opsi RSVP
                    $rsvp_options = ["Ceremony" => "Ceremony",
                                     "Project Presentation" => "Project Presentation",
                                     "One On One Meeting" => "One On One Meeting",
                                     "Exhibition" => "Exhibition",
                                     "Talkshow" => "Talkshow"
                                    ];
                    
                    // Generate checkbox
                    foreach($rsvp_options as $value => $label){
                      $checked = in_array(strtolower($value), array_map('strtolower', $rsvp_data)) ? 'checked' : '';
                      echo '<input type="checkbox" name="RSVP_Information[]" value="' . $value . '" id="' . $value . '" ' . $checked . '/>' . $label;
                    }
                    ?>
                  </td>
                </tr>
                <tr>
                  <td align="left" width="15%" style="vertical-align:top;"  style="margin-top:30%;"><b>Purpose Of Visit</b></td>
                  <td>
                    <table cellpadding="0" cellspacing="0" border="1" class="display">
                      <tr>
                        <th>No</th>
                        <th>Kegiatan</th>
                        <th>Pembicara/Talent</th>
                        <th>Project Presentation</th>
                        <th>One On One Meeting</th>
                      </tr>
                      <?php 
                      $nomor = 1; 
                      foreach($data_rowndown as $acara){ 
                        $checked_project = ''; // Default tidak dicentang
                        $checked_meeting = ''; // Default tidak dicentang
                        // Periksa apakah event_id ada dalam data_event_selection
                        foreach($data_event_selection as $event){
                          if($event->project_presentasion_event_id == $acara->id){
                            $checked_project = 'checked';
                            break;
                          }
                        }
                        foreach($data_event_selection_one_on_meeting as $event){
                          if($event->one_on_one_meeting_id == $acara->id){
                            $checked_meeting = 'checked';
                            break;
                          }
                        }
                        if($acara->kegiatan === "Project Presentation"){
                          ?>
                          <tr>
                            <td colspan="7" style="text-align: center;"><?php echo htmlspecialchars($acara->kegiatan); ?></td>
                          </tr>
                          <?php
                        }else{
                          ?>
                            <tr>
                                <?php
                                // Periksa status_tampil untuk menentukan apakah nilai checkbox dan teks waktu perlu diubah
                                $showSold = $acara->status_tampil == 2;

                                if ($acara->no_urut > 0) {
                                    // Jika kondisi showSold berlaku
                                    $projectCheckboxValue = $showSold ? '' : htmlspecialchars($acara->id);
                                    $meetingCheckboxValue = $showSold ? '' : htmlspecialchars($acara->id);
                                    $timeLabel = $showSold ? 'SOLD' : $acara->waktu_start . ' - ' . $acara->waktu_end;
                                    $oomTimeLabel = $showSold ? 'SOLD' : $acara->oom_start . ' - ' . $acara->oom_end;

                                    ?>
                                    <td><?php echo htmlspecialchars($acara->no_urut); ?></td>
                                    <td><?php echo htmlspecialchars($acara->kegiatan); ?></td>
                                    <td><?php echo htmlspecialchars($acara->pembicara_talent); ?></td>
                                    <td>
                                        <?php if (!$showSold) { ?>
                                            <input type="checkbox" id="project_<?php echo $acara->id; ?>" name="project_presentasion_event_id[]" value="<?php echo $projectCheckboxValue; ?>" style="height: 20px;width: 20px;"
                                            <?php echo $checked_project; ?>>
                                        <?php } ?>
                                        <?php echo $timeLabel; ?>
                                    </td>
                                    <td>
                                        <?php if (!$showSold) { ?>
                                            <input type="checkbox" id="meeting_<?php echo $acara->id; ?>" name="one_on_one_meeting_event_id[]" value="<?php echo $meetingCheckboxValue; ?>" style="height: 20px;width: 20px;" 
                                            <?php echo $checked_meeting; ?>>
                                        <?php } ?>
                                        <?php echo $oomTimeLabel; ?>
                                    </td>
                                    <?php
                                } else {
                                    $keg = '<strong style="color: black; text-transform: uppercase;">' . $acara->kegiatan . '</strong>';
                                    ?>
                                    <td colspan="7" class="text-center text-white"><?php echo $keg; ?></td>
                                    <?php
                                }
                                ?>
                            </tr>
                          <?php 
                        }
                      }
                      ?>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td align="left" width="15%"><b>Status Kehadiran:</b></td>
                  <td>
                    <select style="width:100%" name="status" id="status" class="pilihan">
                      <!--<option value="" selected disabled>Pilih Status Kehadiran :</option>-->
                      <option value="0" <?php if($data_tamu->status == '0'){ echo 'selected'; } ?>>Belum Dikonfirmasi</option>
                      <option value="1" <?php if($data_tamu->status == '1'){ echo 'selected'; } ?>>Proses Konfirmasi</option>
                      <option value="2" <?php if($data_tamu->status == '2'){ echo 'selected'; } ?>>Hadir</option>
                      <option value="3" <?php if($data_tamu->status == '3'){ echo 'selected'; } ?>>Tidak Hadir</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td align="left" width="15%"><b>Souvenir DPMPTSP</b></td>
                  <td>
                    <?php
                    // Data souvenir dari database
                    $rsvp_data = explode(", ", $data_tamu->souvenir);
                    
                    // Daftar semua opsi RSVP
                    $rsvp_options = ["1" => "ya",
                                     "0" => "Tidak",
                                    ];
                    
                    // Generate checkbox
                    foreach($rsvp_options as $value => $label){
                      $checked = in_array(strtolower($value), array_map('strtolower', $rsvp_data)) ? 'checked' : '';
                      echo '<input type="radio" name="souvenir" value="' . $value . '" id="' . $value . '" ' . $checked . '/>' . $label;
                    }
                    ?>
                  </td>
                </tr>
                <tr>
                  <td align="left" width="15%"><b>Souvenir Bank Indonesia</b></td>
                  <td>
                    <?php
                    // Data souvenir dari database
                    $rsvp_data = explode(", ", $data_tamu->souvenir_bank_indonesia);
                    
                    // Daftar semua opsi RSVP
                    $rsvp_options = ["1" => "ya",
                                     "0" => "Tidak",
                                    ];
                    
                    // Generate checkbox
                    foreach($rsvp_options as $value => $label){
                      $checked = in_array(strtolower($value), array_map('strtolower', $rsvp_data)) ? 'checked' : '';
                      echo '<input type="radio" name="souvenir_bank_indonesia" value="' . $value . '" id="' . $value . '" ' . $checked . '/>' . $label;
                    }
                    ?>
                  </td>
                </tr>
                
                <tr>
                  <td align="left" width="15%"><b>Keterangan</b></td>
                  <td>
                    <textarea type="text" class="textarea-wrc" style="width:100%; height: 100px;" name="Keterangan" value=""><?php echo htmlspecialchars($data_tamu->keterangan); ?></textarea>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <label>&nbsp;</label>
        <div class="spacer"></div>
      </div>
      <div class="entry" style="text-align: center;">
        <?php
        $p_user = 0;
        if(!empty($data_user)){
          $p_user = $data_user->id;
        }
        if($p_user == $id_user) {
        	?>
         <input type="submit" name="submit" value="Simpan" class="submit-wrc" content="Simpan">
          <?php
        }else{
          ?>
         <input type="submit" name="submit" value="Ubah" class="submit-wrc" content="Ubah"> 
          <?php
        }
        ?>
        <span></span>
        <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('monitoring/wjisguest'); ?>'">Batal</button>
      </div>
    </form>
  </div>
  <br style="clear: both;" />
</div>
<script>
  document.addEventListener('DOMContentLoaded', function() {
      var oneOnOneMeetingCheckbox = document.getElementById('project_presentation');
      var oneOnOneMeetingTable = document.getElementById('oneOnOneMeetingTable');

      // Function to show or hide the table based on checkbox status
      function toggleTableVisibility() {
          if (oneOnOneMeetingCheckbox.checked) {
              oneOnOneMeetingTable.style.display = 'table';
          } else {
              oneOnOneMeetingTable.style.display = 'none';
          }
      }

      // Add event listener to the checkbox
      oneOnOneMeetingCheckbox.addEventListener('change', toggleTableVisibility);

      // Initial check
      toggleTableVisibility();
  });
</script>
<script>
  // Data dari database
  var rsvpData = "<?php echo $data_tamu->RSVP_Information; ?>";
  console.log(rsvpData);
  // Memecah data menjadi array
  var rsvpArray = rsvpData.split(", ");
  
  // Loop melalui semua checkbox
  rsvpArray.forEach(function(value) {
    // Menghilangkan spasi pada nilai
    var normalizedValue = value.toLowerCase().replace(/\s+/g, '_');
    var checkbox = document.getElementById(normalizedValue.charAt(0).toUpperCase() + normalizedValue.slice(1));
    if (checkbox) {
        checkbox.checked = true;
    }
  });
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
