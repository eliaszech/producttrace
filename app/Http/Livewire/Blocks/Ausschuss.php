<?php

namespace App\Http\Livewire\Blocks;

use App\Models\Data\Process;
use App\Models\Generic\Block;
use Livewire\Component;

class Ausschuss extends Component
{
    public $blockId;
    public $orderId;

    public $search = '';

    public function render()
    {
        $block = Block::find($this->blockId);

        $wafers = Process::where('order_id', $this->orderId)->with(['rejection', 'block', 'wafer'])->whereHas('rejection', function($query) {
            return $query->where('reject', true);
        })->lazy();

        $waferCount = count(Process::where('order_id', $this->orderId)->select('wafer_id')->groupBy('wafer_id')->get());

        $wafers = $wafers->where('wafer.reworked', false)->sortBy('block.avo');

        if($wafers->count() > 0)
            $calculatedRejections = ($wafers->count() / $waferCount) * 100;
        else
            $calculatedRejections = 0;

        if($this->search != '') {
            $wafers = $wafers->filter(function ($value, $key) {
                return stristr($value->wafer_id, $this->search);
            });
        }

        $rejections = [];
        $rejectionCounts = [];
        $prevRejection = "";
        $index = -1;
        $wafersT = $wafers->sortBy('rejection.name');
        foreach($wafersT as $wafer) {
            if($wafer->rejection->name != $prevRejection) {
                $index++;
                $prevRejection = $wafer->rejection->name;
                $rejections[] = "'{$wafer->rejection->name}'";
                $rejectionCounts[$index] = 1;
            } else {
                $rejectionCounts[$index] += 1;
            }
        }

        $failedWafers = $wafers->count();
        foreach($rejectionCounts as $rejectionCountKey => $rejectionCountValue) {
            $rejectionCounts[$rejectionCountKey] = number_format(($rejectionCountValue / $failedWafers) * 100, 2);
        }

        return view('livewire.blocks.ausschuss', compact('block', 'wafers', 'waferCount', 'calculatedRejections', 'rejections', 'rejectionCounts'));
    }
}
