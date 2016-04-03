<?php

namespace EmergencyExplorer\Http\View\Helper;

class NavigationHelper
{
    const HOME          = 'home';
    const LOGIN         = 'login';
    const USERS         = 'users';
    const PROJECTS      = 'projects';
    const DASHBOARD     = 'dashboard';
    const NOTIFICATIONS = 'notifications';

    protected $section = self::HOME;

    /**
     * @param string $section
     */
    public function setSection(string $section)
    {
        $this->section = $section;
    }

    /**
     * @return string
     */
    public function getSection()
    {
        return $this->section;
    }
    
    /**
     * Check if current section equals $section
     *
     * @param string $section
     *
     * @return bool
     */
    public function is(string $section)
    {
        return $this->section === $section ? 'active' : '';
    }

    /**
     * (Sugar) Check if current section equals home
     *
     * @return bool
     */
    public function isHome()
    {
        return $this->is(self::HOME);
    }

    /**
     * (Sugar) Check if current section equals projects
     *
     * @return bool
     */
    public function isProjects()
    {
        return $this->is(self::PROJECTS);
    }

    /**
     * (Sugar) Check if current section equals users
     *
     * @return bool
     */
    public function isUsers()
    {
        return $this->is(self::USERS);
    }

    /**
     * (Sugar) Check if current section equals login
     *
     * @return bool
     */
    public function isLogin()
    {
        return $this->is(self::LOGIN);
    }
}