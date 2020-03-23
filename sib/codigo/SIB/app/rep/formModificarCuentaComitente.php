<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la garantia seleccionada */

/* Se obtiene el id para obtener los datos de la BD */
$idCuentaComitente = $_POST['seleccionado'];
$query = "SELECT * FROM cuentasComitentes
                        WHERE idCuentaComitente =" . $idCuentaComitente;
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

function alta() {
    $idCuentaComitente = $_POST['seleccionado'];
    $queryAltas = "SELECT * FROM cuentasComitentesAltas
                        WHERE idCuentaComitente =" . $idCuentaComitente;
    $resultAltas = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryAltas);
    return $resultAltas;
}

function baja() {
    $idCuentaComitente = $_POST['seleccionado'];
    $queryBajas = "SELECT * FROM cuentasComitentesBajas
                        WHERE idCuentaComitente =" . $idCuentaComitente;
    $resultBajas = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryBajas);
    return $resultBajas;
}
?>

<div class="container">
    <div id="contenido">
        <h4 class="text-center p-4">MODIFICAR REPORTE</h4>
        <div id="centro" class="container">
            <?php
            if (!$idCuentaComitente || !$result) {
                $log = new Log();
                $log->writeLine("[Error al obtener cuenta comitente desde la BD][ID: $idCuentaComitente][QUERY: $query]");
                echo '<div class="alert alert-danger" role="alert"> No se pudo obtener la información de la cuenta comitente </div>';
            } else {
                $row = sqlsrv_fetch_array($result);

                $fecha = utf8_encode($row['fechaAccion']);
                $estado = utf8_encode($row['estadoDepositante']);
                $cuentaDepositante = $row['cuentaDepositante'];
                $cuentaComitente = $row['cuentaComitente'];
                $cantidad = $row['cantidadCliente'];
                $accion = utf8_encode($row['tipoAccion']);

                //tabla altas

                function Altas() {
                    $result = alta();
                    $html = '';
                    while ($row = sqlsrv_fetch_array($result)) {
                        if($row['vinculado'] === "NO"){
                            //no vinculado
                            $html .= '<input type="hidden" id="idAltas" name="idAltas[]" value="'.utf8_encode($row["idCuentasComitentesAltas"]).'">
                                <hr /><hr /><h5><u>Cliente</u></h5><hr /><hr />
                                <table class="table table-bordered table-striped" id="tablaJuridicas">
                                <tr>
                                    <td><label>Tipo de Cliente:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="tipoCliente" name="tipoClienteAlta[]" required="true" value="'.utf8_encode($row["tipoCliente"]).'"></td>                        
                                 </tr>
                                 <tr>
                                    <td><label>CUIT/CUIL/CDI:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="cuil" name="cuilAlta[]" placeholder="CUIT/CUIL/CDI" value="'.utf8_encode($row["cuil"]).'"></td>                        
                                 </tr>
                                 <tr>
                                    <td><label>Tipo de Persona:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="tipoPersona" name="tipoPersonaAlta[]" value="'.utf8_encode($row["tipoPersona"]).'" readonly="true"></td>                        
                                 </tr>
                                ';
                            //no vinculado persona juridica
                            if(utf8_encode($row["tipoPersona"]) === "Persona jurídica" || utf8_encode($row["tipoPersona"]) === "Persona jurídica extranjera"){
                                
                                $html .='<tr>
                                    <td><label>Denominacion:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="denominacion" name="denominacionAlta[]" required="true" value="'.utf8_encode($row["denominacion"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Fecha de Constitucion:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="fechaConstitucion" name="fechaConstitucionAlta[]" value="'.utf8_encode($row["fechaConstitucion"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Riesgo asignado al cliente:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="riesgo" name="riesgoAlta[]" value="'.utf8_encode($row["riesgo"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Pais:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="pais" name="paisAlta[]" value="'.utf8_encode($row["pais"]).'" readonly="true"></td>                        
                                    </tr>
                                ';
                                if(utf8_encode($row["pais"]) === "Argentina"){
                                    $html .='<tr>
                                    <td><label>Provincia:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="provincia" name="provinciaAlta[]" required="true" value="'.utf8_encode($row["provincia"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Localidad:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="localidad" name="localidadAlta[]" value="'.utf8_encode($row["localidad"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Calle:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="calle" name="calleAlta[]" value="'.utf8_encode($row["calle"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Numero:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="numero" name="numeroAlta[]" value="'.utf8_encode($row["numero"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Piso:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="piso" name="pisoAlta[]" value="'.utf8_encode($row["piso"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Departamento:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="departamento" name="departamentoAlta[]" value="'.utf8_encode($row["departamento"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Codigo Postal:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="codigoPostal" name="codigoPostalAlta[]" value="'.utf8_encode($row["codigoPostal"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Codigo de area:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="codigoArea" name="codigoAreaAlta[]" value="'.utf8_encode($row["codigoArea"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Telefono:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="telefono" name="telefonoAlta[]" value="'.utf8_encode($row["telefono"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Correo electronico:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="correoElectronico" name="correoElectronicoAlta[]" value="'.utf8_encode($row["correoElectronico"]).'"></td>                        
                                    </tr>
                                    </table>
                                ';
                                }else{
                                    $html .='<tr>
                                    <td><label>Otro Pais:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="otroPais" name="otroPaisAlta[]" value="'.utf8_encode($row["otroPais"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Provincia / Estado:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="provinciaEstado" name="provinciaEstadoAlta[]" value="'.utf8_encode($row["provinciaEstado"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Localidad / Ciudad:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="localidadCiudad" name="localidadCiudadAlta[]" value="'.utf8_encode($row["localidadCiudad"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Domicilio / Direccion:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="domicilioDireccion" name="domicilioDireccionAlta[]" value="'.utf8_encode($row["domicilioDireccion"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Codigo Postal:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="codigoPostal" name="codigoPostalAlta[]" value="'.utf8_encode($row["codigoPostal"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Codigo de area:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="codigoArea" name="codigoAreaAlta[]" value="'.utf8_encode($row["codigoArea"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Telefono:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="telefono" name="telefonoAlta[]" value="'.utf8_encode($row["telefono"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Correo electronico:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="correoElectronico" name="correoElectronicoAlta[]" value="'.utf8_encode($row["correoElectronico"]).'"></td>                        
                                    </tr>
                                    </table>
                                ';
                                    
                                }
                            }else{
                                //no vinculado persona humana
                                if(utf8_encode($row["tipoPersona"]) === "Persona humana" || utf8_encode($row["tipoPersona"]) === "Persona humana extranjera"){
                                
                                $html .='<tr>
                                    <td><label>Apellido:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="apellido" name="apellidoAlta[]" required="true" value="'.utf8_encode($row["apellido"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Nombre:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="nombre" name="nombreAlta[]" value="'.utf8_encode($row["nombre"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Tipo de documento:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="tipoDocumento" name="tipoDocumentoAlta[]" value="'.utf8_encode($row["tipoDocumento"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Numero de documento:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="numeroDocumento" name="numeroDocumentoAlta[]" value="'.utf8_encode($row["numeroDocumento"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Genero:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="genero" name="generoAlta[]" value="'.utf8_encode($row["genero"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Nacionaliada cliente:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="nacionalidad" name="nacionalidadAlta[]" value="'.utf8_encode($row["nacionalidad"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Pais de nacimiento:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="paisNacimiento" name="paisNacimientoAlta[]" value="'.utf8_encode($row["paisNacimiento"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Lugar de nacimiento:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="lugarNacimiento" name="lugarNacimientoAlta[]" value="'.utf8_encode($row["lugarNacimiento"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Fecha de nacimiento:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="fechaNacimiento" name="fechaNacimientoAlta[]" value="'.utf8_encode($row["fechaNacimiento"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Declara ser PEP:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="pep" name="pepAlta[]" value="'.utf8_encode($row["declaraSerPEP"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Riesgo asignado al cliente:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="riesgo" name="riesgoAlta[]" value="'.utf8_encode($row["riesgo"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Pais:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="pais" name="paisAlta[]" value="'.utf8_encode($row["pais"]).'"></td>                        
                                    </tr>
                                ';
                                if(utf8_encode($row["pais"]) === "Argentina"){
                                    $html .='<tr>
                                    <td><label>Provincia:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="provincia" name="provinciaAlta[]" required="true" value="'.utf8_encode($row["provincia"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Localidad:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="localidad" name="localidadAlta[]" value="'.utf8_encode($row["localidad"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Calle:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="calle" name="calleAlta[]" value="'.utf8_encode($row["calle"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Numero:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="numero" name="numeroAlta[]" value="'.utf8_encode($row["numero"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Piso:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="piso" name="pisoAlta[]" value="'.utf8_encode($row["piso"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Departamento:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="departamento" name="departamentoAlta[]" value="'.utf8_encode($row["departamento"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Codigo Postal:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="codigoPostal" name="codigoPostalAlta[]" value="'.utf8_encode($row["codigoPostal"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Codigo de area:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="codigoArea" name="codigoAreaAlta[]" value="'.utf8_encode($row["codigoArea"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Telefono:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="telefono" name="telefonoAlta[]" value="'.utf8_encode($row["telefono"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Correo electronico:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="correo" name="correoElectronicoAlta[]" value="'.utf8_encode($row["correoElectronico"]).'"></td>                        
                                    </tr>
                                    </table>
                                ';
                                }else{
                                    $html .='<tr>
                                    <td><label>Otro Pais:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="otroPais" name="otroPaisAlta[]" value="'.utf8_encode($row["otroPais"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Provincia / Estado:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="provinciaEstado" name="provinciaEstadoAlta[]" value="'.utf8_encode($row["provinciaEstado"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Localidad / Ciudad:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="localidadCiudad" name="localidadCiudadAlta[]" value="'.utf8_encode($row["localidadCiudad"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Domicilio / Direccion:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="domicilioDireccion" name="domicilioDireccionAlta[]" value="'.utf8_encode($row["domicilioDireccion"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Codigo Postal:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="codigoPostal" name="codigoPostalAlta[]" value="'.utf8_encode($row["codigoPostal"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Codigo de area:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="codigoArea" name="codigoAreaAlta[]" value="'.utf8_encode($row["codigoArea"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Telefono:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="telefono" name="telefonoAlta[]" value="'.utf8_encode($row["telefono"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Correo electronico:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="correo" name="correoAlta[]" value="'.utf8_encode($row["correoElectronico"]).'"></td>                        
                                    </tr>
                                    </table>
                                ';
                                    
                                }
                            }
                            }
                        }else{
                            //vinculado persona juridica
                            $html .= '<input type="hidden" id="idSujetoVinculado" name="idSujetoVinculado[]" value="'.utf8_encode($row["idCuentasComitentesAltas"]).'">
                                <hr /><hr /><h5><u>Cliente Vinculado</u></h5><hr /><hr />
                                <table class="table table-bordered table-striped" id="tablaJuridicas">
                                <tr>
                                    <td><label>Naturaleza del vinculo:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="naturalezaSujetoVinculado" name="naturalezaSujetoVinculado[]" required="true" value="'.utf8_encode($row["naturalezaDelVinculo"]).'"></td>                        
                                 </tr>
                                 <tr>
                                    <td><label>CUIT/CUIL/CDI:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="cuil" name="cuilSujetoVinculado[]" placeholder="CUIT/CUIL/CDI" value="'.utf8_encode($row["cuil"]).'"></td>                        
                                 </tr>
                                 <tr>
                                    <td><label>Tipo de Persona:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="tipoPersona" name="tipoPersonaSujetoVinculado[]" value="'.utf8_encode($row["tipoPersona"]).'" readonly="true"></td>                        
                                 </tr>
                                ';
                            //vinculado persona juridica
                            if(utf8_encode($row["tipoPersona"]) === "Persona jurídica" || utf8_encode($row["tipoPersona"]) === "Persona jurídica extranjera"){
                                
                                $html .='<tr>
                                    <td><label>Denominacion:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="denominacion" name="denominacionSujetoVinculado[]" required="true" value="'.utf8_encode($row["denominacion"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Fecha de Constitucion:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="fechaConstitucion" name="fechaConstitucionSujetoVinculado[]" value="'.utf8_encode($row["fechaConstitucion"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Pais:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="pais" name="paisSujetoVinculado[]" value="'.utf8_encode($row["pais"]).'" readonly="true"></td>                        
                                    </tr>
                                ';
                                if(utf8_encode($row["pais"]) === "Argentina"){
                                    $html .='<tr>
                                    <td><label>Provincia:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="provincia" name="provinciaSujetoVinculado[]" required="true" value="'.utf8_encode($row["provincia"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Localidad:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="localidad" name="localidadSujetoVinculado[]" value="'.utf8_encode($row["localidad"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Calle:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="calle" name="calleSujetoVinculado[]" value="'.utf8_encode($row["calle"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Numero:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="numero" name="numeroSujetoVinculado[]" value="'.utf8_encode($row["numero"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Piso:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="piso" name="pisoSujetoVinculado[]" value="'.utf8_encode($row["piso"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Departamento:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="departamento" name="departamentoSujetoVinculado[]" value="'.utf8_encode($row["departamento"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Codigo Postal:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="codigoPostal" name="codigoPostalSujetoVinculado[]" value="'.utf8_encode($row["codigoPostal"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Codigo de area:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="codigoArea" name="codigoAreaSujetoVinculado[]" value="'.utf8_encode($row["codigoArea"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Telefono:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="telefono" name="telefonoSujetoVinculado[]" value="'.utf8_encode($row["telefono"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Correo electronico:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="correoElectronico" name="correoElectronicoSujetoVinculado[]" value="'.utf8_encode($row["correoElectronico"]).'"></td>                        
                                    </tr>
                                    </table>
                                ';
                                }else{
                                    $html .='<tr>
                                    <td><label>Otro Pais:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="otroPais" name="otroPaisSujetoVinculado[]" value="'.utf8_encode($row["otroPais"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Provincia / Estado:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="provinciaEstado" name="provinciaEstadoSujetoVinculado[]" value="'.utf8_encode($row["provinciaEstado"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Localidad / Ciudad:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="localidadCiudad" name="localidadCiudadSujetoVinculado[]" value="'.utf8_encode($row["localidadCiudad"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Domicilio / Direccion:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="domicilioDireccion" name="domicilioDireccionSujetoVinculado[]" value="'.utf8_encode($row["domicilioDireccion"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Codigo Postal:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="codigoPostal" name="codigoPostalSujetoVinculado[]" value="'.utf8_encode($row["codigoPostal"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Codigo de area:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="codigoArea" name="codigoAreaSujetoVinculado[]" value="'.utf8_encode($row["codigoArea"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Telefono:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="telefono" name="telefonoSujetoVinculado[]" value="'.utf8_encode($row["telefono"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Correo electronico:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="correoElectronico" name="correoElectronicoSujetoVinculado[]" value="'.utf8_encode($row["correoElectronico"]).'"></td>                        
                                    </tr>
                                    </table>
                                ';
                                    
                                }
                            }else{
                                //vinculado persona humana
                                if(utf8_encode($row["tipoPersona"]) === "Persona humana" || utf8_encode($row["tipoPersona"]) === "Persona humana extranjera"){
                                
                                $html .='<tr>
                                    <td><label>Apellido:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="apellido" name="apellidoSujetoVinculado[]" required="true" value="'.utf8_encode($row["apellido"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Nombre:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="nombre" name="nombreSujetoVinculado[]" value="'.utf8_encode($row["nombre"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Tipo de documento:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="tipoDocumento" name="tipoDocumentoSujetoVinculado[]" value="'.utf8_encode($row["tipoDocumento"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Numero de documento:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="numeroDocumento" name="numeroDocumentoSujetoVinculado[]" value="'.utf8_encode($row["numeroDocumento"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Genero:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="genero" name="generoSujetoVinculado[]" value="'.utf8_encode($row["genero"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Nacionalidad cliente:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="nacionalidad" name="nacionalidadSujetoVinculado[]" value="'.utf8_encode($row["nacionalidad"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Pais de nacimiento:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="paisNacimiento" name="paisNacimientoSujetoVinculado[]" value="'.utf8_encode($row["paisNacimiento"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Lugar de nacimiento:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="lugarNacimiento" name="lugarNacimientoSujetoVinculado[]" value="'.utf8_encode($row["lugarNacimiento"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Fecha de nacimiento:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="fechaNacimiento" name="fechaNacimientoSujetoVinculado[]" value="'.utf8_encode($row["fechaNacimiento"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Pais:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="pais" name="paisSujetoVinculado[]" value="'.utf8_encode($row["pais"]).'" readonly="true"></td>                        
                                    </tr>
                                ';
                                if(utf8_encode($row["pais"]) === "Argentina"){
                                    $html .='<tr>
                                    <td><label>Provincia:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="provincia" name="provinciaSujetoVinculado[]" required="true" value="'.utf8_encode($row["provincia"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Localidad:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="localidad" name="localidadSujetoVinculado[]" value="'.utf8_encode($row["localidad"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Calle:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="calle" name="calleSujetoVinculado[]" value="'.utf8_encode($row["calle"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Numero:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="numero" name="numeroSujetoVinculado[]" value="'.utf8_encode($row["numero"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Piso:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="piso" name="pisoSujetoVinculado[]" value="'.utf8_encode($row["piso"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Departamento:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="departamento" name="departamentoSujetoVinculado[]" value="'.utf8_encode($row["departamento"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Codigo Postal:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="codigoPostal" name="codigoPostalSujetoVinculado[]" value="'.utf8_encode($row["codigoPostal"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Codigo de area:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="codigoArea" name="codigoAreaSujetoVinculado[]" value="'.utf8_encode($row["codigoArea"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Telefono:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="telefono" name="telefonoSujetoVinculado[]" value="'.utf8_encode($row["telefono"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Correo electronico:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="correoElectronico" name="correoElectronicoSujetoVinculado[]" value="'.utf8_encode($row["correoElectronico"]).'"></td>                        
                                    </tr>
                                    </table>
                                ';
                                }else{
                                    $html .='<tr>
                                    <td><label>Otro Pais:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="otroPais" name="otroPaisSujetoVinculado[]" value="'.utf8_encode($row["otroPais"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Provincia / Estado:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="provinciaEstado" name="provinciaEstadoSujetoVinculado[]" value="'.utf8_encode($row["provinciaEstado"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Localidad / Ciudad:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="localidadCiudad" name="localidadCiudadSujetoVinculado[]" value="'.utf8_encode($row["localidadCiudad"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Domicilio / Direccion:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="domicilioDireccion" name="domicilioDireccionSujetoVinculado[]" value="'.utf8_encode($row["domicilioDireccion"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Codigo Postal:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="codigoPostal" name="codigoPostalSujetoVinculado[]" value="'.utf8_encode($row["codigoPostal"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Codigo de area:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="codigoArea" name="codigoAreaSujetoVinculado[]" value="'.utf8_encode($row["codigoArea"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Telefono:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="telefono" name="telefonoSujetoVinculado[]" value="'.utf8_encode($row["telefono"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Correo electronico:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="correoElectronico" name="correoElectronicoSujetoVinculado[]" value="'.utf8_encode($row["correoElectronico"]).'"></td>                        
                                    </tr>
                                    </table>
                                ';
                                    
                                }
                            }
                            }
                            
                        }
                    }
                    return $html;
                }

                //tabla bajas
                function Bajas() {
                    $result = baja();
                    $html = '';
                    while ($row = sqlsrv_fetch_array($result)) {
                        if($row['vinculado'] === "NO"){
                            //no vinculado
                            $html .= '<input type="hidden" id="idBaja" name="idBaja[]" value="'.utf8_encode($row["idCuentasComitentesBajas"]).'">
                                <hr /><hr /><h5><u>Cliente</u></h5><hr /><hr />
                                <table class="table table-bordered table-striped" id="tablaJuridicas">
                                <tr>
                                    <td><label>Tipo de Cliente:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="tipoCliente" name="tipoClienteBaja[]" required="true" value="'.utf8_encode($row["tipoCliente"]).'"></td>                        
                                 </tr>
                                 <tr>
                                    <td><label>CUIT/CUIL/CDI:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="cuil" name="cuilBaja[]" placeholder="CUIT/CUIL/CDI" value="'.utf8_encode($row["cuil"]).'"></td>                        
                                 </tr>
                                 <tr>
                                    <td><label>Tipo de Persona:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="tipoPersona" name="tipoPersonaBaja[]" value="'.utf8_encode($row["tipoPersona"]).'" readonly="true"></td>                        
                                 </tr>
                                ';
                            //no vinculado persona juridica
                            if(utf8_encode($row["tipoPersona"]) === "Persona jurídica" || utf8_encode($row["tipoPersona"]) === "Persona jurídica extranjera"){
                                
                                $html .='<tr>
                                    <td><label>Denominacion:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="denominacion" name="denominacionBaja[]" required="true" value="'.utf8_encode($row["denominacion"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Fecha de Constitucion:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="fechaConstitucion" name="fechaConstitucionBaja[]" value="'.utf8_encode($row["fechaConstitucion"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Riesgo asignado al cliente:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="riesgo" name="riesgoBaja[]" value="'.utf8_encode($row["riesgo"]).'"></td>                        
                                    </tr>
                                    </table>
                                ';
                            }else{
                                //no vinculado persona humana
                                if(utf8_encode($row["tipoPersona"]) === "Persona humana" || utf8_encode($row["tipoPersona"]) === "Persona humana extranjera"){
                                
                                $html .='<tr>
                                    <td><label>Apellido:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="apellido" name="apellidoBaja[]" required="true" value="'.utf8_encode($row["apellido"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Nombre:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="nombre" name="nombreBaja[]" value="'.utf8_encode($row["nombre"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Tipo de documento:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="tipoDocumento" name="tipoDocumentoBaja[]" value="'.utf8_encode($row["tipoDocumento"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Numero de documento:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="numeroDocumento" name="numeroDocumentoBaja[]" value="'.utf8_encode($row["numeroDocumento"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Riesgo asignado al cliente:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="riesgo" name="riesgoBaja[]" value="'.utf8_encode($row["riesgo"]).'"></td>                        
                                    </tr>
                                    </table>
                                ';
                            }
                            }
                        }else{
                            //vinculado persona juridica
                            $html .= '<input type="hidden" id="idSujetoVinculadoBaja" name="idSujetoVinculadoBaja[]" value="'.utf8_encode($row["idCuentasComitentesBajas"]).'">
                                <hr /><hr /><h5><u>Cliente Vinculado</u></h5><hr /><hr />
                                <table class="table table-bordered table-striped" id="tablaJuridicas">
                                <tr>
                                    <td><label>Naturaleza del vinculo:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="naturalezaSujetoVinculadoBaja" name="naturalezaSujetoVinculadoBaja[]" required="true" value="'.utf8_encode($row["naturalezaDelVinculo"]).'"></td>                        
                                 </tr>
                                 <tr>
                                    <td><label>CUIT/CUIL/CDI:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="cuil" name="cuilSujetoVinculadoBaja[]" placeholder="CUIT/CUIL/CDI" value="'.utf8_encode($row["cuil"]).'"></td>                        
                                 </tr>
                                 <tr>
                                    <td><label>Tipo de Persona:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="tipoPersona" name="tipoPersonaSujetoVinculadoBaja[]" value="'.utf8_encode($row["tipoPersona"]).'" readonly="true"></td>                        
                                 </tr>
                                ';
                            //vinculado persona juridica
                            if(utf8_encode($row["tipoPersona"]) === "Persona jurídica" || utf8_encode($row["tipoPersona"]) === "Persona jurídica extranjera"){
                                
                                $html .='<tr>
                                    <td><label>Denominacion:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="denominacion" name="denominacionSujetoVinculadoBaja[]" required="true" value="'.utf8_encode($row["denominacion"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Fecha de Constitucion:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="fechaConstitucion" name="fechaConstitucionSujetoVinculadoBaja[]" value="'.utf8_encode($row["fechaConstitucion"]).'"></td>                        
                                    </tr>
                                    </table>
                                ';
                            }else{
                                //vinculado persona humana
                                if(utf8_encode($row["tipoPersona"]) === "Persona humana" || utf8_encode($row["tipoPersona"]) === "Persona humana extranjera"){
                                
                                $html .='<tr>
                                    <td><label>Apellido:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="apellido" name="apellidoSujetoVinculadoBaja[]" required="true" value="'.utf8_encode($row["apellido"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Nombre:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="nombre" name="nombreSujetoVinculadoBaja[]" value="'.utf8_encode($row["nombre"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Tipo de documento:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="tipoDocumento" name="tipoDocumentoSujetoVinculadoBaja[]" value="'.utf8_encode($row["tipoDocumento"]).'"></td>                        
                                    </tr>
                                    <tr>
                                    <td><label>Numero de documento:</label></td>
                                    <td><input size=60 type="text" class="form-control mb-3" id="numeroDocumento" name="numeroDocumentoSujetoVinculadoBaja[]" value="'.utf8_encode($row["numeroDocumento"]).'"></td>                        
                                    </tr>
                                    </table>
                                ';
                            }
                            }
                            
                        }
                    }
                    return $html;
                }
                
                
                ?>
                <form action="procesarModificarCuentaComitente.php" id='formModificarCuentaComitente' name='formModificarCuentaComitente' method="post" enctype="multipart/form-data">
                    <div id="centro" class="container">
                        <div class="col-lg-12">
                            <div class="row">
                                <div id="contenido1" class="col-lg-12 contenido1">
                                    <div class="center">
                                        <h3 class="text-center">Reporte De Cuentas Comitentes: </h3>
                                    </div>
                                    <br>
                                    <div class="form-row align-items-center mx-auto">
                                        <div class="col-auto">
                                            <h5><u>DATOS GENERALES</u></h5>
                                            <br>
                                            <table>
                                                <tr>
                                                <input type="hidden" id="idTransaccion" name="idTransaccion" value="<?= $idCuentaComitente ?>">
                                                <td><label for="fecha">Fecha:</label></td>
                                                <td><input size=60 type="text" class="form-control mb-3" id="fecha" name="fecha" placeholder="Fecha y Hora (AAAA-MM-DDT00:00:00)" required="true" value="<?= $fecha ?>"></td>                        
                                                </tr>
                                                <tr>
                                                    <td><label for="estado">Estado:</label></td>
                                                    <td><input type="text" class="form-control mb-3" id="estado" name="estado" placeholder="Estado" required="true" value="<?= $estado ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td><label for="depositante">Numero de cuenta depositante:</label></td>
                                                    <td><input type="text" class="form-control mb-3" id="depositante" name="depositante" placeholder="depositante" required="true" value="<?= $cuentaDepositante ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td><label for="comitente">Numero de cuenta comitente:</label></td>
                                                    <td><input type="text" class="form-control mb-3" id="comitente" name="comitente" placeholder="comitente" required="true" value="<?= $cuentaComitente ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td><label for="vinculados">Cantidad de vinculados:</label></td>
                                                    <td><input type="number" class="form-control mb-3" id="vinculados" name="vinculados" placeholder="vinculados" required="true" value="<?= $cantidad ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td><label for="accion">Tipo de Accion:</label></td>
                                                    <td><input type="text" class="form-control mb-3" id="accion" name="accion" placeholder="accion" required="true" value="<?= $accion ?>" readonly="true"></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TABLA Clientes -->


                    <div class="form-group">
                        <br>
                                <?php
                                echo $output = Altas();
                                echo $output = Bajas();
                                ?>
            
                    </div>

                    <hr /><hr />
                    <br>
                    <!--Panel de Botones -->

                    <div class="row">
                        <div class="col">
                            <div class="text-center">
                                <input type="submit" class="btn btn-bsc" id="btnGuardar" name="btnGuardar" value="Guardar">
                                <a href="formBuscarCuentaComitente.php"><input type="button" class="btn btn-outline-secondary" value="Cancelar"></a>
                            </div>
                        </div>
                    </div><br>
                </form>
            <?php } // ELSE            ?>
        </div>
    </div>
    <div id="contenido2"></div>

</div>
</body>
</html>