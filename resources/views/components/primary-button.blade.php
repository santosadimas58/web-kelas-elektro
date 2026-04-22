<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-slate-950 dark:bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white dark:text-slate-950 uppercase tracking-widest hover:bg-blue-900 dark:hover:bg-yellow-300 focus:bg-blue-900 dark:focus:bg-yellow-300 active:bg-slate-900 dark:active:bg-yellow-200 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
