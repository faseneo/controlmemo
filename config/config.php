<?php
	//Servidor Desarrollo Base de Datos
	/*	define('HOST','172.20.0.120');
	define('USERDB','root');
	define('PASSDB','20odin18++');
	define('DB','controlmemo');
	define('URLRES','http://resoluciones2.umce.cl/');
	define ('RAIZ',$_SERVER['DOCUMENT_ROOT'].'/controlmemo/');*/

	//Servidor Desarrollo test-71
	/*define('HOST','146.83.132.71');
	define('USERDB','root');
	define('PASSDB','rg1979');
	define('DB','controlmemo');
	define('URLRES','http://resoluciones2.umce.cl/');
	define ('RAIZ',$_SERVER['DOCUMENT_ROOT'].'/');*/

	//Servidor locahost
	define('HOST','localhost');
	define('USERDB','root');
	define('PASSDB','');
	define('DB','controlmemo');

	define('CHARSETDB',"SET NAMES utf8");
	define('URLRES','http://resoluciones2.umce.cl/');	

	define('RAIZ',$_SERVER['DOCUMENT_ROOT'].'/controlmemo/');

	define('memoarch_prefijo','archivo_memo_');
    define('memoarch_prefijo_otro','archivo_memo_anexo_');
    define('memoarch_prefijo_det','archivo_detmemo_');
    
    define('memoarch_directorio','archivos/');
    
    define('logdirectorio','logs/');
    define('logarchivoerror','errors.log');
    define('logarchivoquerys','querys.log');
?>