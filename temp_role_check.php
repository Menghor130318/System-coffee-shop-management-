<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Role;
use App\Models\User;

foreach (Role::all() as $role) {
    echo "ROLE: {$role->id} | {$role->name}\n";
}
echo "---\n";

foreach (User::with('role')->get() as $user) {
    $roleName = $user->role?->name ?? 'NULL';
    echo "USER: {$user->id} | {$user->full_name} | {$user->email} | role_id={$user->role_id} | role={$roleName}\n";
}
