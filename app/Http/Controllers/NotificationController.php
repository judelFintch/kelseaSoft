<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

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

    public function getLatestNotification(Request $request): JsonResponse
    {
        $user = Auth::user();
        $notification = $user->unreadNotifications()->latest()->first();

        if ($notification) {
            return response()->json($notification);
        }

        return response()->json(null);
    }

    public function markAsRead(Request $request, $notificationId)
    {
        $user = Auth::user();
        $notification = $user->notifications()->findOrFail($notificationId);
        $notification->markAsRead();

        return response()->json(['status' => 'success']);
    }
}
