<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendBulettinEtudiantNotification extends Notification
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
        $url = url('/space-etudiant'); // L'URL de votre application

        return (new MailMessage)
        ->subject('Vos bulletins sont maintenant disponibles')
        ->greeting('Cher(e) Étudiant(e),')
        ->line('Nous sommes heureux de vous informer que vos bulletins pour ce trimestre sont maintenant disponibles.')
        ->line('Vous pouvez les consulter en vous connectant à notre application.')
        ->action('Consulter les bulletins', $url)
        ->line('Si vous avez des questions ou avez besoin d\'aide pour accéder à vos bulletins, n\'hésitez pas à nous contacter l\'ecole.')
        ->line('Nous espérons que vous êtes satisfait de vos résultats et que vous avez réussi cette année académique avec succès.')
        ->line('Merci de faire partie de notre communauté. Félicitations pour vos réalisations !')
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
