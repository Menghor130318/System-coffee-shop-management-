<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Role;
use App\Models\User;

$user = User::find(6);
if (!$user) {
    echo "USER 6 NOT FOUND\n";
    exit(1);
}

var_dump(get_class($user));
var_dump(method_exists($user, 'role'));
var_dump($user->getTable());
var_dump($user->role_id);
var_dump($user->relationLoaded('role'));

$role = $user->role;
var_dump($role);
$role1 = Role::find(1);
var_dump($role1);
