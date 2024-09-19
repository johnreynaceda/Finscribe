<div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="flex space-x-3 w-96 mb-3">
        <x-datetime-picker label="Date From" placeholder="" wire:model.live="date_from"
            placeholder="{{ now()->format('m/d/Y') }}" without-time without-timezone />
        <x-datetime-picker label="Date To" placeholder="" wire:model.live="date_to"
            placeholder="{{ now()->format('m/d/Y') }}" without-time without-timezone />
    </div>
    <div class="mb-5 grid grid-cols-4 gap-5">
        <div class="p-5 flex flex-col items-start justify-center rounded-3xl bg-[#799BE7]">
            <h1 class="font-semibold">REVENUES</h1>
            <p class="text-3xl mt-2 text-white font-bold">&#8369;{{ number_format($revenue, 2) }}</p>
        </div>
        <div class="p-5 flex flex-col items-start justify-center rounded-3xl bg-[#799BE7]">
            <h1 class="font-semibold">EXPENSES</h1>
            <p class="text-3xl mt-2 text-white font-bold">&#8369;{{ number_format($expense, 2) }}</p>
        </div>
        <div class="p-5 flex flex-col items-start justify-center rounded-3xl bg-[#799BE7]">
            <h1 class="font-semibold">BUDGET</h1>
            <p class="text-3xl mt-2 text-white font-bold">
                &#8369;{{ number_format((75 / 100) * ($income - $expense), 2) }}</p>
        </div>
        <div class="p-5 rounded-3xl bg-[#799BE7]">
            <h1 class="font-semibold">BEGINNING CASH</h1>
            <p class="text-3xl mt-1 text-white font-bold">&#8369;{{ number_format($beginning, 2) }}</p>
            <h1 class="font-semibold mt-5">ENDING CASH</h1>
            <p class="text-3xl mt-1 text-white font-bold">&#8369;{{ number_format($revenue, 2) }}</p>
        </div>
    </div>
</div>
