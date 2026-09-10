<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;

echo "User model class: " . get_class(User::class) . "\n";
$user = User::find(6);
if (!$user) {
    echo "User not found\n";
    exit(1);
}

print_r($user->getAttributes());
echo "role attr: "; var_dump($user->getAttribute('role'));
echo "relation loaded: "; var_dump($user->relationLoaded('role'));
echo "method exists role: "; var_dump(method_exists($user, 'role'));
$roleRelation = $user->role();
echo "role() class: " . get_class($roleRelation) . "\n";
$roleResults = $roleRelation->getResults();
var_dump($roleResults?->name);

echo "role property: "; var_dump($user->role);

echo "-- users columns --\n";
$columns = DB::select('SHOW COLUMNS FROM users');
foreach ($columns as $column) {
    echo $column->Field . ' | ' . $column->Type . ' | ' . $column->Null . ' | ' . $column->Key . ' | ' . $column->Default . ' | ' . $column->Extra . "\n";
}

echo "-- roles columns --\n";
$columns = DB::select('SHOW COLUMNS FROM roles');
foreach ($columns as $column) {
    echo $column->Field . ' | ' . $column->Type . ' | ' . $column->Null . ' | ' . $column->Key . ' | ' . $column->Default . ' | ' . $column->Extra . "\n";
}
