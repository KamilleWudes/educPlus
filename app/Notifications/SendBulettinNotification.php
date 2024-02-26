<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendBulettinNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $etudiant;

    public function __construct($etudiant)
    {
        $this->etudiant = $etudiant;

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
        $url = url('/space-etudiant'); // L'URL de votre application

        return (new MailMessage)
        ->subject('Bulletins Disponibles pour ' . $this->etudiant->prenom . ' ' . $this->etudiant->nom)
        ->greeting('Cher(e) Tuteur,')
        ->line('Nous sommes heureux de vous informer que les bulletins scolaires de ' . $this->etudiant->prenom . ' ' . $this->etudiant->nom . ' sont maintenant disponibles.')
        ->line('Vous pouvez les consulter en vous connectant à notre application.')
        ->action('Consulter les Bulletins', $url)
        ->line('N\'hésitez pas à nous contacter l\'ecole si vous avez des questions ou avez besoin d\'assistance.')
        ->line('Nous vous remercions de votre confiance en notre application.')
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
