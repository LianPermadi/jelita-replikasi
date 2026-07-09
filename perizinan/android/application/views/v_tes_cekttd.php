<?php
ob_start();
$passphrase = $_REQUEST['passphrase'];


//echo $passphrase;
$path_jar = 'signer/JSignPdf.jar';
$path_pdf = 'filepdf/tes.pdf'; // file .pdf yg mau di signing
$path_p12 = 'signer/kepala.p12'; // file sertifikat dalam bentuk p12



        $output_path = 'tessign/'; // output 
        
        //$passphrase = $request['passphrase']; //POST dr user
           
        $tsa_url = "http://tsa-osd.lemsaneg.go.id/"; // free TSA
        
        $ocsp = "http://cvs-osd.lemsaneg.go.id/ocsp"; //ocsp

        $command = 'java -jar "'.$path_jar.'" "'.$path_pdf.'" -kst PKCS12 -ksf "'.$path_p12.'" -ksp "'.$passphrase.'" -l "lokasi penandatangan" -r "tujuan dilakukan tandatangan" -c "kontak yang bisa dihubungi" -tsh SHA256 -ha SHA256 -d "'.$output_path.'" -os "" -ts '.$tsa_url.' -ta PASSWORD -tsu "coba" -tsp "1234" --ocsp --ocsp-server-url "'.$ocsp.'"';
        exec($command, $val, $er); //eksekusi dan cek hasil nya
        //exec($command, $val, $er);
//dd($command);
var_dump($command);
var_dump($val);
var_dump($er);
if($er == 0 || $er == 3){
	echo 'berhasil';
	}
	else{
		echo 'gagal';
	}
	?>}