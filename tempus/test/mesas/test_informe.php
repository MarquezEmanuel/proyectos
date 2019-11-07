
<form action="test_informe_resultado.php">
    <fieldset>
    <legend>Formulario</legend>
        <label>Carrera:</label>
        <select id='selectCarrera' name='selectCarrera'>
        	<option value='todas'>Todos las carreras</option>
        	<option value='16'>Analista De Sistemas</option>
        	<option value='72'>Licenciatura En Sistemas</option>
        </select>
        
        <label>Día:</label>
        <select id='selectDia' name='selectDia'>
        	<option value='todos'>Todos los días</option>
            <option value='1'>Lunes</option>
            <option value='2'>Martes</option>
            <option value='3'>Miercoles</option>
            <option value='4'>Jueves</option>
            <option value='5'>Viernes</option>
            <option value='6'>Sabado</option>
        </select>
        
        <br><label>Hora de inicio:</label>
        <select id='selectHoraInicio' name='selectHoraInicio'>
            <option value='todas'>Todas las horas</option>
            <?php for ($horainicio = 10; $horainicio < 23; ++$horainicio) {
                echo "<option value='{$horainicio}:00'>{$horainicio}:00 hs</option>
                <option value='{$horainicio}:30'>{$horainicio}:30 hs</option>";
            } ?> 
        </select>
        <label>Hora de fin:</label>
        <select id='selectHoraFin' name='selectHoraFin'>
            <option value='todas'>Todas las horas</option>
            <?php for ($horafin = 10; $horafin < 24; ++$horafin) {
                echo "<option value='{$horafin}:00'>{$horafin}:00 hs</option>
                <option value='{$horafin}:30'>{$horafin}:30 hs</option>";
            }?> 
        </select>
        
        <br><label>Modificada:</label>
        	<select id='selectModificada' name='selectModificada'>
        	<option value='true'>Si</option>
        	<option value='false'>No</option>
        </select>
    </fieldset>
    
    <input type="submit" value="informe">
</form>