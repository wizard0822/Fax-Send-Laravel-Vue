<?php
namespace App\Helpers;

use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\Storage;
use App\Fax;
require_once(base_path('/vendor/setasign/fpdi/src/Fpdi.php'));

class FpdiHandler
{
    public static function EditReport($report, $fax_id)
    {
        $pdf = new Fpdi();
        $pdf->AddPage();
        $pdf->setSourceFile(Storage::disk('admin')->readStream("reports/{$report}"));
        // import page 1 
        $tplIdx = $pdf->importPage(1); 
        //use the imported page and place it at point 0,0; calculate width and height
        //automaticallay and ajust the page size to the size of the imported page 
        $pdf->useTemplate($tplIdx, 0, 0, null, null, true); 
    
        $pdf->SetFillColor(255,255,255);
        $pdf->Rect(5, 75, 200, 6, 'F');
        $pdf->Rect(5, 283, 200, 6, 'F');
        $report_new = "New".$report;
        Storage::disk('admin')->put("reports/".$report_new, $pdf->Output('S'));
        $fax = Fax::find($fax_id);
        $fax->new_trans = "reports/".$report_new;
        $fax->save();
    }
}
