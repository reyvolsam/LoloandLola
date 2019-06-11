<!Doctype html>
<html>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Lolo y Lola ::Recibo-{{ $data->id }}::</title>
    <link href="http://lololola.com.mx/favicon/logo.ico" rel="SHORTCUT ICON">
    <link rel="stylesheet" href="http://lololola.com.mx/sistema/public/statics/css/lib/bootstrap.min.css" />
    <style type="text/css">
        html,  body {margin: 0 !important;padding: 0 !important;height: 100% !important;width: 100% !important;background: #f9dcdc !important;}
        * {-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;}
        .ExternalClass {width: 100%;}
        div[style*="margin: 16px 0"] {margin: 0 !important;}
        table,  td {mso-table-lspace: 0pt !important;mso-table-rspace: 0pt !important;}
        table {border-spacing: 0 !important;border-collapse: collapse !important;table-layout: fixed !important;margin: 0 auto !important;}
        table table table {table-layout: auto;}
        img {-ms-interpolation-mode: bicubic;}
        .yshortcuts a {border-bottom: none !important;}
        a[x-apple-data-detectors] {color: inherit !important;}
    </style>
    <style type="text/css">
        .button-td,.button-a {transition: all 100ms ease-in;}
        .button-td:hover,.button-a:hover {background: #555555 !important;border-color: #555555 !important;}
        @media screen and (max-width: 600px) {
            .email-container {width: 100% !important;}
            .fluid,.fluid-centered {max-width: 100% !important;height: auto !important;margin-left: auto !important;margin-right: auto !important;}
            .fluid-centered {margin-left: auto !important;margin-right: auto !important;}
            .stack-column,.stack-column-center {display: block !important;width: 100% !important;max-width: 100% !important;direction: ltr !important;}
            .stack-column-center {text-align: center !important;}
            .center-on-narrow {text-align: center !important;display: block !important;margin-left: auto !important;margin-right: auto !important;float: none !important;}
            table.center-on-narrow {display: inline-block !important;}
        }
    </style>
    </head>
    <body bgcolor="#f9dcdc" width="100%" style="margin: 0;margin-top: -74px !important;" yahoo="yahoo">
    <table bgcolor="#f9dcdc" cellpadding="0" cellspacing="0" border="0" height="100%" width="100%" style="border-collapse:collapse;">
      <tr>
        <td><center style="width: 100%;">
            
            <!-- Email Body : BEGIN -->
            <table cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff" width="760" class="email-container">
            <tr>
            <td style="text-align: center;font-size: 12px;color: #999999;padding: 10px 20px;">Si no logras visualizar el recibo por favor dale <a style="color: #fa9596; font-weight: bold;" href="{{ URL::to('payment2/ticket/') }}/{{ $data->id }}">click</a> al siguiente enlace</td>
            </tr>
            
            <!-- Hero Image, Flush : BEGIN -->
            <tr>
                <td class="full-width-image"><img src="http://lololola.com.mx/sistema/public/statics/images/recibo_head.jpg" width="1200" alt="alt_text" border="0" align="center" style="width: 100%; max-width: 1200px; height: auto;"></td>
              </tr>
            <!-- Hero Image, Flush : END --> 
            
            <!-- Two Even Columns : BEGIN -->
            <tr>
                <td align="center" valign="top" style="padding: 10px 20px;">
                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                        
                        <tr>
                        <td class="stack-column-center">
                            <table cellspacing="0" cellpadding="0" border="0">
                            <tr>
                            <td style="font-family: sans-serif; font-size: 15px; mso-height-rule: exactly; line-height: 20px; color: #555555; padding: 0 10px 10px; text-align: left;" > <!-- class="center-on-narrow" --> <strong style="color: #2d211e;font-weight: bold;font-size: 22px;">Razter Style S.A.S</strong> <br><br>Recibo No. <strong style="color: #fa9596;font-size:18px;">{{ $data->id }}</strong> <br> Fecha de emisión:  {{ $date }} <br> Cliente: <strong style="color: #fa9596;font-size:16px;">{{ $data->name }}</strong> <br> Fecha de entrega: <strong style="color: #fa9596;font-size:16px;">{{ $data->delivery_date }}</strong> </td>
                          </tr>
                          </table>
                        </td>
                        <td class="stack-column-center"><table cellspacing="0" cellpadding="0" border="0">

                            <tr>
                            <td style="font-family: sans-serif; font-size: 15px; mso-height-rule: exactly; line-height: 17px; color: #fa9596; padding: 0 10px 10px; text-align: right;"> Lolo & Lola Boutique<br>Modesto Arreola No. 710, CP. 64000 Centro, Monterrey, Nvo. León.</td>
                          </tr>
                          </table></td>
                      </tr>
                  </table>
                </td>
              </tr>
            <!-- Two Even Columns : END --> 
            
            <!-- Three Even Columns : BEGIN -->
			<tr>
				<td align="center" valign="top" style="padding: 5px; 53px">
					<table class="table" width="98%" cellspacing="0" cellpadding="0" border="0">
                        <thead>
                            <tr style="color: #482f29;font-weight: bold;">
                                <th scope="col">Descripción</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Subtotal</th>
                            </tr>
                        </thead>
					  <tbody>
                          @foreach($data->product_payment AS $kp => $vp)
                            <tr >
                                <td width="30%" class="stack-column-center" scope="row">{{ $vp->product->name }}</td>
                                <td width="30%" >${{ number_format($vp->product->price, 2) }} MXN</td>
                                <td width="15%" >{{ $vp->quantity }}</td>
                                <td width="25%" >${{ number_format($vp->total, 2) }} MXN</td>
                            </tr>
                            @endforeach
                            @foreach($data->service_payment AS $ks => $vs)
                            <tr >
                                <td width="30%" class="stack-column-center" scope="row">{{ $vs->service->name }}</td>
                                <td width="30%" >${{ number_format($vs->service->price, 2) }} MXN</td>
                                <td width="15%" >{{ $vs->quantity }}</td>
                                <td width="25%" >${{ number_format($vs->total, 2)}} MXN</td>
                            </tr>
                            @endforeach
					  </tbody>
					</table>
				</td>
			</tr>	

            <tr><br><br><br> </tr>

            <!-- Three Even Columns : BEGIN -->
            <tr>
                <td align="center" valign="top" style="padding: 5px; 53px">
                    <table class="table" width="98%" cellspacing="0" cellpadding="0" border="0">
                        <thead>
                            <tr style="color: #482f29;font-weight: bold;">
                                <th scope="col">Método de Pago</th>
                                <th scope="col">Fecha de Pago</th>
                                <th scope="col">Anticipo</th>
                                <th scope="col">Cuenta Total</th>
                            </tr>
                        </thead>
                      <tbody>
                        <tr >
                        <td width="30%" class="stack-column-center" scope="row">{{ $data->payment_type->name }}</td>
                        <td width="30%" >{{ $date }}</td>
                        <td width="30%" >${{ number_format($data->advance_payment, 2) }} MXN</td>
                            <td width="40%" style="font-weight: bold; color: #482f28; font-size: 22px;">${{ number_format($data->grand_total, 2) }} MXN</td>
                        </tr>
                        
                      </tbody>
                    </table>
                </td>
            </tr>   
				
				
				
            <tr>
                <td align="center" valign="top" style="padding: 10px;">
                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
						
						<tr>

						</tr>
						
                        <tr>
                        <td width="33.33%" class="stack-column-center">
                            <table cellspacing="0" cellpadding="0" border="0">
                            <tr>
                            <td style="font-family: sans-serif; font-size: 15px; mso-height-rule: exactly; line-height: 20px; color: #555555; padding: 0 10px 10px; text-align: left;" class="center-on-narrow"> </td>
                          </tr>
                          </table>
                        </td>
                        <td width="33.33%" class="stack-column-center">
                            <table cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td style="font-family: sans-serif; font-size: 15px; mso-height-rule: exactly; line-height: 20px; color: #555555; padding: 0 10px 10px; text-align: left;" class="center-on-narrow"> </td>
                            </tr>
                            </table>
                        </td>
                        <td width="33.33%" class="stack-column-center">
                            <table cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td style="font-family: sans-serif; font-size: 15px; mso-height-rule: exactly; line-height: 20px; color: #555555; padding: 0 10px 10px; text-align: left;" class="center-on-narrow"></td>
                            </tr>
                            </table>
                        </td>
                      </tr>
                  </table>
                </td>
              </tr>
            <!-- Three Even Columns : END --> 


            <!-- Hero Image, Flush : BEGIN -->
            <tr>
                <td class="full-width-image"><img src="http://lololola.com.mx/sistema/public/statics/images/recibo_footer.jpg" width="1200" alt="alt_text" border="0" align="center" style="width: 100%; max-width: 1200px; height: auto; padding: 10px 0;"></td>
            </tr>
            <!-- Hero Image, Flush : END --> 
            
          </table>
            <!-- Email Body : END --> 
            
            <!-- Email Footer : BEGIN -->
            <table align="center" width="600" class="email-container">
            <tr>
                <td style="padding: 10px 10px;width: 100%;font-size: 12px; font-family: sans-serif; mso-height-rule: exactly; line-height:18px; text-align: center; color: #888888;"><webversion style="color:#cccccc; text-decoration:underline; font-weight: bold;">Ver como página web</webversion>
                Lolo & Lola Boutique<br>
                <span class="mobile-link--footer"><a style="text-decoration: none; color: #fa9596;" href="http://lololola.com.mx" target="_blank">www.lololola.com.mx</a></span> <br>
                <br></td>
              </tr>
          </table>
            <!-- Email Footer : END -->
            
          </center></td>
      </tr>
    </table>
</body>
</html>
