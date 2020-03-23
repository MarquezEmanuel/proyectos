<?php include_once '../../Principal/Vista/Header.php'; ?>
<div id="content-wrapper">
    <div class="container bg-white mb-4 mt-4 rounded" id="superior">
        <h2 class="pb-4 pt-4 border-bottom mb-4"><b>REVALIDA - Manual de usuario</b></h2>
        <div class="row">
            <div class="col-md-8" id="busqueda">
                <div class="card mb-2" id="card-introduccion">
                    <div class="card-header">
                        <div class="row">
                            <div class="col"><b>Introducción</b></div>
                            <div class="col text-right">
                                <i class="fas fa-eye mostrar" id="mostrar-introduccion" name="introduccion"  style="display: none;"></i>
                                <i class="fas fa-eye-slash ocultar" id="ocultar-introduccion" name="introduccion"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="body-introduccion">
                        <div class="row">
                            <div class="col">
                                <p class="text-justify">El presente sistema surgió como respuesta a la problematica de 
                                    gestión de perfiles y permisos asociados a los usuarios del Banco Santa Cruz.
                                    La solución presentada le permite a la gerencia de <b>Protección de Activos 
                                        de la Información (PAI)</b> acceder a datos actualizados en forma diaria que son
                                    recopilados de cada uno de los aplicativos designados.</p>
                                <p class="text-justify"><b>REVALIDA</b> ofrece a usuarios autorizados, en forma general, las siguientes funcionalidades:</p>
                                <ul class="list-unstyled ml-4 text-justify">
                                    <li class="mb-2"><b>Actualizar perfiles de usuarios externos:</b>  De forma automatica mediante 
                                        procedimientos que consultan las bases de datos de ciertos sistemas o de forma 
                                        manual a traves de la importación de archivos de aplicaciones de terceros.
                                    </li>
                                    <li class="mb-2"><b>Gestionar formularios:</b> A los empleados generar solicitudes formales 
                                        de alta, baja y modificación de acceso a aplicaciones y servicios. A los 
                                        gerentes, propietarios de datos y PAI, aceptar o rechazar dichas solicitudes.
                                        Ademas, generar la documentacion de las solicitudes en formato PDF.
                                    </li>
                                    <li class="mb-2"><b>Administrar información:</b> Permite que la Gerencia de PAI pueda
                                        parametrizar las aplicaciones, servicios y gerencias. Esta información sirve de
                                        soporte para poder llevar a cabo la gestión de formularios (Explicado anteriormente).
                                    </li>
                                    <li class="mb-2"><b>Generar reportes:</b> Los usuarios pueden acceder a reportes con gráficos
                                        y detalle para cada uno de los modulos del sistema. Junto con esto, se puede realizar la
                                        exportación de los datos consultados.
                                    </li>
                                </ul>
                                <p class="text-justify"><b>Sobre el acceso al sistema</b></p>
                                <p class="text-justify">Se realiza mediante número de legajo y
                                    clave personal. La validación del usuario que intenta acceder es doble: primero se verifican los datos
                                    como parte del dominio de Active Directory. Segundo, debe estar dado de alta como usuario dentro del
                                    sistema. El incumplimiento de alguna de las validaciones deniega el acceso.</p>
                                <p class="text-justify"><b>Sobre los roles iniciales</b></p>
                                <p class="text-justify">Un usuario con acceso al sistema puede tener designado algunos de los siguientes
                                    roles: Empleado, Gerente, Propietario de datos o Administrador. Dichos roles (iniciales) pueden verse
                                    modificados con el correr del tiempo. El administrador del sistema es el encargado de otorgar los
                                    permisos correspondientes a cada uno de los roles.</p>
                                <p class="text-justify"><b>Sobre los mensajes del sistema</b></p>
                                <p class="text-justify">Durante la utilización del sistema, es posible encontrarse con distintos tipos de 
                                    mensajes los cuales sirven para diferenciar cada operación realizada.</p>
                                <div class="alert alert-success text-center" role='alert'>
                                    <i class='far fa-check-circle'></i> <strong> Este es un mensaje de exito</strong>
                                </div>
                                <div class="alert alert-warning text-center" role='alert'>
                                    <i class='fas fa-exclamation-circle'></i> <strong> Este es un mensaje de advertencia</strong>
                                </div>
                                <div class="alert alert-danger text-center" role='alert'>
                                    <i class='fas fa-exclamation-triangle'></i> <strong> Este es un mensaje de error</strong>
                                </div>
                                <p class="text-justify ml-4 mr-4"><em>NOTA: Se recomienda que los mensajes de error sean identificados por el usuario e informados
                                        tanto al administrador del sistema como a la Gerencia de Sistemas. Toda información que se pueda
                                        adjuntar al error es de importancia (Por ejemplo: capturas de pantalla, modulo, operacion, fecha y hora).</em></p>
                                <p class="text-justify">En las secciones posteriores se ofrece una explicación detallada de cada uno
                                    de los modulos que componen a REVALIDA.</p>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-2" id="card-accesos">
                    <div class="card-header">
                        <div class="row">
                            <div class="col"><b>Accesos</b></div>
                            <div class="col text-right">
                                <i class="fas fa-eye mostrar" id="mostrar-accesos" name="accesos" style="display: none;"></i>
                                <i class="fas fa-eye-slash ocultar" id="ocultar-accesos" name="accesos"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="body-accesos">
                        <div class="row">
                            <div class="col">
                                <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-2" id="card-aplicaciones">
                    <div class="card-header">
                        <div class="row">
                            <div class="col"><b>Aplicaciones</b></div>
                            <div class="col text-right">
                                <i class="fas fa-eye mostrar" id="mostrar-aplicaciones" name="aplicaciones" style="display: none;"></i>
                                <i class="fas fa-eye-slash ocultar" id="ocultar-aplicaciones" name="aplicaciones"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="body-aplicaciones">
                        <div class="row">
                            <div class="col">
                                <p class="text-justify">El modulo de aplicaciones permite configurar y administrar cada uno
                                    de los sistemas de la entidad. El usuario puede acceder a la información
                                    básica de una aplicacion como su nombre y la gerencia asociada (Ver sección
                                    3. Gerencias) ademas de su estado actual. 
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-2" id="card-gerencias">
                    <div class="card-header">
                        <div class="row">
                            <div class="col"><b>Gerencias</b></div>
                            <div class="col text-right">
                                <i class="fas fa-eye mostrar" id="mostrar-gerencias" name="gerencias"  style="display: none;"></i>
                                <i class="fas fa-eye-slash ocultar" id="ocultar-gerencias" name="gerencias"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="body-gerencias">
                        <div class="row">
                            <div class="col">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-2" id="card-reportes">
                    <div class="card-header">
                        <div class="row">
                            <div class="col"><b>Reportes</b></div>
                            <div class="col text-right">
                                <i class="fas fa-eye mostrar" id="mostrar-reportes" name="reportes"  style="display: none;"></i>
                                <i class="fas fa-eye-slash ocultar" id="ocultar-reportes" name="reportes"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="body-reportes">
                        <div class="row">
                            <div class="col">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-2" id="card-seguridad">
                    <div class="card-header">
                        <div class="row">
                            <div class="col"><b>Seguridad</b></div>
                            <div class="col text-right">
                                <i class="fas fa-eye mostrar" id="mostrar-seguridad" name="seguridad"  style="display: none;"></i>
                                <i class="fas fa-eye-slash ocultar" id="ocultar-seguridad" name="seguridad"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="body-seguridad">
                        <div class="row">
                            <div class="col">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-2" id="card-servicios">
                    <div class="card-header">
                        <div class="row">
                            <div class="col"><b>Servicios</b></div>
                            <div class="col text-right">
                                <i class="fas fa-eye mostrar" id="mostrar-servicios" name="servicios"  style="display: none;"></i>
                                <i class="fas fa-eye-slash ocultar" id="ocultar-servicios" name="servicios"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="body-servicios">
                        <div class="row">
                            <div class="col">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-2" id="card-solicitudes">
                    <div class="card-header">
                        <div class="row">
                            <div class="col"><b>Solicitudes</b></div>
                            <div class="col text-right">
                                <i class="fas fa-eye mostrar" id="mostrar-solicitudes" name="solicitudes"  style="display: none;"></i>
                                <i class="fas fa-eye-slash ocultar" id="ocultar-solicitudes" name="solicitudes"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="body-solicitudes">
                        <div class="row">
                            <div class="col">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <aside class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header"><b>Secciones</b></div>
                    <div class="card-body">
                        <p class="text-justify">Haga click para ir a la sección deseada:</p>
                        <div class="list-group">
                            <a name="card-introduccion" class="list-group-item list-group-item-action seccion">1. Introducción</a>
                            <a name="card-accesos" class="list-group-item list-group-item-action seccion">2. Accesos</a>
                            <a name="card-aplicaciones" class="list-group-item list-group-item-action seccion">3. Aplicaciones</a>
                            <a name="card-gerencias" class="list-group-item list-group-item-action seccion">4. Gerencias</a>
                            <a name="card-reportes" class="list-group-item list-group-item-action seccion">5. Reportes</a>
                            <a name="card-seguridad" class="list-group-item list-group-item-action seccion">6. Seguridad</a>
                            <a name="card-servicios" class="list-group-item list-group-item-action seccion">7. Servicios</a>
                            <a name="card-solicitudes" class="list-group-item list-group-item-action seccion">8. Solicitudes</a>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header"><b>Acerca de</b></div>
                    <div class="card-body text-right">
                        <ul class="list-unstyled">
                            <li><em>Revalida de usuarios v1.0</em></li>
                            <li><em>Desarrollador por la Gerencia De Sistemas</em></li>
                            <li><em>Banco Santa Cruz</em></li>
                        </ul>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>
<script type="text/javascript" src="../Js/ManualUsuario.js"></script>