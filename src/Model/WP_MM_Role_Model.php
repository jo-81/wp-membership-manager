<?php

namespace Wp_Membership_Manager\Model;

class WP_MM_Role_Model
{
    const SUFFIX = "wp_mm_role_";
    
    /**
     * get_roles
     *
     * @return array<int, \WP_Role>
     */
    public function get_roles(): array
    {
        $roles = [];

        foreach(wp_roles()->roles as $role => $caps) {
            if (! preg_match("#". self::SUFFIX ."#", $role)) : continue; endif;

            $roleI = new \WP_Role($role, $caps);
            $roleI->display_name = $caps['name'] ?? "";

            $roles[] = $roleI;
        }

        return $roles;
    }

    public function remove(string $role_name)
    {
        if (! $this->can($role_name)) {
            return false;
        }
        
        remove_role($role_name);

        return true;
    }

    public function exist(string $role_name): bool
    {
        if (! preg_match("#". self::SUFFIX ."#", $role_name)) {
            return false;
        }

        return get_role($role_name) instanceof \WP_Role;
    }

    public function can(string $role_name)
    {
        return ! in_array($role_name, ['administrator', 'editor', 'author', 'contributor', 'subcriber']);
    }
}