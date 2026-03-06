<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class GenerateUserTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:tokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate authentication tokens for all users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->error('No users found in the database.');
            return 1;
        }

        $this->info('Generating tokens for all users...');
        $this->newLine();

        $tokens = [];

        foreach ($users as $user) {
            // Delete existing tokens (optional)
            $user->tokens()->delete();

            // Create new token
            $token = $user->createToken('api-token')->plainTextToken;
            
            $tokens[] = [
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'token' => $token,
            ];

            $this->line("✓ Token generated for: {$user->name} ({$user->email})");
        }

        $this->newLine();
        $this->info("Successfully generated tokens for {$users->count()} user(s)!");
        $this->newLine();

        // Display tokens table
        $this->table(
            ['User ID', 'Name', 'Email', 'Token'],
            $tokens
        );
    }
}
