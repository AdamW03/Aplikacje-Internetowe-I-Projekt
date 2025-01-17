<x-app-layout>
    <div class="max-w-4xl mx-auto mt-8">
        <x-slot name="header">
            <h1 class="text-3xl font-bold text-center text-gray-700">Create a New Tournament</h1>
        </x-slot>

        <form action="{{ route('tournaments.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4">
            @csrf

            <!-- Tournament Name -->
            <div>
                <label for="name" class="block text-gray-700">Tournament Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
            </div>

            <!-- Game Selection -->
            <div>
                <label for="game_id" class="block text-gray-700">Game</label>
                <select name="game_id" id="game_id" class="mt-1 block w-full border-gray-300 rounded-md" required>
                    <option value="">Select a game</option>
                    @foreach($games as $game)
                        <option value="{{ $game->id }}" {{ old('game_id') == $game->id ? 'selected' : '' }}>{{ $game->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-gray-700">Description</label>
                <textarea name="description" id="description" class="mt-1 block w-full border-gray-300 rounded-md" rows="4">{{ old('description') }}</textarea>
            </div>

            <!-- Start Date -->
            <div>
                <label for="start_date" class="block text-gray-700">Start Date</label>
                <input type="datetime-local" name="start_date" id="start_date" value="{{ old('start_date') }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
            </div>

            <!-- End Date (optional) -->
            <div>
                <label for="end_date" class="block text-gray-700">End Date (optional)</label>
                <input type="datetime-local" name="end_date" id="end_date" value="{{ old('end_date') }}" class="mt-1 block w-full border-gray-300 rounded-md">
            </div>

            <!-- Location (optional) -->
            <div>
                <label for="location" class="block text-gray-700">Location (optional)</label>
                <input type="text" name="location" id="location" value="{{ old('location') }}" class="mt-1 block w-full border-gray-300 rounded-md">
            </div>

            <!-- Max Participants -->
            <div>
                <label for="max_participants" class="block text-gray-700">Max Participants</label>
                <input type="number" name="max_participants" id="max_participants" value="{{ old('max_participants') }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
            </div>

            <!-- Per Team (divisor of max participants) -->
            <div>
                <label for="per_team" class="block text-gray-700">Participants per Team</label>
                <input type="number" name="per_team" id="per_team" value="{{ old('per_team') }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-between col-span-full">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 w-full sm:w-auto">
                    Create Tournament
                </button>
                <a href="{{ route('tournaments.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Cancel</a>
            </div>

        </form>
    </div>
</x-app-layout>
