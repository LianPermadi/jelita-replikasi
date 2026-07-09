<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Terbilang class
 *
 * @author  Dichi Al Faridi
 * @since   1.0
 *
 */
class Terbilang {

    private function kekata($x = NULL) {
        $x = abs($x);
        $angka = array("", "satu", "dua", "tiga", "empat", "lima",
            "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($x < 12) {
            $temp = " " . $angka[$x];
        } else if ($x < 20) {
            $temp = $this->kekata($x - 10) . " belas";
        } else if ($x < 100) {
            $temp = $this->kekata($x / 10) . " puluh" . $this->kekata($x % 10);
        } else if ($x < 200) {
            $temp = " seratus" . $this->kekata($x - 100);
        } else if ($x < 1000) {
            $temp = $this->kekata($x / 100) . " ratus" . $this->kekata($x % 100);
        } else if ($x < 2000) {
            $temp = " seribu" . $this->kekata($x - 1000);
        } else if ($x < 1000000) {
            $temp = $this->kekata($x / 1000) . " ribu" . $this->kekata($x % 1000);
        } else if ($x < 1000000000) {
            $temp = $this->kekata($x / 1000000) . " juta" . $this->kekata($x % 1000000);
        } else if ($x < 1000000000000) {
            $temp = $this->kekata($x / 1000000000) . " milyar" . $this->kekata(fmod($x, 1000000000));
        } else if ($x < 1000000000000000) {
            $temp = $this->kekata($x / 1000000000000) . " trilyun" . $this->kekata(fmod($x, 1000000000000));
        }
        return $temp;
    }

    public function terbilang($x = NULL, $style=4) {
        if ($x < 0) {
            $hasil = "minus " . trim($this->kekata($x));
        } else {
            $hasil = trim($this->kekata($x));
        }
        switch ($style) {
            case 1:
                $hasil = strtoupper($hasil);
                break;
            case 2:
                $hasil = strtolower($hasil);
                break;
            case 3:
                $hasil = ucwords($hasil);
                break;
            default:
                $hasil = ucfirst($hasil);
                break;
        }
        return $hasil;
    }


    public function nominal($angka = NULL, $jumlah = 0){
        $nilai = number_format($angka, $jumlah, ',', '.');
        return $nilai;
    }

    public function cek_auth($angka = NULL){
        $user = new user();
		$user_user_auth = new user_user_auth();
        $stat = "19";                              // lihat tabel user_auth untuk Penomoran
		$kd_auth = FALSE;
        $user->where('username', $this->session->userdata('username'))->get();
		$user_user_auth->where('user_id', $user->id)->where('user_auth_id', $stat)->get();
		if($user_user_auth->user_auth_id === $stat) {
		   $kd_auth = TRUE;
		}
        
		if(!$kd_auth) { 
          redirect('dashboard');
        }
        return $kd_auth;
    }

	public function DecRomawi($angka){
        $hsl = "";
        if($angka<1||$angka>3999){
            $hsl = "Batas Angka 1 s/d 3999";
        }else{
            while($angka>=1000){
                $hsl .= "M";
                $angka -= 1000;
            }
            if($angka>=500){
                if($angka>500){
                    if($angka>=900){
                        $hsl .= "CM";
                        $angka-=900;
                    }else{
                        $hsl .= "D";
                        $angka-=500;
                    }
                }
            }
            while($angka>=100){
                if($angka>=400){
                    $hsl .= "CD";
                    $angka-=400;
                }else{
                    $angka-=100;
                }
            }
            if($angka>=50){
                if($angka>=90){
                    $hsl .= "XC";
                    $angka-=90;
                }else{
                    $hsl .= "L";
                    $angka-=50;
                }
            }
            while($angka>=10){
                if($angka>=40){
                   $hsl .= "XL";
                   $angka-=40;
                }else{
                   $hsl .= "X";
                   $angka-=10;
                }
            }
            if($angka>=5){
                if($angka==9){
                    $hsl .= "IX";
                    $angka-=9;
                }else{
                   $hsl .= "V"; 
                   $angka-=5;
                }
            }
            while($angka>=1){
                if($angka==4){
                   $hsl .= "IV"; 
                   $angka-=4;
                }else{
                   $hsl .= "I";
                   $angka-=1;
                }
            }
        }
        return ($hsl);
    }

	public function cek_status($angka = NULL){
        switch ($angka) {
			case 0:  $hasil = 'Pendaftaran Izin (FO)';         break;
            case 1:  $hasil = 'Entry Data';                    break; 
            case 2:  $hasil = 'Penjadualan Tinjauan Lapangan'; break;
            case 3:  $hasil = 'Entri Hasil Tinjauan';          break;
			case 4:  $hasil = 'Penyusunan BAP';                break;
			case 5:  $hasil = 'Penetapan';                     break;
			case 6:  $hasil = 'Izin Ditetapkan';               break;
			case 7:  $hasil = 'Berkas Izin Dicetak';           break;
			case 8:  $hasil = 'Berkas Siap Diserahkan';        break;
			case 9:  $hasil = 'Berkas Sudah Diserahkan';       break;
            default: $hasil = '-';                             break;
        }
        return $hasil;
    }

}