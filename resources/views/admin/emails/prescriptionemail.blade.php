{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .email-tamplate .tamplate-content {
            border: 5px solid #000;
            text-transform: capitalize;
            font-weight: bold;
            color: #000;
        }

        .email-tamplate .tamplate-content .tamplate-content-main{
            padding: 30px 40px;

        }

        .email-tamplate .tamplate-content img{
            max-width: 150px;
            display: block;
            margin: 0 auto 20px;
        }

        .email-tamplate .tamplate-content span{
            display: block;
            margin-bottom:15px;;
            font-size: 14px;
        }


        .email-tamplate .tamplate-content p{
            margin-bottom:30px;;
            font-size: 18px;
        }

        .email-tamplate .tamplate-content  .tamplate-footer{
            text-align: center;
            border-top: 5px solid #000;
            margin-top: 30px;
            padding: 8px;
        }

        @media screen and (max-width:767px){
            .email-tamplate .tamplate-content .tamplate-content-main{
                padding: 10px 15px;
            }
        }
    </style>  
</head>
<body>
<section class="email-tamplate">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="tamplate-content">
                    <div class="tamplate-content-main">
                        <img src="https://cdn.dribbble.com/users/60166/screenshots/17610068/media/4cbea5351f3f12a22dfb63c04658196d.jpg?compress=1&resize=400x300&vertical=top" alt="">
                        <span>Hello, {{ $user->first_name}}</span>
                        <span>thanks for visisting clinic name at 12.60 PM on 12th Feb 2023 </span>
                        <span>Pls find your doctos prescription as below</span>
                        <p> prescription content </p>
                        <p> Next appoinment </p>
                        <span>12th Feb 2023</span>
                        <span>have nice day</span>
                    </div>
                    <div class="tamplate-footer"><div class="col-sm-6 copyright-text">2022 © Doctorly</div>
               <div class="col-sm-6 designed-text">Designed and Developed by Narola</div></div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
 --}}

 <!DOCTYPE HTML>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="x-apple-disable-message-reformatting">
  <meta name="format-detection" content="date=no">
  <meta name="format-detection" content="telephone=no">
  <style type="text/CSS"></style>
  <!-- <style @import url('https://dopplerhealth.com/fonts/BasierCircle/basiercircle-regular-webfont.woff2');></style> -->
  <title></title>
  <style>
    table,
    td,
    div,
    h1,
    p {
      font-family: 'Basier Circle', 'Roboto', 'Helvetica', 'Arial', sans-serif;
    }

    @media screen and (max-width: 530px) {
      .unsub {
        display: block;
        padding: 8px;
        margin-top: 14px;
        border-radius: 6px;
        background-color: #FFEADA;
        text-decoration: none !important;
        font-weight: bold;
      }

      .button {
        min-height: 42px;
        line-height: 42px;
      }

      .col-lge {
        max-width: 100% !important;
      }
    }

    @media screen and (min-width: 531px) {
      .col-sml {
        max-width: 27% !important;
      }

      .col-lge {
        max-width: 73% !important;
      }
    }
  </style>
</head>

<body style="margin:0;padding:0;word-spacing:normal;background-color:#FDF8F4;">
  <div role="article" aria-roledescription="email" lang="en" style="text-size-adjust:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#FDF8F4;">
    <table role="presentation" style="width:100%;border:none;border-spacing:0;">
      <tr>
        <td style="padding:0;">
          <table role="presentation" style="width:94%;max-width:600px;border:none;border-spacing:0;text-align:left;font-family:'Basier Circle', 'Roboto', 'Helvetica', 'Arial', sans-serif;font-size:1em;line-height:1.37em;color:#384049;">
            <!--      Logo headder -->
            <tr>
              <td style="padding:40px 30px 30px 30px;text-align:center;font-size:1.5em;font-weight:bold;">
                <a href="#" style="text-decoration:none;">
                  <img width="2170" alt="" style="width:2170px;max-width:80%;height:auto;border:none;text-decoration:none;color:#ffffff;" src="{{ asset('assets/img/logo.png') }}">
                </a>
              </td>
            </tr>
            <!--      Intro Section -->
            <tr>
              <td style="padding:30px;background-color:#ffffff;">
                <h1 style="margin-top:0;margin-bottom:1.38em;font-size:1.953em;line-height:1.3;font-weight:bold;letter-spacing:-0.02em;">Here is your prescription details</h1>
                <p style="margin:0;">Hi, {{$user->first_name}}</p>
                <p>Thanks for visiting {{$clinic_details->first_name}} at {{ date('H:i', strtotime($user->time_start)), date('H:i', strtotime($user->time_end)) ?? 0}} on {{date('d/m/Y', strtotime($user->appointment_date))}}</p>
                <h3>Please find your doctor's prescription as below.</h3>
                <p>{{$user->disease_name}}</p>
                <h3>Next Appoitment details</h3>
                <p>{{ date('d/m/Y', strtotime($user->next_date))}}</p>
                <p>{{ date('H:i', strtotime($user->next_start_time)), date('H:i', strtotime($user->next_end_time)) ?? 0}}</p>


                {{-- <p>To access the survey, please click on this link:</p>
                <p style="text-align: center;margin: 2.5em auto;">
                  <a class="button" href="https://dopplerhealth.com/" style="background: #DE4D3B; 
                       text-decoration: none; 
                       padding: 1em 1.5em;
                       color: #ffffff; 
                       border-radius: 48px;
                       mso-padding-alt:0;
                       text-underline-color:#ff3884">
                    <span style="mso-text-raise:10pt;font-weight:bold;">Start Survey!</span>
                  </a>
                </p>
 --}}                
                <p>Thank you for your time and for visiting Narola Health. Have a nice time ahead.</p>
                <p>Thanks,</p>
                <p>The Narola Health Team</p>
              </td>
            </tr>
            <tr>
              <td style="padding:30px;text-align:center;font-size: 0.75em;background-color:#ffeada;color:#384049;border: 1em solid #fff;">
                <p style="margin:0 0 0.75em 0;line-height: 0;">
                                 </p>
                <p style="margin:0;font-size:.75rem;line-height:1.5em;text-align: center;">
                  2022 © Doctorly, Designed and Developed by Narola
                  <br>
                </p>
              </td>
            </tr>
          </table>
          <!--[if mso]>
          </td>
          </tr>
          </table>
          <![endif]-->
        </td>
      </tr>
    </table>
  </div>
</body>

</html>