<?php

namespace Database\Seeders;

use App\Models\SaasPlans;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaasPlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Profissional',
                'slug' => 'profissional',
                'description' => 'Para instrutores independentes que trabalham em múltiplos locais',
                'monthly_price' => 97.00,
                'yearly_price' => 970.00, // 10 meses
                'max_clients' => 100,
                'max_professionals' => 1, // Apenas o próprio profissional
                'max_rooms' => null, // Pode trabalhar em qualquer lugar
                'features' => [
                    'Até 100 clientes pessoais',
                    'Agenda pessoal completa',
                    'Controle de aulas particulares',
                    'Relatórios de performance',
                    'App mobile',
                    'Agendamento online',
                    'Gestão financeira pessoal',
                    'Suporte por email',
                    'Trabalhe em múltiplos estúdios'
                ],
                'is_popular' => false,
                'is_active' => true,
                'trial_days' => 14,
            ],
            [
                'name' => 'Estúdio',
                'slug' => 'estudio',
                'description' => 'Solução completa para donos de estúdio gerenciarem seu negócio',
                'monthly_price' => 297.00,
                'yearly_price' => 2673.00, // 9 meses
                'max_clients' => null, // Ilimitado
                'max_professionals' => null, // Ilimitado
                'max_rooms' => null, // Ilimitado
                'features' => [
                    'Clientes ilimitados',
                    'Profissionais ilimitados',
                    'Salas ilimitadas',
                    'Gestão completa do estúdio',
                    'Controle financeiro avançado',
                    'Relatórios gerenciais',
                    'Planos de mensalidade',
                    'Integração com pagamentos',
                    'Multi-unidades',
                    'Suporte prioritário',
                    'App mobile',
                    'Agendamento online',
                    'Backup automático'
                ],
                'is_popular' => true,
                'is_active' => true,
                'trial_days' => 14,
            ],
        ];

        foreach ($plans as $planData) {
            SaasPlans::create($planData);
        }

        $this->command->info('✅ SaaS Plans seeded successfully!');
        $this->command->info('Plans created:');
        foreach ($plans as $plan) {
            $this->command->info("- {$plan['name']}: R$ {$plan['monthly_price']}/mês");
        }
    }
}
