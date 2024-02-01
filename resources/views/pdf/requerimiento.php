<!DOCTYPE html>

<html>

<head>

    <style>

        /** Define the margins of your page **/

        @page {

            margin: 100px 25px;

        }



        body{

            font-family: 'Manrope', sans-serif;

        }



        header {

            position: fixed;

            top: -70px;

            left: 0px;

            right: 0px;

            height: 50px;



            /** Extra personal styles **/

            color: black;

            text-align: right;

            line-height: 25px;

        }



        footer {

            position: fixed; 

            bottom: -70px; 

            left: 0px; 

            right: 0px;

            height: 50px; 



            /** Extra personal styles **/

            color: black;

            text-align: center;

            line-height: 25px;

        }

        hr{

            height: 1px;

            background-color: #2bc3eb;

            border: none;

        }

        .centrar{

            text-align: center;

        }

        h1{

            font-weight: 400 !important;

        }

        table {

            border-collapse: collapse;

        }

        thead{

            background-color: #d9d9d9;

            text-align: center;

            color: #3760b7;

            font-weight: 600;

        }

        .simulacion{

            background-color: #444444;

            color: white;

            font-weight: 400;

        }

        .lastrow{

            background-color: #d9d9d9;

            font-weight: 800;

        }

        .alignright{

            text-align: right;

        }

        /*thead td{

            padding: 7px 0px 7px 15px !important;

        }*/

        tbody tr.borde{

            border-bottom: 1px solid #ebebeb;

        }

        td{

            padding: 7px;

        }

        img{

            height: 25px;

        }

        .notas_promos{

            font-size: 10px;

        }

    </style>

    <title>Requrimiento</title>

</head>

