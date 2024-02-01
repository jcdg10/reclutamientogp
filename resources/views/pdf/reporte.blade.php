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
    <header>
        <table style="text-align: center; width:100%;">
            <tr>
                <td><h4 class="centrar">{{ $data['title'] }}</h4></td>
                <td><img src="https://www.solidezhipotecaria.gpodev.live/app-assets/img/logo/logo-solidez.png" border="0" alt="Logo" style="height:60px;" /></td>
            </tr>
        </table>
        <hr/>
    </header>

    <footer>
        <hr/>
        <table style="text-align: center; width:100%;">
            <tr>
                <td></td>
                <td>Simulador Solidez Hipotecaria</td>
                <td></td>
            </tr>
        </table>
    </footer>
    
    <main>
        <br>
        <p style="text-align: right;"><b>Fecha:</b> {{ date('d-m-Y') }}</p>
        <br>

        <table style="text-align: center; width:70%;">
            <thead>
                <tr>
                    <td></td>
                    <td>Mensajes</td>
                    <td>Simulaciones</td>
                </tr>
            </thead>
            <tbody>
                <?php 

                    $month[0] = 'Ene';
                    $month[1] = 'Feb';
                    $month[2] = 'Mar';
                    $month[3] = 'Abr';
                    $month[4] = 'May';
                    $month[5] = 'Jun';
                    $month[6] = 'Jul';
                    $month[7] = 'Ago';
                    $month[8] = 'Sep';
                    $month[9] = 'Oct';
                    $month[10] = 'Nov';
                    $month[11] = 'Dic';

                    $x = 0;
                    /*for($x = 0; $x < count($information[0]); $x++) {
                        echo '
                                <tr class="borde">
                                    <td><b>'.$month[$x].'</b></td>
                                    <td class="alignright">'.$information[0][$x].'</td>
                                    <td class="alignright">'.$information[1][$x].'</td>
                                </tr>';
                    }*/
                ?>
            </tbody>
        </table>

        
    </main>
    
</body>
</html>