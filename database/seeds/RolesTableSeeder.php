<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Role;
class RolesTableSeeder extends Seeder{
    public function run()
    {
        if (App::environment() === 'production') {
            exit('I just stopped you getting fired. Love, Amo.');
        }
        DB::table('roles')->truncate();
        Role::create([
            'id'            => 1,
            'name'          => 'Root',
            'description'   => 'Placeholder (same as admin for now). Use this account with extreme caution. When using this account it is possible to cause irreversible damage to the system.'
        ]);
        Role::create([
            'id'            => 2,
            'name'          => 'Administrator',
            'description'   => 'Full access to admin area.'
        ]);
        Role::create([
            'id'            => 3,
            'name'          => 'Grader',
            'description'   => 'Ability to see all users and verify user has completed worksheets/calulators'
        ]);
    }
}
