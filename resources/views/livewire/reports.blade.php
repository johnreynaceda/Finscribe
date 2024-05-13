<div>
    <div class="flex justify-between items-center">
        <div class="flex space-x-3 items-center">
            <div class="w-64">
                <x-native-select label="Select Report" wire:model="model">
                    <option>Income</option>
                    <option>Expense</option>

                </x-native-select>
            </div>
            <div class="w-64">
                <x-datetime-picker label="Date From" without-timezon without-time wire:model.defer="normalPicker" />
            </div>
            <div class="w-64">
                <x-datetime-picker label="Date To" without-timezon without-time wire:model.defer="normalPicker" />
            </div>
        </div>
        <div>
            <x-button label="PRINT REPORT" class="font-semibold" icon="printer" dark />
        </div>
    </div>
    <div class="mt-10">
        <div class="flex space-x-3 items-center">
            <img src="{{ asset('images/business_logo.png') }}" class="h-20" alt="">
            <div>
                <h1 class="font-bold text-xl text-gray-800">FINSCRIBE GENERATED REPORT</h1>
                <h1>Mi Pares</h1>
            </div>
        </div>
        <div class="mt-5">
            <h1 class="text-center font-bold text-xl text-gray-700">INCOME REPORT</h1>
        </div>
    </div>
    <div class="mt-5">
        <table id="example" class="table-auto mt-5" style="width:100%">
            <thead class="font-normal">
                <tr>
                    <th class="border text-right    px-2 text-sm font-semibold text-gray-700 py-2">

                    </th>

                    <th class="border text-right   px-2 text-sm font-semibold text-gray-700 py-2">
                        TOTAL AMOUNT
                    </th>
                </tr>
            </thead>
            <tbody class="">
                <tr>
                    <td class="  border text-right  text-gray-700 font-bold  px-3 py-1">sdsdsd
                    </td>
                    <td class="border text-right  text-gray-700  px-3 py-1">
                        sdsdsd</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
