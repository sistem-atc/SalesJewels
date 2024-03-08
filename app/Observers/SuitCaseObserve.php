<?php

namespace App\Observers;

use App\Models\SuitCase;
use App\Models\SuitCaseProduct;

class SuitCaseObserve
{
    public function deleted(SuitCase $suitCase): void
    {
        $dataStock = SuitCaseProduct::where('suit_case_id', $suitCase->id)->get()->toArray();

        foreach ($dataStock as $id)
        {
            SuitCaseProduct::where('id', $id)->delete();
        }
    }

}
