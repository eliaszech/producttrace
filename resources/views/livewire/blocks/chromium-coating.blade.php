<div class="flex flex-col bg-white w-full h-full pt-28 z-[9] border-l border-gray-200">
    <div class="pl-8 pr-4 py-3 text-lg font-semibold shadow-sm flex border-b border-gray-200 items-center z-[8]">
        <span class="font-extrabold text-lg mr-2">{{ $block->avo }}</span>
        <span class="grow">{{ $block->name }}</span>
        @if($wafers->count() > 0)
            <a href="javascript:;" wire:click="clear({{ $orderId }}, {{ $blockId }})" class="bg-red-500 hover:bg-red-500/80 rounded-sm px-2 py-1 text-sm text-white uppercase font-semibold mt-1">Alle Positionen Löschen</a>
        @endif
    </div>
    <div class="h-full bg-gray-100 flex z-[7]" x-data="{ hidePanel: $persist(false) }">
        <a href="javascript:;" @click="hidePanel = false" class="h-full bg-white w-12 p-3 border-r border-gray-200 hover:bg-gray-50" x-show="hidePanel">
            <p class="transform rotate-90 font-bold w-full text-lg whitespace-nowrap"><i class="far fa-chevron-up mr-3"></i> Eintrag hinzufügen</p>
        </a>
        <div class="lg:max-w-sm lg:min-w-sm w-full bg-white border-r border-gray-200 px-8 pt-3 overflow-y-auto pb-20" x-show="!hidePanel">
            <h1 class="text-base font-bold flex justify-between items-center">
                Eintrag hinzufügen
                <a href="javascript:;" @click="hidePanel = true" class="px-3 py-1 hover:bg-gray-50"><i class="far fa-arrow-left"></i></a>
            </h1>
            <div class="flex flex-col gap-2 mt-3" x-data="{ wafer: '', operator: {{ auth()->user()->personnel_number }}, boxId: '', machine: '{{ $machine }}', lot: '' }">
                <div class="flex flex-col">
                    <label class="text-sm mb-1 text-gray-500">Wafer ID *:</label>
                    <div class="flex flex-col w-full relative" x-data="{ show: false, search: '' }" @click.away="show = false">
                        <input type="text" wire:model.lazy="selectedWafer" onfocus="this.setSelectionRange(0, this.value.length)" @focus="show = true" class="w-full bg-gray-100 rounded-sm font-semibold text-sm border-0 focus:ring-[#0085CA]" placeholder="Wafer ID eingeben oder scannen..."/>
                        <div class="shadow-lg rounded-sm absolute divide-y divide-gray-200 w-full border border-gray-300 mt-10 bg-gray-200 overflow-y-auto max-h-60" x-show="show" x-transition>
                            <div class="flex flex-col divide-y divide-gray-300" wire:loading.remove>
                                <div class="px-2 py-1 text-xs text-gray-500">{{ sizeof($sWafers) }} Ergebnisse</div>
                                @forelse($sWafers as $wafer)
                                    <a href="javascript:;" wire:click="$set('selectedWafer', '{{ $wafer->id }}')" class="flex items-center px-2 py-1 text-sm hover:bg-gray-100">
                                        @if($wafer->rejected)
                                            <i class="far fa-ban fa-fw text-red-500 mr-2"></i>
                                        @else
                                            <i class="far fa-check fa-fw text-green-600 mr-2"></i>
                                        @endif
                                        <div class="flex flex-col">
                                            {{ $wafer->id }}
                                            @if($wafer->rejected)
                                                <span class="text-xs text-red-500 italic"><b>{{ $wafer->rejection_reason }}</b> in {{ $wafer->rejection_order }} <i class="fal fa-arrow-right"></i> {{ $wafer->rejection_avo }} - {{ $wafer->rejection_position }} </span>
                                            @else
                                                <span class="text-xs text-green-600 italic">Wafer ist in Ordnung</span>
                                            @endif
                                        </div>
                                    </a>
                                @empty
                                    @if($this->search != '')
                                        <div class="px-2 py-1 text-sm">Keine Wafer gefunden!</div>
                                    @else
                                        <div class="px-2 py-1 text-sm">Scanne oder tippe eine Wafer ID ein...</div>
                                    @endif
                                @endforelse
                            </div>
                            <div class="flex w-full px-2 py-1 text-sm" wire:loading><i class="fal fa-refresh animate-spin mr-1"></i> Wafer werden geladen</div>
                        </div>
                    </div>
                    @error('wafer') <span class="mt-1 text-xs font-semibold text-red-500">{{ $message }}</span> @enderror
                    @if(session()->has('waferCheck')) <span class="mt-1 text-xs font-semibold text-green-600">Wafernummer ist in Ordnung</span> @endif
                </div>
                <div class="flex flex-col">
                    <label class="text-sm mb-1 text-gray-500">Operator *:</label>
                    <input x-model="operator" onfocus="this.setSelectionRange(0, this.value.length)" type="text" class="bg-gray-100 rounded-sm border-0 focus:ring-[#0085CA] text-sm font-semibold" tabindex="2" placeholder="Operator"/>
                    @error('operator') <span class="mt-1 text-xs font-semibold text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="flex flex-col">
                    <label class="text-sm text-gray-500">Box ID *:</label>
                    <input x-model="boxId" onfocus="this.setSelectionRange(0, this.value.length)" type="text" class="mt-1 bg-gray-100 rounded-sm border-0 focus:ring-[#0085CA] text-sm font-semibold" tabindex="3" placeholder="Box ID"/>
                    @error('box') <span class="mt-1 text-xs font-semibold text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="flex flex-col">
                    <label class="text-sm text-gray-500">Chromcharge *:</label>
                    <span class="text-xs font-light italic">Die Chromcharge wird automatisch gezogen, kann aber geändert werden</span>
                    <input x-model="lot" onfocus="this.setSelectionRange(0, this.value.length)" type="text" class="mt-1 bg-gray-100 rounded-sm border-0 focus:ring-[#0085CA] text-sm font-semibold" tabindex="3" placeholder="Chromcharge"/>
                    @error('lot') <span class="mt-1 text-xs font-semibold text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="flex flex-col">
                    <label class="text-sm text-gray-500">Anlagennummer *:</label>
                    <span class="text-xs font-light italic">Anlage wird automatisch gezogen, kann jedoch geändert werden</span>
                    <select x-model="machine" class="mt-1 bg-gray-100 rounded-sm border-0 focus:ring-[#0085CA] text-sm font-semibold">
                        <option value="" disabled>Nicht gefunden</option>
                        <option value="BAKCr51">BAKCr51</option>
                        <option value="BAKCr52">BAKCr52</option>
                    </select>
                    @error('machine') <span class="mt-1 text-xs font-semibold text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="flex flex-col">
                    <label class="text-sm text-gray-500">Position *:</label>
                    <span class="text-xs font-light italic">  Position wird automatisch berechnet, kann jedoch geändert werden</span>
                    <select wire:model.defer="calculatedPosition" class="mt-1 bg-gray-100 rounded-sm border-0 focus:ring-[#0085CA] text-sm font-semibold">
                        <option value="Aussen">Aussen</option>
                        <option value="Mitte">Mitte</option>
                        <option value="Zentrum">Zentrum</option>
                    </select>
                    @error('position') <span class="mt-1 text-xs font-semibold text-red-500">{{ $message }}</span> @enderror
                </div>
                @error('response') <span class="mt-1 text-xs font-semibold text-red-500">{{ $message }}</span> @enderror
                @if(session()->has('success')) <span class="mt-1 text-xs font-semibold text-green-600">Eintrag wurde erfolgreich gespeichert</span> @endif
                <button type="submit" @click="$wire.addEntry('{{ $orderId }}', {{ $blockId }}, operator, boxId, machine)" class="bg-[#0085CA] hover:bg-[#0085CA]/80 rounded-sm px-3 py-1 text-sm uppercase text-white text-left" tabindex="4">
                    <span wire:loading.remove wire:target="addEntry">Eintrag Speichern</span>
                    <span wire:loading wire:target="addEntry"><i class="fal fa-save animate-pulse mr-1"></i> Eintrag wird gespeichert...</span>
                </button>
            </div>
        </div>
        <div class="w-full px-4 py-3 overflow-y-auto flex flex-col pb-20">
            <h1 class="text-base font-bold">Eingetragene Wafer ({{ $wafers->count() }})</h1>
            <input type="text" wire:model.lazy="search" onfocus="this.setSelectionRange(0, this.value.length)" class="bg-white rounded-sm mt-2 mb-1 text-sm font-semibold shadow-sm w-full border-0 focus:ring-[#0085CA]" placeholder="Wafer durchsuchen..." />
            <div class="flex flex-col gap-1 mt-2" wire:loading.remove.delay.longer wire:target="search">
                <div class="px-2 py-1 rounded-sm grid grid-cols-7 items-center justify-between bg-gray-200 shadow-sm mb-1">
                    <span class="text-sm font-bold"><i class="fal fa-hashtag mr-1"></i> Wafer</span>
                    <span class="text-sm font-bold"><i class="fal fa-user mr-1"></i> Operator</span>
                    <span class="text-sm font-bold"><i class="fal fa-hashtag mr-1"></i> Box ID</span>
                    <span class="text-sm font-bold"><i class="fal fa-robot mr-1"></i> Anlage</span>
                    <span class="text-sm font-bold"><i class="fal fa-map-marker-alt mr-1"></i> Position</span>
                    <span class="text-sm font-bold"><i class="fal fa-clock mr-1"></i> Datum</span>
                    <span class="text-sm font-bold text-right"><i class="fal fa-cog mr-1"></i> Aktionen</span>
                </div>
                @forelse($wafers as $wafer)
                    <div class="px-2 py-1 bg-white border @if($wafer->rejection->reject ?? false) border-red-500/50 @else border-green-600/50 @endif flex rounded-sm hover:bg-gray-50 items-center">
                        <div class="flex flex-col grow">
                            <div class="grid grid-cols-7 items-center">
                                <span class="text-sm font-semibold">{{ $wafer->wafer_id }}</span>
                                <span class="text-xs">{{ $wafer->operator }}</span>
                                <span class="text-xs">{{ $wafer->box }}</span>
                                <span class="text-xs">{{ $wafer->machine }}</span>
                                <span class="text-xs">{{ $wafer->position }}</span>
                                <span class="text-xs text-gray-500 truncate col-span-2">{{ date('d.m.Y H:i', strtotime($wafer->created_at)) }}</span>
                            </div>
                            @if($wafer->rejection->reject ?? false)
                                <span class="text-xs font-normal text-red-500">Ausschuss: {{ $wafer->rejection->name }}</span>
                            @else
                                <span class="text-xs font-normal text-green-600">Dieser Wafer ist in Ordnung</span>
                            @endif
                        </div>
                        <div class="flex justify-end">
                            <a href="javascript:;" @click="$wire.removeEntry({{ $wafer->id }})" class="text-red-500"><i class="far fa-trash"></i></a>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col justify-center items-center p-10">
                        <span class="text-lg font-bold text-red-500">Keine Wafer gefunden!</span>
                        <span class="text-sm text-gray-500">Es wurden keine Wafer in diesem Arbeitsschritt gefunden.</span>
                    </div>
                @endforelse
            </div>
            <div class="flex flex-col justify-center items-center p-10 animate-pulse text-center" wire:loading.delay.longer wire:target="search">
                <span class="text-lg font-bold text-red-500">Wafer werden geladen...</span><br>
                <span class="text-sm text-gray-500">Die Wafer werden geladen, wenn dieser Vorgang zu lange dauert bitte die Seite neu laden.</span>
            </div>
        </div>
    </div>
</div>
