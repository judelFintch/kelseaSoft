<?php

namespace App\Livewire\Admin\AuditLog;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AuditLog;

class AuditLogIndex extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $logs = AuditLog::with('user')
            ->when($this->search, function ($query) {
                $query->where('message', 'like', "%{$this->search}%")
                    ->orWhere('operation', 'like', "%{$this->search}%")
                    ->orWhere('auditable_type', 'like', "%{$this->search}%");
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.audit-log.audit-log-index', [
            'logs' => $logs,
        ])->layout('layouts.app');
    }
}
