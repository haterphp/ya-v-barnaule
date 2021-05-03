{{ $body->links() }}

@push('js')
    <script>
        const $links = document.querySelectorAll('.page-link');
        $links.forEach($link => 
            $link.addEventListener('click', ev => {
                ev.preventDefault();
                const link = new URL($link.getAttribute('href'));
                const url = new URL(location.href);
                url.searchParams.append('page', link.searchParams.get('page'))
                location.href = url.href;
            }));    
    </script>   
@endpush