<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Mail\InactiveUserNotification;
use Illuminate\Support\Facades\Mail;

class SendInactiveUserNotifications extends Command
{
    protected $signature = 'notifications:send-inactive-users';
    protected $description = 'Sends mails for inactive users - 10 days.';

    public function handle(): void
    {
        $users = User::where('last_login_at', '<', now()->subDays(10))
            ->where('notifications_inactive', true)
            ->get();

        if ($users->isEmpty()) {
            $this->info('Žádní neaktivní uživatelé nebyli nalezeni.');
            return;
        }

        foreach ($users as $user) {
            if ($this->isBlockedDomain($user->email)) {
                $this->warn("Přeskočeno: {$user->email} (zakázaná doména)");
                continue;
            }

            Mail::to($user->email)->send(new InactiveUserNotification($user));
            $this->line("Odeslán email: {$user->email}");
        }

        $this->info('Notifikace byly odeslány.');
    }

    protected function isBlockedDomain(string $email): bool
    {
        $blockedDomains = ['example.com', 'example.org', 'example.net'];

        $domain = substr(strrchr($email, "@"), 1);

        return in_array(strtolower($domain), $blockedDomains);
    }

}
