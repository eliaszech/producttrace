<div class="flex flex-col bg-white w-full h-full pt-28 z-[9] border-l border-gray-200" x-data="">
    <div class="pl-8 pr-4 py-3 text-lg font-semibold shadow-sm flex border-b border-gray-200 items-center z-[8]">
        <span class="font-extrabold text-lg mr-2"><i class="far fa-tag"></i></span>
        <span class="grow">{{ $block->name }}</span>
    </div>
    <div class="flex divide-x divide-gray-200 w-full h-full">
        <div class="flex flex-col grow z-[7]"></div>
        <div class="flex flex-col relative min-w-xl max-w-xl shrink-0 h-full w-full p-4 overflow-x-visible z-[8]">
            <div class="absolute w-full h-full bg-white bg-opacity-50" wire:loading wire:target="print"></div>
            <div class="flex justify-between items-center z-[8]">
                <h1 class="text-lg font-semibold"><i class="fal fa-eye"></i> Druckvorschau</h1>
                <a href="javascript:" wire:click="print" class="bg-[#0085CA] rounded-sm px-2 py-1 uppercase hover:bg-[#0085CA]/80 text-white text-sm w-max font-semibold">Etiketten Drucken</a>
            </div>
            <div class="flex flex-col bg-gray-200 rounded-sm shadocomposer require h4cc/wkhtmltopdf-i386 0.12.xw-md mt-4 p-[4px] mb-16 shrink-0 h-[574px] w-[508px]">
                <div class="flex gap-[2px]">
                    <div class="bg-white border relative border-gray-300 h-[114px] w-[250px] shadow-sm rounded-sm hover:bg-gray-50 cursor-pointer hover:scale-150 hover:z-[8]">
                        <img class="absolute top-2 right-2" src="{{ asset('img/logo.png') }}" height="50" width="50"/>
                        <span class="absolute top-[15px] left-2 text-[7px] flex items-center">Life Technologies Holdings Pre. Ltd.</span>
                        <span class="absolute top-[35px] left-2 text-[7px] flex gap-4 items-center">Artikelnummer <span>208444</span></span>
                        <span class="absolute top-[44px] left-2 text-[7px] flex gap-4 items-center">PAS Format <span>49</span></span>
                        <span class="absolute top-[50px] right-2 text-[7px] flex gap-3 items-center">Datum<span>08/06/2022</span></span>
                        <span class="absolute top-[60px] left-2 text-[7px] flex gap-4 items-center">Box ID <span>1</span></span>
                        <span class="absolute top-[78px] left-2 text-[7px] flex items-center">Chrom Charge</span>
                        <span class="absolute top-[78px] right-2 text-[7px] flex gap-1 items-center">Menge <span>13</span></span>
                        <span class="absolute top-[87px] left-2 text-[7px] flex items-center">Box ID Chrom</span>
                        <span class="absolute top-[96px] left-2 text-[7px] flex items-center">Auftragsnummer</span>
                    </div>
                    <div class="bg-white border relative border-gray-300 h-[114px] w-[250px] shadow-sm rounded-sm hover:bg-gray-50 cursor-pointer hover:scale-150 hover:z-[8]">
                        <img class="absolute top-2 right-2" src="{{ asset('img/logo.png') }}" height="50" width="50"/>
                        <span class="absolute top-[15px] left-2 text-[7px] flex items-center">Life Technologies Holdings Pre. Ltd.</span>
                        <span class="absolute top-[35px] left-2 text-[7px] flex gap-4 items-center">Artikelnummer <span>208444</span></span>
                        <span class="absolute top-[44px] left-2 text-[7px] flex gap-4 items-center">PAS Format <span>49</span></span>
                        <span class="absolute top-[50px] right-2 text-[7px] flex gap-3 items-center">Datum<span>08/06/2022</span></span>
                        <span class="absolute top-[60px] left-2 text-[7px] flex gap-4 items-center">Box ID <span>1</span></span>
                        <span class="absolute top-[78px] left-2 text-[7px] flex items-center">Chrom Charge</span>
                        <span class="absolute top-[78px] right-2 text-[7px] flex gap-1 items-center">Menge <span>13</span></span>
                        <span class="absolute top-[87px] left-2 text-[7px] flex items-center">Box ID Chrom</span>
                        <span class="absolute top-[96px] left-2 text-[7px] flex items-center">Auftragsnummer</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
