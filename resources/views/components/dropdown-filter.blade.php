<button id="dropdownDefaultButton" data-dropdown-toggle="dropdown"
    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-6 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
    type="button">Filter<svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
        viewBox="0 0 10 6">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
    </svg>
</button>

<div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
    <ul class="py-2">
        <li>
            <button id="latest" class="w-full py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Latest</button>
        </li>
        <li>
            <button id="likes" class="w-full py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Likes</button>
        </li>
        <li>
            <button id="comments" class="w-full py-2  hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Comments</button>
        </li>
        <li>
            <button id="views" class="w-full py-2  hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Views</button>
        </li>
    </ul>
</div>
