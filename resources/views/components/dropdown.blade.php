{{-- Documentation Dropdown Blade Component --}}
<div class="dropdown">
    <a class="btn btn-add-new-car" aria-label="Documentation">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 32 32" width="18" height="18"
            stroke-width="2" stroke="currentColor" style="margin-right: 4px; flex-shrink: 0;" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M29.994,10.183L15.363,24.812L0.733,10.184c-0.977-0.978-0.977-2.561,0-3.536c0.977-0.977,2.559-0.976,3.536,0 l11.095,11.093L26.461,6.647c0.977-0.976,2.559-0.976,3.535,0C30.971,7.624,30.971,9.206,29.994,10.183z" />
        </svg>
        Documentation
    </a>
    <div class="dropdown-content">
        <a href="{{ route('docs') }}">English</a>
        <a href="{{ route('docs.fr') }}">Français</a>
    </div>
</div>

<style>
    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #fff;
        min-width: 180px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.12);
        z-index: 10;
        border-radius: 16px;
        overflow: hidden;
    }

    .dropdown-content a {
        color: #d35400;
        padding: 12px 24px;
        text-decoration: none;
        display: block;
        font-weight: 500;
    }

    .dropdown-content a:hover {
        background-color: var(--primary-color);
        color: var(--primary-button-color);
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }
</style>
