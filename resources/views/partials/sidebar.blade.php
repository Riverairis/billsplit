<div class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('dashboard') }}" class="sidebar-brand">
            <div class="brand-icon">
                <i class="bi bi-pie-chart-fill"></i>
            </div>
            <span class="sidebar-brand-text">BillSplit</span>
        </a>
    </div>
    
    <button class="sidebar-toggle">
        <i class="bi bi-chevron-left toggle-icon"></i>
        <span class="toggle-text">Collapse</span>
    </button>
    
    <div class="sidebar-content">
        <ul class="sidebar-nav">
            <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="sidebar-link">
                    <div class="link-content">
                        <i class="bi bi-speedometer2 sidebar-icon"></i>
                        <span class="sidebar-text">Dashboard</span>
                    </div>
                    <div class="active-indicator"></div>
                </a>
            </li>
            
            <li class="sidebar-item {{ request()->routeIs('bills.*') ? 'active' : '' }}">
                <a href="{{ route('bills.index') }}" class="sidebar-link">
                    <div class="link-content">
                        <i class="bi bi-receipt sidebar-icon"></i>
                        <span class="sidebar-text">Bills</span>
                    </div>
                    <div class="active-indicator"></div>
                </a>
            </li>
            
            <li class="sidebar-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <a href="{{ route('profile.show') }}" class="sidebar-link">
                    <div class="link-content">
                        <i class="bi bi-person sidebar-icon"></i>
                        <span class="sidebar-text">Profile</span>
                    </div>
                    <div class="active-indicator"></div>
                </a>
            </li>
        </ul>
    </div>
    
    <div class="sidebar-footer">
        <a href="{{ route('logout') }}" class="sidebar-link logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <div class="link-content">
                <i class="bi bi-box-arrow-right sidebar-icon"></i>
                <span class="sidebar-text">Logout</span>
            </div>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</div>

<style>
    .sidebar {
        width: 280px;
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        background: linear-gradient(180deg, #1a1d29 0%, #2d3246 100%);
        color: white;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 1000;
        display: flex;
        flex-direction: column;
        box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
        border-right: 1px solid rgba(255, 255, 255, 0.08);
    }
    
    .sidebar.collapsed {
        width: 85px;
    }
    
    .sidebar.collapsed .sidebar-brand-text,
    .sidebar.collapsed .sidebar-text,
    .sidebar.collapsed .toggle-text {
        opacity: 0;
        visibility: hidden;
        width: 0;
    }
    
    .sidebar-header {
        padding: 1.5rem 1.25rem;
        display: flex;
        align-items: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }
    
    .sidebar-brand {
        display: flex;
        align-items: center;
        color: white;
        text-decoration: none;
        font-size: 1.375rem;
        font-weight: 700;
        transition: all 0.3s ease;
    }
    
    .brand-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 0.875rem;
        transition: all 0.3s ease;
    }
    
    .brand-icon i {
        font-size: 1.25rem;
    }
    
    .sidebar-toggle {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.08);
        color: rgba(255, 255, 255, 0.7);
        padding: 0.875rem;
        margin: 1rem;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }
    
    .sidebar-toggle:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .toggle-icon {
        font-size: 1.125rem;
        transition: transform 0.4s ease;
    }
    
    .sidebar.collapsed .toggle-icon {
        transform: rotate(180deg);
    }
    
    .sidebar-content {
        flex: 1;
        padding: 0.5rem;
    }
    
    .sidebar-nav {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .sidebar-item {
        margin: 0.25rem 0;
        position: relative;
    }
    
    .sidebar-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.875rem 1rem;
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        border-radius: 12px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .sidebar-link::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 3px;
        background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
        transform: scaleY(0);
        transition: transform 0.3s ease;
    }
    
    .sidebar-link:hover {
        background: rgba(255, 255, 255, 0.05);
        color: white;
        transform: translateX(4px);
    }
    
    .sidebar-link:hover::before {
        transform: scaleY(1);
    }
    
    .sidebar-item.active .sidebar-link {
        background: rgba(67, 97, 238, 0.15);
        color: white;
    }
    
    .sidebar-item.active .sidebar-link::before {
        transform: scaleY(1);
    }
    
    .active-indicator {
        width: 6px;
        height: 6px;
        background: #4cc9f0;
        border-radius: 50%;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .sidebar-item.active .active-indicator {
        opacity: 1;
    }
    
    .link-content {
        display: flex;
        align-items: center;
        flex: 1;
    }
    
    .sidebar-icon {
        font-size: 1.25rem;
        width: 24px;
        margin-right: 0.875rem;
        transition: all 0.3s ease;
    }
    
    .sidebar.collapsed .sidebar-icon {
        margin-right: 0;
    }
    
    .sidebar-text {
        font-weight: 500;
        transition: all 0.3s ease;
        white-space: nowrap;
    }
    
    .sidebar-footer {
        padding: 1.25rem;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
    }
    
    .logout-btn {
        background: rgba(244, 67, 54, 0.1);
        border: 1px solid rgba(244, 67, 54, 0.2);
    }
    
    .logout-btn:hover {
        background: rgba(244, 67, 54, 0.2);
    }
    
    .main-content {
        margin-left: 280px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        min-height: 100vh;
    }
    
    .main-content.collapsed {
        margin-left: 85px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('.sidebar');
        const sidebarToggle = document.querySelector('.sidebar-toggle');
        const mainContent = document.querySelector('.main-content');
        const toggleText = document.querySelector('.toggle-text');
        const toggleIcon = document.querySelector('.toggle-icon');
        
        // Check localStorage for saved state
        if (localStorage.getItem('sidebarCollapsed') === 'true') {
            sidebar.classList.add('collapsed');
            if (mainContent) mainContent.classList.add('collapsed');
            toggleText.textContent = 'Expand';
        }
        
        // Toggle sidebar
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            if (mainContent) mainContent.classList.toggle('collapsed');
            
            // Update toggle text
            if (sidebar.classList.contains('collapsed')) {
                toggleText.textContent = 'Expand';
            } else {
                toggleText.textContent = 'Collapse';
            }
            
            // Save state to localStorage
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        });
    });
</script>