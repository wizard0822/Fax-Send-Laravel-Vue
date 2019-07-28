<html lang="en">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta name="description" content="">
            <meta name="author" content="">
            <meta name="csrf-token" content="{{ csrf_token() }}" />
            <!--link rel="icon" href="../../../../favicon.ico"-->
            <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
            <link href="{{ asset('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

            <link href="{{ asset('fax.css')}}" rel="stylesheet">
            <link href="{{ asset('css/dropzone.css')}}" rel="stylesheet">
            <title>Attach Your File</title>	
        </head>
        <body>
        <!-- class="container ml-5 pl-5 mx-auto my-5" -->
         <div class="container mx-auto"  style="max-width: 800px;width: 100%;">
            <h2 class="text-center"></h2>
            <?php 
            //echo $database; 
            ?>


            <?php if(isset($message))echo $message ?>
        <form action="/upload" method="POST" id="my-form" style="background-color: white;" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            

            <br>   
            <!-- <h5 classs="text-dark"><img src="../images/svg/handshake.svg" class="svg-image"> </h5>                                    -->
            <div style="max-width: 100%;" id="terms">
                <h6>DE OVEREENKOMST<br><br> 	Hierbij machtigt u Buro Bezwaar en Beroep om de "{{ session('name')}}" 
						in gebreke te stellen. De gemeente moet binnen vijftien dagen op de ingebrekestelling beslissen. 
						Als de gemeente dat niet doet is de gemeente een boete verschuldigd. <br><br>
						De hoogte van de boete is 20,- euro per dag voor de eerste 14 dagen. 30,- euro per dag voor 
						de 14 dagen daarna en 40,- euro per dag voor de 14 dagen daarna. De totale dwangsom bedraagt maximaal 1260,- euro. 



<br><br> Met het tekenen van deze overeenkomst geeft u toestemming aan de gemeente om de verschuldigde boete over te maken op het rekeningnummer van ons kantoor. Vijftig procent van de ontvangen boete wordt binnen twee weken na ontvangst overgemaakt op uw rekeningnummer: "{{ session('bank_account')}}" Voor onze service betaald u vijftig procent van de te ontvangen dwangsom. Buro Bezwaar en Beroep zorgt er ook voor dat er beroep wordt aangetekend als de weigert te beslissen.<br><br>
Uw gegevens worden alleen gebruikt voor het afhandelen ingebrekestelling <br><br> </h6>
            </div>

     	<div class="form-group text-center">
{{--
               	<label for="terms-checkbox"> <input type="checkbox" id="term_check"> Ik heb de overeenkomst gelezen en ben het er eens.</label>
--}}

                <input type="hidden" id="imgName" name="imgName" value="">
                <input type="hidden" id="imgPath" name="imgPath" value="">


                <button id="back-1" onclick="goBack()" type="button" class="white-btn previous wbtn" style="margin-bottom: 10px; margin-right: 10 !important;">
                    <span class="btn-title white-btn-title">VORIGE</span>
                </button>
              

                <button style="width: 70%;" type="button" id="accept" class="blue-btn wbtn blue-grad btn-block custom-btn">
                    	<span style="font-size: 20px;" class="btn-title blue-btn-title btn-block" >AKKOORD MET DE OVEREENKOMST</span>
                </button>
                
  
                <div style="display: none;" class="selection text-center">
                <button style="width: 100%;" type="button" id="choseSig" class="blue-btn wbtn blue-grad btn-block custom-btn-2">
                        <span style="font-size: 20px;" class="btn-title blue-btn-title btn-block" >HANDTEKENING ZETTEN MET DE MUIS OF VINGER. 
                        </span>
                    </button>

                    <button style="width: 100%;margin-top:20px;" type="button" id="choseImg" class="blue-btn wbtn blue-grad btn-block custom-btn-2">
                        <span class="btn-title blue-btn-title btn-block" style="">
                            UPLOAD EEN AFBEELDING MET UW HANDTEKENING.
                        </span>
                    </button>

                    
                </div>

            <div  class="form-group">
          
               {{-- <p id="terms_error" style="display: none" class="alert alert-dark alert-dk-sig">U bent nog niet met de overeenkomst akkoord gegaan.</p>
                <hr width="600px">--}}
                <div style="display: none;" id="sig">
                    {{--<button type="button" class="blue-btn wbtn blue-grad btn-block goBack">
                        <span class="btn-title blue-btn-title btn-block">
                            Go Back
                        </span>
                    </button>--}}
                        <h6 style="color:black">Plaats uw handtekening in het vierkant:</h6>
                        <div id="signature" style="border: 1px solid #009de7;width: 100%;margin-bottom: 0.75rem !important;">

                        </div>
                        <input type="hidden" name="jsignature" id="jsignature" value="">
                        <p id="signature_error" style="display: none" class="alert alert-dark alert-dk-sig signature_error">Schrijf hierboven uw handtekening.</p>

                </div>

                <div style="display: none;" class="form-group" id="imgDiv">
                   {{-- <button type="button" class="blue-btn wbtn blue-grad btn-block goBack">
                        <span class="btn-title blue-btn-title btn-block">
                            Go Back
                        </span>
                    </button>--}}
                    <br>

                         <input id="dzfile" class="form-control custom-file" type="file" name="dzfile" />

                         <div style="display:none;padding:16px;background:white;border: 1px solid #009de7;width: 100%;margin-top: 24px !important;" class="imgP text-center">
                                <i style="display:none" id="spinner" class="fa fa-spinner fa-4x fa-spin"></i>
                                <img  id="processedImage" style="display: none;max-width:100%;height:300px" src="" alt="">
                                <footer id="processSt" style="display:none" >Wij laden de afbeedling en maken deze klaar voor gebruik</footer>
                         </div>

                    <p  style="display: none" class="alert alert-dark alert-dk-sig signature_error">
                        Selecteer hierboven een afbeelding met uw handtekening.
                    </p>

                </div>

                <div style="display: none;" class="my-3">

                    <div class="row">
                  
                        <button  id="resetSig" type="button" class="black-btn wbtn col-md-12 custom-btn" style="border:none;display: none;    	box-shadow: 1px 1px #848484;  margin-right: 10 !important;" id="clear">
                            <span class="btn-title black-btn-title">HANDTEKENING OPNIEUW MAKEN</span>
                        </button>
                   
                    </div>

                    <div class="row">

                    <button  type="button" class="white-btn previous wbtn back-3 custom-btn" style=" margin-right: 10 !important;">
                        <span class="btn-title white-btn-title">VORIGE</span>
                    </button>

                    <button type="submit" id="submit" name="submit_2" 			style="margin-bottom: 10px;width: 70%;" class="blue-btn wbtn blue-grad custom-btn">
                        <span class="btn-title blue-btn-title btn-block" style="">DE BRIEF VERSTUREN</span>
                    </button>
                    </div>

                </div>



                </div>
            </div>
			
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div id="logoDiv" class="form-group text-center">
                <img class="logo" src="{{asset('images/beslisapp-46.png')}}" />


            </div>

        </form>
