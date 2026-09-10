<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;

$user = User::find(6);
if (!$user) {
    echo "User 6 not found\n";
    exit(1);
}

echo "Attributes:\n";
print_r($user->getAttributes());

echo "Relations loaded: "; var_dump($user->relationLoaded('role'));
echo "Method has role: "; var_dump(method_exists($user, 'role'));

echo "role relation class: ";
$relation = $user->role();
var_dump(get_class($relation));

echo "role relation results: ";
print_r($relation->getResults());

echo "role property: "; var_dump($user->role);

echo "--- users table columns ---\n";
$columns = DB::select('SHOW COLUMNS FROM users');
foreach ($columns as $column) {
    echo $column->Field . ' | ' . $column->Type . ' | ' . $column->Null . ' | ' . $column->Key . ' | ' . $column->Default . ' | ' . $column->Extra . "\n";
}

echo "--- roles table columns ---\n";
$roles = DB::select('SHOW COLUMNS FROM roles');
foreach ($roles as $column) {
    echo $column->Field . ' | ' . $column->Type . ' | ' . $column->Null . ' | ' . $column->Key . ' | ' . $column->Default . ' | ' . $column->Extra . "\n";
}
