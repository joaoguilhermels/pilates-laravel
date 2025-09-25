<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StripePaymentSucceeded extends Notification implements ShouldQueue
{
    use Queueable;

    protected $invoice;
    protected $amount;
    protected $currency;

    /**
     * Create a new notification instance.
     */
    public function __construct($invoice, $amount, $currency)
    {
        $this->invoice = $invoice;
        $this->amount = $amount;
        $this->currency = $currency;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
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
        $formattedAmount = 'R$ ' . number_format($this->amount, 2, ',', '.');
        
        return (new MailMessage)
            ->subject('✅ Pagamento Confirmado - ' . config('app.name'))
            ->greeting('Olá, ' . $notifiable->name . '!')
            ->line('Seu pagamento foi processado com sucesso!')
            ->line('**Detalhes do Pagamento:**')
            ->line('• Valor: ' . $formattedAmount)
            ->line('• Fatura: ' . $this->invoice)
            ->line('• Data: ' . now()->format('d/m/Y H:i'))
            ->action('Acessar Painel', route('billing.index'))
            ->line('Obrigado por confiar em nossos serviços!')
            ->line('Se você tiver alguma dúvida, entre em contato conosco.')
            ->salutation('Equipe ' . config('app.name'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'payment_succeeded',
            'invoice_id' => $this->invoice,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'processed_at' => now()->toISOString(),
        ];
    }
}
