@php
    use Filament\Facades\Filament;
    use Rimba\Who\Contracts\PanelAccessResolverContract;

    $user = auth()->user();

    if (! $user) {
        return;
    }

    $resolver = app(PanelAccessResolverContract::class);

    // Replace the icon strings with your raw SVG markup
    $panels = [
        'lobby' => [
            'icon' => '<svg xmlns="http://w3.org" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v4.875h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>',
            'label' => 'Lobby',
        ],
        'staff' => [
            'icon' => '<svg xmlns="http://w3.org" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm-.375 5.25a3.75 3.75 0 0 0-7.5 0v.75h7.5v-.75Z" /></svg>',
            'label' => 'Staff',
        ],
        'team' => [
            'icon' => '<svg xmlns="http://w3.org" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="x1" /></svg>',
            'label' => 'Team',
        ],
        'admin' => [
            'icon' => '<svg xmlns="http://w3.org" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="x2" /></svg>',
            'label' => 'Admin',
        ],
    ];

    $currentPanel = Filament::getCurrentPanel()?->getId();
@endphp

<div class="me-2 flex items-center gap-1">
    @foreach ($panels as $id => $panel)
        @continue(! $resolver->canAccess($user, $id))

        @php
            $url = Filament::getPanel($id)?->getUrl();

            if (! $url) {
                continue;
            }

            $active = $currentPanel === $id;
        @endphp

        <a
            href="{{ $url }}"
            title="{{ $panel['label'] }}"
            class="
                flex h-9 w-9 items-center justify-center rounded-lg transition
                [&>svg]:h-5 [&>svg]:w-5
                {{
                    $active
                    ? 'bg-primary-600 text-white shadow-sm'
                    : 'text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white'
                }}
            "
        >
            {!! $panel['icon'] !!}
        </a>
    @endforeach
</div>
