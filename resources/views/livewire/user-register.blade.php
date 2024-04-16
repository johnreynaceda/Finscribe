<div>
    <div class="grid grid-cols-1 gap-3">
        <x-input label="" placeholder="Firstname" class="h-12" wire:model="firstname" />
        <x-input label="" placeholder="Lastname" class="h-12" wire:model="lastname" />
        <x-input label="" placeholder="Email" type="email" class="h-12" wire:model="email" />
        <x-input label="" placeholder="Mobile Number" class="h-12" wire:model="contact" />
        <x-datetime-picker placeholder="Birthdate" without-timezone without-time class="h-12"
            wire:model="birthdate" />
        <x-inputs.password label="" placeholder="Password" class="h-12" wire:model.live="password" />
        <x-inputs.password label="" placeholder="Confirm Password" class="h-12"
            wire:model.live="confirm_password" />
        <x-button label="SIGN UP" class="font-bold" wire:click="register" spinner="register" dark class="h-12" />
        <x-checkbox id="right-label" wire:model.live="is_checked" checked
            label="By creating an account, you agree to the Terms of use and Privacy Policy. "
            wire:model.defer="model" />
    </div>
</div>
