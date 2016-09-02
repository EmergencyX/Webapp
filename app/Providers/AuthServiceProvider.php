<?php

namespace EmergencyExplorer\Providers;

use EmergencyExplorer\Policies\UserPolicy;
use EmergencyExplorer\User;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Laravel\Passport\Passport;

use EmergencyExplorer\Invitation;
use EmergencyExplorer\Policies\InvitationPolicy;

use EmergencyExplorer\Project;
use EmergencyExplorer\Policies\ProjectPolicy;

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


        Passport::tokensCan([
            'show-project' => 'Projekte ansehen',
        ]);

        Passport::routes();
    }
}