</div>

        <style>
            #my-form{
                padding: 24px !important;
                border-radius:6px !important;
                min-height:700px;
                padding-bottom:16px;
                margin-top:24px;
                position: relative;
            }

            #terms{
                border-radius:5px !important;
            }

            #back-2,#back-1{
                padding: 6px;
                margin-top: 24px;
            }

            .selection .blue-btn{
                padding: 6px;
            }
            .row{
                margin-left: 8px;
                margin-right: 8px;
            }

            .custom-btn{
                margin-top:14px !important;
            }

            .custom-btn-2{
                height: 80px !important;
            }

            .custom-btn-2 span{
                font-size: 20px !important;
            }

            #accept span{
                font-size:20px !important;
            }

            #accept{
                margin-top:24px !important;
            }

            .custom-file{
                border: none;
            }


            .logo{
                height:auto;
                width:auto;
                max-height: 50px;
                max-width: 250px;


            }

            #logoDiv{
                 position:absolute;
                right:0;
                left:0;
                bottom:0;
               
            }

            @media screen and (max-height:700px){
                #accept{
                    height:80px !important;
                }
            }


            @media screen and (max-width:600px){
                .custom-btn{
                    height:70px;
                    width:100% !important;
                }
            }



            /* !important is needed sometimes */
            ::-webkit-scrollbar {
                width: 12px !important;
            }

            /* Track */
            ::-webkit-scrollbar-track {
                -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3) !important;
                -webkit-border-radius: 10px !important;
                border-radius: 10px !important;
            }

            /* Handle */
            ::-webkit-scrollbar-thumb {
                -webkit-border-radius: 10px !important;
                border-radius: 10px !important;
                background: #41617D !important;
                -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5) !important;

            }
            ::-webkit-scrollbar-thumb:window-inactive {
                background: #41617D !important;
            }


            .signature_error{
                margin-top: 24px !important;
                width: 100% !important;
            }

        </style>

        <script type="text/javascript" src="{{ asset('js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('bootstrap/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/jsignature/jSignature.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/dropzone.js')}}"></script>
<script>

