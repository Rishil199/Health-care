<?php
  
namespace App\Mail;
   
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
  
class PrescriptionMail extends Mailable
{
    use Queueable, SerializesModels;
  
     public $user,$request,$clinic_details;
   
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$request,$clinic_details)
    {
        $this->user = $user;
        $this->request = $request;
        $this->clinic_details = $clinic_details;
    }
   
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // dd("Hello");
        return $this->subject('Prescription Mail')
                    ->view('admin.emails.prescriptionemail');
    }
}