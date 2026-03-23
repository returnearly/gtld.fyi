import hljs from 'highlight.js/lib/core';

// Register languages used in code examples
hljs.registerLanguage('bash', require('highlight.js/lib/languages/bash'));
hljs.registerLanguage('css', require('highlight.js/lib/languages/css'));
hljs.registerLanguage('html', require('highlight.js/lib/languages/xml'));
hljs.registerLanguage('javascript', require('highlight.js/lib/languages/javascript'));
hljs.registerLanguage('json', require('highlight.js/lib/languages/json'));
hljs.registerLanguage('php', require('highlight.js/lib/languages/php'));
hljs.registerLanguage('python', require('highlight.js/lib/languages/python'));
hljs.registerLanguage('ruby', require('highlight.js/lib/languages/ruby'));
hljs.registerLanguage('java', require('highlight.js/lib/languages/java'));
hljs.registerLanguage('csharp', require('highlight.js/lib/languages/csharp'));
hljs.registerLanguage('go', require('highlight.js/lib/languages/go'));
hljs.registerLanguage('swift', require('highlight.js/lib/languages/swift'));
hljs.registerLanguage('kotlin', require('highlight.js/lib/languages/kotlin'));
hljs.registerLanguage('rust', require('highlight.js/lib/languages/rust'));
hljs.registerLanguage('elixir', require('highlight.js/lib/languages/elixir'));
hljs.registerLanguage('yaml', require('highlight.js/lib/languages/yaml'));

// Highlight all code blocks
document.querySelectorAll('pre code').forEach((block) => {
    hljs.highlightElement(block);
});

// ---- Tab switching ----
document.querySelectorAll('[data-tab-group]').forEach((group) => {
    const groupName = group.dataset.tabGroup;
    const buttons = group.querySelectorAll('.tab-button');
    const panels = group.querySelectorAll('.tab-panel');

    // Restore saved tab from localStorage
    const saved = localStorage.getItem('tab-' + groupName);
    if (saved) {
        const savedButton = group.querySelector(`.tab-button[data-tab="${saved}"]`);
        if (savedButton) {
            buttons.forEach(b => b.classList.remove('active'));
            panels.forEach(p => p.classList.remove('active'));
            savedButton.classList.add('active');
            const panel = group.querySelector(`#${saved}`);
            if (panel) panel.classList.add('active');
        }
    }

    buttons.forEach((button) => {
        button.addEventListener('click', () => {
            const tabId = button.dataset.tab;

            buttons.forEach(b => b.classList.remove('active'));
            panels.forEach(p => p.classList.remove('active'));

            button.classList.add('active');
            const panel = group.querySelector(`#${tabId}`);
            if (panel) panel.classList.add('active');

            localStorage.setItem('tab-' + groupName, tabId);

            // Re-highlight any newly visible code blocks
            if (panel) {
                panel.querySelectorAll('pre code:not(.hljs)').forEach((block) => {
                    hljs.highlightElement(block);
                });
            }
        });
    });
});

// ---- TLD Search / Filter ----

// Homepage TLD lookup
const tldLookup = document.getElementById('tld-lookup');
if (tldLookup) {
    const form = tldLookup.closest('form');
    if (form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const value = tldLookup.value.trim().toUpperCase().replace(/^\./, '');
            if (value) {
                window.location.href = '/tld/' + encodeURIComponent(value);
            }
        });
    }
}

// All TLDs page filter
const tldFilter = document.getElementById('tld-filter');
const tldGrid = document.getElementById('tld-grid');
const tldCount = document.getElementById('tld-count');

if (tldFilter && tldGrid) {
    const items = tldGrid.querySelectorAll('[data-tld]');
    const total = items.length;

    tldFilter.addEventListener('input', () => {
        const query = tldFilter.value.trim().toUpperCase().replace(/^\./, '');
        let visible = 0;

        items.forEach((item) => {
            const tld = item.dataset.tld;
            const match = !query || tld.includes(query);
            item.classList.toggle('hidden', !match);
            if (match) visible++;
        });

        if (tldCount) {
            tldCount.textContent = query
                ? `Showing ${visible} of ${total} TLDs`
                : `${total} TLDs`;
        }
    });
}
