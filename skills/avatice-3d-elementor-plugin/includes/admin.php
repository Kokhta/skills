<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Avatice_3D_Admin {

    public function __construct() {
        add_action( 'admin_menu', [ $this, 'add_menu_page' ] );
    }

    public function add_menu_page() {
        add_menu_page(
            'Avatice 3D',
            'Avatice 3D',
            'manage_options',
            'avatice-3d',
            [ $this, 'render_admin_page' ],
            'dashicons-3d-viewer',
            60
        );
    }

    public function render_admin_page() {
        if ( isset($_POST['avatice_create_page']) && check_admin_referer('avatice_create_3d_page', 'avatice_nonce') ) {
            $title = sanitize_text_field($_POST['page_title']);
            $page_id = Avatice_3D_Elementor::instance()->create_3d_page($title);

            if ($page_id) {
                echo '<div class="updated"><p>Page created successfully! <a href="' . get_edit_post_link($page_id, 'elementor') . '">Edit with Elementor</a></p></div>';
            } else {
                echo '<div class="error"><p>Failed to create page.</p></div>';
            }
        }
        ?>
        <div class="wrap">
            <h1>Avatice 3D Settings</h1>
            <div class="card">
                <h2>Create New 3D Design Page</h2>
                <p>Enter a title below to create a new page pre-configured with the Avatice 3D Scroll Experience skeleton.</p>
                <form method="post" action="">
                    <?php wp_nonce_field('avatice_create_3d_page', 'avatice_nonce'); ?>
                    <table class="form-table">
                        <tr>
                            <th scope="row"><label for="page_title">Page Title</label></th>
                            <td><input name="page_title" type="text" id="page_title" value="New 3D Experience" class="regular-text" required></td>
                        </tr>
                    </table>
                    <p class="submit">
                        <input type="submit" name="avatice_create_page" id="submit" class="button button-primary" value="Create 3D Page">
                    </p>
                </form>
            </div>
        </div>
        <?php
    }
}
