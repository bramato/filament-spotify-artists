<div x-data="{ switchOn: false }">
    @push('styles')
        <script src="https://js.stripe.com/v3/"></script>
    @endpush
    <div class="flex items-center justify-start p-3"> <!-- Changed to justify-start to align left -->
        <input id="thisId" type="checkbox" name="switch" class="hidden" :checked="switchOn">
        <button
            type="button"
            x-ref="switchButton"
            class="pr-5 mr-5 bg-gray-200 relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2"
            role="switch"
            @click="switchOn = ! switchOn"
            aria-checked="false">
            <span class="sr-only">Use setting</span>
            <span
                aria-hidden="true"
                :class="switchOn ? 'translate-x-5' : 'translate-x-0'"
                class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
        </button>
        <label @click="$refs.switchButton.click(); $refs.switchButton.focus()" :id="$id('switch')"
               class="text-sm select-none"
               x-cloak>
            <span class="p-3" x-show="switchOn">Annual Mode</span>
            <span class="p-3" x-show="!switchOn">Monthly Mode</span>
        </label>
    </div>

    <div x-show="!switchOn" class="grid grid-cols-1 md:grid-cols-3 gap-6 p-5">
        @foreach($products as $productItem)
                <!-- Pricing Card -->
            <x-filament::section class="mt-6 relative" description="Best option for personal use & for your next project.">
                <x-slot name="heading">
                    {{$productItem->name}}
                </x-slot>
                <div class="flex justify-center items-baseline my-8">
                    <span class="mr-2 text-5xl font-extrabold">${{$productItem->monthly_quota}}</span>
                    <span class="text-gray-500 dark:text-gray-400">/month</span>
                </div>
                <!-- List -->
                <ul role="list" class="mb-5 pb-8 mx-auto w-full space-y-4 text-left border-b-0">
                    @foreach($productItem->metadata as $key => $item)
                        <li class="flex items-center space-x-3 {{ $loop->last ? '' : 'border-b border-dashed border-gray-300' }}">
                            <!-- Icon -->
                            <svg class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            <span>{{$item->title}}: {{$item->value}}</span>
                        </li>
                    @endforeach
                </ul>
                <div x-data="{
    product: '{{ $productItem->product }}',
    currentPlanSubscription: @entangle('currentPlanSubscription'),
    plan: '{{$productItem->monthly_plan}}',
    type: 'monthly'
    }" class="absolute inset-x-0 bottom-0 pb-6 px-6 flex justify-center">
                    <a href="#"
                       class="bg-primary-600 p-3 text-white hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:text-white dark:focus:ring-primary-900"
                       @click="plan !== currentPlanSubscription && $wire.getSubscription(plan,product,type)"
                       x-text="plan === currentPlanSubscription ? 'Current' : 'Get'"
                       :aria-disabled="plan === currentPlanSubscription"
                       :tabindex="plan === currentPlanSubscription ? -1 : 0">
                    </a>
                </div>
            </x-filament::section>


        @endforeach
    </div>
    <div x-show="switchOn" class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($products as $productItem)
            <!-- Pricing Card -->
            <x-filament::section class="mt-6" description="Best option for personal use & for your next project." :footerActionsAlignment="\Filament\Support\Enums\Alignment::Center" :footerActions="[$this->submitPaymentMethodAndSubscriptionAction($productItem)]">
                <x-slot name="heading">
                    {{$productItem->name}}
                </x-slot>
                <div class="flex justify-center items-baseline my-8">
                    <span class="mr-2 text-5xl font-extrabold">${{$productItem->annual_quota}}</span>
                    <span class="text-gray-500 dark:text-gray-400">/year</span>
                </div>
                <div class="flex justify-center items-baseline my-8">
                    <span class="mr-2 text-5xl font-extrabold">${{number_format($productItem->annual_quota/12,2)}}</span>
                    <span class="text-gray-500 dark:text-gray-400">/month</span>
                </div>
                <!-- List -->
                <ul role="list" class="mb-5 pb-8 space-y-4 text-left">
                    @foreach($productItem->metadata as $item)
                        <li class="flex items-center space-x-3">
                            <!-- Icon -->
                            <svg class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            <span>{{$item->title}}: {{$item->value}}</span>
                        </li>
                    @endforeach
                </ul>
                <x-filament-actions::modals />
            </x-filament::section>
        @endforeach
    </div>
        @if($selectedPlan!=='')
        <x-filament::section class="mt-6">
            @if($paymentMethodId!=='')
                <x-slot name="heading">
                    {{__('filament-stripe-manager::text.activate_subscription')}}
                </x-slot>
                {{$selectedProduct->name}}
                    <div class="pt-5">
                        <x-filament::button wire:click="submitSubscription" class="mt-6">
                            {{_('filament-stripe-manager::text.activate')}}
                        </x-filament::button>
                    </div>

            @else
            <x-slot name="heading">
                {{__('filament-stripe-manager::text.register_new_payment_method')}}
            </x-slot>

            <div x-data="{
    stripe: null,
    card: null,
    setupElements: function () {
        this.stripe = Stripe('{{ config('cashier.key') }}');
        const elements = this.stripe.elements();
        this.card = elements.create('card');
        this.card.mount('#card-element');
    },
submitPaymentMethod: function () {
    this.stripe.createPaymentMethod('card', this.card, {
        billing_details: { name: '{{\Illuminate\Support\Facades\Auth::user()->name}}' }
    }).then((result) => {
        if (result.error) {
            const errorElement = document.getElementById('card-errors');
            errorElement.textContent = result.error.message;
        } else {
            @this.set('paymentMethodId', result.paymentMethod.id);
            @this.call('submitPaymentMethod');
            // Reinizializza gli elementi Stripe
            this.setupElements();
            // Ripristina lo stato del form
            document.getElementById('card-errors').textContent = '';
            // Puoi anche reimpostare il form su uno stato iniziale se necessario
        }
    });
}
}" x-init="setupElements">

                <form x-on:submit.prevent="submitPaymentMethodAndSubscription">
                    <div id="card-element"></div>
                    <div class="pt-5">
                        <x-filament::button class="mt-6" type="submit">
                            {{__('filament-stripe-manager::text.register_payment_method')}}
                        </x-filament::button>
                    </div>

                </form>
                <div id="card-errors" role="alert"></div>
            </div>
                @endif
        </x-filament::section>
        @endif
</div>
