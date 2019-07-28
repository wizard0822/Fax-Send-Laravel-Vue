<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <!--link rel="icon" href="../../../../favicon.ico"-->
  <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('js/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet">
  <link href="{{ asset('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
  <link href="{{ asset('fax.css')}}" rel="stylesheet">
  <title>Send Fax</title>
</head>

<body>
  <div id="background"></div>

  <div class="container" id="container">
    <form id="fax-form" method="post" action="/" class="">
      <div class="m-2">
        <h4 class="text-primary text-center"></h4>
      </div><br>
      <ul id="progressbar">
        <li class="active clr">1 ALGEMENE INFORMATIE</li>
        <li class="clr">2 Client INFORMATIE</li>
        <li class="clr">3 Gemeente INFORMATIE</li>
      </ul>
      <fieldset <?php if(isset($_GET['status'])) { if($_GET['status']=='true' ){ echo 'style="display:none"' ; }} ?>>

        <h3 class="cyan fs-title">ONTWIKKEL SERVER IXL</h3>

        <h6 class="smalltitletext">De velden met een * zijn verplicht.</h6> <br>





 
  
        <div class="form-group" style="margin-bottom: 0.75rem !important;">
          <p class="title-fax shadow">* Gaat het om een aanvraag of bezwaarschrift:</p>
<select name="my_html_select_box" id="selectOP"  style="width:400px;">
	<option value="">Maak een keuze</option>
	<option value="1">Aanvraag </option>
	<option value="2">Bezwaarschrift (geen adviescommissie)  </option>
	<option value="3">Bezwaarschrift (met een adviescommissie) </option>

</select>
        
            <span class="input-divider"></span>
          </label>
        </div>
   <p class="alert alert-dark alert-dk" id="alert-f1" style="display: none;">Dit is een verplicht veld.</p>

 


        <div class="form-group" style="margin-bottom: 0.75rem !important;">
          <p class="title-fax shadow">* Kies hieronder de datum van de aanvraag:</p>
          <label class="in-label in-label-calendar w-100">
            <input class="form-control inset-shadow border-blue fs in-input pr-0" type="text" id="f2" name="date" value="<?php if(isset($_SESSION['f2']))echo $_SESSION['f2']; ?>"
              placeholder="">
            <span class="input-divider"></span>
          </label>
        </div>

        <p class="alert alert-dark alert-dk" id="alert-f2" style="display: none;">Vul hierboven de datum van uw
          aanvraag in.</p>
        <div class="alert alert-dk alert-dark dnone" id="dterror">De gemeente heeft 8 weken om te beslissen op uw
          aanvraag. Deze termijn is nog niet verstreken. Nog even geduld.</div>

        <div class="form-group">
          <p class="title-fax shadow">* Heeft u een brief ontvangen dat er later wordt beslist?</p>


          <label class="">Ja</label>
          <?php if(isset($_SESSION['nee'])){if($_SESSION['nee'] == "ja"){echo "";}} ?>
          <input type="radio" class="nee" name="letter_received" id="ja" style="" value="ja" <?php
            if(isset($_SESSION['nee'])){if($_SESSION['nee']=="ja" ){echo " checked" ;}} ?>>

          <label class="">Nee</label>
          <?php if(isset($_SESSION['nee'])){if($_SESSION['nee'] == "nee"){echo "";}} ?>
          <input type="radio" class="nee" name="letter_received" id="nee" value="nee" <?php
            if(isset($_SESSION['nee'])){if($_SESSION['nee']=="nee" ){echo " checked" ;}} ?> >

          <p class="alert alert-dark alert-dk" id="alert-ja-nee" style="display: none;">Vertel ons hierboven of u een
            brief heeft ontvangen dat er later wordt beslist.</p>
          <div class="alert alert-dark alert-dk" id="neeerror" style="display: none;">U kunt gewoon doorgaan. Neem
            gerust contact op met ons als u zeker wilt weten dat u de gemeente niet te vroeg in gebreke stelt.</div>
        </div>


        <div class="form-group" style="margin-bottom: 0.75rem !important;">
          <p class="title-fax shadow">* Het Kenmerk van de aanvraag:</p>
          <label class="in-label in-label-question w-100">
            <input class="form-control inset-shadow border-blue fs in-input" type="text" id="f1" name="applied_for" value="<?php if(isset($_SESSION['f1'])) echo $_SESSION['f1']; ?>"
              placeholder="">
            <span class="input-divider"></span>
          </label>
        </div>


        <!-- <div class="alert alert-info2 w-90 dnone" id="info3">You should choose avrangand</div> -->
        <!-- <p class="alert alert-dark alert-dk" id="fserror" style="display: none;">De velden met een ster (*) zijn verplicht</p> -->

        <button type="submit" class="next blue-btn pull-right wbtn blue-grad" id="fb" style="margin-bottom: 10px; margin-left: 10px !important;">

          <span class="btn-title blue-btn-title">VOLGENDE </span>

        </button>


      </fieldset>

      <fieldset <?php if(isset($_GET['status'])) { if($_GET['status']=='true' ){ echo 'style="display:none"' ; }} ?>>

        <h3 class="cyan fs-title">KIES TEST ACCOUNT FAX:</h3>
        <h6 class="smalltitletext">De velden worden automatisch ingevuld.</h6> <br>

        <div class="form-group myfg">
          <p class="title-fax shadow">* Selecteer hieronder de gemeente:</p>
          <label class="in-label in-label-city">
            <input class="form-control inset-shadow border-blue in-input" type="text" id="besto" name="name" value="<?php if(isset($_SESSION['name']))echo $_SESSION['name']; ?>"
              placeholder="Kies de gemeente uit de lijst">
            <span class="input-divider"></span>
          </label>
        </div>
        <p class="alert alert-dark alert-dk" id="alert-besto" style="display: none;">Selecteer hierboven de gemeente
          uit de lijst.</p>

        <div class="form-group myfg">
          <p class="title-fax shadow">* Ter attentie van:</p>
          <label class="in-label in-label-city">
            <input class="form-control inset-shadow border-blue in-input" readonly="readonly" type="text" id="f12" name="department" value="<?php if(isset($_SESSION['f12']))echo $_SESSION['f12']; ?>"
              placeholder="Ter attentie van">
            <span class="input-divider"></span>
          </label>
        </div>
        <p class="alert alert-dark alert-dk" id="alert-f12" style="display: none;">Vul hierboven Burgemeesters en
          Wethouders in.</p>

        <div class="form-group myfg">
          <p class="title-fax shadow">* Fax nummer van de gemeente:</p>
          <label class="in-label in-label-office-telephone">
            <input class="form-control inset-shadow border-blue in-input" readonly="readonly" type="text" id="f17" name="fax" value="<?php if(isset($_SESSION['f17']))echo $_SESSION['f17']; ?>"
              onkeypress="return isNumber(event)" placeholder="Faxnummer gemeente">
            <span class="input-divider"></span>
          </label>
        </div>
        <p class="alert alert-dark alert-dk" id="alert-f17" style="display: none;">Vul hierboven het faxnummer in van
          de gemeente.</p>
        <p class="alert alert-dark alert-dk" id="fierror" style="display: none;">Voer een fax nummer in met tien
          cijfers.</p>

        <div class="form-group myfg">
          <p class="title-fax shadow">Overige gemeente informatie:</p>
          <label class="in-label in-label-at">
            <input class="form-control inset-shadow in-input" type="text" readonly="readonly" name="email" id="f18" value="<?php if(isset($_SESSION['f18']))echo $_SESSION['f18']; ?>"
              placeholder="Emailadres">
            <span class="input-divider"></span>
          </label>
        </div>
        <p class="alert alert-dark alert-dk" id="emailerror" style="display: none;">Vul een geldig email adres in.</p>



        <div class="form-group myfg">
          <?php // <p class="title-fax shadow" >Adres:</p> ?>
          <label class="in-label in-label-marker">
            <input class="form-control inset-shadow in-input" type="text" readonly="readonly" name="address" id="f13" value="<?php if(isset($_SESSION['f13']))echo $_SESSION['f13']; ?>"
              placeholder="Adres">
            <span class="input-divider"></span>
          </label>
        </div>
        <p class="alert alert-dark alert-dk" id="alert-f13" style="display: none;">This field (f13) is required</p>

        <div class="form-group myfg">
          <?php // <p class="title-fax shadow" >Postcode:</p> ?>
          <label class="in-label in-label-marker">
            <input class="form-control inset-shadow in-input" type="text" readonly="readonly" name="postal" id="f14" value="<?php if(isset($_SESSION['f14']))echo $_SESSION['f14']; ?>"
              placeholder="Postcode">
            <span class="input-divider"></span>
          </label>
        </div>
        <p class="alert alert-dark alert-dk" id="alert-f14" style="display: none;">This field (f14) is required</p>

        <div class="form-group myfg">
          <?php //  <p class="title-fax shadow" >Woonplaats:</p> ?>
          <label class="in-label in-label-marker">
            <input class="form-control inset-shadow in-input" type="text" readonly="readonly" id="f15" name="city" value="<?php if(isset($_SESSION['f15']))echo $_SESSION['f15']; ?>"
              placeholder="Woonplaats">
            <span class="input-divider"></span>
          </label>
        </div>
        <p class="alert alert-dark alert-dk" id="alert-f15" style="display: none;">Vul hierboven de woonplaats in.</p>



        <!-- <p class="alert alert-dark alert-dk" id="tserror" style="display: none;">De velden met een ster (*) zijn verplicht</p> -->


        <button class="next blue-btn pull-right wbtn blue-grad" id="sb" type="button" style="margin-bottom: 10px; margin-left: 10px !important;">
          <span class="btn-title blue-btn-title">VOLGENDE </span>


        </button>

        <button type="button" class="white-btn previous pull-right wbtn" style="margin-bottom: 10px; margin-left: 10px !important;"
          onclick="goBack();">
          <span class="btn-title white-btn-title">TERUG </span>

        </button>


      </fieldset>

      <fieldset <?php if(isset($_GET['status'])) { if($_GET['status']=='true' ){ echo 'style="display:block"' ; }} ?>>
        <h3 class="cyan fs-title">CLIENT</h3>
        <h6 class="smalltitletext">Gelukkig, de laatste invul velden.</h6> <br>


        <div class="form-group">
          <p class="title-fax shadow">* Contactgegevens:</p>
          <label class="">Meneer</label>
          <?php if(isset($_SESSION['f4a'])){if($_SESSION['f4a'] == "meneer"){echo "";}} ?>
          <input name="gender" type="radio" class="f4a" value="meneer" id="meneer" <?php
            if(isset($_SESSION['f4a'])){if($_SESSION['f4a']=="meneer" ){echo "checked" ;}} ?> >

          <label class="">Mevrouw</label>
          <?php if(isset($_SESSION['f4a'])){if($_SESSION['f4a'] == "mevrouw"){echo "";}} ?>
          <input type="radio" name="gender" class="f4a" value="mevrouw" id="mevrouw" <?php
            if(isset($_SESSION['f4a'])){if($_SESSION['f4a']=="mevrouw" ){echo "checked" ;}} ?>>

          <p class="alert alert-dark alert-dk" id="alert-f4a" style="display: none;">Vul hierboven uw geslacht in.</p>
        </div>



        <div class="form-group myfg">
          <?php // <p class="title-fax shadow" >* Voorletters:</p> ?>

          <label class="in-label in-label-user">
            <input class="form-control inset-shadow border-blue in-input" id="cli-add" name="first_name" onkeydown="upperCaseF(this)"
              value="<?php if(isset($_SESSION['f4b']))echo $_SESSION['f4b']; ?>" placeholder="Voorletters">
            <span class="input-divider"></span>
            <div class="alert alert-dark alert-dkvl" id="voorlettererror" style="display: none;"> TTSGSGSGSJ.</div>
          </label>
        </div>
        <p class="alert alert-dark alert-dk" id="alert-cliadd" style="display: none;">Vul hierboven de voorletters in.</p>

        <div class="form-group myfg">
          <?php // <p class="title-fax shadow" >* Achternaam:</p> ?>
          <label class="in-label in-label-user">
            <input class="form-control inset-shadow border-blue in-input" type="text" id="cli-name" name="last_name" onkeydown="jsUcfirst(this)"
              value="<?php if(isset($_SESSION['f4']))echo $_SESSION['f4']; ?>" placeholder="Achternaam" style="text-transform: capitalize;">
            <span class="input-divider"></span>
          </label>
        </div>
        <p class="alert alert-dark alert-dk" id="alert-cliname" style="display: none;">Vul hierboven uw achternaam in.</p>


        <div class="form-group myfg">
          <?php // <p class="title-fax shadow" >* Postcode:</p> ?>
          <label class="in-label in-label-marker">
            <input class="form-control inset-shadow border-blue in-input" type="text" id="cli-postcode" name="customer_postal"
              onkeydown="upperCaseF(this)" value="<?php if(isset($_SESSION['f6']))echo $_SESSION['f6']; ?>" placeholder="Postcode">
            <span class="input-divider"></span>
          </label>
          <!-- <span class="postal-code-error" style="display: none;color: red;"></span> -->
        </div>
        <p class="alert alert-dark alert-dk" id="alert-clipostcode" style="display: none;">Vul hierboven uw postcode
          in.</p>
        <p class="alert alert-dark alert-dk" id="alert-clipostcode-len" style="display: none;">Vul een geldige postcode
          in</p>

        <!--ADDED BY PHPRADAR-->
        <div class="form-group myfg">
          <?php // <p class="title-fax shadow" >* Huisnummer:</p> ?>
          <label class="in-label in-label-marker">
            <input class="form-control inset-shadow border-blue in-input" type="text" id="cli-home-number" name="home_num"
              value="<?php if(isset($_SESSION['house']))echo $_SESSION['house']; ?>" placeholder="Huisnummer">
            <span class="input-divider"></span>
          </label>
          <!-- <span class="house-code-error" style="display: none;color: red;"></span> -->
        </div>
        <p class="alert alert-dark alert-dk" id="alert-clihomenumber" style="display: none;">Vul hierboven uw
          huisnummer in.</p>
        <p class="alert alert-dark alert-dk" id="alert-clihomenumber-len" style="display: none;">Vul een geldig
          huisnummer in.</p>

        <!--ADDED BY PHPRADAR CLOSE-->

        <div class="form-group myfg">
          <?php // <p class="title-fax shadow" >* Adres en woonplaats worden alvast ingevuld:</p> ?>
          <label class="in-label in-label-at">
            <input class="form-control inset-shadow border-blue in-input" type="text" id="cli-email" name="customer_email" value="<?php if(isset($_SESSION['f9']))echo $_SESSION['f9']; ?>"
              placeholder="Email">
            <span class="input-divider"></span>
          </label>
        </div>
        <p class="alert alert-dark alert-dk" id="alert-cliemail" style="display: none;">Vul hierboven uw emailadres in.</p>
        <p class="alert alert-dark alert-dk" id="alert-cliemail-form" style="display: none;">Vul een geldig emailadres
          in.</p>

        <div class="form-group myfg">
          <?php // <p class="title-fax shadow" >* Telefoonnummer:</p> ?>
          <label class="in-label in-label-cell">
            <input class="form-control inset-shadow border-blue in-input" type="text" id="cli-phone" name="phone"
              onkeypress="return isNumber(event)" value="<?php if(isset($_SESSION['f8']))echo $_SESSION['f8']; ?>"
              placeholder="Telefoonnummer">
            <span class="input-divider"></span>
          </label>
        </div>
        <p class="alert alert-dark alert-dk" id="alert-cliphone" style="display: none;">Vul hierboven uw telefoonnummer
          in.</p>
        <p class="alert alert-dark alert-dk" id="numerror" style="display: none;">Vul hier de tien cijfers van uw
          nummer in.</p>


        <div class="form-group myfg">
          <?php // <p class="title-fax shadow" >* Iban rekeningnummer:</p> ?>
          <label class="in-label in-label-user">
            <input class="form-control inset-shadow border-blue in-input" type="text" id="cli-reknr" name="bank_account" value="<?php if(isset($_SESSION['reknr']))echo $_SESSION['reknr']; ?>"
              placeholder="Iban rekeningnummer" style="text-transform: uppercase;">
            <span class="input-divider"></span>
          </label>
        </div>
        <p class="alert alert-dark alert-dk" id="alert-clireknr" style="display: none;">Vul hierboven uw Iban
          rekeningnummer in.</p>




        <div class="form-group myfg">
          <p class="title-fax shadow">* Controleer hier uw adres en woonplaats:</p>
          <label class="in-label in-label-marker">
            <input class="form-control inset-shadow border-blue in-input" type="text" id="cli-addr" name="customer_address" value="<?php if(isset($_SESSION['f5']))echo $_SESSION['f5']; ?>"
              placeholder="Adres">
            <span class="input-divider"></span>
          </label>
        </div>
        <p class="alert alert-dark alert-dk" id="alert-cliaddr" style="display: none;">Vul hierboven uw straatnaam in.</p>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">


        <div class="form-group myfg">
          <?php // <p class="title-fax shadow" >* Woonplaats:</p> ?>
          <label class="in-label in-label-marker">
            <input class="form-control inset-shadow border-blue in-input" type="text" id="cli-residence" name="customer_city"
              value="<?php if(isset($_SESSION['f7']))echo $_SESSION['f7']; ?>" placeholder="Woonplaats">
            <span class="input-divider"></span>
          </label>
        </div>
        <p class="alert alert-dark alert-dk" id="alert-clires" style="display: none;">Vul hierboven uw woonplaats in.</p>


        <div class="form-group myfg" style="    margin-bottom: 0.35rem !important;">
          <p class="title-fax shadow">Opmerking voor Buro Bezwaar en Beroep:</p>
          <label class="in-label in-label-mega-phone">
            <textarea class="form-control inset-shadow in-input" type="text" id="cli-comment" name="notes" value=""
              placeholder=""><?php if(isset($_SESSION['f10']))echo $_SESSION['f10']; ?></textarea>
            <span class="input-divider textarea-divider"></span>
          </label>
        </div>
        <p class="alert alert-dark alert-dk" id="alert-clicomment" style="display: none;">Hierboven kunt u een
          berichtje voor Buro Bezwaar en Beroep schrijven</p>
        <!-- <p class="alert alert-danger alert-dk" id="sserror" style="display: none;">De velden met een ster (*) zijn verplicht</p> -->

        <button type="submit" name="submit_form" class="blue-btn pull-right wbtn blue-grad" id="tb" type="button" style="margin-bottom: 10px; margin-left: 10px !important;">
          <span class="btn-title blue-btn-title">VOLGENDE</span>
        </button>

        <button type="button" class="white-btn previous pull-right wbtn" style="margin-bottom: 10px; margin-left: 10px !important;"
          onclick="goBack();">
          <span class="btn-title white-btn-title">TERUG</span>

        </button>


      </fieldset>
      @if ($errors->any())
      <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif

    </form>
  </div>
  <script type="text/javascript" src="{{ asset('js/jquery.min.js')}}"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
  <script type="text/javascript" src="{{ asset('bootstrap/js/bootstrap.min.js')}}"></script>
  <script type="text/javascript" src="{{ asset('js/fax.js')}}"></script>
  <script type="text/javascript" src="{{ asset('js/autocomplete.js')}}"></script>
  <script type=" text/javascript"src="{{ asset('js/valid.js')}}"></script>
  <script type="text/javascript" src="{{ asset('js/jquery-ui/jquery-ui.min.js')}}"></script>
</body>

</html>
