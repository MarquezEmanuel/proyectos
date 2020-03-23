<?php

class ControladorReportesLinea {

    public function getNroCorreosElectronicosInvalidos() {
        $sql = "SELECT COUNT(ID) cantidad FROM [dbo].[correosElectronicosInvalidos] WHERE ID > 0";
        return $this->consultarNumeroRegistros($sql);
    }

    public function getNroTelefonosParticularesInvalidos() {
        $sql = "SELECT COUNT(NROCLIENTE) cantidad FROM [dbo].[telefonosParticularesInvalidos] WHERE NROCLIENTE > 0";
        return $this->consultarNumeroRegistros($sql);
    }

    public function getNroPersonasFisicasDuplicadas() {
        $sql = "SELECT COUNT(ID) cantidad FROM [dbo].[personasFisicasDuplicadas] WHERE ID > 0";
        return $this->consultarNumeroRegistros($sql);
    }

    public function getNroCodigoPostalInconsistente() {
        $sql = "SELECT COUNT(ID) cantidad FROM [dbo].[codigoPostalInconsistente] WHERE ID > 0";
        return $this->consultarNumeroRegistros($sql);
    }

    public function getNroDomiciliosInconsistentes() {
        $sql = "SELECT COUNT(ID) cantidad FROM [dbo].[domiciliosInconsistentes] WHERE ID > 0";
        return $this->consultarNumeroRegistros($sql);
    }

    public function getNroDocumentosInvalidos() {
        $sql = "SELECT COUNT(ID) cantidad FROM [dbo].[documentosInvalidos] WHERE ID > 0";
        return $this->consultarNumeroRegistros($sql);
    }

    public function getReportesLinea() {
        $reportes = array();
        $reportes[0] = array("CLIENTES CON CORREOS ELECTRÓNICOS INVÁLIDOS", "formReporteCorreosInvalidos.php", $this->getNroCorreosElectronicosInvalidos());
        $reportes[1] = array("CLIENTES CON TELÉFONOS PARTICULARES INVÁLIDOS", "formReporteTelefonosInvalidos.php", $this->getNroTelefonosParticularesInvalidos());
        $reportes[2] = array("PERSONAS FÍSICAS DUPLICADAS", "formReportePersonasFisicasDuplicadas.php", $this->getNroPersonasFisicasDuplicadas());
        $reportes[3] = array("CÓDIGO POSTAL INCONSISTENTE", "formReporteCodigoPostalInconsistente.php", $this->getNroCodigoPostalInconsistente());
        $reportes[4] = array("CLIENTES CON DOMICILIO INCONSISTENTE", "formReporteDomiciliosInconsistentes.php", $this->getNroDomiciliosInconsistentes());
        $reportes[5] = array("DOCUMENTOS INVÁLIDOS", "formReporteDocumentosInvalidos.php", $this->getNroDocumentosInvalidos());
        return $reportes;
    }

    private function consultarNumeroRegistros($consulta) {
        $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $consulta);
        if ($result) {
            $fila = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            return $fila["cantidad"];
        }
        Log::escribirError("[Error al consultar numero de registros para reporte en linea][QUERY: $consulta]");
        return NULL;
    }

}
