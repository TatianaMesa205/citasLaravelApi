<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Citas;

class CitaConfirmada extends Mailable
{
    use Queueable, SerializesModels;

    public $cita;
    public $paciente;
    public $medico;

    public function __construct(Citas $cita)
    {
        $this->cita = $cita;
        $this->paciente = $cita->paciente;
        $this->medico = $cita->medico;
    }

    public function build()
    {
        return $this->subject('Tu cita ha sido confirmada')
                    ->markdown('emails.cita_confirmada');
    }
}
