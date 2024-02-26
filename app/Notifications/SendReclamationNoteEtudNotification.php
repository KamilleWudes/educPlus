<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendReclamationNoteEtudNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $note;

    public function __construct($note)
    {
        $this->note = $note;
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
        $url = url('/space-etudiant'); // L'URL de l'espace étudiant
    
        return (new MailMessage)
            ->subject('Réclamation de notes traitée')
            ->greeting('Cher(e) Étudiant(e) ' . $this->note->inscription->etudiant->prenom . ' ' . $this->note->inscription->etudiant->nom . ',')
    
            ->line('Nous tenons à vous informer que votre réclamation concernant les notes dans la matière ' . $this->note->matiere->nom . ' a été traitée.')
            ->line('Type de trimestre : ' . $this->note->typeTrimestre->nom)
            ->line('Type de composition : ' . $this->note->typeComposition->nom)
            ->line('Matière : ' . $this->note->matiere->nom)
            ->line('Classe : ' . $this->note->classe->nom)
            ->line('Année scolaire : ' . $this->note->anneeScolaire->annee1 . '-' . $this->note->anneeScolaire->annee2)
            ->line('Vous pouvez consulter vos notes en utilisant votre matricule : ' . $this->note->inscription->etudiant->matricule)
            ->action('Cliquez ici pour consulter vos notes', $url)
            ->line('La réclamation a été traitée avec succès. Si vous avez d\'autres questions ou préoccupations, n\'hésitez pas à nous contacter à l\'école.')
            ->line('Merci de faire partie de notre communauté.')
            ->salutation('Cordialement, L\'équipe de support de ' . $this->note->classe->ecole->nom);
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
