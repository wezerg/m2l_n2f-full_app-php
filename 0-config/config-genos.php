<?php 
	if(empty($_SESSION) || $_SESSION["id_user"] <= 0) session_start();
	//Genos use auto increment field and attribute id as primary key
	// If you want to use another field/attribute as primary key set following variable
	// If it's false you'll have to add attribute primary_key in your class
	$ID_PRIMARY_DEFAULT = true;

	//Table name format
	//Windows is case unsensitive, but database on prod should be case sensitive
	//You have to choose between : lowercase, uppercase, capitalize, custom
	//If you choose personalised you'll have to add attribute table_name in your class

	$TABLE_CASE = "lowercase";

	//DATABASE
	$DATABASE_NAME ='m2l_notes_de_frais';
	$DATABASE_HOST ='localhost';
	$DATABASE_PORT ='3306';
	$DATABASE_USER ='root';
	$DATABASE_PSWD ='';

	define("ID_PRIMARY_DEFAULT",$ID_PRIMARY_DEFAULT);
	define("TABLE_CASE",$TABLE_CASE);
	define("DATABASE_NAME",$DATABASE_NAME);
	define("DATABASE_HOST",$DATABASE_HOST);
	define("DATABASE_PORT",$DATABASE_PORT);
	define("DATABASE_USER",$DATABASE_USER);
	define("DATABASE_PSWD",$DATABASE_PSWD);
	define("RACINE_GLOBALE", __DIR__."/../");

	include(__DIR__."/genos.php");
	include(RACINE_GLOBALE."utilities.php");

	function SetRacineGlobalRelatif($url){
		// Retourne le chemin relatif
		$tabURL = explode('/', $url);
		// var_dump($tabURL);
		$dossierAttendu = $tabURL[1];

		$tabRacine = explode('/', dirname($_SERVER['PHP_SELF']));
		$path_relatif = "";
		for ($i = count($tabRacine)-1 ; $i > 0 ; $i--){
			if ($tabRacine[$i] == $dossierAttendu) break;
			else if ($tabRacine[$i] != "") $path_relatif .= "../";
		}

		define("RACINE_GLOBAL_RELATIF", $path_relatif); //Permet d'accéder à la racine.
	}
	SetRacineGlobalRelatif($_SERVER['REQUEST_URI']);	

// On ajoute toutes les classes.
	include(__DIR__."/../1-classes/0-classes.php");