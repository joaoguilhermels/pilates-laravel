@extends('layouts.dashboard')

@section('content')
<div class="py-6">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Smart Breadcrumbs -->
        <x-smart-breadcrumbs :items="[
          ['title' => 'Cobrança', 'url' => route('billing.index')],
          ['title' => 'Informações de Cobrança', 'url' => '']
        ]" />
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">📄 Informações de Cobrança</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">
                Complete suas informações para emissão de notas fiscais e cobrança
            </p>
        </div>

        <!-- Form -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <form action="{{ route('billing.info.update') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <!-- Tax Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                        Informações Fiscais
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tax ID Type -->
                        <div>
                            <label for="tax_id_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tipo de Documento *
                            </label>
                            <select 
                                id="tax_id_type" 
                                name="tax_id_type" 
                                required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                x-data="{ taxType: '{{ old('tax_id_type', $user->tax_id_type) }}' }"
                                x-model="taxType"
                            >
                                <option value="">Selecione o tipo</option>
                                <option value="cpf" {{ old('tax_id_type', $user->tax_id_type) === 'cpf' ? 'selected' : '' }}>
                                    CPF - Pessoa Física
                                </option>
                                <option value="cnpj" {{ old('tax_id_type', $user->tax_id_type) === 'cnpj' ? 'selected' : '' }}>
                                    CNPJ - Pessoa Jurídica
                                </option>
                            </select>
                            @error('tax_id_type')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tax ID -->
                        <div>
                            <label for="tax_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <span x-show="taxType === 'cpf'">CPF *</span>
                                <span x-show="taxType === 'cnpj'">CNPJ *</span>
                                <span x-show="!taxType">Documento *</span>
                            </label>
                            <input 
                                type="text" 
                                id="tax_id" 
                                name="tax_id" 
                                value="{{ old('tax_id', $user->tax_id) }}"
                                required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                x-mask:dynamic="taxType === 'cpf' ? '999.999.999-99' : '99.999.999/9999-99'"
                                :placeholder="taxType === 'cpf' ? '000.000.000-00' : '00.000.000/0000-00'"
                            >
                            @error('tax_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Company Name (for CNPJ) -->
                    <div x-show="taxType === 'cnpj'" class="mt-6">
                        <label for="company_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Razão Social *
                        </label>
                        <input 
                            type="text" 
                            id="company_name" 
                            name="company_name" 
                            value="{{ old('company_name', $user->company_name) }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                            placeholder="Nome da empresa conforme CNPJ"
                        >
                        @error('company_name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Address Information -->
                <div class="pt-6 border-t border-gray-200 dark:border-gray-700" x-data="addressForm()">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                        Endereço de Cobrança
                    </h3>
                    
                    <div class="space-y-6">
                        <!-- CEP - Primeiro campo para busca automática -->
                        <div class="max-w-xs">
                            <label for="address_postal_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                CEP *
                            </label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    id="address_postal_code" 
                                    name="address_postal_code" 
                                    x-model="cep"
                                    @input="searchAddress()"
                                    value="{{ old('address_postal_code', $user->address_postal_code) }}"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white pr-10"
                                    placeholder="00000-000"
                                    x-mask="99999-999"
                                >
                                <!-- Loading indicator -->
                                <div x-show="loading" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg class="animate-spin h-4 w-4 text-indigo-500" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                                <!-- Success indicator -->
                                <div x-show="addressFound && !loading" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg class="h-4 w-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                            <p x-show="addressFound && !loading" class="mt-1 text-sm text-green-600 dark:text-green-400">
                                ✓ Endereço encontrado automaticamente
                            </p>
                            <p x-show="error" class="mt-1 text-sm text-red-600 dark:text-red-400" x-text="error"></p>
                            @error('address_postal_code')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address Line 1 -->
                        <div>
                            <label for="address_line1" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Endereço *
                            </label>
                            <input 
                                type="text" 
                                id="address_line1" 
                                name="address_line1" 
                                x-model="street"
                                value="{{ old('address_line1', $user->address_line1) }}"
                                required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                placeholder="Rua, número"
                            >
                            @error('address_line1')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address Line 2 -->
                        <div>
                            <label for="address_line2" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Complemento
                            </label>
                            <input 
                                type="text" 
                                id="address_line2" 
                                name="address_line2" 
                                value="{{ old('address_line2', $user->address_line2) }}"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                placeholder="Apartamento, sala, andar (opcional)"
                            >
                            @error('address_line2')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- City -->
                            <div>
                                <label for="address_city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Cidade *
                                </label>
                                <input 
                                    type="text" 
                                    id="address_city" 
                                    name="address_city" 
                                    x-model="city"
                                    value="{{ old('address_city', $user->address_city) }}"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                    placeholder="São Paulo"
                                >
                                @error('address_city')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- State -->
                            <div>
                                <label for="address_state" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Estado *
                                </label>
                                <select 
                                    id="address_state" 
                                    name="address_state" 
                                    x-model="state"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                >
                                    <option value="">Selecione</option>
                                    @php
                                        $states = [
                                            'AC' => 'Acre', 'AL' => 'Alagoas', 'AP' => 'Amapá', 'AM' => 'Amazonas',
                                            'BA' => 'Bahia', 'CE' => 'Ceará', 'DF' => 'Distrito Federal', 'ES' => 'Espírito Santo',
                                            'GO' => 'Goiás', 'MA' => 'Maranhão', 'MT' => 'Mato Grosso', 'MS' => 'Mato Grosso do Sul',
                                            'MG' => 'Minas Gerais', 'PA' => 'Pará', 'PB' => 'Paraíba', 'PR' => 'Paraná',
                                            'PE' => 'Pernambuco', 'PI' => 'Piauí', 'RJ' => 'Rio de Janeiro', 'RN' => 'Rio Grande do Norte',
                                            'RS' => 'Rio Grande do Sul', 'RO' => 'Rondônia', 'RR' => 'Roraima', 'SC' => 'Santa Catarina',
                                            'SP' => 'São Paulo', 'SE' => 'Sergipe', 'TO' => 'Tocantins'
                                        ];
                                    @endphp
                                    @foreach($states as $code => $name)
                                        <option value="{{ $code }}" {{ old('address_state', $user->address_state) === $code ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('address_state')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Country (hidden, always BR) -->
                        <input type="hidden" name="address_country" value="BR">
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-between">
                    <a href="{{ route('billing.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg font-medium transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                        Salvar Informações
                    </button>
                </div>
            </form>
        </div>

        <!-- Help Text -->
        <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
            <div class="flex">
                <svg class="w-5 h-5 text-blue-400 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                        Por que precisamos dessas informações?
                    </h4>
                    <p class="text-sm text-blue-700 dark:text-blue-300 mt-1">
                        Essas informações são necessárias para emissão de notas fiscais e cumprimento das obrigações fiscais brasileiras. 
                        Todos os dados são armazenados de forma segura e utilizados apenas para fins de cobrança e emissão de documentos fiscais.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://unpkg.com/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script>
<script>
function addressForm() {
    return {
        cep: '{{ old('address_postal_code', $user->address_postal_code) }}',
        street: '{{ old('address_line1', $user->address_line1) }}',
        city: '{{ old('address_city', $user->address_city) }}',
        state: '{{ old('address_state', $user->address_state) }}',
        loading: false,
        addressFound: false,
        error: '',
        searchTimeout: null,

        searchAddress() {
            // Clear previous timeout
            if (this.searchTimeout) {
                clearTimeout(this.searchTimeout);
            }

            // Reset states
            this.error = '';
            this.addressFound = false;

            // Clean CEP (remove mask)
            const cleanCep = this.cep.replace(/\D/g, '');

            // Check if CEP has 8 digits
            if (cleanCep.length !== 8) {
                return;
            }

            // Debounce the search
            this.searchTimeout = setTimeout(() => {
                this.performSearch(cleanCep);
            }, 500);
        },

        async performSearch(cep) {
            this.loading = true;
            this.error = '';

            try {
                const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
                const data = await response.json();

                if (data.erro) {
                    this.error = 'CEP não encontrado. Verifique o número digitado.';
                    return;
                }

                // Fill the form fields
                this.street = data.logradouro || '';
                this.city = data.localidade || '';
                this.state = data.uf || '';
                this.addressFound = true;

                // Show success message briefly
                setTimeout(() => {
                    this.addressFound = false;
                }, 3000);

            } catch (error) {
                console.error('Erro ao buscar CEP:', error);
                this.error = 'Erro ao buscar endereço. Tente novamente.';
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
@endpush
@endsection
