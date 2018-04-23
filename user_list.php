<?php
/**
 * Template Name: User List Page
 */

    get_header();

    /** Items per page */
    $number = 2;

    /** Search parameter*/
    $search = $_GET['search'];

    /** Page var */
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    /** Number of users that should be passed over in the pages */
    $offset = ($paged - 1) * $number;

    // WP_User_Query arguments
    $args = array(
//        'role'           => 'Super Admin',
        'search'         => '*' . esc_attr( $search ) . '*',
        'search_columns' => array( 'user_login', 'user_nicename', 'user_email', 'display_name' ),
        'order'          => 'ASC',
        'orderby'        => 'display_name',
    );

    // The Total Users Query
    $user_query = new WP_User_Query( $args );

    $total_users = $user_query->get_total();
    $total_pages = ceil($total_users / $number);

    $args['number'] = $number;
    $args['offset'] = $offset;

    // The User Query
    $user_query = new WP_User_Query( $args );
?>
<div id="content" <?php Avada()->layout->add_style( 'content_style' ); ?>>
    <div>
        <form method="get">
            <input type="text" name="search" value="<?php echo $search; ?>">
            <button type="submit">enviar</button>
        </form>
    </div>
    <div class="fusion-text">
        <div class="table-2">
            <table width="100%">
                <thead>
                    <tr>
                        <th align="left">Avatar</th>
                        <th align="left">Username</th>
                        <th align="left">Description</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach($user_query->results as $q) { ?>
                    <tr class="user-row">
                        <td><?php echo get_avatar( $q->ID, 80 ); ?></td>
                        <td>
                            <a href="<?php echo get_author_posts_url($q->ID);?>">
                                <?php echo get_the_author_meta('display_name', $q->ID);?>
                            </a>
                        </td>
                        <td><?php echo get_the_author_meta('description', $q->ID); ?></td>
                    </tr>
                <?php }
                ?>
                </tbody>
            </table>
        </div>
        <?php fusion_pagination( $total_pages, 2 ); ?>
    </div>
</div>
<?php do_action( 'avada_after_content' ); ?>
<?php get_footer();
