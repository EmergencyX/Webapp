<?php

namespace EmergencyExplorer\Providers;

use Laravel\Passport\Passport;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use EmergencyExplorer\Models\User;
use EmergencyExplorer\Models\Project;
use EmergencyExplorer\Models\Invitation;

use EmergencyExplorer\Policies\UserPolicy;
use EmergencyExplorer\Policies\ProjectPolicy;
use EmergencyExplorer\Policies\InvitationPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Invitation::class => InvitationPolicy::class,
        Project::class    => ProjectPolicy::class,
        User::class       => UserPolicy::class,
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);


        //Laravel Passport Setup
        Passport::tokensCan([
            'show-project' => 'Projekte ansehen',
        ]);
        Passport::routes();
    }
}
