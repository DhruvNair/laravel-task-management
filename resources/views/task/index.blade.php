<x-layout>
    <div class="max-w-5xl mx-auto">
        <div class="flex justify-between items-end my-4">
            <div>
                <h1>All Tasks for <span class="text-indigo-600 dark:text-indigo-400">{{ $project->name }}</span></h1>
                <p>{{ $project->description }}</p>
            </div>
            <div class="flex flex-col gap-4">
                <div class="flex gap-4">
                    <a
                        class="inline-flex h-fit items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-50 dark:hover:bg-gray-800 dark:focus:ring-gray-300"
                        href="{{ route('project.edit', compact('project')) }}"
                    >
                        Edit Project
                    </a>
                    <form action="{{ route('project.destroy', compact('project')) }}" method="POST">
                        @csrf
                        @method('DELETE')
                    
                        <button
                            class="inline-flex items-center rounded-md border border-red-700 bg-red-100 px-3 py-2 text-sm font-medium leading-4 text-red-700 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:bg-red-900/20 dark:text-red-400 dark:border-red-400 dark:hover:bg-red-800/80"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                strokeWidth="2"
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                class="h-4 w-4 mr-2"
                            >
                                <path d="M3 6h18" />
                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                            </svg>
                            Delete Project
                        </button>
                    </form>
                </div>
                <a
                    class="inline-flex h-fit w-fit items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-50 dark:hover:bg-gray-800 dark:focus:ring-gray-300"
                    href="{{ route('project.task.create', compact('project')) }}"
                >
                    Create a task
                </a>
            </div>
        </div>
        <div class="border rounded-lg w-full">
            <div class="relative w-full overflow-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left font-medium">Title</th>
                            <th class="px-4 py-3 text-left font-medium">Description</th>
                            <th class="px-4 py-3 text-left font-medium">Status</th>
                            <th class="px-4 py-3 text-left font-medium">Created On</th>
                            <th class="px-4 py-3 text-left font-medium">Deadline</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr class="border-b font-medium">
                                <td class="px-4 py-3">
                                    <a href="{{ route('project.task.show', compact('project', 'task')) }}">
                                        {{ $task->title }}
                                    </a>
                                </td>
                                <td class="px-4 py-3">
                                    {{ $task->description }}
                                </td>
                                <td class="px-4 py-3">
                                    <span @class([
                                            'inline-block rounded-full px-3 py-1 text-sm font-medium capitalize',
                                            'bg-green-100 text-green-600 dark:bg-green-900/20 dark:text-green-400' => $task->status === 'completed',
                                            'bg-yellow-100 text-yellow-600 dark:bg-yellow-900/20 dark:text-yellow-400' => $task->status === 'in_progress',
                                            'bg-red-100 text-red-600 dark:bg-red-900/20 dark:text-red-400' => $task->status === 'pending',
                                        ])>
                                        {{ str_replace('_', ' ',$task->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">{{ date('Y-m-d', strtotime($task->created_at)) }}</td>
                                <td class="px-4 py-3">{{ date('Y-m-d', strtotime($task->deadline)) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div>
            {{ $tasks->links() }}
        </div>
    </div>
</x-layout>
