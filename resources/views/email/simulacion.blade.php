<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
    <head>
        <!--[if gte mso 9]>
        <xml>
            <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
        <![endif]-->

        <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="format-detection" content="date=no"/>
        <meta name="format-detection" content="address=no"/>
        <meta name="format-detection" content="telephone=no"/>
        <meta name="x-apple-disable-message-reformatting"/>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700&display=swap" rel="stylesheet">

        <title>{{ env('APP_NAME')}}</title>
    </head>
<?php $base_url = ''; $nombreUsuario = $data["name"]; $emailUsuario = $data["email"]; ?>
<body style="margin: 0; padding: 0; font-family: 'Manrope', sans-serif; background: #EBFAFA;">
        <center>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background: #EBFAFA;">
                <tr>
                    <td align="center">
                        <table width="690" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td style="padding: 35px;">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td style="border-radius: 8px;" bgcolor="#ffffff">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td>
                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                    <td style="text-align:center; padding: 70px 15px 16px;">
                                                                        <a href="{{ $base_url }}" >
                                                                            <img src="https://www.solidezhipotecaria.gpodev.live/app-assets/img/logo/logo-solidez.png" border="0" alt="Logo" style="height:60px;"/>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                    <td style="font-size:14px; color:#636E72; min-width:auto !important; line-height: 20px; text-align:center; padding-bottom: 12px;">
                                                                        Saludos {{ $nombreUsuario }}, gracias por contactar a {{ env('APP_NAME') }}
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td style="padding: 0 45px;">
                                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                            <tr>
                                                                                <td style="padding-bottom: 22px;">
                                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                                                        <tr>
                                                                                            <td style="font-size:14px; color:#636E72; min-width:auto !important; line-height: 20px; text-align:center; padding: 0 25px 32px;">
                                                                                                Con este mensaje hemos adjuntado las mejores presupuestos de acuerdo a tus requerimientos.<br>
                                                                                            
                                                                                            </td>
                                                                                        </tr>
                                                                                        
                                                                                        <tr>
                                                                                            <td style="font-size:14px; color:#636E72; min-width:auto !important; line-height: 20px; text-align:center; padding: 0 25px 32px;">
                                                                                                <br><br>Cualquier duda o aclaración puedes contactar con nosotros, te atenderemos con mucho gusto.
                                                                                            </td>
                                                                                        </tr>

                                                                                        <!--<tr>
                                                                                            <td style="min-width:auto !important; text-align:center; padding-top: 32px;">
                                                                                                <img src="images/logo/logo-text.svg" border="0" alt="Logo"/>
                                                                                            </td>
                                                                                        </tr>-->

                                                                                        <tr>
                                                                                            <td style="font-size:12px; color:#B2BEC3; min-width:auto !important; line-height: 12px; text-align:center; padding-top: 32px;">
                                                                                                <p class="f-fallback sub align-center" style="font-size: 13px; line-height: 1.625; text-align: center; color: #A8AAAF; margin: .4em 0 1.1875em;" align="center">© {{ now()->year }} {{ env('APP_NAME') }}. Todos los derechos reservados.</p>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </center>
</html>