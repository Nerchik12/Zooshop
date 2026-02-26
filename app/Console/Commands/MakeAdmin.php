<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class MakeAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:make-admin {email? : Email пользователя}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Выдать роль администратора пользователю';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');

        if (!$email) {
            $email = $this->ask('Введите email пользователя');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("Пользователь с email '{$email}' не найден.");
            return 1;
        }

        if ($user->role === 'admin') {
            $this->warn("Пользователь '{$user->name}' уже является администратором.");
            return 0;
        }

        $user->update(['role' => 'admin']);

        $this->info("✓ Пользователь '{$user->name}' ({$user->email}) теперь администратор!");
        $this->info("Админ-панель доступна по адресу: /admin");

        return 0;
    }
}
