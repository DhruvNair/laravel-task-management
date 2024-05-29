<x-layout>
    <div class="px-4 py-6 sm:px-6 lg:px-8 lg:py-10">
		<div class="mx-auto max-w-3xl">
            <header>
                <h2 class="text-xl font-bold">Create a Project</h2>
            </header>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <p class="font-bold">Errors when creating the project:</p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form class="space-y-4" method="POST" action="{{ route('project.update', compact('project')) }}">
                @csrf
                @method('PUT')
                <div class="grid gap-2">
                  <label class="text-sm font-medium" for="name">
                    Project Name
                  </label>
                  <input
                    class="rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-gray-500 focus:outline-none focus:ring-1 focus:ring-gray-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:focus:border-gray-600 dark:focus:ring-gray-600"
                    id="name"
                    name="name"
                    placeholder="Enter task name"
                    type="text"
                    value="{{ old('name', $project->name) }}"
                    required
                  />
                </div>
                <div class="grid gap-2">
                    <label class="text-sm font-medium" for="description">
                      Description
                    </label>
                    <textarea
                      class="rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-gray-500 focus:outline-none focus:ring-1 focus:ring-gray-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:focus:border-gray-600 dark:focus:ring-gray-600"
                      id="description"
                      name="description"
                      placeholder="Enter task description"
                    >{{ old('description', $project->description) }}</textarea>
                  </div>
                <div class="flex justify-end">
                  <button
                    class="inline-flex h-10 items-center justify-center rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-gray-50 shadow transition-colors hover:bg-gray-900/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-gray-950 disabled:pointer-events-none disabled:opacity-50 dark:bg-gray-50 dark:text-gray-900 dark:hover:bg-gray-50/90 dark:focus-visible:ring-gray-300"
                    type="submit"
                    onclick="this.disabled = true; this.closest('form').submit(); this.innerText = 'Updating Project...';"
                  >
                    Update Project
                  </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>