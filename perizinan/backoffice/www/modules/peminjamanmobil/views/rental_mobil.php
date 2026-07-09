<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css">
    <link rel="stylesheet" href="assets/css/ebs-bootstrap-datepicker-1.css?h=46bd24b0e6d1732ea32cccb94aa36197">
    <link rel="stylesheet" href="assets/css/ebs-bootstrap-datepicker-2.css?h=7b0a5deac08d5144edaf8e057d3e0c80">
    <link rel="stylesheet" href="assets/css/ebs-bootstrap-datepicker-3.css?h=833282b1358a8ba920a3347a6509febe">
    <link rel="stylesheet" href="assets/css/ebs-bootstrap-datepicker-4.css?h=61f2d5dfb2443dd2f8c216a555f129d7">
    <link rel="stylesheet" href="assets/css/ebs-bootstrap-datepicker.css?h=51e3e64195ec22075db090daddbcfc11">
    <link rel="stylesheet" href="assets/css/Form-Select---Full-Date---Month-Day-Year.css?h=7b6a3c2cb7894fdb77bae43c70b92224">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="assets/css/NZTextbox---Date.css?h=5d457a2c622346b77be67fbaa6a3ea3d">
    <link rel="stylesheet" href="assets/css/styles.css?h=d41d8cd98f00b204e9800998ecf8427e">
</head>
<div id="content">
    <div class="post">
        <div class="title">
          <?php echo $this->lib_date->view_title($page_name); ?>
        </div>

        <?php
        $alert = $this->session->flashdata("sukses");
        if (!empty($alert)) {
        ?>
            <br>
            <div style="color: green; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;">
                <center><?php echo $alert; ?></center>
            </div>
        <?php } ?>

        <?php
        $alert = $this->session->flashdata("gagal");
        if (!empty($alert)) {
        ?>
            <br>
            <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;">
                <center><?php echo $alert; ?></center>
            </div>
        <?php } ?>

        <div class="entry">
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1">Input Tanggal</a></li>
                </ul>
                <div id="tabs-1">
                    <center>
                    <form action="peminjamanmobil/check_mobil" method="post">
                    <table>
                        <tr>
                            <td>
                                <label>Tanggal Keberangkatan</label>
                            </td>
                            <td>
                                <input type="date" name="tgla" class="input-wrc">
                            </td>
                        </tr>
                            <td>
                                <label>Tanggal Pulang</label>
                            </td>
                            <td>
                                <input type="date" name="tglb" class="input-wrc">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                    <input type="submit" name="submit" class="button-wrc" value="Cari">
                </td>
                        </tr>
                    </table>
                    </form>
                    </center>
                </div>
            </div>
            <label>&nbsp;</label>
            <div class="spacer"></div>
        </div>
    </div>
    <br style="clear: both;" />
</div>    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/DateRangePicker.js?h=e84100887465fbb69726c415c180211a"></script>
    <script src="assets/js/ebs-bootstrap-datepicker-1.js?h=faaa5999d870f55a40d5bde0158d0dea"></script>
    <script src="assets/js/ebs-bootstrap-datepicker.js?h=4821df003a733d76cf4ecf1c778318c1"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>