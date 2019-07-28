<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!--link rel="icon" href="../../../../favicon.ico"-->
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('fax.css')}}" rel="stylesheet">
    <title>FAX | Vriendelijke bedankt </title>
 </head>
 <body>
 	<div class="container" style="width: 100%; ">
        <div class="jumbotron">
     		<h3 class="text-primary">Bedankt!</h3>
     		<h5>De brief wordt nu verzonden naar:  <span class="text-success">{{session('fax')}}</span>. Wij hebben zojuist een bevestiging naar uw emailadres gestuurd. U ontvangt ook een bevestiging als de fax succesvol is verzonden. Meestal binnen tien minuutjes.</h5>
        </div>
        @php(Session::flush())
        @php(Session::regenerate())
 	</div>
 </body>
</html>