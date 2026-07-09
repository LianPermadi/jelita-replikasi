<script>
<!--
	$(document).ready(function(){
                $('#frmdata').submit(function(){
		 	if($('#txthost').val()=='')
			{
				$('#txthost').focus();
				$("#loading").text("Input Nama Nama Host").show().fadeOut(2000);
				return false;
			}
			 else if($('#txtusername').val()=='')
			{
				$('#txtusername').focus();
				$("#loading").text("Input Username login database").show().fadeOut(2000);
				return false;
			}
                        else if($('#txtnmdb').val()=='')
			{
				$('#txtnmdb').focus();
				$("#loading").text("Input nama database Anda").show().fadeOut(2000);
				return false;
			}
                        else if($('#txtprefdb').val()=='')
			{
				$('#txtprefdb').focus();
				$("#loading").text("Input prefik database anda").show().fadeOut(2000);
				return false;
			}
			var datakirim = $('#frmdata').serialize();	
			kirimPesan(datakirim);
                        return false;
		});
	});
//-->
</script>
<h1 class="pageTitle"><span>Step</span> Konfigurasi Database</h1>
<form action="<?php echo base_url(); ?>generate/prosescek" method="post" id="frmdata" name="frmdata">
    <fieldset>
        <legend>Informasi Database</legend>   
        <table border="0"  width="100%">
            <tr>
                <th colspan="2" class="header">Koneksi</th>
            </tr>
            <tr>
                <td width="20%">
                    <label for="txthost" class="label">Database Host</label>
                </td >
                <td width="80%"><input type="text" name="txthost" id="txthost" value="localhost" class="input" size="35" maxlength="35" /></td>
            </tr>
            <tr>
                <td>
                    <label for="txtusername" class="label">User Name</label>
                </td>
                <td><input type="text" name="txtusername" id="txtusername" value="root" class="input" size="35" maxlength="35" /></td>
            </tr>
            <tr>
                <td>
                    <label for="txtpasswd" class="label">Password</label>
                </td>
                <td><input type="password" name="txtpasswd" id="txtpasswd" value="" class="input" size="35" maxlength="35" /></td>
            </tr>
        </table>
        <hr />
        <table border="0"  width="100%">
            <tr>
                <th colspan="2"  class="header">Database</th>
            </tr>
            <tr>
                <td width="20%" >
                    <label for="txtnmdb" class="label">Nama database</label>
                </td  width="80%">
                <td><input type="text" name="txtnmdb" value="alp" id="txtnmdb" class="input" size="35" maxlength="35" /></td>
            </tr>
            <tr>
                <td>
                    <label for="txtprefdb" class="label">Prefik database</label>
                </td>
                <td><input type="text" value="alp_" name="txtprefdb" id="txtprefdb" class="input" size="35" maxlength="35" /></td>
            </tr>
            <tr>
                <td>
                    <label for="txtgenerate" class="label">Generate Database</label>
                </td>
                <td><select name="txtgenerate" id="txtgenerate" class="input">
                        <option value="1">Buat Database</option>
                        <option value="0">Database sudah ada</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    &nbsp;
                </td>
                <td>
                  <a href="<?php echo base_url(); ?>generate" class="nextbutton" title="Sebelumnya">Sebelumnya</a>
                  &nbsp;&nbsp;&nbsp;<input type="submit" value="Selanjutnya" name="tblsubmit" id="tblsubmit" />  
                </td>
            </tr>
        </table>
    </fieldset>
</form>
<div id="loading"></div>