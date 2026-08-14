@extends('layouts.app')

@section('title', 'Latest Notifications & Job Updates - SarkariResult.mobi')
@section('meta_description', 'Real-time notifications for latest Sarkari Jobs, Results, Admit Cards, Answer Keys, and Admission notices.')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h1 class="h3 font-weight-bold mb-0">
            <i class="fas fa-bell text-primary me-2"></i> All Notifications &amp; Live Alerts
        </h1>
        <button type="button" class="btn btn-outline-primary btn-sm" onclick="markAllNotificationsRead()">
            <i class="fas fa-check-double me-1"></i> Mark All as Read
        </button>
    </div>

    <div class="card shadow-sm border-0 rounded-lg overflow-hidden">
        <div class="list-group list-group-flush">
            @forelse($notifications as $notif)
            <a href="{{ $notif->link ?: '#' }}" class="list-group-item list-group-item-action p-3 {{ !$notif->is_read ? 'bg-light font-weight-bold border-left-primary' : '' }}" style="{{ !$notif->is_read ? 'border-left: 4px solid #3b82f6;' : '' }}">
                <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                    <div class="d-flex align-items-center">
                        <i class="fas {{ $notif->icon ?: 'fa-bell text-primary' }} fa-lg me-3"></i>
                        <h6 class="mb-0 text-dark font-weight-bold">{{ $notif->title }}</h6>
                    </div>
                    <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                </div>
                <p class="mb-1 text-secondary small ms-4 ps-2">{{ $notif->message }}</p>
            </a>
            @empty
            <div class="text-center py-5 text-muted">
                <i class="fas fa-bell-slash fa-3x mb-3 text-secondary"></i>
                <h5>No notifications yet</h5>
                <p class="small">Notifications for new jobs, admit cards, and results will appear here in real time.</p>
            </div>
            @endforelse
        </div>
        @if($notifications->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $notifications->links() }}
        </div>
        @endif
    </div>
</div>

<script>
function markAllNotificationsRead() {
    fetch('{{ route("notifications.mark-read") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    }).then(res => res.json())
      .then(res => {
          if (res.success) {
              window.location.reload();
          }
      });
}
</script>
@endsection
