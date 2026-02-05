<div class="language-switcher-inline">
    <button type="button" class="lang-btn {{ session('locale', 'bn') == 'bn' ? 'active' : '' }}"
        onclick="changeLanguage('bn')" title="বাংলা">
        বাংলা
    </button>
    <button type="button" class="lang-btn {{ session('locale', 'bn') == 'en' ? 'active' : '' }}"
        onclick="changeLanguage('en')" title="English">
        English
    </button>
</div>

<style>
    .language-switcher-inline {
        display: inline-flex;
        gap: 6px;
        align-items: center;
        height: 100%;
        margin-left: 10px;
    }

    .language-switcher-inline .lang-btn {
        background: #ffffff;
        border: 1px solid var(--secondary-color);
        color: #495057;
        padding: 8px 16px;
        font-size: 14px;
        font-weight: 500;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s ease;
        white-space: nowrap;
        line-height: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .language-switcher-inline .lang-btn.active {
        background-color: var(--secondary-color, #007bff);
        color: white;
        border-color: var(--secondary-color, #007bff);
        font-weight: 600;
    }

    .language-switcher-inline .lang-btn:hover {
        background-color: var(--primary-color, #007bff);
        color: white;
        border-color: var(--primary-color, #007bff);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Ensure proper alignment with header items */
    .header__account--items:has(.language-switcher-inline) {
        display: flex;
        align-items: center;
    }

    /* Tablet responsive */
    @media (max-width: 991px) {
        .language-switcher-inline {
            margin-left: 5px;
            gap: 4px;
        }

        .language-switcher-inline .lang-btn {
            padding: 6px 12px;
            font-size: 12px;
        }
    }

    /* Mobile responsive */
    @media (max-width: 576px) {
        .language-switcher-inline {
            gap: 3px;
            margin-left: 3px;
        }

        .language-switcher-inline .lang-btn {
            padding: 5px 10px;
            font-size: 11px;
        }
    }
</style>

<script>
    function changeLanguage(lang) {
        // Store language preference in localStorage
        localStorage.setItem('preferred_language', lang);

        // Send AJAX request to change language
        fetch('{{ url('/change-language') }}/' + lang, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload the page to apply language changes
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Language change error:', error);
                // Reload anyway
                window.location.reload();
            });
    }

    // Set preferred language on page load if exists
    document.addEventListener('DOMContentLoaded', function() {
        const preferredLang = localStorage.getItem('preferred_language');
        const currentLang = '{{ session('locale', 'bn') }}';

        if (preferredLang && preferredLang !== currentLang) {
            changeLanguage(preferredLang);
        }
    });
</script>
