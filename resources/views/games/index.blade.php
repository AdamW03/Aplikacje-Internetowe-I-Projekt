<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <x-slot name="header">
            <h1 class="text-2xl font-semibold text-gray-800">Games</h1>
        </x-slot>

{{--        <div class="mb-4">--}}
{{--            @admin--}}
{{--            <a href="{{ route('games.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-full block text-center">--}}
{{--                Create New Game--}}
{{--            </a>--}}
{{--            @endadmin--}}
{{--        </div>--}}

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="table-auto w-full text-left">
                <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Description</th>
                    <th class="px-4 py-2">Game Tags</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($games as $game)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2">{{ $game->name }}</td>
                        <td class="px-4 py-2">{{ $game->description }}</td>
                        <td class="px-4 py-2">
                            @foreach($game->game_tags as $tag)
                                <span class="inline-block bg-gray-200 text-gray-700 px-2 py-1 rounded-full text-xs mr-2">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                        <td class="px-4 py-2 flex space-x-2">
                            <a href="{{ route('games.show', $game) }}" class="text-blue-500 hover:underline">View Details</a>
                            @admin
{{--                            <a href="{{ route('games.edit', $game) }}" class="text-blue-500 hover:underline">Edit</a>--}}
                                <form method="POST" action="{{ route('games.destroy', $game) }}" onsubmit="return confirm('Are you sure you want to delete this Game?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                </form>
                            @endadmin
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center text-gray-500">
                            No Games found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $games->links() }} {{-- Paginacja --}}
        </div>
    </div>
</x-app-layout>
