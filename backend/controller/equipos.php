<?php

require_once("../class/equipos.class.php");

$obj_equ = new equipos;

$obj_equ->assignValue();

switch ($_REQUEST["run"]) {
	case 'create':
		$obj_equ->resultado = $obj_equ->create();

		if ($obj_equ->resultado == false) {
			$message = "El equipo que intenta registrar ya existe o puede que algunos datos ya esten registrados en el sistema, por favor ingrese otro";
			$obj_equ->message($message) == false;
			header("refresh:3; url=../../frontend/view/equipos.php");
		} else {
			$message = "Equipo registrado exitosamente";
			$obj_equ->message($message) == true;
			header("refresh:1; url=../../frontend/view/equipos.php");
		}
		break;

	case 'delete':
		$obj_equ->resultado = $obj_equ->delete();

		if ($obj_equ->resultado == false) {
			$message = "Problemas para eliminar el equipo";
			$obj_equ->message($message) == false;
		} else {
			$message = "Equipo eliminado exitosamente";
			$obj_equ->message($message) == true;
		}
		header("refresh:1; url=../../frontend/view/equipos.php");
		break;
}
