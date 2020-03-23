<?php
/* INICIALIZA LA SESION */
session_start();

require_once './menuReportes.php';
?>
<body id="body">
    <div class="container" style="margin: 60px;">
        <div class="card-header">
            
            <div class="form-row align-items-center mx-auto">
                <div class="col-lg-12 text-center">
                    <h4 class="text-center">Regimen TC</h4>
                    <br>
                    <h5 class="text-center"><u>SELECCIONE LA OPCION DESEADA</u></h5>
                </div>
            </div>
            <div class="form-row align-items-center mx-auto mt-2">
                <div class="col-lg-2 text-center">
                </div>
                <div class="col-lg-8 text-center">
                    <a href="formActualizarSMVM.php"> 
                        <button class="btn btn-lg btn-bsc btn-block" 
                                title="Actualizar Salario Minimo Vital y Movil"
                                type="submit">Actualizar SMVM</button>
                    </a>
                </div>
            </div>
            <div class="form-row align-items-center mx-auto mt-2">
                <div class="col-lg-2 text-center">
                </div>
                <div class="col-lg-8 text-center">
                    <a href="formBuscarCTTCPersonal.php"> 
                        <button class="btn btn-lg btn-bsc btn-block" 
                                title="Consolidado de Transacciones con Tarjetas de Credito Personales"
                                type="submit">CTTC Personal (Mayores a 13 SMVM)</button>
                    </a>
                </div>
            </div>
            <div class="form-row align-items-center mx-auto mt-2">
                <div class="col-lg-2 text-center">
                </div>
                <div class="col-lg-8 text-center">
                    <a href="formBuscarCTTCCorporativa.php">
                        <button class="btn btn-lg btn-bsc btn-block" 
                                title="Consolidado de Transacciones con Tarjetas de Credito Corporativas"
                                type="submit">CTTC Corporativa (Mayores a 50 SMVM)</button>
                    </a>
                </div>
            </div>
            <div class="form-row align-items-center mx-auto mt-2">
                <div class="col-lg-2 text-center">
                </div>
                <div class="col-lg-8 text-center">
                    <a href="formBuscarCDAGPersonal.php"> 
                        <button class="btn btn-lg btn-bsc btn-block" 
                                title="Consolidado de Anticipos de Gastos Personales"
                                type="submit" disabled>CDAG Personal (Mayores a 13 SMVM)</button>
                    </a>
                </div>
            </div>
            <div class="form-row align-items-center mx-auto mt-2">
                <div class="col-lg-2 text-center"></div>
                <div class="col-lg-8 text-center">
                    <a href="formBuscarCDAGCorporativa.php"> 
                        <button class="btn btn-lg btn-bsc btn-block" 
                                title="Consolidado de Anticipos de Gastos Corporativas"
                                type="submit" disabled>CDAG Corporativa (Mayores a 100 SMVM)</button>
                    </a>
                </div>
            </div>
            <div class="form-row align-items-center mx-auto mt-2">
                <div class="col-lg-2 text-center"></div>
                <div class="col-lg-8 text-center">
                    <a href="formBuscarITC.php">
                        <button class="btn btn-lg btn-bsc btn-block" 
                                title="Identificaciones de Tarjetas de Credito"
                                type="submit">Identificaciones de Tarjetas de Credito (ITC)</button>
                    </a>
                </div>
            </div>
            <div class="form-row align-items-center mx-auto mt-2 mb-4">
                <div class="col-lg-2 text-center"></div>
                <div class="col-lg-8 text-center">
                    <a href="inicioReportes.php">
                        <button class="btn btn-lg btn-bsc btn-block" 
                                title="Regresar al inicio"
                                type="submit">Volver</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>