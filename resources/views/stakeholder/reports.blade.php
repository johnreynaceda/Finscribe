<x-master-layout>
    <div>
        <header class="text-2xl font-bold text-gray-800">REPORTS</header>
        <div class="mt-10">
            @if (auth()->user()->user_type != 'Employee')
                <livewire:reports />
            @else
            @endif
            <script>
                function printOut(data) {
                    var mywindow = window.open('', '', 'height=1000,width=1000');
                    mywindow.document.head.innerHTML =
                        '<title></title><link rel="stylesheet" href="{{ Vite::asset('resources/css/app.css') }}" />';
                    mywindow.document.body.innerHTML = '<div>' + data +
                        '</div><script src="{{ Vite::asset('resources/js/app.js') }}"/>';

                    mywindow.document.close();
                    mywindow.focus(); // necessary for IE >= 10
                    setTimeout(() => {
                        mywindow.print();
                        return true;
                    }, 1000);
                }
            </script>
        </div>
    </div>
</x-master-layout>
