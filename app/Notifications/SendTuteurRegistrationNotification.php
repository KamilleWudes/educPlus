<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendTuteurRegistrationNotification extends Notification
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

        ->subject('Confirmation de l\'inscription de votre étudiant')
        ->greeting('Cher(e) Tuteur ' . $this->prenoms . ',')
        ->line('Nous avons le plaisir de vous informer que l\'étudiant ' . $this->prenom . ' ' . $this->nom . ' a été inscrit avec succès dans notre école, ' . $this->nomEcole . '.')
        ->line('Votre étudiant a désormais accès à notre application et peut commencer à bénéficier de nos services éducatifs.')
        ->line('N\'hésitez pas à explorer toutes les fonctionnalités que nous offrons pour faciliter l\'apprentissage de votre étudiant.')
        ->line('Informations sur l\'étudiant:')
        ->line('Nom de l\'étudiant: ' . $this->nom)
        ->line('Prénom de l\'étudiant: ' . $this->prenom)
        ->line('Classe: ' . $this->classe)
        ->line('Date d\'inscription: ' . $this->dateInscription)
        ->line('Matricule de l\'étudiant: ' . $this->matricule)
        ->line('Nous vous remercions de votre confiance et sommes enthousiastes à l\'idée de collaborer avec vous pour l\'éducation de votre étudiant.')
        ->line('Pour toute question ou assistance, n\'hésitez pas à nous contacter. Nous sommes là pour vous aider.')
        ->salutation('Cordialement, L\'équipe de support de ' . $this->nomEcole);
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
