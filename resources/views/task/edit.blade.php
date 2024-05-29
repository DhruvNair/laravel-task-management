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
            <form class="space-y-4" method="POST" action="{{ route('project.task.update', compact('project', 'task')) }}">
                @csrf
                @method('PUT')
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
                    value="{{ old('title', $task->title) }}"
                    required
                  />
                </div>
                <div class="grid gap-2">
                    <label class="text-sm font-medium">Status</label>
                    <div class="flex items-center justify-start space-x-2">
                      <fieldset>
                          <div class="flex items-center space-x-2">
                              <div>
                                  <input class="peer sr-only" id="pending" name="status" type="radio" value="pending" {{ old('status',$task->status) == 'pending' ? 'checked' : '' }} />
                                  <label
                                  class="rounded-full px-4 py-2 bg-gray-100 text-gray-900 peer-checked:bg-gray-900 peer-checked:text-gray-50 cursor-pointer transition-colors dark:bg-gray-800 dark:text-gray-400 dark:peer-checked:bg-gray-50 dark:peer-checked:text-gray-900"
                                  for="pending"
                                  >
                                  Pending
                                  </label>
                              </div>
                              <div>
                                  <input class="peer sr-only" id="in_progress" name="status" type="radio" value="in_progress" {{ old('status',$task->status) == 'pending' ? 'in_progress' : '' }} />
                                  <label
                                  class="rounded-full px-4 py-2 bg-gray-100 text-gray-900 peer-checked:bg-gray-900 peer-checked:text-gray-50 cursor-pointer transition-colors dark:bg-gray-800 dark:text-gray-400 dark:peer-checked:bg-gray-50 dark:peer-checked:text-gray-900"
                                  for="in_progress"
                                  >
                                  In Progress
                                  </label>
                              </div>
                              <div>
                                  <input class="peer sr-only" id="completed" name="status" type="radio" value="completed" {{ old('status',$task->status) == 'completed' ? 'checked' : '' }} />
                                  <label
                                  class="rounded-full px-4 py-2 bg-gray-100 text-gray-900 peer-checked:bg-gray-900 peer-checked:text-gray-50 cursor-pointer transition-colors dark:bg-gray-800 dark:text-gray-400 dark:peer-checked:bg-gray-50 dark:peer-checked:text-gray-900"
                                  for="completed"
                                  >
                                  Completed
                                  </label>
                              </div>
                          </div>
                      </fieldset>
                    </div>
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
                    value="{{ old('deadline', $task->deadline) }}"
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
                    >{{ old('description', $task->description) }}</textarea>
                  </div>
                <div class="flex justify-end">
                  <button
                    class="inline-flex h-10 items-center justify-center rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-gray-50 shadow transition-colors hover:bg-gray-900/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-gray-950 disabled:pointer-events-none disabled:opacity-50 dark:bg-gray-50 dark:text-gray-900 dark:hover:bg-gray-50/90 dark:focus-visible:ring-gray-300"
                    type="submit"
                  >
                    Save Task
                  </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>