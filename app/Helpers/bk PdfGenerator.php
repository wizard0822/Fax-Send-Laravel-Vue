<?php
namespace App\Helpers;

use App\Customer;
use App\Fax;
use App\Government;
use App\Helpers\PDF;
use Illuminate\Support\Facades\Storage;

class PdfGenerator
{
    public static function generate($fax_id, $government_id, $customer_id)
    {
        $pdf = new PDF();
        if (!defined('EURO')) define('EURO', chr(128));
        $fax = Fax::find($fax_id);
        $customer = Customer::find($customer_id);
        $government = Government::find($government_id);

        $pdf->SetLeftMargin(20);
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 12);

      //$pdf->Cell(35, 50, 'Aan:');
      //$pdf->Cell($pdf->GetStringWidth($government->fax . "  "), 50, $government->fax . ', ');
      //$pdf->Cell($pdf->GetStringWidth($government->email . " "), 50, $government->email);

        $pdf->Ln(3);

        //$pdf->Cell(35, 55, ''); //an empty cell
        $pdf->Cell($pdf->GetStringWidth($government->name . " "), 55, $government->name);
        $pdf->Cell($pdf->GetStringWidth($government->department . "    "), 55, '(' . $government->department . ')');

        $pdf->Ln(3);
        //$pdf->Cell(35, 60, ''); //an empty cell for paragraphing
        $pdf->Cell(100, 60, $government->address);

        $pdf->Ln(3);
        //$pdf->Cell(35, 65, ''); //an empty cell
        $pdf->Cell($pdf->GetStringWidth($government->postal . " "), 65, $government->postal);
        $pdf->Cell(100, 65, $government->city);

//
        $pdf->Ln(10);
        $pdf->Cell(35, 75, 'Betreft:');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(50, 75, 'INGEBREKESTELLING');
        $pdf->SetFont('Arial', '', 12);

        $pdf->Ln(3);
        $pdf->Cell(35, 80, 'Ons Kenmerk:');
        $pdf->Cell(40, 80, $fax->gen_faxcode); //stiel

        $pdf->Ln(3);
        $pdf->Cell(35, 85, 'Datum:');
        $pdf->Cell(40, 85, date('d-m-Y, H:i') . " uur");

        $pdf->Ln(10);
        $pdf->Cell(35, 90, 'Aanvraag:');
        $pdf->Cell(100, 90, $fax->applied_for);

        $pdf->Ln(3);
        $pdf->Cell(35, 95, 'Datum aanvraag:');
        $pdf->Cell(40, 95, date('m-d-Y', strtotime($fax->date)));

//Client
        $pdf->Ln(3);
        $pdf->Cell(35, 100, 'Client:');
        $pdf->Cell($pdf->GetStringWidth($customer->gender . " "), 100, $customer->gender);
        $pdf->Cell($pdf->GetStringWidth($customer->first_name . " "), 100, $customer->first_name);
        $pdf->Cell($pdf->GetStringWidth($customer->last_name . " "), 100, $customer->last_name);
        $pdf->Cell($pdf->GetStringWidth($customer->address . " "), 100, $customer->address);
        $pdf->Cell($pdf->GetStringWidth($customer->home_num . " "), 100, $customer->home_num);
        $pdf->Cell($pdf->GetStringWidth($customer->postal . " "), 100, $customer->postal);
        $pdf->Cell($pdf->GetStringWidth($customer->city . " "), 100, $customer->city);

        $pdf->Ln(10);
//$pdf->Cell(10, 50, '');
        $pdf->Cell($pdf->GetStringWidth('Geachte '), 110, 'Geachte');
        $pdf->Cell($pdf->GetStringWidth($government->name . " "), 110, $government->name);
        $pdf->Cell($pdf->GetStringWidth(','), 110, ',');

        $pdf->Ln(60);
//body goes here
        //$f1 aanbvraag,$f2 datum aanvraag,$f4 achternaam,$f5 adres,$f6 postcode,$f7 woonplaats,$f8 telefoonnummer,$f9 emailadres,$f10 ,$f11 Gemeente, ,$f12 Burogemeester en wethouders,$f13 gemeente adres,$f14 gemeente postcode,$f15 gemeente woonplaats,$f16   ,$f17 faxnummer,$f18 email gemeente,$$customer->gender meneer,$f4b voorletters

