<x-layouts.app>
    <x-slot name="header">
        <x-h2>{{ __('Campaigns') }}</x-h2>
    </x-slot>

    <x-card class="space-y-4">
        <div class="flex justify-between">
            <x-button.link :href="route('campaigns.create')">
                {{ __('Create new campaign') }}
            </x-button.link>

            <x-form
                    :action="route('campaigns.index')" class="w-3/5 flex space-x-4 item-center" x-data
                    x-ref="form"
                    flat
            >
                <x-input.checkbox
                        name="withTrashed" value="1" @click="$refs.form.submit()" :checked="$withTrashed"
                        :label="__('Show Deleted Records')"
                />
                <x-input.text name="search" :placeholder="__('Search')" :value="$search" class="w-full" />
            </x-form>
        </div>

        <x-table :headers="['#',__('Name'),__('Actions')]">
            <x-slot name="body">
                @foreach($campaigns as $campaign)
                    <tr>
                        <x-table.td class="w-1">{{$campaign->id}}</x-table.td>
                        <x-table.td>{{$campaign->name}}</x-table.td>

                        <x-table.td class="w-1">

                            <div class="flex items-center space-x-4 ">
                                @unless($campaign->trashed())
                                    <x-form
                                            :action="route('campaigns.destroy', $campaign)" delete flat
                                            onsubmit="return confirm('{{__('Are you sure?')}}')"
                                    >
                                        <x-button.secondary type="submit">{{__('Delete')}}</x-button.secondary>
                                    </x-form>
                                @else
                                    <x-badge warning>{{__('Deleted')}}</x-badge>
                                @endunless
                            </div>
                        </x-table.td>
                    </tr>
                @endforeach
            </x-slot>
        </x-table>
        {{$campaigns->links()}}

    </x-card>
</x-layouts.app>
