<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
  |--------------------------------------------------------------------------
  | File and Directory Modes
  |--------------------------------------------------------------------------
  |
  | These prefs are used when checking and setting modes when working
  | with the file system.  The defaults are fine on servers with proper
  | security, but you may wish (or even need) to change the values in
  | certain environments (Apache running a separate process for each
  | user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
  | always be used to set the mode correctly.
  |
 */
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
  |--------------------------------------------------------------------------
  | File Stream Modes
  |--------------------------------------------------------------------------
  |
  | These modes are used when working with fopen()/popen()
  |
 */

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

//if(isset($_SERVER['HTTP_HOST']))
//{
//	$base_url = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on' ? 'https' : 'http';
//	$base_url .= '://'. $_SERVER['HTTP_HOST'];
//	$base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
//
//	// Base URI (It's different to base URL!)
//	$base_uri = parse_url($base_url, PHP_URL_PATH);
//	if(substr($base_uri, 0, 1) != '/') $base_uri = '/'.$base_uri;
//	if(substr($base_uri, -1, 1) != '/') $base_uri .= '/';
//}
//
//else
//{
//	$base_url = 'http://localhost/';
//	$base_uri = '/';
//}
//
//
//define('BASE_URL', $base_url);
//define('BASE_URI', $base_uri);
//define('APPPATH_URI', BASE_URI.APPPATH);

// Define Ajax Request
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');


// Define Link Pelaporan Gratifikasi
define('LINK_PENERIMAAN',  "penerimaan_pelaporan");
define('LINK_VERIFIKASI',  "penerimaan_pelaporan/verifikasi");
define('LINK_RINCI_PENERIMAAN',  "penerimaan_pelaporan/rinci_penerimaan");
define('LINK_PROSES_ANALISIS',  "proses_analisis");
define('LINK_LAPORAN_HA',  "hasil_analisis");
define('LINK_BA_KLARIFIKASI',  "ba_klarifikasi");
define('LINK_SURAT_PEMANGGILAN',  "surat_pemanggilan");
define('LINK_BA_VERIFIKASI',  "ba_verifikasi");
define('LINK_SK',  "surat_keputusan");
define('LINK_SURAT_PENGANTAR_SK',  "surat_pengantar");
define('LINK_LAPORAN_KP',  "laporan_kemajuan");
define('LINK_SURAT_PELIMPAHAN',  "surat_pelimpahan");
define('LINK_BUKTI_PENITIPAN',  "bukti_penitipan");

// Define Title Pelaporan Gratifikasi
define('TITLE_PENERIMAAN',  "Penerimaan Pelaporan");
define('TITLE_VERIFIKASI',  "Verifikasi Pelaporan");
define('TITLE_RINCI_PENERIMAAN',  "Rincian Penerimaan Pelaporan");
define('TITLE_PROSES_ANALISIS',  "Proses Analisis Pelaporan");
define('TITLE_LAPORAN_HA',  "Laporan Hasil Analisis");
define('TITLE_BA_KLARIFIKASI',  "Berita Acara Klarifikasi");
define('TITLE_SURAT_PEMANGGILAN',  "Surat Pemanggilan");
define('TITLE_BA_VERIFIKASI',  "BA Klarifikasi dan Verifikasi");
define('TITLE_SK',  "Surat Keputusan");
define('TITLE_SURAT_PENGANTAR_SK',  "Surat Pengantar SK");
define('TITLE_LAPORAN_KP',  "Laporan Kemajuan Penanganan");
define('TITLE_SURAT_PELIMPAHAN',  "Surat Pelimpahan");
define('TITLE_BUKTI_PENITIPAN',  "Tanda Terima Penitipan Uang/Barang");

// Define Peran Pengguna |-> tr_peran
define('ROLE_ADMINISTRATOR',  1);
define('ROLE_PETUGAS_ADMIN',  2);
define('ROLE_VERIFIKATOR',  3);
define('ROLE_SATGAS',  4);
define('ROLE_KASATGAS',  5);
define('ROLE_DIREKTUR',  6);

// Define Status Pelaporan |-> tr_status
define('ST_PENERIMAAN',  1);
define('ST_LAPORAN_HA',  2); //[Pembuatan Diposisi -> ST_PROSES_ANALISIS -> Diterima] OR [ST_SURAT_PEMANGGILAN -> Ditolak]
define('ST_BA_KLARIFIKASI',  3); //ST_LAPORAN_HA -> Legal
define('ST_SURAT_PEMANGGILAN',  4); //ST_BA_KLARIFIKASI -> Dipanggil
define('ST_BA_VERIFIKASI',  5); //[ST_BA_KLARIFIKASI -> Langsung] OR [ST_SURAT_PEMANGGILAN -> Diterima]
define('ST_SK',  6);
define('ST_SURAT_PENGANTAR_SK',  7);
define('ST_LAPORAN_KP',  8); //ST_PROSES_ANALISIS -> Ditolak
define('ST_SURAT_PELIMPAHAN',  9); //ST_LAPORAN_HA -> Ilegal
define('ST_BUKTI_PENITIPAN',  10);
//exception
define('ST_VERIFIKASI',  100);
define('ST_RINCI_PENERIMAAN',  101);
define('ST_PROSES_ANALISIS',  102);

// Define Jenis Dokumen |-> tr_jenis_dokumen
define('DOK_LAPORAN_HA',  1);
define('DOK_BA_KLARIFIKASI',  2);
define('DOK_SURAT_PEMANGGILAN',  3);
define('DOK_BA_VERIFIKASI',  4);
define('DOK_SK',  5);
define('DOK_SURAT_PENGANTAR_SK',  6);
define('DOK_LAPORAN_KP',  7);
define('DOK_SURAT_PELIMPAHAN',  8);
define('DOK_BUKTI_PENITIPAN',  9);

// Define KodeDokumen
define('KODE_LAPORAN_HA',  "LHA");
define('KODE_BA_KLARIFIKASI',  "BAK");
define('KODE_SURAT_PEMANGGILAN',  "SPM");
define('KODE_BA_VERIFIKASI',  "BAV");
define('KODE_SK',  "SK");
define('KODE_SURAT_PENGANTAR_SK',  "SKP");
define('KODE_LAPORAN_KP',  "LKP");
define('KODE_SURAT_PELIMPAHAN',  "SPL");

// Define Status Persetujuan Dokumen
define('SP_SATGAS',  0);
define('SP_KASATGAS_NO',  1);
define('SP_KASATGAS_YES',  2);
define('SP_DIR_NO',  3);
define('SP_DIR_YES',  4);

define('VAL_SATGAS',  "Satgas Entry");
define('VAL_KASATGAS_NO',  "Belum Disetujui Kasatgas");
define('VAL_KASATGAS_YES',  "Sudah Disetujui Kasatgas");
define('VAL_DIR_NO',  "Belum Disetujui Direktur");
define('VAL_DIR_YES',  "Sudah Disetujui Direktur");

// Define Kantor Gratifikasi KPK |-> tr_kantor
define('KANTOR_KPK',  1);

// Define Satuan Tugas |-> tr_satgas
define('SATGAS_PELAPORAN',  1);
define('SATGAS_PEMERIKSAAN',  2);
define('SATGAS_PPG',  3);

// Define Status Proses
define('STS_NO',  'no');
define('STS_PROCEED',  'proceed');
define('STS_YES',  'yes');
define('STS_REJECTED',  'rejected');

// Define Hasil Review Checklist -> tr_review_formula
define('HSL_INSTANSI',  'instansi');
define('HSL_TIDAK_PROSES',  'tidak_proses');
define('HSL_REVIEW',  'review_ii');
define('HSL_REVIEW_2',  'review_iii');
define('HSL_KPK',  'kpk');