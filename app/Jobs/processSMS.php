<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class processSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $user;
    protected $url;
  
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $url)
    {
        $this->user = $user;
        $this->url =$url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       Http::withBasicAuth('AC83939905e7c70332ed1adf2ce5eba13e', '9b5b9de5089566c7d0a0798f0043dc5d')
        ->asForm()
        ->post('https://api.twilio.com/2010-04-01/Accounts/AC83939905e7c70332ed1adf2ce5eba13e/Messages.json',[
           
            'To'=>"whatsapp:+521{$this->user->numero_telefono}",
            'From'=>'whatsapp:+14155238886',
            'Body'=>"Tu codigo de verificacion es: {$this->user->codigo}",
        ]);
    }
}
