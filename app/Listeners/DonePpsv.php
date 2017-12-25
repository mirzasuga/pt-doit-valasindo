<?php

namespace App\Listeners;

use App\Events\BbsvStored;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DonePpsv
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
     * @param  BbsvStored  $event
     * @return void
     */
    public function handle(BbsvStored $event)
    {
        // $event->ppsv->done();
        // \Log::info('PPSV DONE',json_encode($event->ppsv->get()) );
    }
}