// Dropzone.options.myForm = {
//     paramName: "dzfile", // The name that will be used to transfer the file
//     maxFilesize: 2,
//     thumbnailWidth:250,
//     thumbnailHeight:250,
//     thumbnailMethod:'contain',
//     previewTemplate: document.querySelector('#preview').innerHTML,
//     addRemoveLinks: true,
//     dictRemoveFile: 'Remove file',
//     dictFileTooBig: 'Image is larger than 16MB',
//     timeout: 10000,
//     init: function() {
//         this.on("addedfile", function() {
//             if (this.files[1]!=null){
//                 this.removeFile(this.files[0]);
//             }
//         });
//     }
// };

    function goBack() {
         window.history.back();
        //window.location.href = "http://ralphrf300.300.axc.nl/faxbbbtest1234567/?status=true";
    }
    var initialized=false;
    var $sigdiv = $("#signature");

    $(document).ready(function () {

        $('#accept').click(function () {
            $(this).hide();
            $('.selection').show();
            $('#terms').hide();
            $('#back-1').hide();
        });

        $('#choseSig').click(function () {
            $('#sig').show();
            $('.my-3').show();
            $('#resetSig').show();
            $('.selection').hide();
            if(!initialized){

                $sigdiv.jSignature({'lineWidth':1}); // inits the jSignature widget.
                // after some doodling...
                $sigdiv.jSignature("reset"); // clears the canvas and rerenders the decor on it.
            }
            initialized=true;
            $('#resetSig').bind('click', function(e){
                $sigdiv.jSignature("reset");
            });

        });

        $('#choseImg').click(function () {
            $('#imgDiv').show();
            $('.selection').hide();
            $('.my-3').show();
        });

        $('.back-3').click(function () {

            //Hiding and Showing the elements
            $('.selection').show();
            $('#sig').hide();
            $('.my-3').hide();
            $('#imgDiv').hide();
            $('#resetSig').hide();
            $('.signature_error').hide();


            //Resetting state
            $('#processedImage').attr('src','');
            $('#imgName').val('');
            $('#imgPath').val('');
            $('#dzfile').val('');
            $sigdiv.jSignature("reset");
        });


        $('#back-2').click(function () {
            $('.selection').hide();
            $('#terms').show();
            $('#accept').show();
            $('#back-1').show();
        });



        $('#submit').on('click', function(e) {
            $('.signature_error').hide();
            $('#terms_error').hide();
            no_errors = true;
            console.log($sigdiv.jSignature('getData', 'native'));



            if( ($sigdiv.jSignature('getData', 'native') == undefined || $sigdiv.jSignature('getData', 'native').length ==0) && $('#dzfile')[0].files.length==0) {
                $('.signature_error').show();
                no_errors = false;
            }

            console.log("Success");



            /*if(!$('#term_check').is(':checked')) {
                $('#terms_error').show();
                no_errors = false;
            }*/

            if (!no_errors){
                e.preventDefault(e);
                return false;
            }

            var datapair = $sigdiv.jSignature("getData");
            $('#jsignature').val(datapair);

        });



        /*$('#clear').on('click', function(e){
            $sigdiv.jSignature("reset");
        });*/
        $('#term_check').change(function() {
            if($(this).is(":checked")) {
                $('#checkmark2').attr('style', 'background-color: #fff;');
            }
            $('#checkmark2').attr('style', 'background-color: #0188c7;');
        });


        $('#dzfile').change(function(){
            if($(this).val()!=''){
                $('.signature_error').hide();
                var formData = new FormData();
                console.log($(this)[0].files[0]);
                if($(this)[0].files[0].size>(2*1024*1024))
                {
                    alert("Het gekozen bestand is te groot. Kies een bestand van maximaal 2 MB.");
                    $('#processedImage').attr('src','');
                    $(this).val('');
                    return;
                }
                $('#processedImage').attr('src','');
                $('#imgName').val('');
                $('#imgPath').val('');
                formData.append('dzfile',$(this)[0].files[0]);
                formData.append('_token','{{ csrf_token() }}')
                $('#spinner').show();
                $('#processSt').show();
                $('.imgP').show();

                var request = $.ajax({
                    url: "/image-process",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                });

                request.done(function( msg ) {
                    console.log(msg);
                    $('#spinner').hide();
                    $('#processSt').hide();

                    $('#processedImage').attr('src',msg.url);
                    $('#processedImage').show();
                    $('#imgName').val(msg.name);
                    $('#imgPath').val(msg.path);
                    $('')
                });

                request.fail(function( jqXHR, textStatus ) {
                    alert("Het gekozen bestand is te groot. Kies een bestand van maximaal 2 MB.");
                    $('#processedImage').attr('src','');
                    $('#processedImage').hide();
                    $('#spinner').hide();
                    $('#processSt').hide();

                });
            }
        });
    });



</script>

         {{-- <style>
             .dropzone .dz-preview.dz-error:hover .dz-error-message{
                 margin-top: 12px !important;
             }
             .dropzone .dz-preview .dz-image {
                 width: 100%;
                 height: 250px;

             }

             .text-white{
                 color:white !important;
             }
             .jSignature{
                 background: white;
             }
         </style> --}}

</body>
</html>
