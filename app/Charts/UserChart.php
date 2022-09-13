<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use App\Models\Quotation;
use App\Models\Sale;
use Carbon\Carbon;

class UserChart extends BaseChart
{

    public ?string $name = 'test_chart';

    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        # 1. Add all defined achivement for that month of all DSE
        # 2. Subtract with all order(for now) with data from point 1
        $sum = 0;
        $achieved = 0;

        $quotation_of_the_month = Quotation::where('month', Carbon::now()->format('M-Y'))->get();

        foreach($quotation_of_the_month as $quotation){
            $sum = $sum + $quotation->value;
            $achieved = $achieved + $quotation->achieved;
        }

        $remaining = $sum - $achieved;

        return Chartisan::build()
            ->labels(['Remaining', 'Achieved'])
            ->dataset('Graph', [$remaining, $achieved]);
    }
}