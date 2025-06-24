<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Créer un nouveau ticket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg p-6 transition transform duration-500 hover:scale-[1.01]">

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 animate-pulse">
                        <strong class="font-bold">Oups !</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('client.tickets.store') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Titre</label>
                        <input type="text" name="title" id="title" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 transition focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-300">
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="4" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 transition focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-300"></textarea>
                    </div>

                    <div>
                        <label for="attachments" class="block text-sm font-medium text-gray-700">Pièces jointes</label>
                        <input type="file" name="attachments[]" multiple
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 transition focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-300">
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full bg-blue-600 text-white py-2 px-4 rounded shadow transition transform duration-300 hover:bg-blue-700 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Créer le ticket
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
