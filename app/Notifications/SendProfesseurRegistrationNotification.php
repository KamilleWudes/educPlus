<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendProfesseurRegistrationNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $professeur;

    public function __construct($professeur)
    {
        $this->professeur = $professeur;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url('/'); // L'URL de votre application
        
        $ecoles = $this->professeur->ecoles->unique('id');
        $matieres = $this->professeur->matieres->unique('id');
        $classe = $this->professeur->classe->unique('id');
        $anneesScolaires = $this->professeur->anneesScolaires->unique('id');


        return (new MailMessage)
         ->subject('Bienvenue dans notre application')
         ->greeting('Cher(e) Professeur,'. $this->professeur->prenom . ' ' . $this->professeur->nom . ',')
         ->line('Nous sommes heureux de vous accueillir dans notre ecole.')
        ->line('Vous êtes maintenant inscrit en tant que professeur dans notre école ' . $this->professeur->ecoles->pluck('nom')->unique()->implode(', '))
        ->line('Vous enseignez le(s) matière(s) suivante(s) : ' . $this->professeur->matieres->pluck('nom')->unique()->implode(', '))
        ->line('Vous êtes responsable de(s) classe(s) : ' . $this->professeur->classe->pluck('nom')->unique()->implode(', '))
        ->line('L\'année scolaire en cours est : ' . $anneesScolaires->pluck('annee1')->unique()->implode(', ') . ' - ' . $anneesScolaires->pluck('annee2')->unique()->implode(', '))
        ->line('En tant que professeur, vous avez maintenant accès à un ensemble de fonctionnalités pour gérer vos cours et vos élèves de manière plus efficace.')
        ->action('Visitez notre site Web', url('/'))
         ->line('N\'hésitez pas à explorer et à utiliser toutes les fonctionnalités que nous offrons.')
        ->line('Si vous avez des questions ou avez besoin d\'assistance, n\'hésitez pas à contacter l\'ecole.')
        ->line('Merci de faire partie de notre communauté. Nous sommes impatients de travailler avec vous pour une éducation de qualité.')
        ->salutation('Cordialement, L\'équipe de support de notre application');

}

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
