<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <x-slot name="header">
            <h1 class="text-2xl font-semibold text-gray-800">Tournament: {{ $tournament->name }}</h1>
            <!-- Edit and Delete buttons -->
            <div class="mt-4 flex justify-end">
                <!-- Edit and Delete buttons -->
                @auth
                <div class="mt-4 flex justify-end">
                    @if(auth()->user()->role === 'admin' || $tournament->creator_id == auth()->id()) <!-- Check if the user is admin or creator -->
                    <a href="{{ route('tournaments.edit', $tournament->id) }}" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
                        Edit Tournament
                    </a>
                    @endif
                    @if(auth()->user()->role === 'admin' || $tournament->creator_id == auth()->id()) <!-- Check if the user is admin or creator -->
                    <form action="{{ route('tournaments.destroy', $tournament->id) }}" method="POST" class="ml-4">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700" onclick="return confirm('Are you sure you want to delete this tournament?')">
                            Delete Tournament
                        </button>
                    </form>
                    @endif
                </div>
                    @endauth
            </div>
        </x-slot>

        <div class="bg-white p-6 rounded-lg shadow-lg">
            <img
                src="{{ $tournament->games->image_path ? asset('storage/games/' . $tournament->games->image_path) : asset('images/not-found.jpg') }}"
                alt="Game: {{ $tournament->games->name }}"
                class="w-full h-96 object-cover rounded-lg"
            />
            <div class="mt-6">
                <h3 class="text-2xl font-semibold text-gray-800 text-center">{{ $tournament->name }}</h3>

                <br>
                <div class="mt-4 flex justify-between">
                    <p class="text-gray-600 text-base">Creator: {{ $tournament->creator_users->name }}</p>
                    <p class="text-gray-600 text-base">Game: {{ $tournament->games->name }}</p>
                </div>

                <br>
                <div class="mt-6">
                    <p class="text-gray-600 text-base text-center mx-4 mt-4">
                        {{ $tournament->description }}
                    </p>
                </div>


                <br>
                <div class="mt-6 flex justify-between items-center">
                    <p class="text-gray-600 text-base">Status: <span class="font-bold">{{ ucfirst($tournament->status) }}</span></p>
                    <p class="text-gray-600 text-base">Registered: {{ $tournament->participant_users()->count() }}/{{ $tournament->max_participants }}</p>
                    <p class="text-gray-600 text-base">Team Size: {{ $tournament->per_team }}</p>
                </div>

                <br>
                <div class="mt-6 flex items-center justify-between">
                    <!-- Start Date -->
                    <p class="text-gray-600 text-base">
                        Start Date: {{ \Carbon\Carbon::parse($tournament->start_date)->format('Y-m-d H:i') }}
                    </p>
                    <!-- End Date -->
                    @if($tournament->end_date)
                        <p class="text-gray-600 text-base text-right">
                            End Date: {{ \Carbon\Carbon::parse($tournament->end_date)->format('Y-m-d H:i') }}
                        </p>
                    @else
                        <p class="text-gray-600 text-base text-right">End Date: Not specified</p>
                    @endif
                </div>

                <br>
                <p class="text-gray-600 text-base text-center mx-4">
                    @if($tournament->location)
                        Location: {{ $tournament->location }}
                    @else
                        Location: Not specified
                    @endif
                </p>

                <br>
            @auth
                <!-- Button to join-->
                <div class="flex justify-center">

                    @if($tournament->participant_users()->count() < $tournament->max_participants)
                        <!-- If the current user is not yet registered -->

                        @php
                            $isParticipant = false;
                        @endphp
                        @foreach($tournament->participant_users as $participant)
                                @if($participant->id === auth()->user()->id)
                                    @php
                                        $isParticipant = true;
                                    @endphp
                                @endif
                        @endforeach

                        @if(!$isParticipant)
                            @if($tournament->status == 'open')
                                <div class="mt-6 text-center">
                                    <form action="{{ route('tournaments.join', $tournament->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-blue-600 text-white py-2 px-6 rounded-md hover:bg-blue-700">
                                            Join Tournament
                                        </button>
                                    </form>
                                </div>
                            @else
                                <p class="text-gray-600 mt-3">The tournament is not open for registration.</p>
                            @endif
                        @else
                            <!-- If the user is already registered -->
                            @if($tournament->status == 'open')
                                <div class="mt-6 text-center">
                                    <form action="{{ route('tournaments.leave', $tournament->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 text-white py-2 px-6 rounded-md hover:bg-red-700" onclick="return confirm('Are you sure you want to leave this tournament?')">
                                            Leave Tournament
                                        </button>
                                    </form>
                                </div>
                            @elseif($tournament->status == 'finished')
                                <p class="text-gray-600 mt-3">The tournament is finished.</p>
                            @else
                                <p class="text-gray-600 mt-3">You are already registered for this tournament.</p>
                            @endif
                        @endif
                    @else
                        <p class="text-gray-600 mt-3">The tournament is full.</p>
                    @endif
                </div>
                @endauth

                <br>
                <div class="mt-6 text-center">
                    <a href="{{ route('tournaments.index') }}" class="inline-block text-white bg-blue-600 hover:bg-blue-700 py-2 px-4 rounded-md text-center">
                        Back to tournament list
                    </a>
                </div>

                <br>
                @if($tournament->games->game_tags->isNotEmpty())
                    <p class="text-gray-600 mt-3 text-base">Game tags:
                        @foreach($tournament->games->game_tags as $tag)
                            <span>{{ $tag->name }}</span>{{ !$loop->last ? ',' : '' }}
                        @endforeach
                    </p>
                @else
                    <p class="text-gray-600 mt-3 text-base">No tags</p>
                @endif
            </div>

            <br>
            <div class="mt-6">
                <h3 class="text-xl font-semibold text-gray-800 text-center">Tournament Matches</h3>

                <!-- Table with match details -->
                <div class="flex justify-center items-center mt-6">
                    <table class="min-w-full table-auto mt-4 border-collapse border border-gray-300">
                        <thead>
                        <tr>
                            <th class="px-4 py-2 text-center border border-gray-300">Match No.</th>
                            <th class="px-4 py-2 text-center border border-gray-300">Result</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tournament->tournament_games as $index => $game)
                            <tr class="border-t border-gray-300">
                                <td class="px-4 py-2 text-center border border-gray-300">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 text-center border border-gray-300">
                                    @if($game->draw)
                                        <span class="text-yellow-400">Draw</span>
                                    @elseif($game->winner_id)
                                        <span class="text-green-600">Winner: {{ $game->users->name }}</span>
                                    @else
                                        <span class="text-red-600">Not Played</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            <br>
            <!-- Registrated Users -->
            <div class="mt-6">
                <h3 class="text-xl font-semibold text-gray-800 text-center">Registered Participants</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
                    @foreach($tournament->participant_users as $participant)
                        <div class="text-center">
                            <p class="text-gray-600">{{ $participant->name }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <br>
            <div class="mt-6 text-center">
                <a href="{{ route('tournaments.index') }}" class="inline-block text-white bg-blue-600 hover:bg-blue-700 py-2 px-4 rounded-md text-center">
                    Back to tournament list
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
