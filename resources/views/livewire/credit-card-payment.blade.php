<div>
    @push('styles')
        <script src="https://js.stripe.com/v3/"></script>
    @endpush
    <livewire:list-user-cards></livewire:list-user-cards>

    <x-filament::section class="mt-6">
        <x-slot name="heading">
            {{__('filament-stripe-manager::text.register_payment_method')}}
        </x-slot>

        <div x-data="{
                stripe: null,
                card: null,
                successMessage: '',
                errorMessage: '',
                isSubmitting: false,
                setupElements: function () {
                    this.stripe = Stripe('{{ config('cashier.key') }}');
                    const elements = this.stripe.elements();
                    this.card = elements.create('card');
                    this.card.mount('#card-element');
                },
                submitPaymentMethod: function () {
                    this.isSubmitting = true;
                    this.stripe.createPaymentMethod('card', this.card, {
                        billing_details: { name: '{{\Illuminate\Support\Facades\Auth::user()->name}}' }
                    }).then((result) => {
                        if (result.error) {
                            this.errorMessage = result.error.message;
                            this.isSubmitting = false;
                            this.clearMessages();
                        } else {
                            @this.set('paymentMethodId', result.paymentMethod.id);
                            @this.call('submitPaymentMethod').then(() => {
                                this.successMessage = '{{__('filament-stripe-manager::text.Payment method registered successfully')}}';
                                this.isSubmitting = false;
                                this.resetForm();
                                this.clearMessages();
                            }).catch(() => {
                                this.isSubmitting = false;
                            });
                        }
                    }).catch(() => {
                        this.isSubmitting = false;
                    });
                },
                resetForm: function () {
                    this.card.destroy();
                    this.setupElements();
                    document.getElementById('card-errors').textContent = '';
                },
                clearMessages: function () {
                    setTimeout(() => {
                        this.successMessage = '';
                        this.errorMessage = '';
                    }, 5000);
                }
            }" x-init="setupElements">

            <form x-on:submit.prevent="submitPaymentMethod">
                <div id="card-element"></div>
                <div class="pt-5">
                    <x-filament::button class="mt-6" type="submit" x-bind:disabled="isSubmitting">
                        <span x-show="!isSubmitting">{{__('filament-stripe-manager::text.register_payment_method')}}</span>
                        <span x-show="isSubmitting" class="flex items-center">
                            <svg class="animate-spin h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            {{__('filament-stripe-manager::text.loading')}}
                        </span>
                    </x-filament::button>
                </div>
            </form>
            <div id="card-errors" role="alert"></div>
            <div x-show="successMessage" x-text="successMessage" class="mt-4 p-2 rounded"></div>
            <div x-show="errorMessage" x-text="errorMessage" class="mt-4 p-2 rounded"></div>
        </div>
    </x-filament::section>
</div>
