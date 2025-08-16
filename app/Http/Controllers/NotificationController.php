<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    public function latest(Request $request): JsonResponse
    {
        $logs = AuditLog::with('user')
            ->whereIn('auditable_type', [\App\Models\Folder::class, \App\Models\Invoice::class])
            ->where('operation', 'CREATE')
            ->orderByDesc('created_at')
            ->take(5)
            ->get()
            ->map(function (AuditLog $log) {
                $user = $log->user;

                return [
                    'type' => class_basename($log->auditable_type),
                    'details' => $log->new_data['folder_number'] ?? ($log->new_data['invoice_number'] ?? ''),
                    'user_name' => $user?->name,
                    'avatar_url' => $user && $user->avatar
                        ? asset('storage/' . $user->avatar)
                        : asset('src/images/user/owner.jpg'),
                    'time' => $log->created_at->diffForHumans(),
                ];
            });

        return response()->json($logs);
    }
}
