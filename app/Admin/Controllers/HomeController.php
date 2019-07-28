<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Widgets\InfoBox;
use App\Fax;
use Carbon\Carbon;


class HomeController extends Controller
{
    public function index()
    {
        return Admin::content(function (Content $content) {
    
            // optional
            $content->header('Faxes');
    
            // optional
            // $content->description('page description');
    
            // add breadcrumb since v1.5.7

    
            $content->row( function ( Row $row ) {


				$row->column( 4, function ( Column $column ) {
					$faxes   = Fax::count();
					$infoBox = new InfoBox( 'Faxes', 'fax', 'green', '/admin/fax', $faxes );
					$column->append( $infoBox->render() );
				} );
            } );

            $content->row(function (Row $row) {
                $row->column(12, function (Column $column) {
                    $faxes = Fax::get([ 'created_at', 'id'])->groupBy(function ( $date) {
                        return Carbon::parse($date->created_at)->format('m'); // grouping by years
                    })->all();
                    $y = [];
                    $x = [];
                    foreach ($faxes as $key => $value) {
                        $y[] = $value->count();
                        $x[] = date("F", mktime(0, 0, 0, intval($key) - 1, 10));
                    }

                    $column->append(view('vendor.charts.report', [
                        'x_axis' => json_encode($x),
                        'y_axis' => json_encode($y),
                        'label' => 'Faxes',
                        'type' => 'line',
                        'id' => 2,
                    ])->render());
                });
            });
        });
    }
}
