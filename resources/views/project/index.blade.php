<x-layout>
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center my-4">
            <h1>All Projects</h1>
            <a
                class="inline-flex h-fit items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-50 dark:hover:bg-gray-800 dark:focus:ring-gray-300"
                href="{{ route('project.create') }}"
            >
                Create a Project
            </a>
        </div>
        <div class="border rounded-lg w-full">
            <div class="relative w-full overflow-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left font-medium">Project</th>
                            <th class="px-4 py-3 text-left font-medium">Description</th>
                            <th class="px-4 py-3 text-left font-medium">Number of Tasks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                            <tr class="border-b">
                                <td class="px-4 py-3">
                                    <a class="font-medium text-indigo-600 dark:text-indigo-400" href="{{ route('project.task.index', compact('project')) }}">
                                        {{ $project->name }}
                                    </a>
                                </td>
                                <td class="px-4 py-3">
                                    {{ $project->description }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    {{ $project->taskCount() }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div>
            {{ $projects->links() }}
        </div>
    </div>
</x-layout>
