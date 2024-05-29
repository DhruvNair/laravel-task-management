<x-layout>
    <div class="px-4 py-6 sm:px-6 lg:px-8 lg:py-10">
		<div class="mx-auto max-w-3xl">
            <header>
                <h2 class="text-xl font-bold">Create Task</h2>
                <p class="text-gray-500">Create a task for the {{ $project->name }} project</p>
            </header>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <p class="font-bold">Errors when creating the task:</p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form class="space-y-4" method="POST" action="{{ route('project.task.store', compact('project')) }}">
                @csrf
                <input type="hidden" name="project_id" value="{{ $project->id }}" />
                <div class="grid gap-2">
                  <label class="text-sm font-medium" for="title">
                    Task Title
                  </label>
                  <input
                    class="rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-gray-500 focus:outline-none focus:ring-1 focus:ring-gray-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:focus:border-gray-600 dark:focus:ring-gray-600"
                    id="title"
                    name="title"
                    placeholder="Enter task title"
                    type="text"
                    value="{{ old('title') }}"
                    required
                  />
                </div>
                <div class="grid gap-2">
                  <label class="text-sm font-medium" for="deadline">
                    Deadline
                  </label>
                  <input
                    class="rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-gray-500 focus:outline-none focus:ring-1 focus:ring-gray-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:focus:border-gray-600 dark:focus:ring-gray-600"
                    id="deadline"
                    name="deadline"
                    type="date"
                    value="{{ old('deadline') }}"
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
                    >{{ old('description') }}</textarea>
                  </div>
                <div class="flex justify-end">
                  <button
                    class="inline-flex h-10 items-center justify-center rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-gray-50 shadow transition-colors hover:bg-gray-900/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-gray-950 disabled:pointer-events-none disabled:opacity-50 dark:bg-gray-50 dark:text-gray-900 dark:hover:bg-gray-50/90 dark:focus-visible:ring-gray-300"
                    type="submit"
                    onclick="this.disabled = true; this.closest('form').submit(); this.innerText = 'Creating Task...';"
                  >
                    Create Task
                  </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>