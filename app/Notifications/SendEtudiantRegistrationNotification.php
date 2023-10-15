<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendEtudiantRegistrationNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $nom;
    public $prenom;
    public $classe;
    public $dateInscription;
    public $nomEcole;
    public $noms;
    public $prenoms;
    public $matricule;

    public function __construct($nom, $prenom, $classe, $dateInscription, $nomEcole, $noms, $prenoms, $matricule)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->classe = $classe;
        $this->dateInscription = $dateInscription;
        $this->nomEcole = $nomEcole;
        $this->noms = $noms;
        $this->prenoms = $prenoms;
        $this->matricule = $matricule;
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

        ->subject('Confirmation de votre inscription à ' . $this->nomEcole)
->greeting('Cher(e) Étudiant(e) ' . $this->prenom . ',')
->line('Nous sommes ravis de vous informer que votre inscription à l\'école ' . $this->nomEcole . ' a été enregistrée avec succès.')
->line('Vous êtes désormais officiellement inscrit(e) dans la classe ' . $this->classe . '.')
->line('Votre date d\'inscription est le ' . $this->dateInscription . '.')
->line('Votre numéro de matricule est le ' . $this->matricule . '.')
->line('Nous avons également informé votre tuteur, ' . $this->noms . ' ' . $this->prenoms . ', de votre inscription.')
->line('N\'hésitez pas à explorer et à profiter de toutes les fonctionnalités que nous mettons à votre disposition pour faciliter votre parcours éducatif.')
->line('Si vous avez des questions ou avez besoin d\'assistance, n\'hésitez pas à nous contacter à tout moment. Nous sommes là pour vous aider.')
->line('Nous tenons à vous remercier pour la confiance que vous accordez à ' . $this->nomEcole . ', et nous sommes impatients de vous accompagner tout au long de votre éducation.')
->line('N\'oubliez pas que notre équipe est à votre disposition pour vous soutenir à chaque étape de votre parcours éducatif.')
->salutation('Cordialement, L\'équipe de ' . $this->nomEcole);
}
// }

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
