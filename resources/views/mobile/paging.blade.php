@if ($paginator->hasPages())
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        @if ($paginator->onFirstPage())
        <li class="page-item disabled">
            <a class="page-link" href="#" tabindex="-1" style="background-color:#800000 !important;"><span aria-hidden="true">&laquo;</span></a>
        </li>
        @else
        <li class="page-item">
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" style="background-color:#800000 !important;"><span aria-hidden="true">&laquo;</span></a>
        </li>
        @endif

        @foreach ($elements as $element)
        @if (is_string($element))
        <li class="page-item disabled">{{ $element }}</li>
        @endif

        @if (is_array($element))
        @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <li class="page-item active">
            <a class="page-link" style="background-color: #800000 !important;">{{ $page }}</a>
        </li>
        @else
        <li class="page-item">
            <a class="page-link" href="{{ $url }}" style="background-color:#800000 !important;">{{ $page }}</a>
        </li>
        @endif
        @endforeach
        @endif
        @endforeach

        @if ($paginator->hasMorePages())
        <li class="page-item">
            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" style="background-color:#800000 !important;"><span aria-hidden="true">&raquo;</span></a>
        </li>
        @else
        <li class="page-item disabled">
            <a class="page-link" href="#" style="background-color:#800000 !important;"><span aria-hidden="true">&raquo;</span></a>
        </li>
        @endif
    </ul>
</nav>
@endif
