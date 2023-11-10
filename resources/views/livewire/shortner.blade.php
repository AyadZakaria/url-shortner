<div class="rounded-lg shadow-2xl text-center p-4  border-gray-400 mx-auto mt-[12vh] items-center w-2/4">
    <form action="" class="text-center" wire:submit.prevent="shortenUrl">
        <label for="" class="text-2xl m-3 p-6">Saisir Le Lien</label>
        <x-input class=" block w-full p-4 m-4 text-gray-900 border border-gray-300 rounded-lg bg-gray-50"
            wire:model="originalUrl" placeholder="URL..." />

        @error('originalUrl')
            <p class="text-red-400">{{ $message }}</p>
        @enderror

        @if (!$isValidLink)
            <p class="text-red-400">Saisir un lien valid</p>
        @endif
        <div class=" m-3 p-3">
            <div class="expirationContainer flex flex-col justify-center items-center">
                <p class="text-sm text-bold m-2">Ajouter une date d'expiration?</p>
                <x-checkbox id="checkbox" wire:click="toggleCheck" />
                @if ($isExpirable)
                    <div class="w-full max-w-xs">
                        <label class="block text-gray-700 text-sm font-bold m-2" for="datepicker">
                            Choisir Une Date:
                        </label>
                        <input type="date" id="datepicker" wire:model="Expiration_date"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                            min="{{ date('Y-m-d') }}" />
                    </div>
                @endif
            </div>
            <button
                class="text-white  bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 m-3 focus:outline-none"
                type="submit">Génerer </button>
        </div>
    </form>

    <div class="ShortendLinksContainer text-left">
        <div class="radioContainer flex justify-center ml-4 w-1/6">
            <label for="" class="text-sm font-bold">Afficher Historique</label>
            <x-toggle class="w-10 m-4" wire:click="toggleShowHistory" />
        </div>
        @if ($shorts)
            <div class="relative m-4 overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 ">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                        <tr>
                            <th scope="col" class="px-6 py-3">Lien Original</th>
                            <th scope="col" class="px-6 py-3">Lien Minimal</th>
                            <th scope="col" class="px-6 py-3">Date D'expiration</th>
                            <th scope="col" class="px-6 py-3">Archiver</th>
                        </tr>
                    </thead>
                    @foreach ($shorts as $short)
                        <tr class="m-3 p-3">
                            <td class="px-6 py-4 w-2/4">
                                <p class="w-2/4">
                                    {{ $short->original_url }}
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                <div class="relative">
                                    <input
                                        class="block w-full p-4 pl-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                        id="{{ $short->hash }}" value="{{ env('APP_URL') . '/r/' . $short->hash }}"
                                        readonly>
                                    <button value="copy"
                                        class="text-white absolute  right-2.5 bottom-2.5 bg-blue-400 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-1 "onclick="copyToClipboard('{{ $short->hash }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5A3.375 3.375 0 006.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0015 2.25h-1.5a2.251 2.251 0 00-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 00-9-9z" />
                                        </svg>

                                    </button>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">{{ $short->expiration_date ?? '--' }}</td>
                            <td class="flex justify-center items-center text-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class=" text-center w-5 h-5 mt-8 cursor-pointer"
                                    viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 "
                                    wire:click="Archive({{ $short->id }})">
                                    <path
                                        d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375z" />
                                    <path fill-rule="evenodd"
                                        d="M3.087 9l.54 9.176A3 3 0 006.62 21h10.757a3 3 0 002.995-2.824L20.913 9H3.087zm6.163 3.75A.75.75 0 0110 12h4a.75.75 0 010 1.5h-4a.75.75 0 01-.75-.75z"
                                        clip-rule="evenodd" />
                                </svg>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            {{ $shorts->links('vendor.livewire.simple-tailwind') }}
        @endif
    </div>

</div>
<script>
    function copyToClipboard(id) {
        document.getElementById(id).select();
        document.execCommand('copy');
    }
</script>
