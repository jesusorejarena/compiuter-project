<?php

require_once("theme_sesion.php");
require_once("../../backend/class/diagnosticos.class.php");
require_once("../../backend/class/empleados.class.php");
require_once("../../backend/class/equipos.class.php");
require_once("../../backend/class/clientes.class.php");
require_once("../../backend/class/categorias.class.php");

$obj_dia = new diagnosticos;
$obj_dia->puntero = $obj_dia->getAll();

$obj_equ = new equipos;
$obj_emp = new empleados;
$obj_cli = new clientes;
$obj_cat = new categorias;

head("Lista de Diagnosticos");

check('Diagnosticos');

?>

<!-- Lista -->
<div class="container-fluid px-3 pt-3 pb-5 mb-5">
	<a class="btn btn-success btn-lg" href="dia_menu.php"><i class="fas fa-arrow-circle-left"></i></a>
	<h2 class="text-center p-3">Lista de Diagnosticos</h2>
	<div class="row justify-content-center">
		<div class="col-12 py-2">
			<div class="card-header">
				<div class="row">
					<div class="col-12">
						<a class="btn btn-danger" href="dia_reportes/dia_reportepdf_enlace.php"><i class="fas fa-file-pdf mr-1"></i> Descargar listado
							por PDF</i></a>
					</div>
				</div>
			</div>
			<div class="table-responsive">
				<table class="table table-bordered table-hover text-center">
					<thead>
						<tr>
							<th>Código</th>
							<th>Atendió</th>
							<th>Falla cliente</th>
							<th>Falla inicial</th>
							<th>Categoria</th>
							<th>Marca</th>
							<th>Serial</th>
							<th>Cliente</th>
							<th>Eliminar</th>
						</tr>
					</thead>
					<tbody>
						<?php
						while (($diagnosticos = $obj_dia->extractData()) > 0) {

							$obj_equ->cod_equ = $diagnosticos['fky_equipos'];
							$obj_equ->puntero = $obj_equ->getByCode();
							$equipo = $obj_equ->extractData();

							$obj_cat->cod_cat = $equipo['fky_categorias'];
							$obj_cat->puntero = $obj_cat->getByCode();
							$categoria = $obj_cat->extractData();

							$obj_cli->cod_cli = $diagnosticos['fky_clientes'];
							$obj_cli->puntero = $obj_cli->getByCode();
							$cliente = $obj_cli->extractData();

							$obj_emp->cod_emp = $diagnosticos['fky_empleados'];
							$obj_emp->puntero = $obj_emp->getByCode();
							$empleado = $obj_emp->extractData();

							echo "<form action='../../backend/controller/diagnosticos.php' method='POST'>
											<tr>
												<input type='hidden' name='cod_dia' value='$diagnosticos[cod_dia]'>
												<td>$diagnosticos[cod_dia]</td>
												<td>$empleado[nom_emp] $empleado[ape_emp]</td>
												<td>$diagnosticos[fal_cli_dia]</td>
												<td>$diagnosticos[fal_ini_dia]</td>
												<td>$categoria[nom_cat]</td>
												<td>$equipo[ser_equ]</td>
												<td>$equipo[mar_equ]</td>
												<td>$cliente[nom_cli] $cliente[ape_cli]</td>";

							if ($_SESSION['cargo'] === 'Administrador') {

								echo "
												<td><button type='button' data-toggle='modal' class='btn btn-danger' data-target='#modalDelete$diagnosticos[cod_dia]'><i class='fas fa-trash'></i></button></td>
												<div class='modal fade' id='modalDelete$diagnosticos[cod_dia]' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
													<div class='modal-dialog modal-sm'>
														<div class='modal-content'>
															<div class='modal-header'>
																<h5 class='modal-title' id='exampleModalLabel'>¿Estas seguro de enviar a la papelera?</h5>
																<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
																	<span aria-hidden='true'>&times;</span>
																</button>
															</div>
															<div class='modal-body d-flex justify-content-around'>
																<button type='submit' name='run' value='delete' class='btn btn-light'>Eliminar</button>
																<button type='button' class='btn btn-danger' data-dismiss='modal'>Cerrar</button>
															</div>
														</div>
													</div>
													</div>";
							} else {
								echo "<td></td>";
							}
							echo "
											</tr>
										</form>
									";
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>


<?php

footer();

?>