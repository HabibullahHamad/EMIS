@extends('welcome')
@section('title', 'Dashboard')
@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Welcome to EOMIS Dashboard</h2>
    <div class="row">
        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h5><i class="fa-solid fa-briefcase"></i> Tasks Pending</h5>
                <h3 class="text-primary">12</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h5><i class="fa-solid fa-envelope-open-text"></i> New Mails</h5>
                <h3 class="text-success">7</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h5><i class="fa-solid fa-users"></i> Active Users</h5>
                <h3 class="text-warning">25</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
            <h5><i class="fa-solid fa-chart-line"></i> Sales This Month</h5>
            <h3 class="text-info">$5000</h3>
            </div>
        </div>
        
    </div>
</div>
<!-- Task Bar -->
<div class="row mt-4">
  <div class="col-12">
    <div class="card border-0 shadow-sm rounded-4">
      <div class="card-header bg-white border-0 d-flex align-items-center justify-content-between py-3">
        <h5 class="mb-0 fw-semibold text-primary">📝 Task Management</h5>
        <a href="" class="btn btn-sm btn-primary">
          ➕ Add Task
        </a>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th style="width: 50px;">#</th>
                <th>Title</th>
                <th>Assigned To</th>
                <th>Due Date</th>
                <th>Priority</th>
                <th>Status</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($tasks ?? [] as $task)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="fw-semibold">{{ $task->title ?? '-' }}</td>
                <td>{{ $task->assigned_to ?? '-' }}</td>
                <td>{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y') : '-' }}</td>

                <td>
                  @switch(strtolower($task->priority ?? ''))
                      @case('high')
                          <span class="badge bg-danger">High</span>
                          @break
                      @case('medium')
                          <span class="badge bg-warning text-dark">Medium</span>
                          @break
                      @case('low')
                          <span class="badge bg-success">Low</span>
                          @break
                      @default
                          <span class="badge bg-light text-dark">Unknown</span>
                  @endswitch
                </td>

                <td>
                  @php $status = strtolower($task->status ?? 'unknown'); @endphp
                  @if(in_array($status, ['completed','done']))
                      <span class="badge bg-success">✔ Completed</span>
                  @elseif(in_array($status, ['pending','awaiting']))
                      <span class="badge bg-warning text-dark">⏳ Pending</span>
                  @elseif(in_array($status, ['in progress','in_progress','progress']))
                      <span class="badge bg-info text-dark">🔄 In Progress</span>
                  @elseif(in_array($status, ['overdue','late']))
                      <span class="badge bg-danger">⚠ Overdue</span>
                  @elseif(in_array($status, ['on hold','on-hold']))
                      <span class="badge bg-secondary">⏸ On Hold</span>
                  @else
                      <span class="badge bg-light text-dark">{{ ucfirst($task->status ?? 'Unknown') }}</span>
                  @endif
                </td>

                <td class="text-end">
                  <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-sm btn-outline-primary" title="View Task">
                    View
                  </a>
                  <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-outline-secondary" title="Edit Task">
                    Edit
                  </a>
                  <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this task?');">
                      Delete
                    </button>
                  </form>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="7" class="text-center text-muted py-4">
                  📭 No tasks available
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="mt-4 small text-muted">
          <span class="me-3"><span class="badge bg-success">✔ Completed</span></span>
          <span class="me-3"><span class="badge bg-warning text-dark">⏳ Pending</span></span>
          <span class="me-3"><span class="badge bg-info text-dark">🔄 In Progress</span></span>
          <span class="me-3"><span class="badge bg-danger">⚠ Overdue</span></span>
          <span class="me-3"><span class="badge bg-secondary">⏸ On Hold</span></span>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- end tast bar -->

</div>
@endsection
