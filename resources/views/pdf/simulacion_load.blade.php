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
    <title>Solidez Hipotecaria</title>
</head>
<body>
    <?php 
        $nameDirigido = $data['name']; 
        $url = URL::to('/').'/imagenes/logo_bancos/'; 
        $montoCredito = $data["montoCredito"];
        $garantia = $data["garantia"];
    
    ?>
    <header>
        <!-- {{ URL::to('/') }}/app-assets/img/logo/logo-solidez.png  -->
        <img src="https://sistema.solidezhipotecaria.com.mx/app-assets/img/logo/logo-solidez.png" border="0" alt="Logo" style="height:60px;" />
        <hr/>
    </header>

    <footer>
        <hr/>
        <table style="text-align: center; width:100%;">
            <tr>
                <td>www.solidezhipotecaria.com</td>
                <td>8008313111</td>
                <td>info@solidezhipotecaria.com</td>
            </tr>
        </table>
    </footer>
    
    <main>
        <?php $title = "ITStuff"; $body="HElo";?>
        <h1 class="centrar">OPCIONES DE CRÉDITO</h1>
        <br>
        <p>!Hola {{ $nameDirigido }}!</p>
        <p>A continuación encontrarás las opciones de crédito disponibles de acuerdo con la información que nos proporcionaste:</p>
        
        <table>
            <thead>
                <tr>
                    <td colspan="2">{{ $data["credit"] }}</td>
                </tr>
            </thead>
            <tbody>
                <tr class="borde">
                    <td><b>Monto</b></td>
                    <td><b>$ {{ number_format($data["montoCredito"],2) }}</b></td>
                </tr>
                <tr class="borde">
                    <td>Plazo</td>
                    <td><?php if($data["plazoAnios"] == '') echo "Sin plazo"; else echo $data["plazoAnios"]." años"; ?></td>
                </tr>
                <tr class="borde">
                    <td>Tipo de pago </td>
                    <td><?php if($data["pago"] == '') echo "Fijo/Creciente"; else echo $data["pago"]; ?></td>
                </tr>
                <tr class="borde">
                    <td>Fecha de generación </td>
                    <td>{{ date('d-m-Y') }}</td>
                </tr>
            </tbody>
        </table>

        <table>
            <thead class="simulacion">
                <tr>
                    <td>BANCO</td>
                    <td>PRODUCTO</td>
                    <td>TASA DE INTERÉS</td>
                    <td>COMISIÓN POR APERTURA</td>
                    <td>COSTO DEL AVALÚO</td>
                    <td>PAGO MENSUAL</td>
                </tr>
            </thead>
            <tbody style="font-size: 12px;">
                <?php 
                    foreach ($simulations as $s) {

                    echo '
                        <tr class="borde">
                            <td>'.$s->bank.'</td>
                            <td>'.$s->product.'</td>
                            <td class="alignright">'.$s->tasa_interes.' %</td>
                            <td class="alignright">$ '.number_format($s->apertura,2).'</td>
                            <td class="alignright">$ '.number_format($s->avaluo,2).'</td>
                            <td class="lastrow alignright">$ '.number_format($s->mensualidad,2).'</td>
                        </tr>';
                    }
                ?>
            </tbody>
        </table>
        

        <div class="notas_promos">
        <p><b>Notas:</b></p>
        <?php 
            $bancoAnt = '';
            for($x = 0; $x < count($products); $x++){

                if($bancoAnt != $products[$x]->bank){
                    if($products[$x]->cuenta > 0){
                        echo '
                        <div>
                        '.$products[$x]->bank.':<br>';
                    }
                }

                    if(!is_null($products[$x]->notas_adicionales)){
                        echo '- '.$products[$x]->product.' ('.$products[$x]->tasa_interes.' %): '.$products[$x]->notas_adicionales;
                    }
                
                if($bancoAnt != $products[$x]->bank){
                    echo '</div>';
                }

                $bancoAnt = $products[$x]->bank;
            }
       ?>




        <br>
        <p><b>Promociones:</b></p>
        <?php 
            foreach ($banks as $b) {

                if($b->promotion != ''){
                    echo '
                    <div><b>'.$b->bank.':</b> <br>
                        '.$b->promotion.' <br>
                        (vigencia '.$b->date_start.' - '.$b->date_end.')
                    </div>';
                }
            }
        ?>
        </div>
    </main>
    
</body>
</html>