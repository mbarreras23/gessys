<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        @foreach ($links as $link)
            <li class="breadcrumb-item {{ $link['active'] ? 'active' : '' }}">
                @if (!$link['active'])
                    <a href="{{ $link['url'] }}">{{ $link['title'] }}</a>
                @else
                    {{ $link['title'] }}
                @endif
            </li>
        @endforeach
    </ol>
</nav>
<hr>
