<?php

namespace App\Livewire\Admin\Audit;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AuditLog;

class AuditLogIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $logs = AuditLog::with('user')
            ->when($this->search, function ($query) {
                $query->where('auditable_type', 'like', '%'.$this->search.'%')
                    ->orWhere('operation', 'like', '%'.$this->search.'%')
                    ->orWhere('message', 'like', '%'.$this->search.'%');
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.audit.audit-log-index', [
            'logs' => $logs,
        ]);
    }
}
