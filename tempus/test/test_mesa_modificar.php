<?php
    
    require_once '../lib/conf/ObjetoDatos.php';
    require_once '../lib/conf/Utilidades.php';
    require_once '../modelos/mesas/Tribunal.php';
    require_once '../modelos/mesas/MesaExamen.php';
    
    $mesa = new MesaExamen();
    $tribunal = new Tribunal(92);
    $mesa->setTribunal($tribunal);
    
    $presidente = "Bilardo C.";
    $vocal1 = $tribunal->getVocal1()->getNombre();
    $vocal2= $tribunal->getVocal2()->getNombre();
    $suplente = $tribunal->getSuplente()->getNombre();
    
    echo "<br>idpresidente: ".$tribunal->getPresidente()->getIdDocente()." / ".$tribunal->getPresidente()->getNombre();
    echo "<br>idvocal1: ".$tribunal->getVocal1()->getIdDocente()." / ".$tribunal->getVocal1()->getNombre();
    echo "<br>idvocal2: ".$tribunal->getVocal2()->getIdDocente()." / ".$tribunal->getVocal2()->getNombre();
    echo "<br>suplente: ".$tribunal->getSuplente()->getIdDocente()." / ".$tribunal->getSuplente()->getNombre();
    
    $tribunalmod = $mesa->modificarTribunal($tribunal, $presidente, $vocal1, $vocal2, $suplente);
    if ($tribunalmod) {
        $mesa->setTribunal($tribunal);
        echo "<br>Se ha realizado la modificación del tribunal correctamente";
    } else {
        echo "<br>No se ha realizado la modificación del tribunal";
    }
    
    $tribunal = $mesa->getTribunal();
    
    echo "<br>idpresidente: ".$tribunal->getPresidente()->getIdDocente()." / ".$tribunal->getPresidente()->getNombre();
    echo "<br>idvocal1: ".$tribunal->getVocal1()->getIdDocente()." / ".$tribunal->getVocal1()->getNombre();
    echo "<br>idvocal2: ".$tribunal->getVocal2()->getIdDocente()." / ".$tribunal->getVocal2()->getNombre();
    echo "<br>suplente: ".$tribunal->getSuplente()->getIdDocente()." / ".$tribunal->getSuplente()->getNombre();
    
    