<?php

include '../phpmailer.php';


$objmail = new Mail();

    /*******************************
    * ESTILOS CSS PARA ENVIO DE CORREO A LOS USUARIOS (PASS).
    *******************************/

class EnvioEmail {
    public function enviarEmailRegistro($email, $nombre, $token) {
        global $objmail;
        $linkredireccion = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . "/asimet_encuestas/views/login.php";

        $mensaje = "
        <style type='text/css'>
                @media screen and (max-width: 80%px) {
                    table[class='container'] {
                        width: 95% !important;
                    }
                }

                imgPBM {
                    outline: none;
                    margin-left: 0;
                    display: list-item;
                    align-content: center;
                    /* text-align-last: left; */
                    text-decoration: none;
                }
                #outlook a {
                    padding: 0;
                    font-family: 'Google Sans';
                }

                body {
                    width: 100% !important;
                    -webkit-text-size-adjust: 100%;
                    -ms-text-size-adjust: 100%;
                    margin: 0;
                    padding: 0;
                }

                .ExternalClass {
                    width: 100%;
                }

                .ExternalClass,
                .ExternalClass p,
                .ExternalClass span,
                .ExternalClass font,
                .ExternalClass td,
                .ExternalClass div {
                    line-height: 100%;
                }

                #backgroundTable {
                    margin: 0;
                    padding: 0;
                    width: 100% !important;
                    line-height: 100% !important;
                }

                img {
                    outline: none;
                    text-decoration: none;
                    -ms-interpolation-mode: bicubic;
                }

                a img {
                    border: none;
                }

                .image_fix {
                    display: block;
                }

                p {
                    color: #002142;
                    font-family: 'Century Gothic';
                    font-size: 16px;
                    line-height: 160%;
                    /* font-weight: bold;
                }

                h1,
                h2,
                h3,
                h4,
                h5,
                h6 {
                    color: #062352 !important;
                    font-family: 'Century Gothic';
                }

                h1 a,
                h2 a,
                h3 a,
                h4 a,
                h5 a,
                h6 a {
                    font-family: 'Century Gothic';
                }

                h1 a:active,
                h2 a:active,
                h3 a:active,
                h4 a:active,
                h5 a:active,
                h6 a:active {
                    color: #1F91FF !important;
                    font-family: 'Century Gothic';
                }

                h1 a:visited,
                h2 a:visited,
                h3 a:visited,
                h4 a:visited,
                h5 a:visited,
                h6 a:visited {
                    color: #062352 !important;
                    font-family: 'Century Gothic';
                }

                table td {
                    border-collapse: collapse;
                }

                table {
                    border-collapse: collapse;
                }

                a {
                    color: #000;
                    
                }

                @media only screen and (max-device-width: 480px) {

                    a[href^='tel'],
                    a[href^='sms'] {
                        text-decoration: none;
                        color: #062352;
                        /* or whatever your want */
                        pointer-events: none;
                        cursor: default;
                    }

                    .mobile_link a[href^='tel'],
                    .mobile_link a[href^='sms'] {
                        text-decoration: default;
                        /* or whatever your want */
                        pointer-events: auto;
                        cursor: default;
                    }
                }


                @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {

                    a[href^='tel'],
                    a[href^='sms'] {
                        text-decoration: none;
                        color: white;
                        /* or whatever your want */
                        pointer-events: none;
                        cursor: default;
                    }

                    .mobile_link a[href^='tel'],
                    .mobile_link a[href^='sms'] {
                        text-decoration: default;
                        color: black !important;
                        pointer-events: auto;
                        cursor: default;
                    }
                }

                @media only screen and (-webkit-min-device-pixel-ratio: 2) {
                    /* Put your iPhone 4g styles in here */
                }

                @media only screen and (-webkit-device-pixel-ratio:.75) {
                    /* Put CSS for low density (ldpi) Android layouts in here */
                }

                @media only screen and (-webkit-device-pixel-ratio:1) {
                    /* Put CSS for medium density (mdpi) Android layouts in here */
                }

                @media only screen and (-webkit-device-pixel-ratio:1.5) {
                    /* Put CSS for high density (hdpi) Android layouts in here */
                }

                /* end Android targeting */
                h2 {
                    color: #062352;
                    font-family: 'Century Gothic';
                    font-size: 22px;
                    line-height: 22px;
                    font-weight: bolder;
                    }

                a.link2 {
                    color: #fff;
                    text-decoration: none;
                    font-family: 'Google Sans';
                    font-size: 16px;
                    color: #fff;
                    border-radius: 4px;
                }

                p {
                    color: #0A2E51;
                    font-family: 'Century Gothic';
                    font-size: 16px;
                    line-height: 160%;
                }
            </style>


        <table cellpadding='0' width='700' cellspacing='0' border='0' id='backgroundTable' class='bgBody'>
        <tr>
            <td>
                <table cellpadding='0' cellspacing='0' border='0' align='center' width='80%'>
                    <tr>
                        <td class='movableContentContainer bgItem'>

                            <div class='movableContent'>
                                <table cellpadding='0' cellspacing='0' border='0' align='center' width='80%' class='container'>
                                    <tr style='background-color: #F5F5F5E6;'>
                                        <td width='200' valign='top'>&nbsp;</td>
                                        <td width='200' valign='top' align='center'>
                                            <div class='contentEditableContainer contentImageEditable'>
                                                <div class='contentEditable' align='center'>
                                                    <img id='LogoPBM' src='https://www.redpbm.org/images/pbm%20logo.png?crc=429737261' alt='Logo' data-default='placeholder' />
                                                </div>
                                            </div>
                                        </td>
                                        <td width='200' valign='top'>&nbsp;</td>
                                    </tr>
                                    <tr height='25'>
                                        <td width='200'>&nbsp;</td>
                                        <td width='200'>&nbsp;</td>
                                        <td width='200'>&nbsp;</td>
                                    </tr>
                                </table>
                            </div>

                            <div class='movableContent'>
                                <table cellpadding='0' cellspacing='0' border='0' align='center' width='80%' class='container'>
                                    <tr>
                                        <td width='100%' colspan='3' align='center'>
                                            <div class='contentEditableContainer contentTextEditable'>
                                                <div style='font-weight: bold;' class='contentEditable' align='center'>
                                                    <h2>Bienvenido</h2>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width='100'>&nbsp;</td>
                                        <td width='400' align='center' style='font-family:Google Sans;'>
                                            <div class='contentEditableContainer contentTextEditable'>
                                                <div style='font-family:'Google Sans; class='contentEditable' align='left'>
                                                    <p>Hola, $nombre
                                                        <br />
                                                        <br />
                                                        Esta es su clave de acceso al sistema de encuestas de Red PbM:
                                                    </p>
                                                    <h2 style='font-weight: bolder;'>$token</h2>
                                                    <p>Ingrese su clave para continuar encuesta.</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td width='100'>&nbsp;</td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        </table>

        <script>
            document.getElementsByClassName('link2').href = '$linkredireccion'
        </script>
        ";
        $response = $objmail->enviar_email('cuestionarios@redpbm.org', utf8_decode('Red PbM'), $email, $nombre, 'Encuesta Red PbM', $mensaje);
        return $response;
    }

    /*******************************
    * ESTILOS CSS PARA ENVIO DE CORREO AL ADMINISTRADOR.
    *******************************/

    public function enviarEmailEncuesta($email, $nombre_representante, $nombre_empresa, $rif_empresa, $rubro, $cargo, $telefono, $token, $promedio_general) {
        global $objmail;

        $linkredireccion = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . "/asimet_encuestas/views/resultados.php?token=" . $token;

        $hoy = new DateTime('now', new DateTimeZone('America/Caracas'));

        $mensaje = "<style>

        #general {
            background-color: white;
            font-family: 'Google Sans';
        }

        #tgeneral {
            padding: 10px; margin:0 auto;
        }

        #tdgeneral {
            background-color: white;
        }

        #tdheadergeneral {
        color: white; margin: 4% 10% 2%; text-align: center;font-family: Google Sans;
        }

        #tdheadertitulogeneral {
            /* Azul oscuro */
            color: #062352; margin: 0 0 7px;
        }

        #t {
            text-align: center;
        }

        
        #td {
            font-family: 'Google Sans';
            background-color: #58D128;
        }

        #footer {
            color: white; font-size: 12px; text-align: center;margin: 30px 0 0;
        }

        #center {
            margin: 0 auto;
        }

        </style>

        <div id='general'>
            <table id='tgeneral'>
                <tr>
                    <td id='tdgeneral'>
                        <div id='tdheadergeneral'>
                            <table>
                                <thead>
                                <tr>
                                <td style='width: 50%;'><img style='width: 70%;' src='https://www.redpbm.org/images/pbm%20logo.png?crc=429737261'></td>
                                <td> <h2 style='font-family: Google Sans;' id='tdheadertitulogeneral'> Resultados Evolución Digital (" . $hoy->format('d/m/Y H:i') . ")</h2></td>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td style='font-family:Google Sans;'><strong>Valor del Índice de Evolución Digital:</strong> $promedio_general</td>
                                    </tr>
                                </tbody>
                            </table>
                            <br><br>
                            <table cellpadding='0' cellspacing='0' border='0' align='center' width='80%' class='container'>
                                <tr>
                                    <td width='200'>&nbsp;</td>
                                    <td width='200' align='center' style='padding-top:25px;'>
                                        <table cellpadding='0' cellspacing='0' border='0' align='center' width='200' height='50' style='font-family:Google Sans;'>
                                            <tr>
                                                <td bgcolor='#58D128' style='font-family:Google Sans;' align='center' style='border-radius:4px;' width='200' height='50'>
                                                    <div class='contentEditableContainer contentTextEditable'>
                                                        <div style=font-family: 'Google Sans'; class='contentEditable' align='center'>
                                                            <a target='_blank' href='$linkredireccion' class='link2'>Ver resultados</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td width='200'>&nbsp;</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>

        </div>";

            $mensajeRedPbM = "<style>
        #general {
            background-color: #fff;
        }

        #tgeneral {
            padding: 10px; margin:0 auto;
        }

        #tdgeneral {
            background-color: #ecf0f1;
        }

        .body, td, input, textarea, select {
            margin: 0;
            font-family: Google Sans;
        }

        #tdheadergeneral {
        color: #062352; margin: 4% 10% 2%; text-align: center;font-family: Google Sans;
        }

        #tdheadertitulogeneral {
            color: #062352; margin: 0 0 7px;font-family: Google Sans;
        }

        #t {
            text-align: center;
        }

        #footer {
            color: white; font-size: 12px; text-align: center;margin: 30px 0 0
        }

        #center {
            margin: 0 auto;
        }

        </style>

        <div id='general'>
            <table id='tgeneral'>
                <tr>
                    <td id='tdgeneral' style='background-color:white;'>
                        <div id='tdheadergeneral'>
                        <h2 id='tdheadertitulogeneral' style='font-family:Google Sans;'> Resultados Evolución Digital</h2>

                            <table>
                                <thead id='t'>
                                    <th><h4 id='tdheadertitulogeneral' style='font-family:Google Sans;'> Datos del Encuestado</h4></th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style='font-family:Google Sans;'>Empresa: </td>
                                        <td style='font-family:Google Sans;'>$nombre_empresa</td>
                                    </tr>
                                    <tr>
                                        <td style='font-family:Google Sans;'>RIF: </td>
                                        <td style='font-family:Google Sans;'>$rif_empresa</td>
                                    </tr>
                                    <tr>
                                    <td style='font-family:Google Sans;'>Rubro: </td>
                                    <td style='font-family:Google Sans;'>$rubro</td>
                                    </tr>
                                    <tr>
                                        <td style='font-family:Google Sans;'>Nombre: </td>
                                        <td style='font-family:Google Sans;'>$nombre_representante</td>
                                    </tr>
                                    
                                    <tr>
                                        <td style='font-family:Google Sans;'>Cargo: </td>
                                        <td style='font-family:Google Sans;'>$cargo</td>
                                    </tr>
                                    <tr>
                                        <td style='font-family:Google Sans;'>Telefono: </td>
                                        <td style='font-family:Google Sans;'>$telefono</td>
                                    </tr>
                                    <tr>
                                        <td style='font-family:Google Sans;'>Email: </td>
                                        <td style='font-family:Google Sans;'>$email</td>
                                    </tr>
                                </tbody>
                            </table>
                            <br><br>
                            <table id='center'>
                                <tbody>
                                    <tr>
                                        <td style='font-family:Google Sans;'>Promedio General: </td>
                                        <td style='font-family:Google Sans;'>$promedio_general</td>
                                    </tr>
                                </tbody>
                            </table>
                            <br><br>
                            <table cellpadding='0' cellspacing='0' border='0' align='center' width='80%'>
                                <tr>
                                    <td width='200'></td>
                                    <td width='200' align='left'>
                                        <table cellpadding='0' cellspacing='0' border='0' align='center' width='200' height='50'>
                                            <tr>
                                                <td bgcolor='#58D128' align='center' style='border-radius:4px;' width='200' height='50'>
                                                    <div class='contentEditableContainer contentTextEditable'>
                                                        <div class='contentEditable' align='center' style='font-family:Google Sans;'>
                                                            <a target='_blank' href='$linkredireccion' class='link2' style='color:#062352;'>Ver resultados</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td width='200'>&nbsp;</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>

        </div>";
        $response = $objmail->enviar_email('cuestionarios@redpbm.org', utf8_decode('Red PbM'), $email, $nombre_representante, 'Resultados Evolución Digital ' . $nombre_empresa, $mensaje);
        $response = $objmail->enviar_email('cuestionarios@redpbm.org', utf8_decode('Red PbM'), 'cuestionarios@redpbm.org', 'cuestionarios@redpbm.org', 'Resultados Evolución Digital ' . $nombre_empresa, $mensajeRedPbM);
        return $response;
    }
}
?>