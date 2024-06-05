<x-layout>
    <div class="px-4 py-6 sm:px-6 lg:px-8 lg:py-10">
		<div class="mx-auto max-w-3xl">
			<div class="space-y-6">
				<div class="flex items-center justify-between">
					<h1 class="mr-4" id="title">{{ $task->title }}</h1>
					<div class="flex items-center space-x-2">
						<a
							class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-50 dark:hover:bg-gray-800 dark:focus:ring-gray-300"
							href="{{ route('project.task.edit', compact('project', 'task')) }}"
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
								<path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
								<path d="m15 5 4 4" />
							</svg>
							Edit
						</a>
						<form action="{{ route('project.task.destroy', compact('project', 'task')) }}" method="POST">
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
								Delete
							</button>
						</form>
					</div>
				</div>
				<span class="text-sm font-medium text-gray-500 dark:text-gray-400">
					Project: <a href="{{ route('project.show', $project) }}" class="text-indigo-600 dark:text-indigo-400" id="project-name">{{ $project->name }}</a>
				</span>
				<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
					<div class="space-y-1">
						<p class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</p>
						<div @class([
							'inline-flex items-center rounded-full px-3 py-1 text-sm font-medium capitalize',
							'bg-green-100 text-green-600 dark:bg-green-900/20 dark:text-green-400' => $task->status === 'completed',
							'bg-yellow-100 text-yellow-600 dark:bg-yellow-900/20 dark:text-yellow-400' => $task->status === 'in_progress',
							'bg-red-100 text-red-600 dark:bg-red-900/20 dark:text-red-400' => $task->status === 'pending',
						]) id="status">{{ str_replace('_', ' ',$task->status) }}</div>
					</div>
					<div class="space-y-1">
						<p class="text-sm font-medium text-gray-500 dark:text-gray-400">Deadline</p>
						<p class="text-base font-medium" id="deadline">{{ date('Y-m-d', strtotime($task->deadline)) }}</p>
					</div>
				</div>
				<div class="space-y-1">
					<p class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</p>
					<p class="text-base" id="description">{{ $task->description }}</p>
				</div>
			</div>
		</div>
	</div>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
	<script>
		var pusher = new Pusher('9ef31d30f4774ffc8270', {
		  cluster: 'mt1'
		});

		const colorClasses = {
			completed: 'bg-green-100 text-green-600 dark:bg-green-900/20 dark:text-green-400'.split(' '),
			in_progress: 'bg-yellow-100 text-yellow-600 dark:bg-yellow-900/20 dark:text-yellow-400'.split(' '),
			pending: 'bg-red-100 text-red-600 dark:bg-red-900/20 dark:text-red-400'.split(' '),
		};
		const allColorClasses = Object.values(colorClasses).flat();
		console.log(allColorClasses);
	
		var channel = pusher.subscribe('task.{{$task->id}}');
		const title = document.getElementById('title');
		const description = document.getElementById('description');
		const status = document.getElementById('status');
		const deadline = document.getElementById('deadline');
		channel.bind('task.updated', function({task, project}) {
			title.innerText = task.title;
			description.innerText = task.description;
			status.classList.remove(...allColorClasses);
			status.classList.add(...colorClasses[task.status]);
			status.innerText = task.status.split('_').join(' ');
			deadline.innerText = new Date(task.deadline).toISOString().split('T')[0];
		});
	  </script>
</x-layout>
