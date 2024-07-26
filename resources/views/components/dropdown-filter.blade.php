<div class="px-4">

    <form class="">
        <label for="sort_by" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Sort By</label>
        <select id="sort_by" wire:model.live='sort_by'
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="latest">Latest</option>
            <option value="likes">Likes</option>
            <option value="comments">Comment</option>
        </select>
    </form>

</div>
