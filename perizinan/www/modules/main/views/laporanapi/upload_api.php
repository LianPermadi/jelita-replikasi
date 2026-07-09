<?php if(@$msg<>"") 
{
   if(@$msg == "sukses")
    {
    ?>
    <script>alert("Data Berhasil disimpan");
    window.location.href='../dataapi'

    </script>

    <?php
   
    }else if(@$msg == "sukses api")
    {
    ?>
    <script>alert("Data Berhasil disimpan");
    window.location.href='laporanapiuser/dataapi'

    </script>

    <?php
   
    }else if(@$msg == "gagal api")
    {
    ?>
    <script>alert("Data Berhasil disimpan");
    window.location.href='laporanapiuser/tambah_api_form'

    </script>

    <?php
   
    }else
    {
    ?>
    <script>alert("Data gagal disimpan");
  window.location.href='../tambah_api'
    </script>
    <?php

}

}
?>