
@livewireStyles
<!-- Fonts -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
<!-- Styles -->
<link rel="stylesheet" href="{{ mix('css/app.css') }}">
<!-- Scripts -->
<script src="{{ mix('js/app.js') }}" defer></script>

<div class="content">
    <div class="row row-deck">
        <div class="col-sm-12 col-xl-12 col-md-12">
            <div class="block block-rounded d-flex flex-column">
                <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                    <div class="row">
                        <div class="col-md-12">
                            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                                <div class="mt-1 sm:mt-0">
                                    @livewire('profile.update-password-form')
                                </div>
                            @endif
                        </div>
                        <div class="col-md-12">
                            <div class="mt-1 sm:mt-0">
                                @livewire('profile.logout-other-browser-sessions-form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@livewireScripts

