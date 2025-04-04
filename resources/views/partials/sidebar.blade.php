<div class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('dashboard') }}" class="sidebar-brand">
            <i class="bi bi-pie-chart-fill"></i>
            <span class="sidebar-brand-text">BillSplit</span>
        </a>
    </div>
    
    <button class="sidebar-toggle">
        <i class="bi bi-list"></i>
        <span class="toggle-text">Collapse</span>
    </button>
    
    <ul class="sidebar-nav">
        <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="sidebar-link">
                <i class="bi bi-speedometer2 sidebar-icon"></i>
                <span class="sidebar-text">Dashboard</span>
            </a>
        </li>
        
        <li class="sidebar-item {{ request()->routeIs('bills.*') ? 'active' : '' }}">
            <a href="{{ route('bills.index') }}" class="sidebar-link">
                <i class="bi bi-receipt sidebar-icon"></i>
                <span class="sidebar-text">Bills</span>
            </a>
        </li>
        
        <li class="sidebar-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <a href="{{ route('profile.show') }}" class="sidebar-link">
                <i class="bi bi-person sidebar-icon"></i>
                <span class="sidebar-text">Profile</span>
            </a>
        </li>
    </ul>
    
    <div class="sidebar-footer">
        <a href="{{ route('logout') }}" class="sidebar-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right sidebar-icon"></i>
            <span class="sidebar-text">Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</div>

<style>
    .sidebar {
        width: 250px;
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        background-color: #343a40;
        color: white;
        transition: all 0.3s ease;
        z-index: 1000;
        display: flex;
        flex-direction: column;
    }
    
    .sidebar.collapsed {
        width: 70px;
    }
    
    .sidebar.collapsed .sidebar-brand-text,
    .sidebar.collapsed .sidebar-text,
    .sidebar.collapsed .toggle-text {
        display: none;
    }
    
    .sidebar-header {
        padding: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .sidebar-brand {
        display: flex;
        align-items: center;
        color: white;
        text-decoration: none;
        font-size: 1.25rem;
    }
    
    .sidebar-brand i {
        font-size: 1.5rem;
        margin-right: 0.75rem;
    }
    
    .sidebar-toggle {
        background: none;
        border: none;
        color: rgba(255, 255, 255, 0.7);
        padding: 0.75rem;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
    }
    
    .sidebar-toggle:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: white;
    }
    
    .sidebar-toggle i {
        font-size: 1.25rem;
        margin-right: 0.5rem;
    }
    
    .sidebar-nav {
        list-style: none;
        padding: 1rem 0;
        margin: 0;
        flex-grow: 1;
    }
    
    .sidebar-item {
        margin: 0.25rem 0;
    }
    
    .sidebar-link {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .sidebar-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: white;
    }
    
    .sidebar-item.active .sidebar-link {
        background-color: rgba(255, 255, 255, 0.2);
        color: white;
    }
    
    /* New icon alignment styles */
    .sidebar-icon {
        font-size: 1.25rem;
        width: 24px;
        text-align: center;
        margin-right: 0.75rem;
        flex-shrink: 0;
    }
    
    .sidebar-footer {
        padding: 1rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .main-content {
        margin-left: 250px;
        transition: all 0.3s ease;
    }
    
    .main-content.collapsed {
        margin-left: 70px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('.sidebar');
        const sidebarToggle = document.querySelector('.sidebar-toggle');
        const mainContent = document.querySelector('.main-content');
        const toggleText = document.querySelector('.toggle-text');
        
        // Check localStorage for saved state
        if (localStorage.getItem('sidebarCollapsed') === 'true') {
            sidebar.classList.add('collapsed');
            mainContent.classList.add('collapsed');
            toggleText.textContent = 'Expand';
        }
        
        // Toggle sidebar
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('collapsed');
            
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