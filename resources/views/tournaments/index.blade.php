<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <x-slot name="header">
            <h1 class="text-2xl font-semibold text-gray-800">Tournaments</h1>
        </x-slot>

        <!-- Creating -->
        @auth
            <div class="mb-6">
                <div class="col-span-full sm:col-span-2 flex justify-center mt-4">
                    <a href="{{ route('tournaments.create') }}" class="w-full bg-green-600 text-white py-2 rounded-md hover:bg-green-700 text-center">Create Tournament</a>
                </div>
            </div>
        @endauth

        <!-- Filtration -->
        <div class="mb-6">
            <form action="{{ route('tournaments.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4">
                <!-- Filtering by tournament name -->
                <div>
                    <label for="tournament_name" class="block text-gray-700">Tournament Name</label>
                    <input type="text" name="tournament_name" id="tournament_name" value="{{ request('tournament_name') }}" class="mt-1 block w-full border-gray-300 rounded-md">
                </div>

                <!-- Filtering by game name -->
                <div>
                    <label for="game_name" class="block text-gray-700">Game Name</label>
                    <select name="game_name" id="game_name" class="mt-1 block w-full border-gray-300 rounded-md">
                        <option value="">Select a game</option>
                        @foreach($games as $game)
                            <option value="{{ $game->name }}" {{ request('game_name') == $game->name ? 'selected' : '' }}>{{ $game->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtering by game tag -->
                <div>
                    <label for="game_tag" class="block text-gray-700">Game Tags</label>
                    <select name="game_tag" id="game_tag" class="mt-1 block w-full border-gray-300 rounded-md">
                        <option value="">Select a tag</option>
                        @foreach($gameTags as $tag)
                            <option value="{{ $tag->name }}" {{ request('game_tag') == $tag->name ? 'selected' : '' }}>{{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtering by status -->
                <div>
                    <label for="status" class="block text-gray-700">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md">
                        <option value="">Select status</option>
                        <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                        <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="finished" {{ request('status') == 'finished' ? 'selected' : '' }}>Finished</option>
                    </select>
                </div>

                <!-- Submit button -->
                <div class="col-span-full sm:col-span-2 flex justify-center">
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">Filter</button>
                </div>
            </form>
        </div>

        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($tournaments as $tournament)
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105"> <!-- Zwiększenie paddingu i dodanie efektu hover -->
                    <img
                        src="{{ $tournament->games->image_path ? asset('storage/games/' . $tournament->games->image_path) : asset('images/not-found.jpg') }}"
                        alt="Game: {{ $tournament->games->name }}"
                        class="w-full h-48 object-cover rounded-lg"
                    />
                    <br>
                    <h3 class="text-xl font-semibold text-gray-800">{{ $tournament->name }}</h3>
                    <p class="text-gray-600 mt-3 text-base">Game: {{ $tournament->games->name }}</p>
                    <p class="text-gray-600 mt-3 text-base">Status: <span class="font-bold">{{ ucfirst($tournament->status) }}</span></p>
                    <p class="text-gray-600 mt-3 text-base">Registered: {{ $tournament->participant_users()->count() }}/{{ $tournament->max_participants }}</p>
                    @if($tournament->games->game_tags->isNotEmpty())
                        <p class="text-gray-600 mt-3 text-base">Tags:
                            @foreach($tournament->games->game_tags as $tag)
                                <span>{{ $tag->name }}</span>{{ !$loop->last ? ',' : '' }}
                            @endforeach
                        </p>
                    @else
                        <p class="text-gray-600 mt-3 text-base">Brak tagów</p>
                    @endif
                    <a href="{{ route('tournaments.show', $tournament->id) }}" class="text-white bg-blue-600 hover:bg-blue-700 py-2 px-4 rounded-md inline-block text-center mt-4">
                        View Details
                    </a>
                </div>
            @endforeach
        </div>

        <!-- Paginate links -->
        <div class="mt-6">
            {{ $tournaments->links() }}
        </div>
    </div>
</x-app-layout>
