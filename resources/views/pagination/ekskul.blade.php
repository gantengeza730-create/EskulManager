
@if ($paginator->hasPages())
<!-- Pagination navigation container -->
<nav class="pager" role="navigation" aria-label="Navigasi halaman">

    <!-- Display the current item range and total number of items -->
    <span class="pager-info">Menampilkan {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} dari {{ $paginator->total() }}</span>

    <div class="pager-links">

        <!-- Previous page button: disabled on the first page -->
        @if ($paginator->onFirstPage())
            <span class="btn btn-o btn-s pg off" aria-disabled="true">‹ Sebelumnya</span>
        @else
            <a class="btn btn-o btn-s pg" href="{{ $paginator->previousPageUrl() }}" rel="prev">‹ Sebelumnya</a>
        @endif

        <!-- Loop through Laravel's pagination elements -->
        @foreach ($elements as $element)

            <!-- Display a separator, such as an ellipsis -->
            @if (is_string($element))
                <span class="btn btn-o btn-s pg off">{{ $element }}</span>
            @endif

            <!-- Display the available page numbers -->
            @if (is_array($element))
                @foreach ($element as $page => $url)

                    <!-- Highlight the current page -->
                    @if ($page == $paginator->currentPage())
                        <span class="btn btn-p btn-s pg on" aria-current="page">{{ $page }}</span>
                    @else
                        <!-- Link to another page -->
                        <a class="btn btn-o btn-s pg" href="{{ $url }}">{{ $page }}</a>
                    @endif

                @endforeach
            @endif
        @endforeach

        <!-- Next page button: disabled on the last page -->
        @if ($paginator->hasMorePages())
            <a class="btn btn-o btn-s pg" href="{{ $paginator->nextPageUrl() }}" rel="next">Berikutnya ›</a>
        @else
            <span class="btn btn-o btn-s pg off" aria-disabled="true">Berikutnya ›</span>
        @endif
    </div>
</nav>
@endif
