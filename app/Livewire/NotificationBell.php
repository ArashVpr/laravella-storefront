<?php

namespace App\Livewire;

use Livewire\Component;

class NotificationBell extends Component
{
    public int $unreadCount = 0;
    public $notifications = [];
    public bool $showDropdown = false;

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        if (auth()->check()) {
            $this->unreadCount = auth()->user()->unreadNotifications()->count();
            $this->notifications = auth()->user()
                ->notifications()
                ->take(5)
                ->get()
                ->map(fn($n) => [
                    'id' => $n->id,
                    'type' => $n->data['type'] ?? 'general',
                    'message' => $n->data['message'] ?? '',
                    'url' => $n->data['url'] ?? '#',
                    'read_at' => $n->read_at,
                    'created_at' => $n->created_at->diffForHumans(),
                ]);
        }
    }

    public function toggleDropdown()
    {
        $this->showDropdown = !$this->showDropdown;
        if ($this->showDropdown) {
            $this->loadNotifications();
        }
    }

    public function markAsRead($notificationId)
    {
        auth()->user()
            ->notifications()
            ->findOrFail($notificationId)
            ->markAsRead();

        $this->loadNotifications();
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.notification-bell');
    }

    public function refreshNotifications()
    {
        $this->loadNotifications();
    }

    protected $listeners = ['notificationReceived' => 'loadNotifications'];
}
