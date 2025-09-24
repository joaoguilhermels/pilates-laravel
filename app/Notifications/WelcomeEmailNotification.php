<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeEmailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $plan = $notifiable->saasPlans;
        $planName = $plan ? $plan->name : 'Profissional';
        $trialDays = $plan ? $plan->trial_days : 14;
        $isProfessional = $plan && $plan->slug === 'profissional';
        $isStudio = $plan && $plan->slug === 'estudio';

        $message = (new MailMessage)
            ->subject('Bem-vindo ao PilatesFlow! Sua conta est  ativa')
            ->greeting("Parab ns, {$notifiable->name}! ")
            ->line("Sua conta **PilatesFlow** foi ativada com sucesso!")
            ->line("Voc  est  no plano **{$planName}** com **{$trialDays} dias de trial gratuito**.");

        if ($isProfessional) {
            $message
                ->line("** Como Profissional Independente, voc  pode:**")
                ->line("• Gerenciar at  100 clientes pessoais")
                ->line("• Organizar sua agenda completa")
                ->line("• Controlar aulas particulares")
                ->line("• Trabalhar em m ltiplos est d ios")
                ->line("• Acompanhar sua performance financeira");
        } elseif ($isStudio) {
            $message
                ->line("** Como Dono de Est dio, voc  tem acesso a:**")
                ->line("• Gest o completa do seu neg cio")
                ->line("• Clientes e profissionais ilimitados")
                ->line("• Relat rios gerenciais avan ados")
                ->line("• Controle financeiro completo")
                ->line("• Suporte priorit rio");
        }

        $message
            ->line("---")
            ->line("** Pr ximos passos recomendados:**")
            ->line("1. **Complete seu Perfil** - Adicione informa es do seu neg cio")
            ->line("2. **Configure seu primeiro plano** - Defina pre os e modalidades")
            ->line("3. **Cadastre seus clientes** - Importe ou adicione manualmente")
            ->line("4. **Explore o dashboard** - Familiarize-se com as funcionalidades")
            ->action(' Come ar Agora', route('home'))
            ->line("---")
            ->line("** Dicas para o sucesso:**");

        if ($isProfessional) {
            $message
                ->line("• Use a agenda para organizar seus hor rios")
                ->line("• Cadastre todos os locais onde trabalha")
                ->line("• Acompanhe seus ganhos mensais")
                ->line("• Configure lembretes autom ticos");
        } else {
            $message
                ->line("• Configure todos os seus profissionais")
                ->line("• Defina planos de mensalidade atrativos")
                ->line("• Use os relat rios para tomar decis es")
                ->line("• Automatize a cobran a dos clientes");
        }

        $message
            ->line("---")
            ->line("** Precisa de ajuda?**")
            ->line("• **Suporte por email**: suporte@pilatesflow.com")
            ->line("• **Central de ajuda**: pilatesflow.com/ajuda")
            ->line("• **WhatsApp**: (11) 99999-9999");

        if ($isStudio) {
            $message->line("• **Suporte priorit rio**: Resposta em at  2 horas");
        }

        $message
            ->line("---")
            ->line("Estamos aqui para ajudar voc  a **revolucionar** a gest o do seu neg cio de Pilates!")
            ->salutation("Equipe PilatesFlow \n*Gest o Inteligente para Profissionais Inteligentes*");

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'welcome',
            'plan' => $notifiable->saasPlans?->name,
            'trial_days' => $notifiable->saasPlans?->trial_days,
        ];
    }
}
