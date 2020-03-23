<?php

class ControladorReportesDiarios {

    public function getNroChequesPagadosPorCaja() {
        $sql = "SELECT COUNT(id) cantidad FROM [5chequesPagadosCaja] WHERE id IS NOT NULL";
        return $this->consultarNumeroRegistros($sql);
    }

    public function getNroChequesCobradosPorMorosos() {
        $sql = "select count(id) cantidad from [5chequesCobradosMorosos] WHERE id IS NOT NULL";
        return $this->consultarNumeroRegistros($sql);
    }

    public function getNroCuentasSinRestriccionDebitos() {
        $sql = "select count(id) cantidad from [5cuentasSinRestriccion] WHERE id IS NOT NULL";
        return $this->consultarNumeroRegistros($sql);
    }

    public function getNroTarjetasMalVinculadas() {
        $sql = "select count(id) cantidad from [5tarjetasMalVinculadas] WHERE id IS NOT NULL";
        return $this->consultarNumeroRegistros($sql);
    }

    public function getNroCobrosNoAplicados() {
        $sql = "select count(id) cantidad from [4cobroNoAplicado] WHERE id IS NOT NULL";
        return $this->consultarNumeroRegistros($sql);
    }

    public function getReportesDiarios() {
        $reportes = array();
        $reportes[0] = array("CHEQUES PAGADOS POR CAJA", "formReporteChequesPagadosCaja.php", $this->getNroChequesPagadosPorCaja());
        $reportes[1] = array("CHEQUES COBRADOS POR MOROSOS", "formReporteChequesCobrados.php", $this->getNroChequesCobradosPorMorosos());
        $reportes[2] = array("CUENTAS SIN RESTRICCIÓN A LOS DÉBITOS DE CLIENTES FALLECIDOS", "formReporteCuentasSinRestriccion.php", $this->getNroCuentasSinRestriccionDebitos());
        $reportes[3] = array("TARJETAS DE DÉBITO MAL VINCULADAS", "formReporteTarjetasMalVinculadas.php", $this->getNroTarjetasMalVinculadas());
        $reportes[4] = array("COBROS NO APLICADOS", "formReporteCobrosNoAplicados.php", $this->getNroCobrosNoAplicados());
        return $reportes;
    }

    private function consultarNumeroRegistros($consulta) {
        $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $consulta);
        if ($result) {
            $fila = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            return $fila["cantidad"];
        }
        Log::escribirError("[Error al consultar numero de registros para reporte diario][QUERY: $consulta]");
        return NULL;
    }

}
