<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <x-slot name="header">
            <h1 class="text-2xl font-semibold text-gray-800">Admin Panel - Users Management</h1>
        </x-slot>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <!-- Filtration -->
            <div class="mb-6 p-6">
                <form action="{{ route('admin.users.index') }}" method="GET" class="flex items-center space-x-4">
                    <!-- Filtering by user name -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">User Name</label>
                        <input type="text" name="name" id="name" value="{{ request('name') }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                    </div>
                    <!-- Submit button -->
                    <div class="flex justify-center">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filter Users</button>
                    </div>
                </form>
            </div>

            <table class="table-auto w-full text-left">
                <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2">{{ $user->name }}</td>
                        <td class="px-4 py-2">{{ $user->email }}</td>
                        <td class="px-4 py-2">{{ $user->is_banned ? 'Banned' : 'Active' }}</td>
                        <td class="px-4 py-2 flex space-x-2 items-center">
                            @if($user->is_banned)
                                <form method="POST" action="{{ route('admin.users.unban', $user) }}" onsubmit="return confirm('Are you sure you want to unban this user?');">
                                    @csrf
                                    <button type="submit" class="text-green-500 hover:underline">Unban</button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('admin.users.ban', $user) }}" onsubmit="return confirm('Are you sure you want to ban this user?');">
                                    @csrf
                                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Ban</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center text-gray-500">No users available.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4 p-6">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>
