<?php
/*
Plugin Name: MTG Collection
Plugin URI:
Description: Creates a custom post type that will show Magic the Gathering cards
Version: 1.0
Author: Nicholas Harberg
License: GLPv2
 */


function create_mtg_collection() {
    register_post_type(
        'mtg_cards',
        array (
            'labels' => array(
                'name'               => 'MTG Cards',
                'singular_name'      => 'MTG Card',
                'add_new'            => 'Add New',
                'add_new_item'       => 'Add New MTG Card',
                'edit'               => 'Edit',
                'edit_item'          => 'Edit MTG Card',
                'new_item'           => 'New MTG Card',
                'view'               => 'View',
                'view_item'          => 'View MTG Card',
                'search_items'       => 'Search MTG Cards',
                'not_found'          => 'No MTG Cards found',
                'not_found_in_trash' => 'No MTG Cards found in Trash',
                'parent'             => 'Parent Movie Review'
            ),
            'public'        => true,
            'menu_position' => 15,
            'supports'      => array( 'title', 'editor', 'comments', 'thumbnail' ),
            'taxonomies'    => array(''),
            'menu_icon'     => 'dashicons-id-alt',
            'has_arcive'    => true
        )
    );
}// end create_mtg_collection

function my_admin() {
    add_meta_box(
        'mtg_card_meta_box',
        'MTG Card Info',
        'display_mtg_card_meta_box',
        'mtg_cards',
        'advanced',
        'high'
    );
}// end my_admin()

function display_mtg_card_meta_box( $mtg_card ) {
    // Retrive current Set based on card
    $card_set = esc_html( get_post_meta( $mtg_card->ID, 'card_set', true ) );
    $card_rarity = esc_html( get_post_meta( $mtg_card->ID, 'card_rarity', true ) );
    ?>
    <table>
        <tr>
            <td style="width: 150px">MTG Card Set</td>
            <td>
                <input type="text" name="card_set_name" value="<?php echo $card_set; ?>" />
            </td>
        </tr>
        <tr>
            <td style="width: 150px">MTG Card Rarity</td>
            <td>
                <select style="width:100px" name="card_rarity_name">
                <?php
                    $rarity = ['Common', 'Uncommon', 'Rare', 'Mythic'];
                    echo $rarity;
                    for( $i = 0; $i < count($rarity); $i++) { ?>
                        <option value="<?php echo $rarity[$i]; ?>" ><?php echo $rarity[$i]; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
    </table>
 <?php } // end display_mtg_card_meta_box();

function add_mtg_card_fields( $mtg_card_id, $mtg_card ) {
    // Check post type for mtg cards
    if ( $mtg_card->post_type = 'mtg_cards' ) {
        // Store data in post meta table if present in post data
        if ( isset( $_POST['card_set_name'] ) && $_POST['card_set_name'] != '') {
            update_post_meta( $mtg_card_id, 'card_set', $_POST['card_set_name'] );
        }
        if ( isset( $_POST['card_rarity_name'] ) && $_POST['card_rarity_name'] != '' ) {
            update_post_meta( $mtg_card_id, 'card_rarity', $_POST['card_rarity_name'] );
        }
    }
}// end add_mtg_card_fields()

function include_template_function( $template_path ) {
    //if( get_post_type() == 'mtg_cards' ) {
        if( is_page( 'cards' ) ) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if( $theme_file = locate_template( array( 'mtg_cards.php') ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/mtg_cards.php';
            }
        }
    //}
    return $template_path;
}

add_action( 'save_post', 'add_mtg_card_fields', 10, 2);
add_action( 'init', 'create_mtg_collection' );
add_action( 'admin_init', 'my_admin' );

add_filter( 'template_include', 'include_template_function', 1 );


















