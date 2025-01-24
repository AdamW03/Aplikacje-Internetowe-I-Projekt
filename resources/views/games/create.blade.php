<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <x-slot name="header">
            <h1 class="text-2xl font-semibold text-gray-800">Add New Game</h1>
        </x-slot>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form method="POST" action="{{ route('games.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Game Name</label>
                    <input type="text" name="name" id="name"
                           class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                           value="{{ old('name') }}" required autofocus autocomplete="name">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="4"
                              class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                <div class="mb-4">
                    <label for="image_path" class="block text-sm font-medium text-gray-700">Choose Game Image (optional)</label>
                    <input type="file" id="image_path" name="image_path"
                           class="mt-1 block w-full p-2 border border-gray-300 rounded-md" accept="image/*">
                    @error('image_path')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="game_tags" class="block text-sm font-medium text-gray-700">Tags</label>
                    <select name="game_tags[]" id="game_tags"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md" multiple>
                        @foreach($gameTags as $tag)
                            <option value="{{ $tag->id }}" {{ in_array($tag->id, old('game_tags', [])) ? 'selected' : '' }}>
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('game_tags')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Add Game
                    </button>
                    <a href="{{ route('games.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