        $pdf->Write(5, "Op " .  date('m-d-Y', strtotime($fax->date)) . " heeft" ." ". $customer->gender ." ". $customer->first_name ." ". $customer->last_name . " het volgende aangevraagd: " . $fax->applied_for ." ". $customer->gender ." ".$customer->last_name . " heeft geen beslissing ontvangen.

Ingevolge artikel 4:13 tweede lid van de AWB is de redelijke termijn voor het nemen van een beslissing in ieder geval verstreken indien het bestuursorgaan binnen acht weken na ontvangst van de aanvraag geen beschikking heeft gegeven, noch een mededeling als bedoeld in artikel 4:14, derde lid, heeft gedaan. Een mededeling op grond waarvan de beslissing is verdaagd is niet door " . $customer->gender." ".$customer->last_name . " ontvangen. Dientengevolge is te laat op de ingediende aanvraag beslist. U wordt hierbij in gebreke gesteld.

Opgrondvan artikel 4:17 derde lid van de Awb heeft U twee weken de tijd om alsnog een beslissing te nemen. Op grond van artikel 4:17 eerste lid van de Awb bent u een dwangsom verschuldigd indien u direct na het verstrijken van een termijn van twee weken geen beslissing neemt. De dwangsom dient te worden overgemaakt op rekeningnummer: NL25 ASNB 0950 2832 31, ten name van: derdengelden en onder vermelding van kenmerk:" . $customer->gender ." ". $customer->first_name . " ". $customer->last_name . ", " . $fax->gen_faxcode);

/*
This breakline has to be adjusted here
 */
        $pdf->Ln(7); //HERE
        //

        $pdf->Cell(35, 10, 'Datum:');

//add date
        $pdf->Cell(80, 10, date('d-m-Y'));

        $pdf->Ln(20);
        $pdf->Cell(50, 5, "Handtekening:");
        $pdf->Image(public_path('uploads/assets/ralph_sign.jpg'), 50, 235, 50);

        $pdf->Ln(20);
        $pdf->Cell(35, 5, 'Naam:');
        $pdf->Cell(80, 5, "Ralph Vincent Tjon");

        $pdf->Ln(5);
        $pdf->Cell(35, 5, '');
        $pdf->Cell($pdf->GetStringWidth("Buro Bezwaar en Beroep"), 5, "Buro Bezwaar en Beroep");

//**************************************

        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 12);

        $pdf->Cell(35, 50, 'Aan:');
        $pdf->Cell($pdf->GetStringWidth($customer->gender . " "), 50, $customer->gender);
        $pdf->Cell($pdf->GetStringWidth($customer->first_name . " "), 50, $customer->first_name);
        $pdf->Cell($pdf->GetStringWidth($customer->last_name . " "), 50, $customer->last_name);

        $pdf->Ln(3);
        $pdf->Cell(35, 55, '');
        $pdf->Cell($pdf->GetStringWidth($customer->address . " "), 55, $customer->address);
        $pdf->Cell($pdf->GetStringWidth($customer->home_num . ""), 55, $customer->home_num);

        $pdf->Ln(3);
        $pdf->Cell(35, 60, '');
        $pdf->Cell($pdf->GetStringWidth($customer->postal . " "), 60, $customer->postal);
        $pdf->Cell($pdf->GetStringWidth($customer->city), 60, $customer->city);

        $pdf->Ln(3);
        $pdf->Cell(35, 65, ''); //an empty cell

        $pdf->Ln(10);
        $pdf->Cell(35, 75, 'Betreft:');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(50, 75, 'MACHTIGING INGEBREKESTELLING');
        $pdf->SetFont('Arial', '', 12);

        $pdf->Ln(3);
        $pdf->Cell(35, 80, 'Tussen:');
        $pdf->Cell($pdf->GetStringWidth($customer->gender . ", "), 80, $customer->gender);
        $pdf->Cell($pdf->GetStringWidth($customer->first_name . " "), 80, $customer->first_name);
        $pdf->Cell($pdf->GetStringWidth($customer->last_name . " "), 80, $customer->last_name);

