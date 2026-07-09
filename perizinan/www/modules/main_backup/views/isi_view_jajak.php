<style> p{font-size: 1px; color: #ffffff;} table tr td {text-align: center; width: 150px;} </style>


<script type="text/javascript" src="<?php echo base_url().'assets/js/fusion/JS';?>/jquery.fusioncharts.js"></script>

<div class="isi">
    <div id="entry">
        <h2>Hasil Data Polling Jajak</h2>
        
<center>
<?php
//$ip= getIP();

    
    $dt_jajak=new Tmjajak();
    $dt_piljajak=new Tmjajak_det();
    $get_jajak=$dt_jajak->where("STATUS = 1 limit 1")->get();
    $id=$get_jajak->C_JAJAK;
    $get_pil=$dt_piljajak->where("C_JAJAK = $id")->get();    
    
    $this->tm_client_jajak=new Tm_client_jajak();
    
    
?>

    
    <br/><b>
    <?php   
        echo $get_jajak->N_TANYA
    ?>
    </b>
    <br/><br/>
    
    <table id="myHTMLTable" border="1" align="center" >
        <tr> 
            <td><p><?php echo $get_jajak->N_TANYA?> : </p></td> 
        <?php
        foreach ($get_pil as $row) {
            
             if($row->N_PILIHAN!="")
            echo '<td  align="center"><p>'.$row->N_PILIHAN.'</p></td>';
        }
        ?>   
        </tr>
        <tr> 
            <td></td> 
            <?php
                $count=0;
                foreach ($get_pil as $row) 
                {
                    if($row->N_PILIHAN!=""){
                     $get_jumlah= $this->tm_client_jajak->where("C_JAJAK =".$row->C_PILJAJAK)->count();   
                     $count +=$get_jumlah;
                    }
                }
                if($count<1)
                {
                    foreach ($get_pil as $row) 
                    {
                        if($row->N_PILIHAN!=""){
                         $get_jumlah= $this->tm_client_jajak->where("C_JAJAK =".$row->C_PILJAJAK)->count();   
                         echo "";
                        }
                    }
                }
                else
                {
                    foreach ($get_pil as $row) 
                    {       
                        if($row->N_PILIHAN!=""){
                         $get_jumlah= $this->tm_client_jajak->where("C_JAJAK =".$row->C_PILJAJAK)->count();   
                         echo "<td align='center'><p>". $get_jumlah."</p></td>";
                        }
                    }
                }                
            ?>
          
        </tr>
    </table>
    
    <script type="text/javascript">
        $('#myHTMLTable').convertToFusionCharts({
            swfPath: site+"assets/js/fusion/Charts/",
            type: "MSColumn2D",
            data: "#myHTMLTable",
            dataFormat: "HTMLTable",
            width:850,
            height:300
        });
    </script>

</center>


    </div>

    <div class="clear"></div>

</div>
