<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Events\BbsvStored;

use App\Ppsv;

class IncrementStokValas
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(BbsvStored $event)
    {
        $event->valas->batchIncrementStok(
            $event->jumlahValas
        );
        
        \Log::info('stored',['bbsv' => $event->valas]);
    }
}
