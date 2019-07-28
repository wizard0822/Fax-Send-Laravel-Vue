<?php
namespace App\Helpers;

use Codedge\Fpdf\Fpdf\Fpdf;


class PDF extends FPDF
{
    public function Header()
    {
        $this->Image(public_path('images/bbb_logo.png'), 60, 6, 100);
        $this->Ln(20);

    }
    public function Footer()
    {
        $this->Image(public_path('images/bbb_footer.jpg'), 16, 290, 180);
    }
}
