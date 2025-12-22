@include('new')
@section('content')

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- User Popup Modal -->
<div id="userModal" class="user-modal-overlay">
    <div class="user-modal">

        <div class="user-modal-header">
            <div class="avatar-big">H</div>
            <span class="role-badge">Admin</span>
            <h4>{{ auth()->user()->name }}</h4>
        </div>
        <div class="user-modal-body">
            <a href="{{ route('settings') }}" class="modal-btn">
                ⚙️ Settings
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="modal-btn logout">
                    ⏻ Logout
                </button>
            </form>
        </div>

    </div>
</div>

<!-- Inbox Table -->


@endsection