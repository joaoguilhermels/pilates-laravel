<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends VerifyEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);
        $planName = $notifiable->saasPlans ? $notifiable->saasPlans->name : 'Profissional';

        return (new MailMessage)
            ->subject(' Confirme seu email - PilatesFlow')
            ->greeting("Olá, {$notifiable->name}!")
            ->line("Bem-vindo ao **PilatesFlow**! ")
            ->line("Você escolheu o plano **{$planName}** e está quase pronto para começar sua jornada de gestão inteligente de Pilates.")
            ->line("Para ativar sua conta e começar seu **trial gratuito de 14 dias**, confirme seu email clicando no botão abaixo:")
            ->action(' Confirmar Email', $verificationUrl)
            ->line("**Por que confirmar?**")
            ->line("• Acesso completo à plataforma")
            ->line("• Receber notificações importantes")
            ->line("• Segurança da sua conta")
            ->line("• Suporte técnico personalizado")
            ->line("---")
            ->line("**Próximos passos após confirmação:**")
            ->line("1. Complete seu Perfil")
            ->line("2. Configure seu estúdio/agenda")
            ->line("3. Comece a usar todas as funcionalidades")
            ->line("---")
            ->line("Se você não criou esta conta, ignore este email.")
            ->line("**Link válido por 24 horas.**")
            ->salutation("Equipe PilatesFlow ");
    }

    /**
     * Get the verification URL for the given notifiable.
     */
    protected function verificationUrl($notifiable): string
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60 * 24)), // 24 hours
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
