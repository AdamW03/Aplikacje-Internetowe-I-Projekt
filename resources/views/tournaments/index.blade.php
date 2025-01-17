<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <x-slot name="header">
            <h1 class="text-2xl font-semibold text-gray-800">Turnieje</h1>
        </x-slot>

        <!-- Filtracja -->
        <div class="mb-6">
            <form action="{{ route('tournaments.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Filtrowanie po nazwie turnieju -->
                <div>
                    <label for="tournament_name" class="block text-gray-700">Nazwa turnieju</label>
                    <input type="text" name="tournament_name" id="tournament_name" value="{{ request('tournament_name') }}" class="mt-1 block w-full border-gray-300 rounded-md">
                </div>

                <!-- Filtrowanie po nazwie gry -->
                <div>
                    <label for="game_name" class="block text-gray-700">Nazwa gry</label>
                    <select name="game_name" id="game_name" class="mt-1 block w-full border-gray-300 rounded-md">
                        <option value="">Wybierz grę</option>
                        @foreach($games as $game)
                            <option value="{{ $game->name }}" {{ request('game_name') == $game->name ? 'selected' : '' }}>{{ $game->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtrowanie po tagu gry -->
                <div>
                    <label for="game_tag" class="block text-gray-700">Tagi gry</label>
                    <select name="game_tag" id="game_tag" class="mt-1 block w-full border-gray-300 rounded-md">
                        <option value="">Wybierz tag</option>
                        @foreach($gameTags as $tag)
                            <option value="{{ $tag->name }}" {{ request('game_tag') == $tag->name ? 'selected' : '' }}>{{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Przycisk submit -->
                <div class="col-span-full sm:col-span-3 flex justify-center">
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">Filtruj</button>
                </div>
            </form>
        </div>

        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8"> <!-- Zmiana na 3 kafelki w rzędzie na większych ekranach -->
            @foreach($tournaments as $tournament)
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105"> <!-- Zwiększenie paddingu i dodanie efektu hover -->
                    <img
                        src="{{ $tournament->games->image_path ? asset('storage/games/' . $tournament->games->image_path) : asset('images/not-found.jpg') }}"
                        alt="Gra: {{ $tournament->games->name }}"
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
