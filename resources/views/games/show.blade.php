<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <x-slot name="header">
            <h1 class="text-2xl font-semibold text-gray-800">Game: {{ $game->name }}</h1>
{{--            Edit and Delete buttons--}}
            <div class="mt-4 flex justify-end">
                @admin
                    <a href="{{ route('games.edit', $game->id) }}" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
                        Edit Game
                    </a>
                    <form action="{{ route('games.destroy', $game->id) }}" method="POST" class="ml-4">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700" onclick="return confirm('Are you sure you want to delete this game?')">
                            Delete Game
                        </button>
                    </form>
                @endadmin
            </div>
        </x-slot>

        <div class="bg-white p-6 rounded-lg shadow-lg">
            <img
                src="{{ $game->image_path ? asset('storage/games/' . $game->image_path) : asset('images/not-found.jpg') }}"
                alt="Game: {{ $game->name }}"
                class="max-w-full max-h-[500px] object-contain rounded-lg mx-auto"
            />
            <div class="mt-6">
                <h3 class="text-2xl font-semibold text-gray-800 text-center">{{ $game->name }}</h3>

                <br>
                <div class="mt-4 flex flex-col items-center w-full space-y-4">
                    <p class="text-gray-600 text-base">Release Date: {{ \Carbon\Carbon::parse($game->release_date)->format('Y-m-d') }}</p>
                    <p class="text-gray-600 text-base">Tags:
                        @if($game->game_tags->isNotEmpty())
                            @foreach($game->game_tags as $tag)
                                <span>{{ $tag->name }}</span>{{ !$loop->last ? ', ' : '' }}
                            @endforeach
                        @else
                            Not specified
                        @endif
                    </p>
                </div>



                <br>
                <div class="mt-6">
                    <p class="text-gray-600 text-base text-center mx-4 mt-4">
                        {{ $game->description }}
                    </p>
                </div>

                <br>
                <div class="mt-6 text-center">
                    <a href="{{ route('games.index') }}" class="inline-block text-white bg-blue-600 hover:bg-blue-700 py-2 px-4 rounded-md">
                        Back to game list
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
