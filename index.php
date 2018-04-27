<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

if(is_file($_SERVER['DOCUMENT_ROOT'].'/config.php')){
	//Подключаем конфигурационный файл
	require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
	
	if(is_file($_SERVER['DOCUMENT_ROOT'].'/models/Db.php')){
		//Подкючаем класс работы с БД
		require_once($_SERVER['DOCUMENT_ROOT'].'/models/Db.php');
		$db = new Db($config);
	}else{
		die("Ошибка соединения с БД");
	}
}else{
	die("Ошибка конфигурации");
}

if(is_file($_SERVER['DOCUMENT_ROOT'].'/controllers/Reply.php')){
	//Подключаем контроллер
	require_once($_SERVER['DOCUMENT_ROOT'].'/controllers/Reply.php');
	new Reply($db);
}else{
	die("Ошибка маршрутизации");
}
?>