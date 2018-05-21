<?php

namespace App\Providers;

use App\Semester;
use App\User;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $pdo = new \PDO(getenv('DB_CONNECTION').':host='.getenv('DB_HOST').';dbname='.getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
        $query = $pdo->query("SHOW TABLES 'Table_Name' ");
        if($query){
          // assign new users to the latest group (for now)
          $defaultGroup = Semester::orderBy('id', 'desc')->first();

          User::created(function ($user) use ($defaultGroup) {
              $user->semesters()->attach($defaultGroup->id);
          });
        }
    }
}