        $pdf->Ln(3);
        $pdf->Cell(35, 85, 'En:');
        $pdf->Cell(100, 85, "Ralph Vincent Tjon, Buro Bezwaar en Beroep");

        $pdf->Ln(10);
        $pdf->Cell(35, 95, 'Dossier nr.:');
        $pdf->Cell($pdf->GetStringWidth($fax->gen_faxcode), 95, $fax->gen_faxcode);

//we have to break down the date here. or just change it in date picker
        $pdf->Ln(3);
        $pdf->Cell(35, 100, 'Datum aanvraag:');
        $pdf->Cell($pdf->GetStringWidth(date('m-d-Y', strtotime($fax->date))), 100, date('m-d-Y', strtotime($fax->date)));

        $pdf->Ln(3);
        $pdf->Cell(35, 105, 'Inzake besluit:');
        $pdf->Cell($pdf->GetStringWidth($fax->applied_for), 105, $fax->applied_for);
        $pdf->Ln(3);
        $pdf->Cell(35, 110, ''); //an empty cell
        $pdf->Ln(3);
        $pdf->Cell(35, 110, ''); //an empty cell

        $pdf->Ln(60);

//body goes here
        $pdf->Write(5, "Hierbij machtigt u Buro Bezwaar en Beroep om de $government->name in gebreke te stellen. Als de gemeente $government->name niet binnen vijftien dagen een besluit neemt op uw aanvraag of bezwaarschrift is een dwangsom verschuldigd. De hoogte van de boete is  ".EURO." 20 per dag voor de eerste 14 dagen. ".EURO." 30 per dag voor de 14 dagen daarna en ".EURO." 40 per dag voor de 14 dagen daarna. De totale dwangsom bedraagt maximaal ".EURO." 1260,-. 

Dekosten voor het in gebreke stellen bedragen vijftig procent van de uit te betalen dwangsom.  Vijftig procent van de ontvangen dwangsom wordt binnen twee weken na ontvangst overgemaakt op uw rekeningnummer. Met het tekenen van deze overeenkomst geeft u toestemming aan het bestuursorgaan om de verschuldigde dwangsom over te maken op een derdenrekening.

");        
/* This is where adjustment will be made for page 2*/
        $pdf->Ln(7); //HERE

        $pdf->Cell(35, 10, 'Datum:');
        $pdf->Cell(80, 10, date('d-m-Y'));

        $pdf->Ln(20);
        $pdf->Cell(50, 5, "Handtekening:");
        //$pdf->Image(public_path('uploads/'.$customer->sign), 110, 225, 85); //nededn
if($customer->sign_image==0)
			$pdf->Image(public_path('uploads/'.$customer->sign), 110, 225, 85); //nededn
		else {
			
			$pdf->Image(public_path('assets/signatures/'.$customer->sign_name), 120, 190, 50);
		}
        $pdf->Image(public_path('uploads/assets/ralph_sign.jpg'), 50, 215, 50);

        $pdf->Ln(20);
        $pdf->Cell(35, 5, 'Naam:');
        $pdf->Cell(80, 5, "Ralph Vincent Tjon");
        $pdf->Cell($pdf->GetStringWidth($customer->gender . " "), 5, $customer->gender);
        $pdf->Cell($pdf->GetStringWidth($customer->first_name . " "), 5, $customer->first_name . " ");
        $pdf->Cell($pdf->GetStringWidth($customer->last_name . " "), 5, $customer->last_name);

        $pdf->Ln(5);
        $pdf->Cell(35, 5, '');
        $pdf->Cell($pdf->GetStringWidth("Buro Bezwaar en Beroep"), 5, "Buro Bezwaar en Beroep");

        $fax_genpdf = $fax_id.".pdf";
        Storage::disk('admin')->put($fax_genpdf, $pdf->Output('S'));
        $fax->gen_pdf = $fax_genpdf;
        $fax->Save();
    }
}
