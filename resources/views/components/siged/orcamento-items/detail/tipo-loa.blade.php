{{-- tipo-loa.blade.php --}}
<div
    class="w-full"
    x-data="{
        assetUrl: '{{ asset('/') }}',
        globalAssetUrl: '{{ global_asset('/') }}',
        formatDate(dateInfo, options = {}, locale = 'pt-BR') {
            try {
                let date = new Date('2023-01-25 14:14');
                options = {
                    // weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    // month: 'numeric'
                    day: 'numeric',
                    // hour: 'numeric',
                    // minute: 'numeric',
                    ...options
                };

                let formattedDate = date.toLocaleString(locale, options);

                return formattedDate;
            } catch(error) {
                console.error(error);

                return null;
            }
        },
        getIconUrl(extension) {
            try {
                let iconUrls = {
                    pdf: 'vendor/blade-carbon-icons/document-pdf.svg',
                    signed: 'vendor/blade-carbon-icons/document-signed.svg',
                    document: 'vendor/blade-carbon-icons/document.svg',
                    view: 'vendor/blade-carbon-icons/document-view.svg',
                    doc: 'vendor/blade-carbon-icons/doc.svg',
                    word: 'vendor/blade-carbon-icons/document-word-processor.svg',
                    unknown: 'vendor/blade-carbon-icons/document-unknown.svg',
                };

                let defaultValue = iconUrls.unknown ?? '';
                let fileUri = (extension in iconUrls) ? iconUrls[extension] : defaultValue;

                return (new URL(fileUri, this.globalAssetUrl)).href;
            } catch(error) {
                console.error(error);

                return null;
            }
        },
        showAttachments: false,
        attachments: [
            {
                description: 'Ata da reunião (demo)',
                fileName: 'ata-2023-01-algum-nome.pdf',
                fileUrl: '{{ url('anexos/ata-2023-01-algum-nome.pdf') }}',
                uploadDate: '2023-07-09T20:26:05+00:00',
                mimeType: 'application/pdf',
                extension: 'pdf',
                fileSize: '15Kb',
            },
            {
                description: 'Ata da reunião 2 (demo)',
                fileName: 'ata-2023-05-algum-nome.pdf',
                fileUrl: '{{ url('anexos/ata-2023-05-algum-nome.pdf') }}',
                uploadDate: '2023-07-09T20:26:05+00:00',
                mimeType: 'application/pdf',
                extension: 'pdf',
                fileSize: '12Kb',
            },
        ]
    }">

    <!-- Centered items -->
    <div class="flex justify-center items-center text-gray-500 mb-5 pb-2 pt-4 sm:justify-center sm:pt-0 dark:text-gray-200">
        @if ($orcamentoItem?->lei_numero && $orcamentoItem?->lei_data ?? null)
            <div class="text-center">
                <h4 class="px-4 text-lg text-center tracking-wider border-r border-gray-400">
                    Lei n° <strong>{{ $orcamentoItem?->lei_numero }}</strong> de
                    {{ $orcamentoItem?->lei_data?->format('d/m/Y') }}
                </h4>
            </div>
        @endif

        @if ($orcamento?->tipoValue ?? null)
            <div class="text-center">
                <h4 class="px-4 text-lg text-center tracking-wider border-gray-400">
                    {{ $orcamento?->tipoValue }}
                </h4>
            </div>
        @endif
    </div>

    <div class="grid items-center grid-cols-3 gap-3 my-3 py-4">
        <div class="col-span-3 py-4">
            {!! $orcamentoItem?->content ?? null !!}
        </div>

        <div class="col-span-3">
            Publicado no Diário Oficial Edição <strong>157</strong> – <strong> Pag. 3</strong>
        </div>

        <div class="col-span-2">
            2022 / 2022
        </div>

        <div class="col-span-1 text-center">
            <x-filament-support::button
                icon="heroicon-o-paper-clip"
                :attributes="\Filament\Support\prepare_inherited_attributes($attributes)"
                :dark-mode="config('forms.dark_mode')"
                x-on:click="showAttachments = !showAttachments"
                class="w-full"
            >
                <span x-text="showAttachments ? 'ocultar' : 'mostrar'"> </span>
                <strong
                    x-text="attachments && attachments.length"
                ></strong>

                <strong
                    x-text="attachments && attachments.length == 1 ? 'anexo' : 'anexos'"
                ></strong>
            </x-filament-support::button>
        </div>
    </div>

    <div
        class="w-full overflow-hidden rounded-lg shadow-xs"
        x-show="showAttachments"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-90"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-90"

        style="display: none"
    >
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr
                        @class([
                            'text-xs',
                            'font-semibold',
                            'tracking-wide',
                            'text-left',
                            'text-gray-500',
                            'uppercase',
                            'border-b',
                            'bg-gray-50',
                            'dark:bg-gray-900',
                            'dark:text-white',
                        ])>
                        <th class="px-4 py-3 truncate">fileName</th>
                        <th class="px-4 py-3 truncate">description</th>
                        <th class="px-4 py-3 truncate">Data do upload</th>
                        <th class="px-4 py-3 truncate">fileSize</th>
                        <th class="px-4 py-3 truncate"></th>
                    </tr>
                </thead>
                <tbody
                    @class([
                        'bg-white',
                        'text-gray-700',
                        'divide-y',
                        'dark:bg-gray-800',
                        'dark:text-white',
                    ])
                >
                    <template x-for="attachment in attachments" :key="index">
                        <tr
                            class="hover:bg-gray-500"
                        >
                            <td
                                class="px-4 py-3 truncate"
                                x-tooltip.html="`${attachment.fileName} - (${attachment.mimeType})`"
                            >
                                <template
                                    x-if="getIconUrl(attachment.extension)"
                                >
                                    <img
                                        :src="getIconUrl(attachment.extension)"
                                        :title="attachment.mimeType"
                                        class="filament-link-icon bg-white w-5 h-5 mr-1 rtl:ml-1 rounded inline"
                                >
                                </template>
                                <span x-text="attachment.fileName"></span>
                            </td>
                            <td
                                class="px-4 py-3 truncate"
                                x-text="attachment.description"
                                x-tooltip.html="attachment.description"
                            ></td>
                            <td
                                class="px-4 py-3 truncate"
                                x-text="formatDate(attachment.uploadDate, {
                                    month: 'numeric'
                                })"
                            ></td>
                            <td class="px-4 py-3 truncate" x-text="attachment.fileSize"></td>
                            <td class="px-4 py-3 truncate">
                                <a
                                    class="inline"
                                    x-if="attachment.fileUrl"
                                    :href="attachment.fileUrl"
                                    target="_blank"
                                    download
                                >
                                    Ver anexo
                                </a>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>
