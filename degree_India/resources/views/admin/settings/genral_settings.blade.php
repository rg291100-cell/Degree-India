<!-- resources/views/admin/settings/index.blade.php -->
@extends('admin.layouts.master')

@section('title', 'App Settings')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    :root {
        --primary-color: #4361ee;
        --primary-light: #eef2ff;
        --secondary-color: #3f37c9;
        --success-color: #06d6a0;
        --info-color: #4cc9f0;
        --warning-color: #ffd166;
        --danger-color: #ef476f;
        --light-color: #f8f9fa;
        --dark-color: #212529;
        --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --card-hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --transition: all 0.3s ease;
    }

    .settings-container {
        padding: 1.5rem;
    }

    .settings-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e9ecef;
    }

    .settings-title h5 {
        color: var(--dark-color);
        font-weight: 600;
        margin-bottom: 0.25rem;
        font-size: 1.5rem;
    }

    .settings-title p {
        color: #6c757d;
        margin-bottom: 0;
        font-size: 0.9rem;
    }

    .settings-search {
        width: 300px;
    }

    .settings-search .input-group-text {
        background-color: white;
        border-right: none;
    }

    .settings-search input {
        border-left: none;
    }

    .settings-search input:focus {
        box-shadow: none;
        border-color: #ced4da;
    }

    .settings-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem;
    }

    .setting-card {
        background: white;
        border-radius: 12px;
        box-shadow: var(--card-shadow);
        padding: 1.5rem;
        transition: var(--transition);
        border: 1px solid #e9ecef;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .setting-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-hover-shadow);
        border-color: var(--primary-light);
    }

    .setting-card-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 1.25rem;
    }

    .setting-icon {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        margin-right: 1rem;
        flex-shrink: 0;
    }

    .setting-icon.email {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .setting-icon.website {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    .setting-icon.notification {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }

    .setting-icon.page {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }

    .setting-icon.system {
        background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
        color: #495057;
    }

    .setting-info {
        flex: 1;
    }

    .setting-info h6 {
        font-weight: 600;
        color: var(--dark-color);
        margin-bottom: 0.25rem;
        font-size: 1.1rem;
    }

    .setting-info p {
        color: #6c757d;
        font-size: 0.85rem;
        margin-bottom: 0;
        line-height: 1.4;
    }

    .setting-status {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .setting-status.active {
        background-color: rgba(6, 214, 160, 0.1);
        color: var(--success-color);
    }

    .setting-status.inactive {
        background-color: rgba(239, 71, 111, 0.1);
        color: var(--danger-color);
    }

    .setting-details {
        margin-top: auto;
        padding-top: 1.25rem;
        border-top: 1px dashed #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .setting-value {
        font-size: 0.9rem;
        color: #495057;
        max-width: 70%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .setting-value i {
        margin-right: 0.5rem;
        color: #adb5bd;
    }

    .setting-manage-btn {
        background-color: var(--primary-color);
        border: none;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 500;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        text-decoration: none;
    }

    .setting-manage-btn:hover {
        background-color: var(--secondary-color);
        color: white;
        transform: translateY(-2px);
    }

    .setting-manage-btn i {
        margin-right: 0.5rem;
    }

    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 3rem;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #dee2e6;
    }

    .empty-state h5 {
        color: #adb5bd;
        font-weight: 500;
    }

    .badge-type {
        background-color: rgba(76, 201, 240, 0.1);
        color: var(--info-color);
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .settings-grid {
            grid-template-columns: 1fr;
        }

        .settings-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .settings-search {
            width: 100%;
            margin-top: 1rem;
        }
    }
</style>

@section('content')
    <div class="settings-container">
        <div class="settings-header">
            <div class="settings-title">
                <h5>App Settings</h5>
                <p>Manage all your application settings from one place</p>
            </div>
            <div class="settings-search">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Search settings..." id="settingsSearch">
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: 10px;">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-2"></i>
                    <div>{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="settings-grid">
            @foreach ($groups as $key => $groupName)
                @php
                    $groupSettings = $settings[$key] ?? [];
                    $firstSetting = $groupSettings->first();
                    $groupCount = count($groupSettings);

                    // Get icon class based on group type
                    $iconClass = 'fas fa-cog';
                    $iconBg = 'system';

                    if ($key === 'email') {
                        $iconClass = 'fas fa-envelope';
                        $iconBg = 'email';
                    } elseif ($key === 'website') {
                        $iconClass = 'fas fa-globe';
                        $iconBg = 'website';
                    } elseif ($key === 'notification') {
                        $iconClass = 'fas fa-bell';
                        $iconBg = 'notification';
                    } elseif ($key === 'page') {
                        $iconClass = 'fas fa-file-alt';
                        $iconBg = 'page';
                    }

                    // Get status text based on group
                    $statusText = 'Configured';
                    if ($key === 'email') {
                        $statusText = $firstSetting && $firstSetting->value ? 'Configured' : 'Not Configured';
                    } elseif ($key === 'notification') {
                        $statusText = 'Enabled';
                    } elseif ($key === 'page') {
                        $statusText = 'Published';
                    }
                @endphp

                @if ($firstSetting)
                    <div class="setting-card" data-setting-name="{{ strtolower($groupName) }}">
                        <div class="setting-card-header">
                            <div class="setting-icon {{ $iconBg }}">
                                <i class="{{ $iconClass }}"></i>
                            </div>
                            <div class="setting-info">
                                <h6>{{ $groupName }}</h6>
                                <p>{{ $groupCount }} setting{{ $groupCount !== 1 ? 's' : '' }} in this group</p>
                            </div>
                            <span class="setting-status active">Active</span>
                        </div>

                        <div class="mb-3">
                            <span class="badge-type">{{ $firstSetting->group }}</span>
                        </div>

                        <div class="setting-details">
                            <div class="setting-value">
                                <i class="fas fa-info-circle"></i>
                                <span>{{ $statusText }}</span>
                            </div>
                            <a href="{{ route('admin.settings.manage', $key) }}" class="setting-manage-btn">
                                <i class="fas fa-cog"></i> Manage
                            </a>
                        </div>
                    </div>
                @endif
            @endforeach

            @if (empty($groups) || empty($settings))
                <div class="empty-state">
                    <i class="fas fa-cogs"></i>
                    <h5>No settings found</h5>
                    <p>Add some settings to get started</p>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let baseUrl = "{{ config('app.url') }}";
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('settingsSearch');
            const settingCards = document.querySelectorAll('.setting-card');

            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    const searchTerm = this.value.toLowerCase();

                    settingCards.forEach(card => {
                        const settingName = card.getAttribute('data-setting-name');

                        if (settingName.includes(searchTerm) || searchTerm === '') {
                            card.style.display = 'flex';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            }

            // Add animation on page load
            settingCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';

                setTimeout(() => {
                    card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 100 + (index * 100));
            });
        });
    </script>
@endsection
