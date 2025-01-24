<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <x-slot name="header">
            <h1 class="text-2xl font-semibold text-gray-800">Game Tags</h1>
        </x-slot>

        @admin
            <div class="mb-4">
                <a href="{{ route('game_tags.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-blue-600 w-full block text-center">
                    Create New Game Tag
                </a>
            </div>
        @endadmin

{{--        Filtration--}}
        <div class="mb-6">
            <form action="{{ route('game_tags.index') }}" method="GET">
                <div class="mb-4">
                    <label for="tag_name" class="block text-sm font-medium text-gray-700">Tag Name</label>
                    <input type="text" name="tag_name" id="tag_name" value="{{ request('tag_name') }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                </div>

                <div class="flex justify-center">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filter Game Tags</button>
                </div>
            </form>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="table-auto w-full text-left">
                <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Description</th>
                    @admin
                    <th class="px-4 py-2">Actions</th>
                    @endadmin
                </tr>
                </thead>
                <tbody>
                @forelse ($gameTags as $gameTag)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2">{{ $gameTag->name }}</td>
                        <td class="px-4 py-2">{{ $gameTag->description }}</td>
                        @admin
                        <td class="px-4 py-2 flex space-x-2">
                            <a href="{{ route('game_tags.edit', $gameTag) }}"
                               class="text-blue-500 hover:underline">Edit</a>
                            <form method="POST" action="{{ route('game_tags.destroy', $gameTag) }}" onsubmit="return confirm('Are you sure you want to delete this Game Tag?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Delete</button>
                            </form>
                        </td>
                        @endadmin
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-2 text-center text-gray-500">
                            No Game Tags found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $gameTags->links() }}
        </div>
    </div>
</x-app-layout>