<body>

    <?php 

        $nameRequerimiento = "Requerimiento";//$data['name']; 

      /*  $url = URL::to('/').'/imagenes/logo_bancos/'; 

        $montoCredito = $data["montoCredito"];

        $garantia = $data["garantia"];*/

    ?>

    <header>

        <!-- {{ URL::to('/') }}/app-assets/img/logo/logo-solidez.png  -->

        <img src="https://grupoperti.com.mx/static/assets/front/img/logo-grupo-perti.svg" border="0" alt="Logo" style="height:60px;" />

        <hr/>

    </header>



    <footer>

        <hr/>

        <table style="text-align: center; width:100%;">

            <tr>

                <td></td>

                <td>Grupo Perti</td>

                <td></td>

            </tr>

        </table>

    </footer>

    

    <main>

        <?php $title = "ITStuff"; $body="HElo";?>

        <h1 class="centrar">REQUERIMIENTO</h1>

        <table style="width:100%;">
            <thead>
            
                <tr class="borde">

                    <td colspan="4"><b>Datos del cliente</b></td>

                </tr>

            </thead>
            <tbody>

                <tr class="borde">

                    <td><b>Cliente:</b></td>

                    <td colspan="3"><?php echo $clienteData[0]->nombres; ?></td>

                </tr>

                <tr class="borde">

                    <td><b>Dirección:</b></td>

                    <td colspan="3"><?php 
                        if(trim($clienteData[0]->num_ext) != ''){
                            $num_ext = ' '.$clienteData[0]->num_ext;
                        }
                        else{
                            $num_ext = ' ';
                        }
                        if(trim($clienteData[0]->codigo_postal) != ''){
                            $codigo_postal = ' '.$clienteData[0]->codigo_postal;
                        }
                        else{
                            $codigo_postal = ' ';
                        }
                        if(trim($clienteData[0]->ciudad) != ''){
                            $ciudad = ' '.$clienteData[0]->ciudad;
                        }
                        else{
                            $ciudad = ' ';
                        }
                        if(trim($clienteData[0]->estado) != ''){
                            $estado = ', '.$clienteData[0]->estado;
                        }
                        else{
                            $estado = ' ';
                        }
                        echo $clienteData[0]->calle." ".$clienteData[0]->num_int.$num_ext.$codigo_postal.$ciudad.$estado; ?></td>

                </tr>

                <tr class="borde">

                    <td><b>Referencia:</b></td>

                    <td colspan="3"><?php echo $clienteData[0]->referencia; ?></td>

                </tr>

                <tr class="borde">

                    <td><b>Teléfono:</b></td>

                    <td><?php echo $clienteData[0]->telefono; ?></td>

                    <td><b>Correo electrónico:</b></td>

                    <td><?php echo $clienteData[0]->email; ?></td>

                </tr>

            </tbody>

        </table>

        <br><br>

        <table style="width:100%;">
            <thead>
            
                <tr class="borde">

                    <td colspan="4"><b>Datos generales</b></td>

                </tr>

            </thead>
            <tbody>

                <tr class="borde">

                    <td><b>Puesto:</b></td>

                    <td><?php echo $generalData[0]->puesto; ?></td>

                    <td><b>Número de vacantes:</b></td>

                    <td><?php echo $generalData[0]->novacantes; ?></td>

                </tr>

                <tr class="borde">

                    <td><b>Fecha de solicitud:</b></td>

                    <td><?php echo $generalData[0]->fecha; ?></td>

                    <td><b>Servicio requerido:</b></td>

                    <td><?php echo $generalData[0]->servicio; ?></td>

                </tr>

                <tr class="borde">

                    <td><b>Modalidad:</b></td>

                    <td><?php echo $generalData[0]->modalidad; ?></td>

                    <td><b>Tiempo de asignación:</b></td>

                    <td><?php 
                                    if($generalData[0]->tiemasignacion == 1){
                                        if($generalData[0]->cantidadtiempo > 1 || $generalData[0]->cantidadtiempo < 1){
                                            echo $generalData[0]->cantidadtiempo." días";
                                        }
                                        else{
                                            echo "1 día";
                                        }
                                    } 

                                    if($generalData[0]->tiemasignacion == 2){
                                        if($generalData[0]->cantidadtiempo > 1 || $generalData[0]->cantidadtiempo < 1){
                                            echo $generalData[0]->cantidadtiempo." meses";
                                        }
                                        else{
                                            echo "1 mes";
                                        }
                                    }  

                                    if($generalData[0]->tiemasignacion == 3){
                                        echo "Indefinido";
                                    } 
                            ?></td>

                </tr>

                <tr class="borde">

                    <td><b>Horario:</b></td>

                    <td><?php if($generalData[0]->horario_inicio != '' && $generalData[0]->horario_fin != '' ) echo $generalData[0]->horario_inicio." a ".$generalData[0]->horario_fin; ?></td>

                    <td><b>Ejecutivo encargado:</b></td>

                    <td><?php echo $generalData[0]->executive_name; ?></td>

                </tr>

            </tbody>

        </table>

        <br><br>
        
        <table style="width:100%;">
            <thead>
            
                <tr class="borde">

                    <td colspan="4"><b>Información personal</b></td>

                </tr>

            </thead>
            <tbody>

                <tr class="borde">

                    <td><b>Rango de edad:</b></td>

                    <td colspan="3"><?php echo $personalData[0]->rangoedad; ?></td>

                </tr>

                <tr class="borde">

                    <td><b>Sexo:</b></td>

                    <td><?php if($personalData[0]->sexo == 1)echo "Femenino";
                              if($personalData[0]->sexo == 2)echo "Masculino";
                              if($personalData[0]->sexo == 3)echo "Indiferente";
                         ?></td>

                    <td><b>Estado civil:</b></td>

                    <td><?php echo $personalData[0]->estados_civiles; ?></td>

                </tr>

                <tr class="borde">

                    <td><b>Lugar residencia:</b></td>

                    <td colspan="3"><?php echo $personalData[0]->lugarresidencia; ?></td>

                </tr>

            </tbody>

        </table>

        <br><br>
        
        <table style="width:100%;">
            <thead>
            
                <tr class="borde">

                    <td colspan="4"><b>Información academica</b></td>

                </tr>

            </thead>
            <tbody>

                <tr class="borde">

                    <td><b>Escolaridad:</b></td>

                    <td colspan="3"><?php echo $academicData->escolaridad; ?></td>

                </tr>

                <tr class="borde">

                    <td><b>Certificados o cursos:</b></td>

                    <td colspan="3"><?php echo $academicData->certificado_select; ?></td>

                </tr>

                <tr class="borde">

                    <td><b>Idiomas:</b></td>

                    <td colspan="3"><?php echo $academicData->idiom_select; ?></td>

                </tr>

            </tbody>

        </table>

        <br><br>
        
        <table style="width:100%;">
            <thead>
            
                <tr class="borde">

                    <td colspan="4"><b>Descripción del puesto</b></td>

                </tr>

            </thead>
            <tbody>

                <tr class="borde">

                    <td><b>Experiencia:</b></td>

                    <td colspan="3"><?php echo $puestoData[0]->experiencia; ?></td>

                </tr>

                <tr class="borde">

                    <td><b>Actividades:</b></td>

                    <td colspan="3"><?php echo $puestoData[0]->actividades; ?></td>

                </tr>

                <tr class="borde">

                    <td><b>Conocimientos técnicos:</b></td>

                    <td colspan="3"><?php echo $puestoData[0]->conocimientos_tecnicos; ?></td>

                </tr>

                <tr class="borde">

                    <td><b>Competencias necesarias:</b></td>

                    <td colspan="3"><?php echo $puestoData[0]->competencias_necesarias; ?></td>

                </tr>

            </tbody>

        </table>

        <br><br>

        <table style="width:100%;">
            <thead>
            
                <tr class="borde">

                    <td colspan="4"><b>Requerimientos adicionales</b></td>

                </tr>

            </thead>
            <tbody>

                <tr class="borde">

                    <td><b>Disponibilidad para desplazarse:</b></td>

                    <td colspan="3"><?php 
                                if($adicionalData[0]->desplazarse == 1) echo "Sí";
                                if($adicionalData[0]->desplazarse == 2) echo "No";
                                if($adicionalData[0]->desplazarse == 3) echo $adicionalData[0]->desplazarse_motivo; 
                                ?></td>

                </tr>

                <tr class="borde">

                    <td><b>Disponibilidad para viajar:</b></td>

                    <td colspan="3"><?php
                                if($adicionalData[0]->viajar == 1) echo "Sí";
                                if($adicionalData[0]->viajar == 2) echo "No";
                                if($adicionalData[0]->viajar == 3) echo $adicionalData[0]->viajar_motivo; 
                                ?></td>

                </tr>

                <tr class="borde">

                    <td><b>Disponibilidad de horario:</b></td>

                    <td colspan="3"><?php 
                                 if($adicionalData[0]->disponibilidad_horario == 1) echo "Sí";
                                 if($adicionalData[0]->disponibilidad_horario == 2) echo "No";
                                 if($adicionalData[0]->disponibilidad_horario == 3) echo $adicionalData[0]->disponibilidad_horario_motivo; 
                                  ?></td>

                </tr>

                <tr class="borde">

                    <td><b>Cuenta con personal a cargo:</b></td>

                    <td colspan="3"><?php 
                                if($adicionalData[0]->personal_cargo == 1) echo "Sí(".$adicionalData[0]->num_personas_cargo.")";
                                if($adicionalData[0]->viajar == 2) echo "No";
                                ?></td>

                </tr>

                <tr class="borde">

                    <td><b>A quién reporta directamente:</b></td>

                    <td colspan="3"><?php echo $adicionalData[0]->persona_reporta; ?></td>

                </tr>

                <tr class="borde">

                    <td><b>Requiere equipo de cómputo propio:</b></td>

                    <td colspan="3"><?php if($adicionalData[0]->equipo_computo == 1) echo "Sí";
                              if($adicionalData[0]->equipo_computo == 2) echo "No"; ?></td>

                </tr>

            </tbody>

        </table>

        <br><br>

        <table style="width:100%;">
            <thead>
            
                <tr class="borde">

                    <td colspan="4"><b>Propuesta económica</b></td>

                </tr>

            </thead>
            <tbody>

                <tr class="borde">

                    <td><b>Esquema de contratación:</b></td>

                    <td><?php echo $economicaData[0]->esquemacontratacion; ?></td>

                    <td><b>Tipo de salario:</b></td>

                    <td><?php echo $economicaData[0]->tiposalario; ?></td>

                </tr>

                <tr class="borde">

                    <td><b>Monto mínimo:</b></td>

                    <td><?php echo number_format($economicaData[0]->montominimo,2); ?></td>

                    <td><b>Monto máximo:</b></td>

                    <td><?php echo number_format($economicaData[0]->montomaximo,2); ?></td>

                </tr>

                <tr class="borde">

                    <td><b>Jornada laboral:</b></td>

                    <td><?php echo $economicaData[0]->jornadalaboral; ?></td>

                    <td></td>

                    <td></td>
                </tr>

                <tr class="borde">

                    <td><b>Prestaciones/Beneficiosrio:</b></td>

                    <td colspan="3"><?php echo $economicaData[0]->prestaciones_beneficios; ?></td>

                </tr>

            </tbody>

        </table>

        <br><br>

        <table style="width:100%;">
            <thead>
            
                <tr class="borde">

                    <td colspan="4"><b>Proceso</b></td>

                </tr>

            </thead>
            <tbody>

                <tr class="borde">

                    <td><b>Duración estimada del proceso:</b></td>

                    <td><?php echo $procesoData[0]->duracion; ?></td>

                    <td><b>Cantidad de filtros a realizar:</b></td>

                    <td><?php echo $procesoData[0]->cantidadfiltros; ?></td>

                </tr>

                <tr class="borde">

                    <td><b>Niveles que participan en el filtro:</b></td>

                    <td><?php echo $procesoData[0]->niveles_flitro; ?></td>

                    <td></td>

                    <td></td>

                </tr>

                <tr class="borde">

                    <td colspan="4"><b>Incluye:</b></td>

                </tr>

                <tr class="borde">

                    <td><b>Entrevista filtro:</b></td>

                    <td><?php if($procesoData[0]->entrevista == 1) echo "Sí"; else echo "No"; ?></td>

                    <td><b>Prueba técnica:</b></td>

                    <td><?php if($procesoData[0]->pruebatecnica == 1) echo "Sí"; else echo "No"; ?></td>

                </tr>

                <tr class="borde">

                    <td><b>Pruebas psicométricas:</b></td>

                    <td><?php if($procesoData[0]->pruebapsicometrica == 1) echo "Sí"; else echo "No"; ?></td>

                    <td><b>Referencias:</b></td>

                    <td><?php if($procesoData[0]->referencias == 1) echo "Sí"; else echo "No"; ?></td>

                </tr>

            </tbody>

        </table>

        <br><br>

        <table style="width:100%;">
            <thead>
            
                <tr class="borde">

                    <td colspan="4"><b>Datos adicionales</b></td>

                </tr>

            </thead>
            <tbody>

                <tr class="borde">

                    <td><b>Razón no contratación:</b></td>

                    <td colspan="3"><?php echo $finalData[0]->razonnocontratacion; ?></td>

                </tr>

                <tr class="borde">

                    <td><b>Fecha de contratación:</b></td>

                    <td colspan="3"><?php echo $finalData[0]->fechacontratacion; ?></td>

                </tr>

            </tbody>

        </table>

    </main>

    

</body>

</html>