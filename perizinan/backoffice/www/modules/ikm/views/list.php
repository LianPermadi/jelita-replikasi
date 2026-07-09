<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
        <div class="entry">
        <fieldset id="half">
            <legend>Filter</legend>
           
			   
			   <?php
		
			   echo form_open('ikm/tampildata');
			 
            ?>
			

      <div id="statusRail">
	  <div id="leftRail">
	  <?php
                    echo form_label('Bidang');
            ?>
              </div>
 <div id="rightRail">
 <?php  
			$this->db->select('id');
			$this->db->select('n_sektor');
			$anggota = $this->db->get('trsektor');
	foreach($anggota->result() as $row){
	$hasil[$row->id] = $row->n_sektor;
}
	$pilih = array($anggota);
	echo form_dropdown('id',$hasil,$pilih);
	echo br();
	
?>
 </div>
</div>
<div id="statusRail">
              <div id="leftRail">
            <?php
                    echo form_label('Tahun');
            ?>
              </div>
              <div id="rightRail">
              <?php
$now=date('Y');
echo "<select name='tgla' style='width: 163px' >";
for ($a=$now;$a>=$now-20;$a--)
{
     echo "<option value=' ".$a." '>".$a."</option>";
}
echo "</select>";
?>
              </div>
      </div>

                   <div id="statusRail">
              <div id="leftRail"></div>
              <div id="rightRail">
                <?php
				
                    $filter_data = array(
                        'name' => 'button',
                        'class' => 'button-wrc',
                        'content' => 'Filter',
                        'value' => 'Filter'
						
                    );

                     $reset_data = array(
                                    'name' => 'button',
                                    'content' => 'Reset Filter',
                                    'value' => 'Reset Filter',
                                    'class' => 'button-wrc',
                                    //'onclick' => 'parent.location=\''. site_url('durasiizin/izin') . '\''
                    );

                    echo form_submit($filter_data);
                   // echo form_button($reset_data);
                    ?>
              </div>
            </div>
            <?php
                echo form_close();
            ?>
        </fieldset>
       <br>
<div class="contentForm">
                          
                        </div>


        
        </div>
    </div>
    <br style="clear: both;" />
</div>
