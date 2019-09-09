<?php

declare(strict_types = 1);

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

/**
 * Class UserCreateCommand
 * @package App\Console\Commands
 */
class UserCreateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new admin user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {
        $name = $this->ask('What is user Name?');
        $email = $this->ask('What is user E-mail?');
        $password = $this->secret('Enter user password');

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        $this->line('User created successfully!');
    }
}
