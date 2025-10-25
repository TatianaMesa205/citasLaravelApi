@component('mail::message')
# 🩺 ¡Tu cita ha sido confirmada! ✅

Hola **{{ $paciente->nombre }}**,  

Nos complace informarte que tu cita ha sido **confirmada** por el médico  
**Dr. {{ $medico->nombre_m }} {{ $medico->apellido_m }}** 🩵

---

@component('mail::panel')
### 📅 Detalles de tu cita

- **🕓 Fecha:** {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}  
- **⏰ Hora:** {{ $cita->hora }}  
- **💬 Motivo:** {{ $cita->motivo ?? 'No registrado' }}
@endcomponent

---

### 📌 Recomendaciones
- Te recomendamos llegar **10 minutos antes** de tu cita.  
- Si necesitas **cambiar o cancelar la cita**, puedes hacerlo comunicandote con tu medico.  

Gracias por confiar en **CitasApp** 💙  
Te esperamos pronto,  
**El equipo de CitasApp**
@endcomponent
