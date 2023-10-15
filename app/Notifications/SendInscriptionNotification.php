<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendInscriptionNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        return (new MailMessage)
        ->subject('Inscription de l\'étudiant confirmée ')
        ->greeting('Cher(e) inscription,')
        ->line('Nous sommes heureux de vous informer que l\'inscription de votre étudiant a été enregistrée avec succès à l\'ecole')
        ->line('Votre étudiant a maintenant accès à notre application et peut commencer à utiliser nos services éducatifs.')
        ->line('N\'hésitez pas à explorer et à utiliser toutes les fonctionnalités que nous offrons.')
        ->line('Si vous avez des questions ou avez besoin d\'assistance, n\'hésitez pas à nous contacter l\'ecole.')
        ->line('Nous vous remercions de votre confiance et sommes ravis de travailler avec vous pour l\'éducation de votre étudiant.')
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
