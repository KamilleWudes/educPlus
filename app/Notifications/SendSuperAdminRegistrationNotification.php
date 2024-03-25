<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendSuperAdminRegistrationNotification extends Notification
{
    use Queueable;
    protected $password;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($password)
    {
        $this->password = $password;
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
        ->subject('Création de compte SuperAdmin')
        ->line('Vous avez été enregistré en tant que SuperAdmin.')
        ->line('Voici vos informations de connexion :')
        ->line('Nom: ' . $notifiable->nom)
        ->line('Prénom: ' . $notifiable->prenom)
        ->line('Email: ' . $notifiable->email)
        ->line('Téléphone: ' . $notifiable->telephone)
        ->line('Mot de passe temporaire: ' . $this->password)
        ->action('Connectez-vous pour changer votre mot de passe', url('/'))
        ->line('Merci de votre inscription !');
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
