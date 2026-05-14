(function () {
    var root = document.documentElement;
    var config = window.EvoUI && window.EvoUI.config ? window.EvoUI.config : {};
    var themes = config.themes || ['evolight', 'evolightness', 'evodark', 'evodarkness'];
    var darkThemes = config.darkThemes || ['evodark', 'evodarkness'];
    var defaultLight = config.defaultLight || 'evolight';
    var defaultDark = config.defaultDark || 'evodark';
    var managerThemeModes = config.managerThemeModes || ['', 'lightness', 'light', 'dark', 'darkness'];

    window.EvoUI = window.EvoUI || {};
    root.classList.add('evo-ui-page');
    applyPlatformClasses();

    function readStorage(key, sourceWindow) {
        try {
            return (sourceWindow || window).localStorage.getItem(key);
        } catch (error) {
            return null;
        }
    }

    function writeStorage(key, value, sourceWindow) {
        try {
            (sourceWindow || window).localStorage.setItem(key, value);
        } catch (error) {
            // Storage can be disabled in private windows or embedded managers.
        }
    }

    function readCookie(key, sourceDocument) {
        var cookies = '';

        try {
            cookies = (sourceDocument || document).cookie || '';
        } catch (error) {
            cookies = '';
        }

        return cookies
            .split(';')
            .map(function (item) {
                return item.trim();
            })
            .filter(function (item) {
                return item.indexOf(key + '=') === 0;
            })
            .map(function (item) {
                return decodeURIComponent(item.slice(key.length + 1));
            })[0] || null;
    }

    function normalizeTheme(theme) {
        if (!theme) {
            return null;
        }

        theme = String(theme).toLowerCase();

        if (theme === 'evodarknes') {
            theme = 'evodarkness';
        }
        if (theme === 'light') {
            theme = defaultLight;
        }
        if (theme === 'lightness') {
            theme = 'evolightness';
        }
        if (theme === 'dark') {
            theme = defaultDark;
        }
        if (theme === 'darkness') {
            theme = 'evodarkness';
        }

        return themes.indexOf(theme) !== -1 ? theme : null;
    }

    function themeMode(theme) {
        return darkThemes.indexOf(theme) !== -1 ? 'dark' : 'light';
    }

    function platformName() {
        var platform = '';

        try {
            platform = (navigator.userAgentData && navigator.userAgentData.platform) || navigator.platform || navigator.userAgent || '';
        } catch (error) {
            platform = '';
        }

        platform = String(platform).toLowerCase();

        if (platform.indexOf('mac') !== -1 || platform.indexOf('iphone') !== -1 || platform.indexOf('ipad') !== -1 || platform.indexOf('ipod') !== -1) {
            return 'mac';
        }

        return platform.indexOf('win') !== -1 ? 'windows' : 'other';
    }

    function applyPlatformClasses() {
        var platform = platformName();

        root.classList.toggle('evo-ui-os-mac', platform === 'mac');
        root.classList.toggle('evo-ui-os-windows', platform === 'windows');
        root.classList.toggle('evo-ui-custom-scrollbars', platform === 'windows');

        if (document.body) {
            document.body.classList.toggle('evo-ui-os-mac', platform === 'mac');
            document.body.classList.toggle('evo-ui-os-windows', platform === 'windows');
            document.body.classList.toggle('evo-ui-custom-scrollbars', platform === 'windows');
        }
    }

    function eventName(name) {
        name = String(name || '');

        return name.indexOf('evo-ui:') === 0 ? name : 'evo-ui:' + name;
    }

    function dispatch(name, detail, target) {
        (target || window).dispatchEvent(new CustomEvent(eventName(name), {
            detail: detail || {}
        }));
    }

    function formIsDirty() {
        return document.querySelector('[data-evo-form-dirty="true"]:not([data-evo-form-saved="true"])') !== null;
    }

    function waitForCleanForm(callback, options) {
        options = options || {};

        var interval = Number(options.interval || 60);
        var maxAttempts = Number(options.maxAttempts || 80);
        var attempts = 0;

        function check() {
            if (!formIsDirty()) {
                if (typeof callback === 'function') {
                    callback();
                }

                return;
            }

            attempts += 1;

            if (attempts < maxAttempts) {
                window.setTimeout(check, interval);
            }
        }

        check();
    }

    function label(key, fallback) {
        var labels = window.EvoUI && window.EvoUI.config && window.EvoUI.config.labels
            ? window.EvoUI.config.labels
            : {};

        return labels[key] || fallback;
    }

    function escapeAttribute(value) {
        return String(value || '')
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
    }

    function iconSvg(name) {
        var paths = {
            trash: '<path d="M4 7l16 0"/><path d="M10 11l0 6"/><path d="M14 11l0 6"/><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>',
            x: '<path d="M18 6l-12 12"/><path d="M6 6l12 12"/>'
        };

        return '<svg width="20" height="20" stroke-width="1.5" fill="none" stroke="currentColor" aria-hidden="true" class="inline-block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/>' + (paths[name] || '') + '</svg>';
    }

    function on(name, callback, target) {
        (target || window).addEventListener(eventName(name), callback);
    }

    function themeFromElement(element) {
        if (!element) {
            return null;
        }

        var attr = normalizeTheme(element.getAttribute('data-theme'));

        if (attr) {
            return attr;
        }

        for (var i = 0; i < themes.length; i++) {
            if (element.classList.contains(themes[i])) {
                return themes[i];
            }
        }

        if (element.classList.contains('lightness')) {
            return 'evolightness';
        }
        if (element.classList.contains('darkness')) {
            return 'evodarkness';
        }
        if (element.classList.contains('light')) {
            return defaultLight;
        }
        if (element.classList.contains('dark')) {
            return defaultDark;
        }

        return null;
    }

    function readParentTheme() {
        try {
            if (!window.parent || window.parent === window || !window.parent.document) {
                return null;
            }

            var parentDocument = window.parent.document;

            return themeFromElement(parentDocument.documentElement)
                || themeFromElement(parentDocument.body)
                || readStoredTheme(window.parent)
                || readCookieTheme(window.parent);
        } catch (error) {
            return null;
        }
    }

    function readStoredTheme(sourceWindow) {
        var mode = readStorage('evo.mode', sourceWindow);
        var evoThemeMode = readStorage('EVO_themeMode', sourceWindow);
        var modeTheme = null;
        var numericTheme = null;

        if (mode === 'dark') {
            modeTheme = normalizeTheme(readStorage('evo.theme.dark', sourceWindow));
        } else if (mode === 'light') {
            modeTheme = normalizeTheme(readStorage('evo.theme.light', sourceWindow));
        }

        if (evoThemeMode !== null && !Number.isNaN(parseInt(evoThemeMode, 10))) {
            numericTheme = normalizeTheme(managerThemeModes[parseInt(evoThemeMode, 10)] || null);
        }

        return normalizeTheme(readStorage('evo.theme', sourceWindow))
            || modeTheme
            || normalizeTheme(readStorage('evo.blogDaisyui.theme', sourceWindow))
            || numericTheme;
    }

    function readCookieTheme(sourceWindow) {
        var sourceDocument = sourceWindow && sourceWindow.document ? sourceWindow.document : document;
        var value = readCookie('EVO_themeMode', sourceDocument);

        return value !== null && !Number.isNaN(parseInt(value, 10))
            ? normalizeTheme(managerThemeModes[parseInt(value, 10)] || null)
            : null;
    }

    function fallbackTheme() {
        return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches
            ? defaultDark
            : defaultLight;
    }

    function applyTheme(theme) {
        theme = normalizeTheme(theme) || fallbackTheme();
        root.setAttribute('data-theme', theme);
        root.setAttribute('data-theme-mode', themeMode(theme));

        if (document.body) {
            applyPlatformClasses();
            document.body.classList.add('evo-ui-page');
            document.body.setAttribute('data-theme', theme);
            document.body.setAttribute('data-theme-mode', themeMode(theme));
            document.body.classList.toggle('dark', themeMode(theme) === 'dark');
            document.body.classList.toggle('darkness', theme === 'evodarkness');
            document.body.classList.toggle('light', theme === 'evolight');
            document.body.classList.toggle('lightness', theme === 'evolightness');
        }

        document.querySelectorAll('[data-evo-ui-root]').forEach(function (element) {
            element.setAttribute('data-theme', theme);
            element.setAttribute('data-theme-mode', themeMode(theme));
            element.classList.toggle('dark', themeMode(theme) === 'dark');
            element.classList.toggle('darkness', theme === 'evodarkness');
            element.classList.toggle('light', theme === 'evolight');
            element.classList.toggle('lightness', theme === 'evolightness');
        });

        dispatch('theme.changed', {theme: theme, mode: themeMode(theme)});
    }

    function hydrateTheme() {
        applyTheme(readParentTheme() || readStoredTheme(window) || readCookieTheme(window) || fallbackTheme());
    }

    function currentTheme() {
        return normalizeTheme(root.getAttribute('data-theme'));
    }

    function syncThemeIfChanged() {
        var theme = readParentTheme() || readStoredTheme(window) || readCookieTheme(window) || fallbackTheme();

        if (theme && theme !== currentTheme()) {
            applyTheme(theme);
        }
    }

    function observeParentTheme() {
        try {
            if (!window.parent || window.parent === window || !window.parent.document || !window.MutationObserver) {
                return;
            }

            var observer = new MutationObserver(syncThemeIfChanged);
            observer.observe(window.parent.document.documentElement, {
                attributes: true,
                attributeFilter: ['class', 'data-theme', 'data-theme-mode']
            });

            if (window.parent.document.body) {
                observer.observe(window.parent.document.body, {
                    attributes: true,
                    attributeFilter: ['class', 'data-theme', 'data-theme-mode']
                });
            }
        } catch (error) {
        }
    }

    function initLayout(layout) {
        if (layout.__evoInitialized) {
            return;
        }

        layout.__evoInitialized = true;

        var slider = Array.prototype.find.call(layout.children, function (child) {
            return child.matches && child.matches('[data-evo-layout-slider]');
        });
        var firstPane = Array.prototype.find.call(layout.children, function (child) {
            return child.matches && child.matches('[data-role="layout-pane"]');
        });

        if (!slider || !firstPane || slider.classList.contains('is-disabled')) {
            return;
        }

        var type = layout.getAttribute('data-layout-type') || 'horizontal';
        var key = 'evo-ui.layout.' + (layout.getAttribute('data-key') || type);
        var stored = window.localStorage ? window.localStorage.getItem(key) : null;

        if (stored) {
            firstPane.style[type === 'vertical' ? 'height' : 'width'] = stored + '%';
        }

        function startResize(event) {
            if (event.button !== undefined && event.button !== 0) {
                return;
            }

            event.preventDefault();
            event.stopPropagation();

            var start = type === 'vertical' ? event.clientY : event.clientX;
            var startSize = type === 'vertical' ? firstPane.offsetHeight : firstPane.offsetWidth;
            var parentSize = type === 'vertical' ? layout.clientHeight : layout.clientWidth;

            if (!parentSize) {
                return;
            }

            document.body.classList.add('evo-ui-disable-selection');

            function move(moveEvent) {
                var current = type === 'vertical' ? moveEvent.clientY : moveEvent.clientX;
                var next = Math.max(5, Math.min(95, Math.round(((startSize + current - start) / parentSize) * 100)));
                firstPane.style[type === 'vertical' ? 'height' : 'width'] = next + '%';
                layout.__evoNextSize = next;
            }

            function up() {
                document.removeEventListener('pointermove', move);
                document.removeEventListener('pointerup', up);
                document.removeEventListener('pointercancel', up);
                document.body.classList.remove('evo-ui-disable-selection');

                if (layout.__evoNextSize && window.localStorage) {
                    window.localStorage.setItem(key, String(layout.__evoNextSize));
                }

                window.dispatchEvent(new Event('resize'));
                dispatch('layout.resize', {key: key, size: layout.__evoNextSize || null});
            }

            document.addEventListener('pointermove', move);
            document.addEventListener('pointerup', up);
            document.addEventListener('pointercancel', up);
        }

        slider.addEventListener('pointerdown', startResize);
    }

    function managerTree() {
        try {
            return window.parent && window.parent !== window ? window.parent.tree : null;
        } catch (error) {
            return null;
        }
    }

    function livewireComponent(element) {
        var componentRoot = element.closest && element.closest('[wire\\:id]');

        if (!componentRoot || !window.Livewire || typeof window.Livewire.find !== 'function') {
            return null;
        }

        return window.Livewire.find(componentRoot.getAttribute('wire:id'));
    }

    function evoBuilderRows(list) {
        return Array.prototype.filter.call(list.querySelectorAll('[data-evo-builder-row]'), function (row) {
            return !row.matches('[data-evo-builder-placeholder]');
        });
    }

    function evoBuilderRowAfter(list, y, dragged) {
        return evoBuilderRows(list).reduce(function (closest, child) {
            if (child === dragged || child.classList.contains('is-dragging')) {
                return closest;
            }

            var box = child.getBoundingClientRect();
            var offset = y - box.top - box.height / 2;

            if (offset < 0 && offset > closest.offset) {
                return {offset: offset, element: child};
            }

            return closest;
        }, {offset: Number.NEGATIVE_INFINITY, element: null}).element;
    }

    function evoBuilderLists(rootElement) {
        var lists = rootElement.querySelectorAll('[data-evo-builder-list]');

        return lists.length ? Array.prototype.slice.call(lists) : [rootElement];
    }

    function evoBuilderPayload(rootElement) {
        return evoBuilderLists(rootElement).map(function (list, listIndex) {
            return {
                key: list.getAttribute('data-evo-builder-list') || String(listIndex),
                parent_id: list.getAttribute('data-evo-builder-parent-id') || '',
                item_ids: evoBuilderRows(list).map(function (row) {
                    return row.getAttribute('data-evo-builder-id') || '';
                }).filter(Boolean),
                items: evoBuilderRows(list).map(function (row, index) {
                    return {
                        id: row.getAttribute('data-evo-builder-id') || '',
                        type: row.getAttribute('data-evo-builder-row-type') || '',
                        index: index
                    };
                })
            };
        });
    }

    function initBuilder(rootElement) {
        if (!rootElement || rootElement.__evoBuilderInitialized) {
            return;
        }

        rootElement.__evoBuilderInitialized = true;
        var dragged = null;
        var placeholder = document.createElement('div');
        placeholder.className = 'evo-ui-builder-placeholder';
        placeholder.setAttribute('data-evo-builder-placeholder', 'true');

        function cleanup() {
            if (placeholder.parentNode) {
                placeholder.parentNode.removeChild(placeholder);
            }

            rootElement.querySelectorAll('.is-dragging, .is-drag-hidden, .is-drag-over').forEach(function (node) {
                node.classList.remove('is-dragging', 'is-drag-hidden', 'is-drag-over');
            });

            dragged = null;
        }

        rootElement.addEventListener('dragstart', function (event) {
            var handle = event.target && event.target.closest ? event.target.closest('[data-evo-drag-handle]') : null;
            var row = event.target && event.target.closest ? event.target.closest('[data-evo-builder-row]') : null;

            if (!row || !rootElement.contains(row)) {
                return;
            }

            if (!handle && event.target !== row) {
                event.preventDefault();
                return;
            }

            dragged = row;
            row.classList.add('is-dragging');

            var box = row.getBoundingClientRect();
            placeholder.style.minHeight = Math.max(10, Math.round(box.height)) + 'px';
            placeholder.style.height = Math.max(10, Math.round(box.height)) + 'px';

            if (event.dataTransfer) {
                event.dataTransfer.effectAllowed = 'move';
                event.dataTransfer.setData('text/plain', row.getAttribute('data-evo-builder-id') || '');
            }
        });

        rootElement.addEventListener('dragover', function (event) {
            var list = event.target && event.target.closest ? event.target.closest('[data-evo-builder-list]') : rootElement;

            if (!dragged || !list || !rootElement.contains(list)) {
                return;
            }

            event.preventDefault();
            list.classList.add('is-drag-over');

            var after = evoBuilderRowAfter(list, event.clientY, dragged);
            list.insertBefore(placeholder, after || null);
            dragged.classList.add('is-drag-hidden');
        });

        rootElement.addEventListener('dragleave', function (event) {
            var list = event.target && event.target.closest ? event.target.closest('[data-evo-builder-list]') : null;

            if (list && !list.contains(event.relatedTarget)) {
                list.classList.remove('is-drag-over');
            }
        });

        rootElement.addEventListener('drop', function (event) {
            if (!dragged || !placeholder.parentNode) {
                return;
            }

            event.preventDefault();
            placeholder.parentNode.insertBefore(dragged, placeholder);
            dragged.classList.remove('is-drag-hidden');

            var component = livewireComponent(rootElement);
            var method = rootElement.getAttribute('data-evo-builder-reorder-method') || 'reorderBuilderRows';

            if (component && method && typeof component.call === 'function') {
                component.call(method, evoBuilderPayload(rootElement));
            }

            cleanup();
        });

        rootElement.addEventListener('dragend', cleanup);
    }

    function dndSelector(rootElement, key, fallback) {
        return rootElement.getAttribute('data-evo-dnd-' + key + '-selector') || fallback;
    }

    function dndUid(row, type) {
        return row.getAttribute('data-evo-dnd-uid') ||
            row.getAttribute('data-evo-dnd-' + type + '-uid') ||
            row.getAttribute('data-' + type + '-uid') ||
            '';
    }

    function dndRows(container, selector, placeholder) {
        return Array.prototype.filter.call(container ? container.querySelectorAll(selector) : [], function (row) {
            return row !== placeholder;
        });
    }

    function dndCall(rootElement, method, args) {
        var component = livewireComponent(rootElement);
        var result = null;

        dispatch('dnd.changed', {method: method, args: args}, rootElement);

        if (component && method && typeof component[method] === 'function') {
            result = component[method].apply(component, args);
        } else if (component && method && typeof component.call === 'function') {
            result = component.call.apply(component, [method].concat(args));
        } else if (component && method && typeof component.$call === 'function') {
            result = component.$call.apply(component, [method].concat(args));
        }

        if (result && typeof result.finally === 'function') {
            result.finally(function () {
                window.setTimeout(function () {
                    init(rootElement);
                }, 0);
            });
        }
    }

    function markDndDirty(rootElement, source) {
        var form = rootElement.closest && rootElement.closest('[data-evo-form]') ||
            rootElement.querySelector && rootElement.querySelector('[data-evo-form]');
        var surface = form && form.closest ? form.closest('[data-evo-form-dirty], .evo-ui-form-surface') : null;

        if (!surface && rootElement.closest) {
            surface = rootElement.closest('[data-evo-form-dirty], .evo-ui-form-surface');
        }

        if (surface) {
            surface.setAttribute('data-evo-form-dirty', 'true');
            surface.setAttribute('data-evo-form-saved', 'false');
        }

        if (form) {
            form.setAttribute('data-evo-form-dirty', 'true');
            form.dispatchEvent(new Event('change', {bubbles: true}));
        }

        dispatch('form.dirty', {source: source}, rootElement);
        dispatch('form-dirty', {source: source}, rootElement);
    }

    function initDnd(rootElement) {
        if (!rootElement || rootElement.__evoDndInitialized) {
            return;
        }

        rootElement.__evoDndInitialized = true;

        var selectors = {
            group: dndSelector(rootElement, 'group', '[data-evo-dnd-group]'),
            item: dndSelector(rootElement, 'item', '[data-evo-dnd-item]'),
            list: dndSelector(rootElement, 'list', '[data-evo-dnd-list]'),
            optionList: dndSelector(rootElement, 'option-list', '[data-evo-dnd-option-list]'),
            optionRow: dndSelector(rootElement, 'option-row', '[data-evo-dnd-option-row]'),
            handle: dndSelector(rootElement, 'handle', '[data-evo-dnd-handle]'),
            dropzone: dndSelector(rootElement, 'dropzone', '[data-evo-dnd-dropzone]'),
            modal: dndSelector(rootElement, 'modal', '.evo-ui-modal')
        };
        var groupMethod = rootElement.getAttribute('data-evo-dnd-group-method') || 'sortGroupByUid';
        var itemMethod = rootElement.getAttribute('data-evo-dnd-item-method') || 'sortItemByUid';
        var optionMethod = rootElement.getAttribute('data-evo-dnd-option-method') || '';
        var payloadType = rootElement.getAttribute('data-evo-dnd-payload-type') || 'application/x-evo-dnd';
        var optionRoot = rootElement.matches && rootElement.matches(selectors.optionList);
        var dragged = null;
        var placeholder = null;
        var handleRow = null;
        var payload = null;
        var stateTarget = null;
        var optionPointerDrag = null;
        var nativeDragImage = null;
        var tableDragPreview = null;

        function eventTarget(event) {
            if (
                typeof event.clientX === 'number' &&
                typeof event.clientY === 'number' &&
                document.elementFromPoint
            ) {
                return document.elementFromPoint(event.clientX, event.clientY) || event.target;
            }

            return event.target;
        }

        function rowType(row) {
            if (row && row.matches(selectors.group)) {
                return 'group';
            }

            if (row && row.matches(selectors.optionRow)) {
                return 'option';
            }

            return 'item';
        }

        function rowFromTarget(target) {
            return target && target.closest ? target.closest(selectors.group + ', ' + selectors.item + ', ' + selectors.optionRow) : null;
        }

        function ownerDndRoot(target) {
            return target && target.closest ? target.closest('[data-evo-dnd]') : null;
        }

        function belongsToRoot(target) {
            var owner = ownerDndRoot(target);
            return !owner || owner === rootElement;
        }

        function isInteractiveTarget(target) {
            return target && target.closest && target.closest('input, select, textarea, button, a, [contenteditable="true"]');
        }

        function createPlaceholder(type, row) {
            if (row && row.tagName && row.tagName.toLowerCase() === 'tr') {
                var tr = document.createElement('tr');
                var td = document.createElement('td');
                var inner = document.createElement('div');

                tr.className = 'evo-ui-dnd-placeholder evo-ui-dnd-placeholder--' + type + ' evo-ui-dnd-placeholder--table-row';
                td.colSpan = Math.max(1, row.children ? row.children.length : 1);
                inner.className = 'evo-ui-dnd-placeholder__table-inner';
                td.appendChild(inner);
                tr.appendChild(td);

                return tr;
            }

            var div = document.createElement('div');
            div.className = 'evo-ui-dnd-placeholder evo-ui-dnd-placeholder--' + type;

            return div;
        }

        function stripReactivePreviewAttributes(node) {
            if (!node || !node.querySelectorAll) {
                return;
            }

            [node].concat(Array.prototype.slice.call(node.querySelectorAll('*'))).forEach(function (element) {
                if (!element.getAttributeNames) {
                    return;
                }

                element.getAttributeNames().forEach(function (name) {
                    if (
                        name === 'wire:key' ||
                        name.indexOf('wire:') === 0 ||
                        name.indexOf('x-') === 0 ||
                        name.indexOf(':') === 0 ||
                        name.indexOf('@') === 0
                    ) {
                        element.removeAttribute(name);
                    }
                });
            });
        }

        function removeNativeDragImage() {
            if (nativeDragImage && nativeDragImage.parentNode) {
                nativeDragImage.parentNode.removeChild(nativeDragImage);
            }

            nativeDragImage = null;
        }

        function createTransparentNativeDragImage() {
            var preview = document.createElement('div');

            preview.className = 'evo-ui-dnd-floating-preview evo-ui-dnd-floating-preview--transparent';
            preview.setAttribute('aria-hidden', 'true');
            preview.style.width = '1px';
            preview.style.height = '1px';

            document.body.appendChild(preview);
            nativeDragImage = preview;

            return preview;
        }

        function createNativeDragImage(row) {
            var isTableRow = row.tagName && row.tagName.toLowerCase() === 'tr';

            if (isTableRow) {
                return createTransparentNativeDragImage();
            }

            return row;
        }

        function createTableDragPreview(row, event) {
            if (!row || !row.tagName || row.tagName.toLowerCase() !== 'tr') {
                return null;
            }

            var box = row.getBoundingClientRect();
            var table = document.createElement('table');
            var tbody = document.createElement('tbody');
            var clone = row.cloneNode(true);
            var sourceCells = Array.prototype.slice.call(row.children || []);
            var cloneCells = Array.prototype.slice.call(clone.children || []);

            clone.classList.remove('is-dragging', 'is-drag-hidden', 'is-drag-over', 'is-drop-target');
            clone.removeAttribute('id');
            clone.removeAttribute('wire:key');
            clone.removeAttribute('draggable');
            stripReactivePreviewAttributes(clone);

            cloneCells.forEach(function (cell, index) {
                var source = sourceCells[index];
                if (!source || !source.getBoundingClientRect) {
                    return;
                }

                cell.style.width = Math.max(1, Math.round(source.getBoundingClientRect().width)) + 'px';
            });

            table.className = 'evo-ui-table evo-ui-dnd-floating-preview evo-ui-dnd-floating-preview--table';
            table.setAttribute('aria-hidden', 'true');
            table.style.width = Math.ceil(box.width) + 'px';
            table.style.height = Math.ceil(box.height) + 'px';

            tbody.appendChild(clone);
            table.appendChild(tbody);
            document.body.appendChild(table);

            return {
                preview: table,
                offsetX: event.clientX - box.left,
                offsetY: event.clientY - box.top
            };
        }

        function ensurePlaceholder(type, row) {
            if (placeholder && placeholder.getAttribute('data-evo-dnd-placeholder-type') === type) {
                return placeholder;
            }

            removePlaceholder();
            placeholder = createPlaceholder(type, row);
            placeholder.setAttribute('data-evo-dnd-placeholder', 'true');
            placeholder.setAttribute('data-evo-dnd-placeholder-type', type);
            syncPlaceholderSize(row);

            return placeholder;
        }

        function isStateOwnedOption(type) {
            return type === 'option' && !optionMethod;
        }

        function syncPlaceholderSize(row) {
            if (!placeholder || !row || !row.getBoundingClientRect) {
                return;
            }

            var box = row.getBoundingClientRect();
            var measuredHeight = Math.ceil(box.height);
            var previousHeight = parseInt(placeholder.getAttribute('data-evo-dnd-placeholder-height') || '0', 10) || 0;
            var height = Math.max(10, measuredHeight || previousHeight);
            var target = placeholder.querySelector
                ? (placeholder.querySelector('.evo-ui-dnd-placeholder__table-inner') || placeholder)
                : placeholder;
            if (measuredHeight > 0) {
                placeholder.setAttribute('data-evo-dnd-placeholder-height', String(height));
            }

            placeholder.style.minHeight = height + 'px';
            placeholder.style.height = height + 'px';
            target.style.minHeight = height + 'px';
            target.style.height = height + 'px';
        }

        function removePlaceholder() {
            if (placeholder && placeholder.parentNode) {
                placeholder.parentNode.removeChild(placeholder);
            }

            placeholder = null;
        }

        function clear() {
            removeOptionPointerPreview();
            removeTableDragPreview();
            removeNativeDragImage();
            removePlaceholder();
            rootElement.classList.remove('is-dnd-group', 'is-dnd-item', 'is-dnd-option', 'is-dnd-handle-armed', 'is-drag-over', 'is-drop-target');
            rootElement.querySelectorAll('.is-dragging, .is-drag-hidden, .is-drag-over, .is-drop-target').forEach(function (node) {
                node.classList.remove('is-dragging', 'is-drag-hidden', 'is-drag-over', 'is-drop-target');
            });
            dragged = null;
            handleRow = null;
            payload = null;
            stateTarget = null;
            optionPointerDrag = null;
            tableDragPreview = null;
        }

        function removeOptionPointerPreview() {
            if (optionPointerDrag && optionPointerDrag.preview && optionPointerDrag.preview.parentNode) {
                optionPointerDrag.preview.parentNode.removeChild(optionPointerDrag.preview);
            }
        }

        function removeTableDragPreview() {
            if (tableDragPreview && tableDragPreview.preview && tableDragPreview.preview.parentNode) {
                tableDragPreview.preview.parentNode.removeChild(tableDragPreview.preview);
            }
        }

        function armHandle(handle) {
            if (!handle || !rootElement.contains(handle) || !belongsToRoot(handle)) {
                handleRow = null;
                return null;
            }

            handleRow = rowFromTarget(handle);
            if (!optionRoot && handleRow && handleRow.matches(selectors.optionRow)) {
                handleRow.setAttribute('draggable', 'true');
            }

            if (!optionRoot) {
                handle.setAttribute('draggable', 'true');
            }

            return handleRow;
        }

        function listForRow(row, type) {
            if (!row) {
                return null;
            }

            if (type === 'group') {
                return rootElement;
            }

            return row.closest(type === 'option' ? selectors.optionList : selectors.list) || rootElement;
        }

        function containerFromEvent(event, type) {
            var target = eventTarget(event);

            if (type === 'group') {
                return rootElement;
            }

            return target && target.closest ? target.closest(type === 'option' ? selectors.optionList : selectors.list) : null;
        }

        function rowAfter(container, selector, y) {
            return dndRows(container, selector, placeholder).reduce(function (closest, child) {
                if (child === dragged || child.classList.contains('is-dragging')) {
                    return closest;
                }

                var box = child.getBoundingClientRect();
                var offset = y - box.top - box.height / 2;

                if (offset < 0 && offset > closest.offset) {
                    return {offset: offset, element: child};
                }

                return closest;
            }, {offset: Number.NEGATIVE_INFINITY, element: null}).element;
        }

        function insertPlaceholder(container, before) {
            if (!container || !placeholder) {
                return false;
            }

            syncPlaceholderSize(dragged);
            container.insertBefore(placeholder, before || null);
            container.classList.add('is-drag-over');
            dragged.classList.add('is-dragging');

            return true;
        }

        function positionFromPlaceholder(container, type) {
            if (!container || !placeholder || !placeholder.parentNode) {
                return null;
            }

            var selector = type === 'group' ? selectors.group : (type === 'option' ? selectors.optionRow : selectors.item);
            var rows = dndRows(container, selector, placeholder).filter(function (row) {
                return row !== dragged && (row.compareDocumentPosition(placeholder) & Node.DOCUMENT_POSITION_FOLLOWING);
            });
            var group = type === 'item' ? container.closest(selectors.group) : null;

            return {
                position: rows.length,
                groupUid: group ? dndUid(group, 'group') : (container.getAttribute('data-evo-dnd-group-uid') || container.getAttribute('data-evo-dnd-uid') || '')
            };
        }

        function moveStateOwnedOptionTarget(event) {
            var container = containerFromEvent(event, 'option') || listForRow(dragged, 'option');

            if (!container) {
                return false;
            }

            ensurePlaceholder('option', dragged);
            var before = rowAfter(container, selectors.optionRow, event.clientY);
            if (!insertPlaceholder(container, before)) {
                return false;
            }

            stateTarget = positionFromPlaceholder(container, 'option');
            return Boolean(stateTarget);
        }

        function movePlaceholder(event) {
            if (!dragged || !payload) {
                return false;
            }

            var type = payload.type;

            if (isStateOwnedOption(type)) {
                return moveStateOwnedOptionTarget(event);
            }

            var container = containerFromEvent(event, type) || listForRow(dragged, type);
            var selector = type === 'group' ? selectors.group : (type === 'option' ? selectors.optionRow : selectors.item);
            var dropzone = event.target && event.target.closest ? event.target.closest(selectors.dropzone) : null;

            ensurePlaceholder(type, dragged);

            if (dropzone && rootElement.contains(dropzone)) {
                dropzone.classList.add('is-drop-target');
                return insertPlaceholder(dropzone.parentNode, dropzone);
            }

            return insertPlaceholder(container, rowAfter(container, selector, event.clientY));
        }

        function createOptionPointerPreview(row, event) {
            var box = row.getBoundingClientRect();
            var preview = row.cloneNode(true);

            preview.classList.remove('is-dragging', 'is-drag-hidden', 'is-drag-over', 'is-drop-target');
            preview.classList.add('evo-ui-dnd-floating-preview');
            preview.setAttribute('aria-hidden', 'true');
            preview.style.width = Math.ceil(box.width) + 'px';
            preview.style.height = Math.ceil(box.height) + 'px';
            stripReactivePreviewAttributes(preview);
            preview.setAttribute('x-ignore', '');

            Array.prototype.forEach.call(preview.querySelectorAll('input, textarea, select, button'), function (control) {
                control.setAttribute('tabindex', '-1');
                control.setAttribute('disabled', 'disabled');
            });

            document.body.appendChild(preview);

            return {
                preview: preview,
                offsetX: event.clientX - box.left,
                offsetY: event.clientY - box.top
            };
        }

        function updateOptionPointerPreview(event) {
            if (!optionPointerDrag || !optionPointerDrag.preview) {
                return;
            }

            var x = Math.round(event.clientX - optionPointerDrag.offsetX);
            var y = Math.round(event.clientY - optionPointerDrag.offsetY);

            optionPointerDrag.preview.style.transform = 'translate3d(' + x + 'px, ' + y + 'px, 0)';
        }

        function updateTableDragPreview(event) {
            if (!tableDragPreview || !tableDragPreview.preview) {
                return;
            }

            var x = Math.round(event.clientX - tableDragPreview.offsetX);
            var y = Math.round(event.clientY - tableDragPreview.offsetY);

            tableDragPreview.preview.style.transform = 'translate3d(' + x + 'px, ' + y + 'px, 0)';
        }

        function finishOptionPointerDrag(event, cancelled) {
            if (!optionPointerDrag) {
                return;
            }

            if (!cancelled) {
                moveStateOwnedOptionTarget(event);
            }

            var target = cancelled ? null : targetPosition('option');
            var uid = payload ? payload.uid : '';
            var method = optionMethod;

            if (optionPointerDrag.handle && optionPointerDrag.handle.releasePointerCapture) {
                try {
                    optionPointerDrag.handle.releasePointerCapture(optionPointerDrag.pointerId);
                } catch (error) {
                    // The pointer may already be released by the browser.
                }
            }

            document.removeEventListener('pointermove', handleOptionPointerMove, true);
            document.removeEventListener('pointerup', handleOptionPointerUp, true);
            document.removeEventListener('pointercancel', handleOptionPointerCancel, true);

            if (!target || !uid) {
                clear();
                return;
            }

            if (method) {
                commitDom();
                clear();
                markDndDirty(rootElement, 'dnd-option');
                dndCall(rootElement, method, [uid, target.position]);
            } else {
                clear();
                dispatch('dnd.option.changed', {uid: uid, position: target.position}, rootElement);
                dispatch('dnd-option-changed', {uid: uid, position: target.position}, rootElement);
                markDndDirty(rootElement, 'dnd-option');
            }
        }

        function handleOptionPointerMove(event) {
            if (!optionPointerDrag || event.pointerId !== optionPointerDrag.pointerId) {
                return;
            }

            event.preventDefault();
            event.stopPropagation();
            updateOptionPointerPreview(event);
            moveStateOwnedOptionTarget(event);
        }

        function handleOptionPointerUp(event) {
            if (!optionPointerDrag || event.pointerId !== optionPointerDrag.pointerId) {
                return;
            }

            event.preventDefault();
            event.stopPropagation();
            finishOptionPointerDrag(event, false);
        }

        function handleOptionPointerCancel(event) {
            if (!optionPointerDrag || event.pointerId !== optionPointerDrag.pointerId) {
                return;
            }

            finishOptionPointerDrag(event, true);
        }

        function startOptionPointerDrag(event, handle) {
            if (!optionRoot || !handle || !rootElement.contains(handle) || !belongsToRoot(handle)) {
                return false;
            }

            if (typeof event.button === 'number' && event.button !== 0) {
                return false;
            }

            var row = rowFromTarget(handle);

            if (!row || rowType(row) !== 'option' || !belongsToRoot(row)) {
                return false;
            }

            var uid = dndUid(row, 'option');

            if (!uid) {
                return false;
            }

            event.preventDefault();
            event.stopPropagation();

            dragged = row;
            handleRow = row;
            payload = {
                type: 'option',
                uid: uid,
                sourceGroupUid: ''
            };
            optionPointerDrag = {
                pointerId: event.pointerId,
                handle: handle
            };

            Object.assign(optionPointerDrag, createOptionPointerPreview(row, event));

            rootElement.classList.add('is-dnd-option', 'is-dnd-handle-armed');
            updateOptionPointerPreview(event);
            moveStateOwnedOptionTarget(event);

            if (handle.setPointerCapture && typeof event.pointerId !== 'undefined') {
                try {
                    handle.setPointerCapture(event.pointerId);
                } catch (error) {
                    // Some embedded manager contexts do not allow pointer capture.
                }
            }

            document.addEventListener('pointermove', handleOptionPointerMove, true);
            document.addEventListener('pointerup', handleOptionPointerUp, true);
            document.addEventListener('pointercancel', handleOptionPointerCancel, true);

            window.requestAnimationFrame(function () {
                if (dragged === row) {
                    row.classList.add('is-drag-hidden');
                }
            });

            return true;
        }

        function targetPosition(type) {
            if (isStateOwnedOption(type)) {
                return stateTarget;
            }

            if (!placeholder || !placeholder.parentNode) {
                return null;
            }

            var parent = placeholder.parentNode;
            return positionFromPlaceholder(parent, type);
        }

        function commitDom() {
            if (dragged && placeholder && placeholder.parentNode) {
                placeholder.parentNode.insertBefore(dragged, placeholder);
                dragged.classList.remove('is-dragging', 'is-drag-hidden');
            }
        }

        rootElement.addEventListener('pointerdown', function (event) {
            var handle = event.target && event.target.closest ? event.target.closest(selectors.handle) : null;

            if (optionRoot) {
                startOptionPointerDrag(event, handle);
                return;
            }

            if (!handle || !rootElement.contains(handle)) {
                handleRow = null;
                return;
            }

            var row = armHandle(handle);

            if (row) {
                event.stopPropagation();
                rootElement.classList.add('is-dnd-handle-armed');
            }
        }, true);

        rootElement.addEventListener('mousedown', function (event) {
            if (optionRoot) {
                return;
            }

            var handle = event.target && event.target.closest ? event.target.closest(selectors.handle) : null;

            if (handle && rootElement.contains(handle)) {
                if (armHandle(handle)) {
                    event.stopPropagation();
                    rootElement.classList.add('is-dnd-handle-armed');
                }
            }
        }, true);

        rootElement.addEventListener('touchstart', function (event) {
            if (optionRoot) {
                return;
            }

            var handle = event.target && event.target.closest ? event.target.closest(selectors.handle) : null;

            if (handle && rootElement.contains(handle)) {
                if (armHandle(handle)) {
                    event.stopPropagation();
                    rootElement.classList.add('is-dnd-handle-armed');
                }
            }
        }, true);

        rootElement.addEventListener('selectstart', function (event) {
            var handle = event.target && event.target.closest ? event.target.closest(selectors.handle) : null;

            if (!handle || !rootElement.contains(handle)) {
                return;
            }

            event.preventDefault();
        }, true);

        rootElement.addEventListener('dragstart', function (event) {
            if (optionRoot) {
                event.preventDefault();
                return;
            }

            var handle = event.target && event.target.closest ? event.target.closest(selectors.handle) : null;
            var handleTargetRow = handle && rootElement.contains(handle) ? armHandle(handle) : null;
            var row = handleTargetRow || rowFromTarget(event.target);
            var type = rowType(row);

            if (!row || !rootElement.contains(row) || event.target.closest(selectors.modal) && type !== 'option') {
                return;
            }

            if (!belongsToRoot(row)) {
                return;
            }

            if (handleTargetRow) {
                handleRow = handleTargetRow;
            }

            if (isInteractiveTarget(event.target) && row !== handleRow && !handle) {
                event.preventDefault();
                return;
            }

            if (type === 'option' && row !== handleRow) {
                handleRow = row;
            }

            if (row !== handleRow && event.target !== row && !handle) {
                event.preventDefault();
                return;
            }

            payload = {
                type: type,
                uid: dndUid(row, type),
                sourceGroupUid: type === 'item' ? (row.closest(selectors.group) ? dndUid(row.closest(selectors.group), 'group') : '') : ''
            };

            if (!payload.uid) {
                event.preventDefault();
                payload = null;
                return;
            }

            dragged = row;
            rootElement.classList.add('is-dnd-' + type);

            if (event.dataTransfer) {
                var serialized = JSON.stringify(payload);
                var box = row.getBoundingClientRect();
                var dragImage = createNativeDragImage(row);
                event.dataTransfer.effectAllowed = 'move';
                event.dataTransfer.setData('text/plain', serialized);
                event.dataTransfer.setData(payloadType, serialized);
                event.dataTransfer.setDragImage(
                    dragImage,
                    Math.max(0, Math.min(event.clientX - box.left, box.width)),
                    Math.max(0, Math.min(event.clientY - box.top, box.height))
                );
            }

            tableDragPreview = createTableDragPreview(row, event);
            updateTableDragPreview(event);

            if (window.getSelection) {
                var selection = window.getSelection();
                if (selection && typeof selection.removeAllRanges === 'function') {
                    selection.removeAllRanges();
                }
            }

            if (isStateOwnedOption(type)) {
                moveStateOwnedOptionTarget(event);
                window.requestAnimationFrame(function () {
                    if (dragged === row) {
                        row.classList.add('is-drag-hidden');
                    }
                });
            } else {
                ensurePlaceholder(type, row);
                insertPlaceholder(listForRow(row, type), row.nextElementSibling);
                window.requestAnimationFrame(function () {
                    if (dragged === row) {
                        row.classList.add('is-drag-hidden');
                    }
                });
            }
        }, true);

        rootElement.addEventListener('dragover', function (event) {
            updateTableDragPreview(event);

            if (!dragged || !payload || !movePlaceholder(event)) {
                return;
            }

            event.preventDefault();
            event.stopPropagation();

            if (event.dataTransfer) {
                event.dataTransfer.dropEffect = 'move';
            }
        }, true);

        rootElement.addEventListener('drop', function (event) {
            if (!dragged || !payload) {
                return;
            }

            event.preventDefault();
            event.stopPropagation();

            movePlaceholder(event);

            var type = payload.type;
            var target = targetPosition(type);
            var uid = payload.uid;

            if (!target) {
                clear();
                return;
            }

            if (type === 'group') {
                commitDom();
                clear();
                markDndDirty(rootElement, 'dnd-group');
                dndCall(rootElement, groupMethod, [uid, target.position]);
            } else if (type === 'item') {
                commitDom();
                clear();
                markDndDirty(rootElement, 'dnd-item');
                dndCall(rootElement, itemMethod, [uid, target.position, target.groupUid]);
            } else if (optionMethod) {
                commitDom();
                clear();
                markDndDirty(rootElement, 'dnd-option');
                dndCall(rootElement, optionMethod, [uid, target.position]);
            } else {
                clear();
                dispatch('dnd.option.changed', {uid: uid, position: target.position}, rootElement);
                dispatch('dnd-option-changed', {uid: uid, position: target.position}, rootElement);
                markDndDirty(rootElement, 'dnd-option');
            }
        }, true);

        rootElement.addEventListener('dragend', clear, true);
    }

    function issueKanbanCardAfter(list, y) {
        return Array.prototype.reduce.call(
            list.querySelectorAll('[data-evo-issue-card]:not(.is-dragging)'),
            function (closest, child) {
                var box = child.getBoundingClientRect();
                var offset = y - box.top - box.height / 2;

                if (offset < 0 && offset > closest.offset) {
                    return {offset: offset, element: child};
                }

                return closest;
            },
            {offset: Number.NEGATIVE_INFINITY, element: null}
        ).element;
    }

    function issueKanbanLanePayload(board) {
        return Array.prototype.map.call(board.querySelectorAll('[data-evo-issue-lane]'), function (lane) {
            return {
                status_id: parseInt(lane.getAttribute('data-status-id') || '0', 10) || 0,
                issue_ids: Array.prototype.map.call(lane.querySelectorAll('[data-evo-issue-card]'), function (card) {
                    return parseInt(card.getAttribute('data-issue-id') || '0', 10) || 0;
                }).filter(function (id) {
                    return id > 0;
                })
            };
        }).filter(function (lane) {
            return lane.status_id > 0;
        });
    }

    function issueKanbanSyncLane(lane) {
        if (!lane) {
            return;
        }

        var count = lane.querySelectorAll('[data-evo-issue-card]').length;
        var empty = lane.querySelector('[data-evo-issue-empty]');
        var wrapper = lane.closest ? lane.closest('.evo-ui-issue-kanban__lane') : null;
        var countNode = wrapper ? wrapper.querySelector('[data-evo-issue-count]') : null;

        lane.classList.toggle('is-empty', count === 0);
        lane.classList.toggle('has-issue-cards', count > 0);

        if (empty) {
            empty.hidden = count > 0;
        }

        if (countNode && !countNode.hasAttribute('data-evo-issue-total')) {
            countNode.textContent = String(count);
        }
    }

    function issueKanbanSyncBoard(board) {
        if (!board) {
            return;
        }

        board.querySelectorAll('[data-evo-issue-lane]').forEach(issueKanbanSyncLane);
    }

    function initIssueKanban(board) {
        if (board.__evoIssueKanbanInitialized) {
            return;
        }

        board.__evoIssueKanbanInitialized = true;
        var dragged = null;

        issueKanbanSyncBoard(board);

        board.addEventListener('dragstart', function (event) {
            var card = event.target && event.target.closest ? event.target.closest('[data-evo-issue-card]') : null;

            if (!card || !board.contains(card)) {
                return;
            }

            dragged = card;
            card.classList.add('is-dragging');

            if (event.dataTransfer) {
                event.dataTransfer.effectAllowed = 'move';
                event.dataTransfer.setData('text/plain', card.getAttribute('data-issue-id') || '');
            }
        });

        board.addEventListener('dragover', function (event) {
            var lane = event.target && event.target.closest ? event.target.closest('[data-evo-issue-lane]') : null;

            if (!lane || !board.contains(lane)) {
                return;
            }

            event.preventDefault();
            lane.classList.add('is-drag-over');

            if (!dragged) {
                return;
            }

            var after = issueKanbanCardAfter(lane, event.clientY);

            if (after) {
                lane.insertBefore(dragged, after);
            } else {
                lane.appendChild(dragged);
            }

            issueKanbanSyncBoard(board);
        });

        board.addEventListener('dragleave', function (event) {
            var lane = event.target && event.target.closest ? event.target.closest('[data-evo-issue-lane]') : null;

            if (lane && !lane.contains(event.relatedTarget)) {
                lane.classList.remove('is-drag-over');
            }
        });

        board.addEventListener('drop', function (event) {
            var lane = event.target && event.target.closest ? event.target.closest('[data-evo-issue-lane]') : null;
            var component = livewireComponent(board);

            if (!lane || !board.contains(lane)) {
                return;
            }

            event.preventDefault();
            board.querySelectorAll('[data-evo-issue-lane].is-drag-over').forEach(function (item) {
                item.classList.remove('is-drag-over');
            });
            issueKanbanSyncBoard(board);

            if (component && typeof component.call === 'function') {
                component.call('sortKanbanLanes', issueKanbanLanePayload(board));
            }
        });

        board.addEventListener('dragend', function () {
            if (dragged) {
                dragged.classList.remove('is-dragging');
            }

            dragged = null;
            board.querySelectorAll('[data-evo-issue-lane].is-drag-over').forEach(function (lane) {
                lane.classList.remove('is-drag-over');
            });
            issueKanbanSyncBoard(board);
        });
    }

    function issueWorkspaceScrollParent(element) {
        var parent = element ? element.parentElement : null;

        while (parent && parent !== document.body && parent !== document.documentElement) {
            var style = window.getComputedStyle(parent);

            if (/(auto|scroll|hidden)/.test(style.overflowY) && parent.clientHeight > 0) {
                return parent;
            }

            parent = parent.parentElement;
        }

        return null;
    }

    function updateIssueWorkspaceHeight(workspace) {
        if (!workspace || !workspace.getBoundingClientRect) {
            return;
        }

        var rect = workspace.getBoundingClientRect();
        var viewportHeight = window.visualViewport && window.visualViewport.height
            ? window.visualViewport.height
            : window.innerHeight;
        var scrollParent = issueWorkspaceScrollParent(workspace);
        var parentBottom = scrollParent && scrollParent !== workspace
            ? scrollParent.getBoundingClientRect().bottom
            : viewportHeight;
        var bottom = Math.min(viewportHeight, parentBottom);
        var bottomGap = parseInt(workspace.getAttribute('data-evo-issue-bottom-gap') || '8', 10) || 8;
        var height = Math.max(320, Math.floor(bottom - rect.top - bottomGap));

        workspace.style.setProperty('--evo-ui-issue-workspace-height', height + 'px');
    }

    function initIssueWorkspace(workspace) {
        var tabContent = workspace.closest ? workspace.closest('.tab-content') : null;

        if (tabContent) {
            tabContent.classList.add('evo-ui-tab-content--issue-workspace');
        }

        if (workspace.__evoIssueWorkspaceInitialized) {
            updateIssueWorkspaceHeight(workspace);
            return;
        }

        workspace.__evoIssueWorkspaceInitialized = true;
        updateIssueWorkspaceHeight(workspace);
        window.addEventListener('resize', function () {
            updateIssueWorkspaceHeight(workspace);
        }, {passive: true});

        if (window.visualViewport) {
            window.visualViewport.addEventListener('resize', function () {
                updateIssueWorkspaceHeight(workspace);
            }, {passive: true});
        }
    }

    function stopResourceParentSelection() {
        var tree = managerTree();

        if (tree && tree.ca === 'parent') {
            tree.ca = 'open';
        }

        if (window.EvoUI.resourceParent.active) {
            window.EvoUI.resourceParent.active.classList.remove('is-selecting');
            window.EvoUI.resourceParent.active = null;
        }
    }

    function applyResourceParentSelection(id, title) {
        var picker = window.EvoUI.resourceParent.active || document.querySelector('[data-evo-resource-parent].is-selecting');

        if (!picker) {
            return;
        }

        id = Math.max(0, parseInt(id, 10) || 0);
        title = title || '';

        var field = picker.getAttribute('data-evo-resource-parent') || 'parent';
        var input = picker.querySelector('[data-evo-resource-parent-input]');
        var label = picker.querySelector('[data-evo-resource-parent-label]');
        var display = id + ' (' + title + ')';
        var component = livewireComponent(picker);

        if (input) {
            input.value = String(id);
            input.dispatchEvent(new Event('input', {bubbles: true}));
            input.dispatchEvent(new Event('change', {bubbles: true}));
        }

        if (label && title) {
            label.textContent = display;
        }

        if (component && typeof component.call === 'function') {
            component.call('setResourceParent', field, id, title);
        }

        dispatch('resource-parent.selected', {field: field, id: id, title: title});
        stopResourceParentSelection();
    }

    function initResourceParent(picker) {
        if (picker.__evoInitialized) {
            return;
        }

        picker.__evoInitialized = true;

        var trigger = picker.querySelector('[data-evo-resource-parent-trigger]');

        function startSelection(event) {
            var tree = managerTree();

            event.preventDefault();
            event.stopPropagation();

            if (window.EvoUI.resourceParent.active === picker) {
                stopResourceParentSelection();
                return;
            }

            stopResourceParentSelection();
            window.EvoUI.resourceParent.active = picker;
            picker.classList.add('is-selecting');

            if (tree) {
                tree.ca = 'parent';
            }

            dispatch('resource-parent.open', {
                field: picker.getAttribute('data-evo-resource-parent') || 'parent',
                recordId: parseInt(picker.getAttribute('data-evo-record-id'), 10) || 0
            });
        }

        if (trigger) {
            trigger.addEventListener('click', startSelection);
            trigger.addEventListener('keydown', function (event) {
                if (event.key === 'Enter' || event.key === ' ') {
                    startSelection(event);
                }
            });
        }
    }

    function updateModuleTabs(tabbar) {
        var row = tabbar.querySelector('[data-evo-module-tabs-scroller]');
        var prev = tabbar.querySelector('[data-evo-module-tabs-prev]');
        var next = tabbar.querySelector('[data-evo-module-tabs-next]');

        if (!row || !prev || !next) {
            return;
        }

        var tabs = Array.prototype.slice.call(row.querySelectorAll('.evo-ui-module-tab'));
        var active = row.querySelector('.evo-ui-module-tab.is-active') || tabs[0] || null;
        var activeIndex = active ? tabs.indexOf(active) : -1;

        prev.disabled = tabs.length < 2 || activeIndex <= 0;
        next.disabled = tabs.length < 2 || activeIndex === -1 || activeIndex >= tabs.length - 1;
        prev.classList.toggle('is-disabled', prev.disabled);
        next.classList.toggle('is-disabled', next.disabled);
    }

    function ensureModuleTabVisible(row, tab) {
        if (!row || !tab) {
            return;
        }

        var rowRect = row.getBoundingClientRect();
        var tabRect = tab.getBoundingClientRect();
        var offset = 0;

        if (tabRect.left < rowRect.left) {
            offset = tabRect.left - rowRect.left;
        } else if (tabRect.right > rowRect.right) {
            offset = tabRect.right - rowRect.right;
        }

        if (offset === 0) {
            return;
        }

        if (typeof row.scrollBy === 'function') {
            row.scrollBy({left: offset, behavior: 'smooth'});
        } else {
            row.scrollLeft += offset;
        }
    }

    function activateAdjacentModuleTab(button, direction) {
        var tabbar = button.closest('[data-evo-module-tabs]');
        var row = tabbar ? tabbar.querySelector('[data-evo-module-tabs-scroller]') : null;

        if (!tabbar || !row || button.disabled) {
            return;
        }

        var tabs = Array.prototype.slice.call(row.querySelectorAll('.evo-ui-module-tab'));
        var active = row.querySelector('.evo-ui-module-tab.is-active') || tabs[0] || null;
        var activeIndex = active ? tabs.indexOf(active) : -1;
        var target = tabs[direction === 'prev' ? activeIndex - 1 : activeIndex + 1];

        if (!target) {
            return;
        }

        ensureModuleTabVisible(row, target);
        target.click();
    }

    function initModuleTabs(tabbar) {
        if (tabbar.__evoInitialized) {
            return;
        }

        tabbar.__evoInitialized = true;

        var row = tabbar.querySelector('[data-evo-module-tabs-scroller]');
        var prev = tabbar.querySelector('[data-evo-module-tabs-prev]');
        var next = tabbar.querySelector('[data-evo-module-tabs-next]');
        var active = row ? row.querySelector('.evo-ui-module-tab.is-active') : null;

        if (!row || !prev || !next) {
            return;
        }

        prev.addEventListener('click', function (event) {
            event.preventDefault();
            activateAdjacentModuleTab(prev, 'prev');
        });

        next.addEventListener('click', function (event) {
            event.preventDefault();
            activateAdjacentModuleTab(next, 'next');
        });

        row.addEventListener('scroll', function () {
            updateModuleTabs(tabbar);
        }, {passive: true});

        if (active) {
            ensureModuleTabVisible(row, active);
        }

        updateModuleTabs(tabbar);
        window.setTimeout(function () {
            updateModuleTabs(tabbar);
        }, 60);
    }

    function init(rootElement) {
        var target = rootElement || document;

        if (target.matches && target.matches('[data-evo-layout]')) {
            initLayout(target);
        }

        if (target.matches && target.matches('[data-evo-resource-parent]')) {
            initResourceParent(target);
        }

        if (target.matches && target.matches('[data-evo-module-tabs]')) {
            initModuleTabs(target);
        }

        if (target.matches && target.matches('[data-evo-issue-kanban]')) {
            initIssueKanban(target);
        }

        if (target.matches && target.matches('[data-evo-builder]')) {
            initBuilder(target);
        }

        if (target.matches && target.matches('[data-evo-dnd]')) {
            initDnd(target);
        }

        if (target.matches && target.matches('[data-evo-issue-workspace]')) {
            initIssueWorkspace(target);
        }

        if (target.matches && target.matches('[data-evo-inline-create]')) {
            initInlineCreate(target);
        }

        target.querySelectorAll('[data-evo-layout]').forEach(initLayout);
        target.querySelectorAll('[data-evo-resource-parent]').forEach(initResourceParent);
        target.querySelectorAll('[data-evo-module-tabs]').forEach(initModuleTabs);
        target.querySelectorAll('[data-evo-issue-kanban]').forEach(initIssueKanban);
        target.querySelectorAll('[data-evo-builder]').forEach(initBuilder);
        target.querySelectorAll('[data-evo-dnd]').forEach(initDnd);
        target.querySelectorAll('[data-evo-issue-workspace]').forEach(initIssueWorkspace);
        target.querySelectorAll('[data-evo-inline-create]').forEach(initInlineCreate);
    }

    function shouldHandleManagerLink(link, event) {
        var rawHref = link ? (link.getAttribute('href') || '') : '';

        if (!link || !link.href || rawHref === '#' || rawHref.indexOf('javascript:') === 0) {
            return false;
        }

        if (event && (event.metaKey || event.ctrlKey || event.shiftKey || event.altKey || event.which === 2)) {
            return false;
        }

        if (link.hasAttribute('data-delete') || link.hasAttribute('data-toggle') || link.hasAttribute('data-target') || link.hasAttribute('onclick')) {
            return false;
        }

        return link.hasAttribute('data-evo-manager-link');
    }

    function openManagerLink(url) {
        if (!url) {
            return;
        }

        window.location.href = new URL(url, window.location.href).toString();
    }

    function assignInputValue(input, value) {
        if (!input) {
            return;
        }

        input.value = value || '';
        input.dispatchEvent(new Event('input', {bubbles: true}));
        input.dispatchEvent(new Event('change', {bubbles: true}));
    }

    function mediaBridgeInput(inputId) {
        var bridgeId = 'evo-ui-media-bridge-' + String(inputId || '').replace(/[^a-z0-9_-]/gi, '-');
        var bridge = document.getElementById(bridgeId);

        if (!bridge) {
            bridge = document.createElement('input');
            bridge.type = 'hidden';
            bridge.id = bridgeId;
            bridge.setAttribute('data-evo-media-bridge', inputId);
            document.body.appendChild(bridge);
        }

        return bridge;
    }

    function mediaBrowserUrl(type) {
        var managerUrl = '';
        var browser = 'mcpuk';

        try {
            if (window.evo && window.evo.EVO_MANAGER_URL) {
                managerUrl = window.evo.EVO_MANAGER_URL;
            } else if (window.parent && window.parent.evo && window.parent.evo.EVO_MANAGER_URL) {
                managerUrl = window.parent.evo.EVO_MANAGER_URL;
            }
        } catch (error) {
            managerUrl = '';
        }

        try {
            if (window.evo && window.evo.config && window.evo.config.which_browser) {
                browser = window.evo.config.which_browser;
            } else if (window.parent && window.parent.evo && window.parent.evo.config && window.parent.evo.config.which_browser) {
                browser = window.parent.evo.config.which_browser;
            }
        } catch (error) {
            browser = 'mcpuk';
        }

        return new URL('media/browser/' + browser + '/browser.php?Type=' + (type || 'images'), managerUrl || window.location.href).toString();
    }

    function browseMediaField(inputId, type) {
        var input = document.getElementById(inputId);

        if (!input) {
            return;
        }

        var bridge = mediaBridgeInput(inputId);
        var previousSetUrl = window.SetUrl;
        var previousKCFinder = window.KCFinder;

        function restoreMediaCallbacks() {
            window.SetUrl = previousSetUrl;
            window.KCFinder = previousKCFinder || null;
            bridge.onchange = null;
        }

        function applyMediaValue(url) {
            assignInputValue(input, url);
            bridge.value = url || '';
            restoreMediaCallbacks();
        }

        bridge.onchange = function () {
            applyMediaValue(bridge.value);
        };

        window.SetUrl = function (url, width, height, alt) {
            if (typeof previousSetUrl === 'function') {
                previousSetUrl(url, width, height, alt);
            }

            applyMediaValue(url);
        };

        window.KCFinder = {
            callBack: function (url) {
                applyMediaValue(url);
            }
        };

        if (typeof window.BrowseServer === 'function' && (!type || type === 'images')) {
            window.BrowseServer(bridge.id);
            return;
        }

        var width = Math.round((screen.width || 1280) * 0.7);
        var height = Math.round((screen.height || 800) * 0.7);
        var left = Math.round(((screen.width || width) - width) / 2);
        var top = Math.round(((screen.height || height) - height) / 2);

        window.open(
            mediaBrowserUrl(type || 'images'),
            'FCKBrowseWindow',
            'toolbar=no,status=no,resizable=yes,dependent=yes,width=' + width + ',height=' + height + ',left=' + left + ',top=' + top
        );
    }

    function handleManagerClick(event) {
        var link = event.target && event.target.closest ? event.target.closest('a[data-evo-manager-link]') : null;

        if (!shouldHandleManagerLink(link, event)) {
            return;
        }

        event.preventDefault();
        openManagerLink(link.href);
    }

    function handleDeleteClick(event) {
        var trigger = event.target && event.target.closest ? event.target.closest('[data-delete][data-href]') : null;

        if (!trigger) {
            return;
        }

        event.preventDefault();
        event.stopPropagation();

        var id = trigger.getAttribute('data-delete') || '';
        var name = trigger.getAttribute('data-name') || id;
        var href = trigger.getAttribute('data-href') || '';

        if (!href) {
            return;
        }

        openDeleteConfirm(href, name);
    }

    function closeDeleteConfirm() {
        var modal = document.querySelector('[data-evo-delete-confirm]');

        if (modal) {
            modal.remove();
        }

        document.removeEventListener('keydown', handleDeleteConfirmKeydown, true);
    }

    function confirmDelete(href) {
        closeDeleteConfirm();
        openManagerLink(href);
    }

    function handleDeleteConfirmKeydown(event) {
        if (event.key === 'Escape') {
            event.preventDefault();
            closeDeleteConfirm();
        }
    }

    function openDeleteConfirm(href, name) {
        var title = label('deleteConfirmTitle', 'Delete item');
        var message = label('deleteConfirmMessage', 'Are you sure you want to delete ":name"?')
            .replace(':name', name || '');
        var cancel = label('actionCancel', 'Cancel');
        var deleteText = label('actionDelete', 'Delete');
        var backdrop = document.createElement('div');

        closeDeleteConfirm();

        backdrop.className = 'evo-ui-modal-backdrop evo-ui-confirm-backdrop';
        backdrop.setAttribute('role', 'presentation');
        backdrop.setAttribute('data-evo-delete-confirm', 'true');
        backdrop.innerHTML = [
            '<section class="evo-ui-modal evo-ui-modal--sm evo-ui-confirm" role="dialog" aria-modal="true" aria-labelledby="evo-ui-delete-confirm-title">',
                '<header class="evo-ui-modal__header">',
                    '<div class="evo-ui-modal__title" id="evo-ui-delete-confirm-title">',
                        iconSvg('trash'),
                        '<span></span>',
                    '</div>',
                    '<button type="button" class="evo-ui-modal__close" data-evo-delete-cancel title="' + escapeAttribute(cancel) + '" aria-label="' + escapeAttribute(cancel) + '">',
                        iconSvg('x'),
                    '</button>',
                '</header>',
                '<div class="evo-ui-modal__body evo-ui-confirm__body">',
                    '<p class="evo-ui-confirm__message"></p>',
                '</div>',
                '<footer class="evo-ui-modal__footer evo-ui-confirm__footer">',
                    '<button type="button" class="evo-ui-btn" data-evo-delete-cancel></button>',
                    '<button type="button" class="evo-ui-btn evo-ui-btn--danger evo-ui-btn--filled" data-evo-delete-confirm-action>',
                        iconSvg('trash'),
                        '<span></span>',
                    '</button>',
                '</footer>',
            '</section>'
        ].join('');

        backdrop.querySelector('.evo-ui-modal__title span').textContent = title;
        backdrop.querySelector('.evo-ui-confirm__message').textContent = message;
        backdrop.querySelector('.evo-ui-confirm__footer [data-evo-delete-cancel]').textContent = cancel;
        backdrop.querySelector('[data-evo-delete-confirm-action] span').textContent = deleteText;

        backdrop.addEventListener('click', function (event) {
            if (event.target === backdrop || event.target.closest('[data-evo-delete-cancel]')) {
                event.preventDefault();
                closeDeleteConfirm();
                return;
            }

            if (event.target.closest('[data-evo-delete-confirm-action]')) {
                event.preventDefault();
                confirmDelete(href);
            }
        });

        document.body.appendChild(backdrop);
        document.addEventListener('keydown', handleDeleteConfirmKeydown, true);

        var cancelButton = backdrop.querySelector('.evo-ui-confirm__footer [data-evo-delete-cancel]');
        if (cancelButton) {
            cancelButton.focus();
        }
    }

    function handleManagerDoubleClick(event) {
        var row = event.target && event.target.closest ? event.target.closest('[data-evo-manager-dblclick]') : null;

        if (!row || event.target.closest('a, button, input, select, textarea, label, summary, details')) {
            return;
        }

        openManagerLink(row.getAttribute('data-evo-manager-dblclick'));
    }

    function handleModalDoubleClick(event) {
        var row = event.target && event.target.closest ? event.target.closest('[data-evo-modal-dblclick]') : null;

        if (!row || event.target.closest('a, button, input, select, textarea, label, summary, details')) {
            return;
        }

        var component = livewireComponent(row);
        var rowId = parseInt(row.getAttribute('data-evo-modal-dblclick') || '0', 10);
        var actionKey = String(row.getAttribute('data-evo-modal-action') || '').trim();

        if (!component || typeof component.call !== 'function' || rowId < 1) {
            return;
        }

        event.preventDefault();
        event.stopPropagation();

        if (actionKey !== '') {
            component.call('openActionModal', actionKey, rowId);
            return;
        }

        component.call('openEditModal', rowId);
    }

    function observeComponentDom() {
        if (!window.MutationObserver || !document.body || document.body.__evoUiObserver) {
            return;
        }

        document.body.__evoUiObserver = new MutationObserver(function (mutations) {
            mutations.forEach(function (mutation) {
                mutation.addedNodes.forEach(function (node) {
                    if (node.nodeType === 1) {
                        init(node);
                    }
                });
            });
        });

        document.body.__evoUiObserver.observe(document.body, {
            childList: true,
            subtree: true
        });
    }

    function normalizeOptions(options) {
        return Array.isArray(options)
            ? options.map(function (option) {
                return {
                    id: option && option.id !== undefined ? option.id : '',
                    name: String(option && option.name !== undefined ? option.name : '')
                };
            })
            : [];
    }

    function filterVisibleOptions(context) {
        var query = String(context.search || '').trim().toLowerCase();

        return query
            ? context.options.filter(function (option) {
                return String(option.name || '').toLowerCase().indexOf(query) !== -1;
            })
            : context.options;
    }

    function closeFilterRoot(context) {
        if (context.$root) {
            context.$root.open = false;
        }
    }

    var evoUiScriptQueue = Promise.resolve();
    var evoUiLoadedExternalScripts = {};

    function patchTinyMceDefaults() {
        if (!window.tinymce || typeof window.tinymce.init !== 'function' || window.tinymce.init.__evoUiPatched) {
            return;
        }

        var originalInit = window.tinymce.init;

        window.tinymce.init = function (options) {
            if (options && typeof options === 'object' && !Array.isArray(options)) {
                options = Object.assign({}, options, {
                    promotion: false,
                    branding: false
                });
            }

            return originalInit.call(this, options);
        };

        window.tinymce.init.__evoUiPatched = true;
        window.tinymce.init.__evoUiOriginal = originalInit;
    }

    function normalizeScriptSource(src) {
        return String(src || '').split('?')[0];
    }

    function isTinyMceCoreScript(src) {
        var normalized = normalizeScriptSource(src);

        return normalized.indexOf('/tinymce.min.js') !== -1 || normalized.indexOf('/tinymce.js') !== -1;
    }

    function isETinyMceInitScript(src) {
        return normalizeScriptSource(src).indexOf('/etinymce-init.js') !== -1;
    }

    function shouldSkipExternalScript(src) {
        var normalized = normalizeScriptSource(src);

        if (!normalized || isETinyMceInitScript(normalized)) {
            return false;
        }

        return evoUiLoadedExternalScripts[normalized] === true
            || (isTinyMceCoreScript(normalized) && window.tinymce && typeof window.tinymce.init === 'function');
    }

    function executeScriptElement(script) {
        return new Promise(function (resolve) {
            var next = document.createElement('script');
            var src = script.src || '';
            var normalizedSrc = normalizeScriptSource(src);

            if (src && shouldSkipExternalScript(src)) {
                resolve();
                return;
            }

            Array.prototype.slice.call(script.attributes).forEach(function (attribute) {
                if (attribute.name !== 'data-evo-ui-executed') {
                    next.setAttribute(attribute.name, attribute.value);
                }
            });

            next.async = false;

            if (!src) {
                next.text = script.textContent || '';
                try {
                    document.head.appendChild(next);
                } catch (error) {
                    // Keep the editor queue moving even if a legacy inline script fails.
                }
                resolve();
                return;
            }

            next.addEventListener('load', function () {
                if (!isETinyMceInitScript(src)) {
                    evoUiLoadedExternalScripts[normalizedSrc] = true;
                }

                if (isTinyMceCoreScript(src) || isETinyMceInitScript(src)) {
                    patchTinyMceDefaults();
                }

                resolve();
            }, { once: true });

            next.addEventListener('error', resolve, { once: true });
            try {
                document.head.appendChild(next);
            } catch (error) {
                resolve();
            }
        });
    }

    function executeScriptsSequentially(scripts) {
        return scripts.reduce(function (promise, script) {
            return promise.then(function () {
                return executeScriptElement(script);
            });
        }, Promise.resolve());
    }

    function activateScripts(container) {
        if (!container || !container.querySelectorAll) {
            return Promise.resolve();
        }

        patchTinyMceDefaults();

        var scripts = Array.prototype.slice.call(container.querySelectorAll('script')).filter(function (script) {
            if (script.dataset.evoUiExecuted === '1') {
                return false;
            }

            script.dataset.evoUiExecuted = '1';
            return true;
        });

        evoUiScriptQueue = evoUiScriptQueue.then(function () {
            return executeScriptsSequentially(scripts);
        });

        return evoUiScriptQueue;
    }

    function removeExistingRichEditors(container) {
        if (!container || !container.querySelectorAll) {
            return;
        }

        container.querySelectorAll('[data-evo-rich-editor][id]').forEach(function (field) {
            if (window.tinymce && typeof window.tinymce.get === 'function') {
                var editor = window.tinymce.get(field.id);

                if (editor && typeof editor.remove === 'function') {
                    editor.remove();
                }
            }

            if (window.dTuiEditor && typeof window.dTuiEditor.remove === 'function') {
                window.dTuiEditor.remove(field);
            }
        });
    }

    function initRichEditorField(container) {
        removeExistingRichEditors(container);
        return activateScripts(container);
    }

    function syncRichEditors(form, wire) {
        if (!form || !wire) {
            return Promise.resolve();
        }

        if (window.tinymce && typeof window.tinymce.triggerSave === 'function') {
            window.tinymce.triggerSave();
        }

        var updates = [];

        form.querySelectorAll('[data-evo-rich-editor][data-evo-rich-editor-model]').forEach(function (field) {
            var model = field.getAttribute('data-evo-rich-editor-model') || '';
            var value = field.value || '';

            if (!model) {
                return;
            }

            if (field.id && window.tinymce && typeof window.tinymce.get === 'function') {
                var editor = window.tinymce.get(field.id);

                if (editor && typeof editor.getContent === 'function') {
                    value = editor.getContent() || '';
                    field.value = value;
                }
            }

            if (window.dTuiEditor && typeof window.dTuiEditor.getValue === 'function') {
                value = window.dTuiEditor.getValue(field) || '';
                field.value = value;
            }

            updates.push(wire.set(model, value, false));
        });

        return Promise.all(updates);
    }

    function clearRichEditors(form) {
        if (!form || !form.querySelectorAll) {
            return;
        }

        form.querySelectorAll('[data-evo-rich-editor]').forEach(function (field) {
            field.value = '';

            if (field.id && window.tinymce && typeof window.tinymce.get === 'function') {
                var editor = window.tinymce.get(field.id);

                if (editor && typeof editor.setContent === 'function') {
                    editor.setContent('');
                }
            }

            if (window.dTuiEditor && typeof window.dTuiEditor.setValue === 'function') {
                window.dTuiEditor.setValue(field, '');
            }
        });
    }

    function inlineCreateRootMatches(rootElement, rootKey) {
        if (!rootKey) {
            return true;
        }

        return rootElement.getAttribute('data-evo-inline-create') === rootKey ||
            rootElement.getAttribute('data-evo-inline-create-root') === rootKey ||
            rootElement.id === rootKey;
    }

    function inlineCreateRoots(rootKey) {
        return Array.prototype.slice.call(document.querySelectorAll('[data-evo-inline-create]')).filter(function (rootElement) {
            return inlineCreateRootMatches(rootElement, rootKey);
        });
    }

    function inlineCreateCreatedItems(rootElement, itemId) {
        var items = Array.prototype.slice.call(rootElement.querySelectorAll('[data-evo-inline-created], [data-evo-inline-create-id]'));

        if (!itemId) {
            return items;
        }

        return items.filter(function (item) {
            return item.getAttribute('data-evo-inline-created') === itemId ||
                item.getAttribute('data-evo-inline-create-id') === itemId ||
                item.id === itemId;
        });
    }

    function inlineCreateFocusTarget(item) {
        if (!item || !item.querySelector) {
            return null;
        }

        return item.querySelector('[data-evo-inline-focus]') ||
            item.querySelector('input:not([type="hidden"]):not([disabled]), textarea:not([disabled]), select:not([disabled]), button:not([disabled]), [tabindex]:not([tabindex="-1"])');
    }

    function focusInlineCreateItem(item) {
        if (!item) {
            return;
        }

        item.classList.add('is-evo-inline-created');
        item.scrollIntoView({behavior: 'smooth', block: 'center', inline: 'nearest'});

        window.setTimeout(function () {
            var focusTarget = inlineCreateFocusTarget(item);

            if (focusTarget && typeof focusTarget.focus === 'function') {
                focusTarget.focus({preventScroll: true});
            }

            dispatch('inline-create.focused', {
                id: item.getAttribute('data-evo-inline-create-id') || item.getAttribute('data-evo-inline-created') || item.id || ''
            }, item);
        }, 120);

        window.setTimeout(function () {
            item.classList.remove('is-evo-inline-created');
        }, 1800);
    }

    function inlineCreateHasOverflow(rootElement) {
        var mode = rootElement.getAttribute('data-evo-inline-create-overflow') || 'page';
        var target = mode === 'root' ? rootElement : document.documentElement;

        if (target === rootElement) {
            return rootElement.scrollHeight > rootElement.clientHeight + 1 || rootElement.scrollWidth > rootElement.clientWidth + 1;
        }

        return Math.max(document.body.scrollHeight, document.documentElement.scrollHeight) > window.innerHeight + 1;
    }

    function toggleInlineCreateOverflow(rootElement) {
        if (!rootElement || !rootElement.querySelectorAll) {
            return;
        }

        var overflow = inlineCreateHasOverflow(rootElement);

        rootElement.classList.toggle('is-evo-inline-create-overflowing', overflow);
        rootElement.querySelectorAll('[data-evo-inline-create-bottom]').forEach(function (action) {
            action.hidden = !overflow;
            action.classList.toggle('is-visible', overflow);
            action.setAttribute('aria-hidden', overflow ? 'false' : 'true');
        });
    }

    function initInlineCreate(rootElement) {
        toggleInlineCreateOverflow(rootElement);
    }

    function handleInlineCreateCreated(detail) {
        detail = detail || {};

        window.requestAnimationFrame(function () {
            var roots = inlineCreateRoots(String(detail.root || detail.container || ''));

            roots.forEach(function (rootElement) {
                var items = inlineCreateCreatedItems(rootElement, String(detail.id || detail.uid || ''));
                var item = items.length ? items[items.length - 1] : null;

                if (item) {
                    focusInlineCreateItem(item);
                }

                toggleInlineCreateOverflow(rootElement);
            });
        });
    }

    function selectFilter(config) {
        config = config || {};

        return {
            search: '',
            committed: String(config.selected || ''),
            selected: String(config.selected || ''),
            options: normalizeOptions(config.options),
            visibleOptions: function () {
                return filterVisibleOptions(this);
            },
            reset: function () {
                this.search = '';
                this.selected = this.committed;
            },
            apply: function () {
                this.$wire.applySelectFilter(config.state, this.selected);
                this.committed = this.selected;
                this.search = '';
                closeFilterRoot(this);
            }
        };
    }

    function multiFilter(config) {
        config = config || {};

        var selected = Array.isArray(config.selected)
            ? config.selected.map(function (value) {
                return Number(value);
            })
            : [];

        return {
            search: '',
            committed: selected.slice(),
            selected: selected.slice(),
            options: normalizeOptions(config.options).map(function (option) {
                option.id = Number(option.id);

                return option;
            }),
            toggle: function (id) {
                id = Number(id);
                this.selected = this.selected.indexOf(id) !== -1
                    ? this.selected.filter(function (value) {
                        return value !== id;
                    })
                    : this.selected.concat([id]);
            },
            visibleOptions: function () {
                return filterVisibleOptions(this);
            },
            allVisibleSelected: function () {
                var selectedValues = this.selected;
                var visible = this.visibleOptions().map(function (option) {
                    return option.id;
                });

                return visible.length > 0 && visible.every(function (id) {
                    return selectedValues.indexOf(id) !== -1;
                });
            },
            toggleAllVisible: function () {
                var visible = this.visibleOptions().map(function (option) {
                    return option.id;
                });

                if (this.allVisibleSelected()) {
                    this.selected = this.selected.filter(function (id) {
                        return visible.indexOf(id) === -1;
                    });

                    return;
                }

                this.selected = Array.from(new Set(this.selected.concat(visible)));
            },
            reset: function () {
                this.search = '';
                this.selected = this.committed.slice();
            },
            apply: function () {
                this.$wire.applyMultiFilter(config.state, this.selected);
                this.committed = this.selected.slice();
                this.search = '';
                closeFilterRoot(this);
            }
        };
    }

    function dateRangeFilter(config) {
        config = config || {};

        return {
            committedFrom: String(config.from || ''),
            committedTo: String(config.to || ''),
            from: String(config.from || ''),
            to: String(config.to || ''),
            reset: function () {
                this.from = this.committedFrom;
                this.to = this.committedTo;
            },
            clear: function () {
                this.from = '';
                this.to = '';
                this.$wire.applyDateRangeFilter(config.state, '', '');
                this.committedFrom = '';
                this.committedTo = '';
                closeFilterRoot(this);
            },
            apply: function () {
                this.$wire.applyDateRangeFilter(config.state, this.from, this.to);
                this.committedFrom = this.from;
                this.committedTo = this.to;
                closeFilterRoot(this);
            }
        };
    }

    window.EvoUI.init = init;
    window.EvoUI.dispatch = dispatch;
    window.EvoUI.on = on;
    window.EvoUI.form = {
        isDirty: formIsDirty,
        waitForClean: waitForCleanForm
    };
    window.EvoUI.selectFilter = selectFilter;
    window.EvoUI.multiFilter = multiFilter;
    window.EvoUI.dateRangeFilter = dateRangeFilter;
    window.EvoUI.initBuilder = initBuilder;
    window.EvoUI.builderPayload = evoBuilderPayload;
    window.EvoUI.initDnd = initDnd;
    window.EvoUI.initInlineCreate = initInlineCreate;
    window.EvoUI.focusInlineCreateItem = focusInlineCreateItem;
    window.EvoUI.initIssueKanban = initIssueKanban;
    window.EvoUI.syncRichEditors = syncRichEditors;
    window.EvoUI.clearRichEditors = clearRichEditors;
    window.EvoUI.initRichEditorField = initRichEditorField;
    window.EvoUI.browseMediaField = browseMediaField;
    window.EvoUI.browseImageField = function (inputId) {
        browseMediaField(inputId, 'images');
    };
    window.EvoUI.resourceParent = window.EvoUI.resourceParent || {
        active: null,
        select: applyResourceParentSelection,
        close: stopResourceParentSelection
    };
    window.EvoUI.theme = {
        hydrate: hydrateTheme,
        apply: applyTheme
    };
    window.EvoUI.manager = {
        open: openManagerLink
    };

    window.setParent = function (id, title) {
        applyResourceParentSelection(id, title);
    };

    window.EvoLivewireBridge = window.EvoLivewireBridge || {
        initialized: false,
        init: function () {
            if (this.initialized || !window.Livewire || typeof window.Livewire.hook !== 'function') {
                return;
            }

            this.initialized = true;

            function emit(name, detail) {
                dispatch('livewire.' + name, detail);
            }

            function rehydrate(el) {
                init(el && el.querySelectorAll ? el : document);
                hydrateTheme();
                emit('element.updated');
            }

            if (typeof window.Livewire.interceptMessage === 'function') {
                window.Livewire.interceptMessage(function ({message, onSend, onSuccess, onError, onFailure, onCancel}) {
                    if (typeof onSend === 'function') onSend(function () {
                        emit('message.sent', {component: message.component});
                    });

                    if (typeof onSuccess === 'function') onSuccess(function ({onRender}) {
                        emit('message.received', {component: message.component});

                        if (typeof onRender === 'function') {
                            onRender(function () {
                                rehydrate(message.component && message.component.el);
                            });
                        }
                    });

                    if (typeof onError === 'function') onError(function () {
                        emit('message.failed', {component: message.component});
                    });

                    if (typeof onFailure === 'function') onFailure(function () {
                        emit('message.failed', {component: message.component});
                    });

                    if (typeof onCancel === 'function') onCancel(function () {
                        emit('message.failed', {component: message.component});
                    });
                });
            } else {
                ['message.sent', 'message.received', 'message.failed'].forEach(function (hook) {
                    window.Livewire.hook(hook, function () {
                        emit(hook);
                    });
                });
            }

            window.Livewire.hook('component.init', function ({component}) {
                emit('component.initialized', {component: component});
                rehydrate(component && component.el);
            });

            window.Livewire.hook('morph.updated', function ({el}) {
                rehydrate(el);
            });

            window.Livewire.hook('element.updated', function (el) {
                rehydrate(el);
            });
        }
    };

    hydrateTheme();

    document.addEventListener('DOMContentLoaded', function () {
        hydrateTheme();
        observeParentTheme();
        observeComponentDom();
        init(document);
        window.EvoLivewireBridge.init();
    });

    document.addEventListener('click', handleManagerClick, true);
    document.addEventListener('click', handleDeleteClick, true);
    document.addEventListener('dblclick', handleModalDoubleClick, true);
    document.addEventListener('dblclick', handleManagerDoubleClick, true);

    window.addEventListener('evo-ui:inline-create.created', function (event) {
        handleInlineCreateCreated(event.detail || {});
    });

    window.addEventListener('resize', function () {
        document.querySelectorAll('[data-evo-inline-create]').forEach(toggleInlineCreateOverflow);
    });

    window.addEventListener('message', function (event) {
        if (event.data && event.data.type === 'evo:theme') {
            applyTheme(event.data.theme);
        }
    });

    window.addEventListener('storage', function (event) {
        if (['evo.theme', 'evo.theme.light', 'evo.theme.dark', 'evo.mode', 'evo.blogDaisyui.theme', 'EVO_themeMode'].indexOf(event.key) !== -1) {
            hydrateTheme();
        }
    });

    window.setInterval(syncThemeIfChanged, 500);
})();
