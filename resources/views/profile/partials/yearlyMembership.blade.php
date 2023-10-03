<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Betaal jouw jaarlijkse lidgeld') }}
        </h2>
        <p class="mt-1 text-m text-gray-600" >
            {{ __('Bedrag: €25') }}
        </p>
    </header>
    <br>
    <a href="{{route('profile.membershipfee')}}">
        <x-primary-button>{{ __('Betaal') }}</x-primary-button>
    </a>
</section>