<?php
/**
 * Page d'administration pour gérer les messages de contact
 */

// Empêcher l'accès direct
if (!defined('ABSPATH')) {
    exit;
}

// Ajouter le menu dans l'admin
function mada_contact_messages_menu() {
    add_menu_page(
        'Messages de Contact',
        'Messages',
        'manage_options',
        'mada-contact-messages',
        'mada_contact_messages_page',
        'dashicons-email',
        26
    );
}
add_action('admin_menu', 'mada_contact_messages_menu');

// Page d'administration des messages
function mada_contact_messages_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_messages';
    
    // Traiter les actions
    if (isset($_GET['action']) && isset($_GET['message_id'])) {
        $message_id = intval($_GET['message_id']);
        
        switch ($_GET['action']) {
            case 'mark_read':
                check_admin_referer('mark_read_' . $message_id);
                $wpdb->update(
                    $table_name,
                    array('status' => 'read'),
                    array('id' => $message_id),
                    array('%s'),
                    array('%d')
                );
                echo '<div class="notice notice-success"><p>Message marqué comme lu.</p></div>';
                break;
                
            case 'mark_unread':
                check_admin_referer('mark_unread_' . $message_id);
                $wpdb->update(
                    $table_name,
                    array('status' => 'unread'),
                    array('id' => $message_id),
                    array('%s'),
                    array('%d')
                );
                echo '<div class="notice notice-success"><p>Message marqué comme non lu.</p></div>';
                break;
                
            case 'delete':
                check_admin_referer('delete_' . $message_id);
                $wpdb->delete(
                    $table_name,
                    array('id' => $message_id),
                    array('%d')
                );
                echo '<div class="notice notice-success"><p>Message supprimé.</p></div>';
                break;
        }
    }
    
    // Export CSV
    if (isset($_GET['export']) && $_GET['export'] === 'csv') {
        check_admin_referer('export_messages');
        
        $messages = $wpdb->get_results("SELECT * FROM $table_name ORDER BY date_submitted DESC");
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=messages_contact_' . date('Y-m-d') . '.csv');
        
        $output = fopen('php://output', 'w');
        fputcsv($output, array('ID', 'Nom', 'Email', 'Sujet', 'Message', 'IP', 'Date', 'Statut'));
        
        foreach ($messages as $msg) {
            fputcsv($output, array(
                $msg->id,
                $msg->name,
                $msg->email,
                $msg->subject,
                $msg->message,
                $msg->ip_address,
                $msg->date_submitted,
                $msg->status
            ));
        }
        
        fclose($output);
        exit;
    }
    
    // Pagination
    $per_page = 20;
    $current_page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
    $offset = ($current_page - 1) * $per_page;
    
    // Filtres
    $status_filter = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : 'all';
    $search = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
    
    // Construire la requête
    $where = "WHERE 1=1";
    
    if ($status_filter !== 'all') {
        $where .= $wpdb->prepare(" AND status = %s", $status_filter);
    }
    
    if (!empty($search)) {
        $where .= $wpdb->prepare(
            " AND (name LIKE %s OR email LIKE %s OR subject LIKE %s OR message LIKE %s)",
            '%' . $wpdb->esc_like($search) . '%',
            '%' . $wpdb->esc_like($search) . '%',
            '%' . $wpdb->esc_like($search) . '%',
            '%' . $wpdb->esc_like($search) . '%'
        );
    }
    
    $total_messages = $wpdb->get_var("SELECT COUNT(*) FROM $table_name $where");
    $messages = $wpdb->get_results("SELECT * FROM $table_name $where ORDER BY date_submitted DESC LIMIT $per_page OFFSET $offset");
    
    // Statistiques
    $total_unread = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE status = 'unread'");
    $total_read = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE status = 'read'");
    $total_all = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
    
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">📬 Messages de Contact</h1>
        <a href="<?php echo wp_nonce_url(add_query_arg('export', 'csv'), 'export_messages'); ?>" 
           class="page-title-action">
            <i class="dashicons dashicons-download"></i> Exporter en CSV
        </a>
        <hr class="wp-header-end">
        
        <!-- Statistiques -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin: 20px 0;">
            <div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-left: 4px solid #2271b1;">
                <h3 style="margin: 0 0 10px 0; color: #2271b1;">Total</h3>
                <p style="font-size: 32px; font-weight: bold; margin: 0;"><?php echo number_format($total_all); ?></p>
            </div>
            
            <div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-left: 4px solid #d63638;">
                <h3 style="margin: 0 0 10px 0; color: #d63638;">Non lus</h3>
                <p style="font-size: 32px; font-weight: bold; margin: 0;"><?php echo number_format($total_unread); ?></p>
            </div>
            
            <div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-left: 4px solid #00a32a;">
                <h3 style="margin: 0 0 10px 0; color: #00a32a;">Lus</h3>
                <p style="font-size: 32px; font-weight: bold; margin: 0;"><?php echo number_format($total_read); ?></p>
            </div>
        </div>
        
        <!-- Filtres et recherche -->
        <div style="background: #fff; padding: 15px; margin: 20px 0; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <form method="get" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                <input type="hidden" name="page" value="mada-contact-messages">
                
                <select name="status" style="height: 32px;">
                    <option value="all" <?php selected($status_filter, 'all'); ?>>Tous les statuts</option>
                    <option value="unread" <?php selected($status_filter, 'unread'); ?>>Non lus</option>
                    <option value="read" <?php selected($status_filter, 'read'); ?>>Lus</option>
                </select>
                
                <input type="search" 
                       name="s" 
                       value="<?php echo esc_attr($search); ?>" 
                       placeholder="Rechercher..."
                       style="width: 300px;">
                
                <button type="submit" class="button">Filtrer</button>
                
                <?php if ($status_filter !== 'all' || !empty($search)): ?>
                    <a href="<?php echo admin_url('admin.php?page=mada-contact-messages'); ?>" 
                       class="button">Réinitialiser</a>
                <?php endif; ?>
            </form>
        </div>
        
        <!-- Liste des messages -->
        <?php if ($messages): ?>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th style="width: 40px;">ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Sujet</th>
                        <th style="width: 150px;">Date</th>
                        <th style="width: 80px;">Statut</th>
                        <th style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($messages as $msg): ?>
                        <tr <?php echo $msg->status === 'unread' ? 'style="background: #fff8e1;"' : ''; ?>>
                            <td><strong>#<?php echo $msg->id; ?></strong></td>
                            <td><?php echo esc_html($msg->name); ?></td>
                            <td>
                                <a href="mailto:<?php echo esc_attr($msg->email); ?>">
                                    <?php echo esc_html($msg->email); ?>
                                </a>
                            </td>
                            <td>
                                <strong><?php echo esc_html($msg->subject); ?></strong>
                                <button type="button" 
                                        class="button-link view-message" 
                                        data-message='<?php echo esc_attr(json_encode($msg)); ?>'
                                        style="display: block; margin-top: 5px; color: #2271b1;">
                                    Voir le message complet
                                </button>
                            </td>
                            <td><?php echo date('d/m/Y H:i', strtotime($msg->date_submitted)); ?></td>
                            <td>
                                <span style="padding: 3px 8px; border-radius: 3px; font-size: 11px; font-weight: 600;
                                    background: <?php echo $msg->status === 'unread' ? '#d63638' : '#00a32a'; ?>; 
                                    color: white;">
                                    <?php echo $msg->status === 'unread' ? 'Non lu' : 'Lu'; ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($msg->status === 'unread'): ?>
                                    <a href="<?php echo wp_nonce_url(add_query_arg(array('action' => 'mark_read', 'message_id' => $msg->id)), 'mark_read_' . $msg->id); ?>" 
                                       class="button button-small">
                                        Marquer lu
                                    </a>
                                <?php else: ?>
                                    <a href="<?php echo wp_nonce_url(add_query_arg(array('action' => 'mark_unread', 'message_id' => $msg->id)), 'mark_unread_' . $msg->id); ?>" 
                                       class="button button-small">
                                        Marquer non lu
                                    </a>
                                <?php endif; ?>
                                
                                <a href="<?php echo wp_nonce_url(add_query_arg(array('action' => 'delete', 'message_id' => $msg->id)), 'delete_' . $msg->id); ?>" 
                                   class="button button-small button-link-delete"
                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?');">
                                    Supprimer
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <!-- Pagination -->
            <?php
            $total_pages = ceil($total_messages / $per_page);
            if ($total_pages > 1):
            ?>
                <div class="tablenav bottom">
                    <div class="tablenav-pages">
                        <?php
                        echo paginate_links(array(
                            'base' => add_query_arg('paged', '%#%'),
                            'format' => '',
                            'prev_text' => '&laquo;',
                            'next_text' => '&raquo;',
                            'total' => $total_pages,
                            'current' => $current_page
                        ));
                        ?>
                    </div>
                </div>
            <?php endif; ?>
            
        <?php else: ?>
            <div style="background: #fff; padding: 40px; text-align: center; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <p style="font-size: 18px; color: #666;">
                    <?php echo !empty($search) || $status_filter !== 'all' ? 'Aucun message trouvé avec ces critères.' : 'Aucun message reçu pour le moment.'; ?>
                </p>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Modal pour afficher le message complet -->
    <div id="message-modal" style="display: none; position: fixed; z-index: 100000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
        <div style="background-color: #fefefe; margin: 5% auto; padding: 0; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 80%; max-width: 700px;">
            <div style="padding: 20px; border-bottom: 1px solid #ddd; display: flex; justify-content: space-between; align-items: center;">
                <h2 style="margin: 0;">Message #<span id="modal-message-id"></span></h2>
                <button type="button" id="close-modal" style="background: none; border: none; font-size: 28px; cursor: pointer; color: #666;">&times;</button>
            </div>
            <div style="padding: 20px;">
                <div style="margin-bottom: 15px;">
                    <strong>De:</strong> <span id="modal-name"></span> &lt;<a href="#" id="modal-email"></a>&gt;
                </div>
                <div style="margin-bottom: 15px;">
                    <strong>Sujet:</strong> <span id="modal-subject"></span>
                </div>
                <div style="margin-bottom: 15px;">
                    <strong>Date:</strong> <span id="modal-date"></span>
                </div>
                <div style="margin-bottom: 15px;">
                    <strong>IP:</strong> <span id="modal-ip"></span>
                </div>
                <div style="padding: 15px; background: #f9f9f9; border-radius: 4px; border-left: 4px solid #2271b1;">
                    <strong style="display: block; margin-bottom: 10px;">Message:</strong>
                    <div id="modal-message" style="white-space: pre-wrap; line-height: 1.6;"></div>
                </div>
            </div>
            <div style="padding: 20px; border-top: 1px solid #ddd; text-align: right;">
                <a href="#" id="modal-reply" class="button button-primary">Répondre par email</a>
            </div>
        </div>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        // Afficher le modal
        $('.view-message').on('click', function() {
            var message = $(this).data('message');
            
            $('#modal-message-id').text(message.id);
            $('#modal-name').text(message.name);
            $('#modal-email').attr('href', 'mailto:' + message.email).text(message.email);
            $('#modal-subject').text(message.subject);
            $('#modal-date').text(new Date(message.date_submitted).toLocaleString('fr-FR'));
            $('#modal-ip').text(message.ip_address || 'N/A');
            $('#modal-message').text(message.message);
            $('#modal-reply').attr('href', 'mailto:' + message.email + '?subject=Re: ' + encodeURIComponent(message.subject));
            
            $('#message-modal').fadeIn(200);
        });
        
        // Fermer le modal
        $('#close-modal, #message-modal').on('click', function(e) {
            if (e.target === this) {
                $('#message-modal').fadeOut(200);
            }
        });
        
        // Empêcher la fermeture en cliquant sur le contenu
        $('#message-modal > div').on('click', function(e) {
            e.stopPropagation();
        });
    });
    </script>
    <?php
}