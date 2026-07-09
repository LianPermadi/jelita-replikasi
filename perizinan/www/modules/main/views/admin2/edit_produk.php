          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms /</span> Basic Inputs</h4>
              <?php  ?>
                <?php foreach ($detail_produk as $row) { ?>
              <div class="row">
                <div class="col-md-10">
                  <div class="card mb-4">
              <form method="post" action="/jelita/main/cms/update/<?php echo $row->id; ?>" enctype="multipart/form-data">
                    <h5 class="card-header">Default</h5>
                    <div class="card-body">
                      <div>
                        <label for="defaultFormControlInput" class="form-label">Name</label>
                        <input
                          type="text"
                          name="nama"
                          class="form-control"
                          id="defaultFormControlInput"
                          placeholder="John Doe"
                          aria-describedby="defaultFormControlHelp"
                          value="<?php echo $row->nama; ?>"
                        />
                        <div id="defaultFormControlHelp" class="form-text">
                          Name
                        </div>
                      </div>
                    </div>
                    <div class="card-body">
                      <div>
                        <label for="defaultFormControlInput" class="form-label">Harga</label>
                        <input
                          type="text"
                          name="harga"
                          class="form-control"
                          id="defaultFormControlInput"
                          placeholder="John Doe"
                          aria-describedby="defaultFormControlHelp"
                          value="<?php echo $row->harga; ?>"
                        />
                        <div id="defaultFormControlHelp" class="form-text">
                          Harga
                        </div>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="form-floating">
                        <div>
                            <label for="defaultFormControlInput" class="form-label">Reviews</label>
                            <textarea
                            type="text"
                            class="form-control"
                          name="reviews"
                            id="defaultFormControlInput"
                            placeholder="John Doe"
                            aria-describedby="defaultFormControlHelp"
                            value=""
                            ><?php echo $row->reviews; ?></textarea>
                            <div id="defaultFormControlHelp" class="form-text">
                            Reviews
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="form-floating">
                        <div>
                            <label for="defaultFormControlInput" class="form-label">Keterangan</label>
                            <textarea
                            type="text"
                            class="form-control"
                          name="keterangan"
                            id="defaultFormControlInput"
                            placeholder="John Doe"
                            aria-describedby="defaultFormControlHelp"
                            value=""
                            ><?php echo $row->keterangan; ?></textarea>
                            <div id="defaultFormControlHelp" class="form-text">
                            Keterangan
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-body">
                      <div>
                        <label for="defaultFormControlInput" class="form-label">availability</label>
                        <input
                          type="text"
                          class="form-control"
                          name="availability"
                          id="defaultFormControlInput"
                          placeholder="John Doe"
                          aria-describedby="defaultFormControlHelp"
                          value="<?php echo $row->availability; ?>"
                        />
                        <div id="defaultFormControlHelp" class="form-text">
                          availability
                        </div>
                      </div>
                    </div>
                    <div class="card-body">
                      <div>
                        <label for="defaultFormControlInput" class="form-label">Shipping</label>
                        <input
                          type="text"
                          class="form-control"
                          name="shipping"
                          id="defaultFormControlInput"
                          placeholder="John Doe"
                          aria-describedby="defaultFormControlHelp"
                          value="<?php echo $row->shipping; ?>"
                        />
                        <div id="defaultFormControlHelp" class="form-text">
                          Shipping
                        </div>
                      </div>
                    </div>
                    <div class="card-body">
                      <div>
                        <label for="defaultFormControlInput" class="form-label">Weight</label>
                        <input
                          type="text"
                          class="form-control"
                          name="weight"
                          id="defaultFormControlInput"
                          placeholder="John Doe"
                          aria-describedby="defaultFormControlHelp"
                          value="<?php echo $row->weight; ?>"
                        />
                        <div id="defaultFormControlHelp" class="form-text">
                          Weight
                        </div>
                      </div>
                    </div>
                    <div class="card-body">
                      <div>
                        <label for="defaultFormControlInput" class="form-label">Foto</label>
                    <?php 
                                $string = $row->foto;
                                $array = explode("^", $string);
                    foreach ($array as $data) {
                      if($data != '' || $data != NULL){
                        # code... ?>
                        <input
                          type="text"
                          class="form-control"
                          id="defaultFormControlInput"
                          placeholder="John Doe"
                          aria-describedby="defaultFormControlHelp"
                          name="foto[]"
                          value="<?php echo $data; ?>"
                        />
                                      <?php if ($data) { ?>
                                        <img 
                                        src="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/product/details/<?php echo $data; ?>"
                                        class="img-preview img-fluid mb-3 col-sm-5"  
                                        style="max-height: 250px; max-width: 250px;"
                                        >
                                      <?php }else{ ?>
                                        <img 
                                        class="img-preview img-fluid mb-3 col-sm-5" 
                                        style="max-height: 250px; max-width: 250px;"
                                        >
                                      <?php } ?>
                                      <!-- <input class="form-control" type="file" id="formFileMultiple" multiple /> -->
                                        <input type="file" class="form-control" id="foto" onchange="previewImage()" name="foto1" style="width:100%;" accept=".jpg,.jpeg,.png,.JPG,.JPEG,.PNG" value="">
                                        <!-- <input type="text"  value="<?php echo $row->foto; ?>"> -->
                    <br>
                    <br>
                    <br>
                    <?php 
                    }
                   } ?>
                        <div id="defaultFormControlHelp" class="form-text">
                          foto
                        </div>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="form-floating">
                        <div>
                            <label for="defaultFormControlInput" class="form-label">Deskripsi</label>
                            <textarea
                            type="text"
                            class="form-control"
                            id="defaultFormControlInput"
                          name="deskripsi"
                            placeholder="John Doe"
                            aria-describedby="defaultFormControlHelp"
                            value=""
                            ><?php echo $row->deskripsi; ?></textarea>
                            <div id="defaultFormControlHelp" class="form-text">
                            Deskripsi
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-body">
                      <div>
                        <label for="defaultFormControlInput" class="form-label">Informasi</label>
                        <input
                          type="text"
                          class="form-control"
                          id="defaultFormControlInput"
                          name="informasi"
                          placeholder="John Doe"
                          aria-describedby="defaultFormControlHelp"
                          value="<?php echo $row->informasi; ?>"
                        />
                        <div id="defaultFormControlHelp" class="form-text">
                          Informasi
                        </div>
                      </div>
                    </div>
                      <div class="card-body">
                        <label for="exampleFormControlSelect1" class="form-label">Kategori</label>
                        <select class="form-select"
                          name="kategori" id="exampleFormControlSelect1" aria-label="Default select example">
                          <option value='-'>-</option>
                          <?php foreach ($kategori as $data) { ?>
                          <option value="<?php echo $data->id; ?>" <?php if($data->id == $row->kategori){ echo 'selected'; } ?>><?php echo $data->kategori; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="card-body">
                        <input type="submit" value="Edit" class="btn btn-primary">
                </form>
                <a href="https://dpmptsp.jabarprov.go.id/jelita/main/cms/produk" class="btn btn-primary">Batal</a>
                      </div>
                  </div>
                </div>
                <?php } ?>
              </div>
            </div>
            <!-- / Content -->
            
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