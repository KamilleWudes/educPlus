<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendUserRegistrationNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
   // public $ecoleNom;
   

    public function __construct($userName, $userPrenom)
    {
        $this->name = $userName;
        $this->prenom = $userPrenom;
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
         $url = url('/');
         $ecole = $notifiable->ecoles; // Supposons que vous ayez défini la relation dans le modèle User

        return (new MailMessage)
        ->subject('Bienvenue dans notre application')
        ->greeting('Cher(e) Responsable d\'École,' . $this->prenom . ' ' . $this->name . ',')
        ->line("Nous sommes ravis de vous informer que vous venez de rejoindre notre application en tant que responsable d'école.")
        ->line('Vous appartenez à l\'école : ' . $ecole->nom) 
        ->line('En tant que responsable d\'école, vous avez maintenant accès à un ensemble de fonctionnalités puissantes pour gérer votre école de manière plus efficace.')
        ->action('Commencer à explorer', $url)
        ->line('N\'hésitez pas à explorer et à utiliser toutes les fonctionnalités que nous offrons. Si vous avez des questions ou avez besoin d\'assistance, n\'hésitez pas à nous contacter.')
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
