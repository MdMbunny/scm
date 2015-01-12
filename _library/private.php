<?php

/** Remove unused Capabilities (insert manually the list) **/
add_action( 'admin_init', 'scm_admin_remove_capabilities' );
function scm_admin_remove_capabilities(){
    $capabilities = array(); // <--------------- Inserire qui le capabilities da eliminare
    global $wp_roles;
    foreach ($capabilities as $cap) {
        foreach (array_keys($wp_roles->roles) as $role) {
            $wp_roles->remove_cap($role, $cap);
        }
    }
}

?>