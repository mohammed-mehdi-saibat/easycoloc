<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Colocation;
use App\Models\Expense;
use App\Models\Category;
use App\Models\Settlement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $categories = Category::all();

        // 1. Create System Admin
        $admin = User::updateOrCreate(
            ['email' => 'admin@easycoloc.com'],
            [
                'name' => 'Mehdi Admin',
                'password' => Hash::make('password'),
                'global_role' => 'admin',
                'reputation' => 100
            ]
        );

        // 2. Generate exactly 30 unique users
        $users = collect();
        for ($i = 1; $i <= 30; $i++) {
            $users->push(User::create([
                'name' => $faker->name,
                'email' => "user{$i}@example.com",
                'password' => Hash::make('password'),
                'reputation' => rand(10, 80),
                'global_role' => 'user'
            ]));
        }

        // 3. Create 5 Colocations
        $groupNames = ['The Code Loft', 'Tech Residency', 'Central Suites', 'Ocean Villa', 'Urban Garden'];
        
        foreach ($groupNames as $name) {
            $owner = $users->random();
            $coloc = Colocation::create([
                'name' => $name,
                'description' => $faker->sentence(8),
                'owner_id' => $owner->id
            ]);

            // Assign Owner + 5 members
            $coloc->users()->attach($owner->id, ['role' => 'owner']);
            $members = $users->where('id', '!=', $owner->id)->random(5);
            foreach ($members as $m) {
                $coloc->users()->attach($m->id, ['role' => 'member']);
            }

            // 4. Create ~10 Expenses per group
            for ($j = 0; $j < 10; $j++) {
                $payer = $coloc->users->random();
                $amount = rand(100, 2500);

                $expense = Expense::create([
                    'colocation_id' => $coloc->id,
                    'user_id' => $payer->id,
                    'category_id' => $categories->random()->id,
                    'amount' => $amount,
                    'description' => $faker->words(2, true),
                    'spent_at' => now()->subDays(rand(1, 90))
                ]);

                // Split between others
                $others = $coloc->users()->where('users.id', '!=', $payer->id)->get();
                $split = $amount / ($others->count() + 1);

                foreach ($others as $other) {
                    Settlement::create([
                        'expense_id' => $expense->id,
                        'user_id' => $other->id,
                        'amount' => $split,
                        'is_paid' => (rand(1, 10) > 5)
                    ]);
                }
            }
        }
    }
}