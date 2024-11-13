<body x-data="main" x-init="$store.app.hasCreative = window.location.href.includes('creative'), $store.app.hasdetached = window.location.href.includes('detached')"
    :class="[$store.app.sidebar ? 'toggle-sidebar' : '', $store.app.fullscreen ? 'full' : '', $store.app.hasCreative ?
        'detached ' : '', $store.app.hasdetached ? 'detached detached-simple ' : '', $store.app.layout
    ]"
    class="relative overflow-x-hidden text-sm antialiased font-normal text-black font-cerebri dark:text-white vertical "
    x-data="modals">
