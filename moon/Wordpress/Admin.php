<?php

namespace Moon\Wordpress;

class Admin
{
    public static function init(): void
    {
        add_action('init', [__CLASS__, 'addClientAdminRole']);
        add_action('init', [__CLASS__, 'changeAdminRoleName']);
        add_filter('editable_roles', [__CLASS__, 'filterEditableRoles']);
        add_action('after_switch_theme', [__CLASS__, 'themeActivationNotice']);
    }

    public static function changeAdminRoleName()
    {
        global $wp_roles;
        if (!isset($wp_roles)) {
            $wp_roles = new WP_Roles();
        }
        $wp_roles->roles['administrator']['name'] = 'SoBold Admin';
        $wp_roles->role_names['administrator'] = 'SoBold Admin';
    }

    public static function addClientAdminRole()
    {
        if (!array_key_exists('client_admin', $GLOBALS['wp_roles']->roles)) {
            add_role(
                'client_admin',
                __('Client Admin'),
                [
                    'read'                      => true,
                    'publish_posts'             => true,
                    'edit_posts'                => true,
                    'delete_posts'              => true,
                    'edit_published_posts'      => true,
                    'edit_others_posts'         => true,
                    'read_private_posts'        => true,
                    'edit_private_posts'        => true,
                    'delete_private_posts'      => true,
                    'manage_categories'         => true,
                    'upload_files'              => true,
                    'edit_attachments'          => true,
                    'delete_attachments'        => true,
                    'read_others_attachments'   => true,
                    'edit_others_attachments'   => true,
                    'delete_others_attachments' => true,
                    'publish_pages'             => true,
                    'edit_pages'                => true,
                    'delete_pages'              => true,
                    'edit_published_pages'      => true,
                    'delete_published_pages'    => true,
                    'edit_others_pages'         => true,
                    'delete_others_pages'       => true,
                    'read_private_pages'        => true,
                    'edit_private_pages'        => true,
                    'delete_private_pages'      => true,
                    'moderate_comments'         => true,
                    'activate_plugins'          => true,
                    'install_plugins'           => true,
                    'update_plugins'            => true,
                    'list_users'                => true,
                    'create_users'              => true,
                    'unfiltered_html'           => true,
                    'manage_links'              => true,
                    'level_0'                   => true,
                    'level_1'                   => true,
                    'level_2'                   => true,
                    'level_3'                   => true,
                    'level_4'                   => true,
                    'level_5'                   => true,
                    'level_6'                   => true,
                    'level_7'                   => true,
                    'publish_blocks'            => true,
                    'edit_blocks'               => true,
                    'delete_blocks'             => true,
                    'edit_published_blocks'     => true,
                    'delete_published_blocks'   => true,
                    'edit_others_blocks'        => true,
                    'delete_others_blocks'      => true,
                    'read_private_blocks'       => true,
                    'edit_private_blocks'       => true,
                    'delete_private_blocks'     => true,
                    'create_blocks'             => true,
                    'read_blocks'               => true,
                    'edit_comment'              => true,
                ]
            );
        }
    }

    public static function filterEditableRoles($allRoles)
    {
        if (!is_super_admin(get_current_user_id())) {
            unset($allRoles['administrator']);
        }
        return $allRoles;
    }

    public static function themeActivationNotice()
    {
        $notice = <<<HTML
        <div class="error notice is-dismissible">
            <p>
                <strong>Important!</strong>
                - Remember to mark the site as non-indexable to search engines when in development.</p>
        </div>
        HTML;

        echo $notice;
    }
}
