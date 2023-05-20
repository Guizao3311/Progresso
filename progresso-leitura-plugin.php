<?php
/*
Plugin Name: Barra de Progresso de Leitura
Plugin URI: http://seu-site.com/
Description: Um plugin para exibir uma barra de progresso de leitura e um botão "Leia Mais" nos posts.
Version: 1.0
Author: Seu Nome
Author URI: http://seu-site.com/
*/

// Adiciona os estilos CSS do plugin
function leia_mais_progresso_styles() {
    wp_enqueue_style( 'leia-mais-progresso-styles', plugins_url( 'css/styles.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'leia_mais_progresso_styles' );

// Adiciona os scripts JavaScript do plugin
function leia_mais_progresso_scripts() {
    wp_enqueue_script( 'leia-mais-progresso-scripts', plugins_url( 'js/scripts.js', __FILE__ ), array( 'jquery' ), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'leia_mais_progresso_scripts' );

// Adiciona a barra de progresso de leitura
function leia_mais_progresso_barra() {
    echo '<div id="leia-mais-progresso-barra"></div>';
}
add_action( 'wp_footer', 'leia_mais_progresso_barra' );

// Adiciona o botão "Leia Mais" com os shortcodes
function leia_mais_progresso_botao( $atts, $content = null ) {
    $a = shortcode_atts( array(
        'start' => '',
        'end' => '',
    ), $atts );

    $output = '<div class="leia-mais-progresso-botao">';
    $output .= '<button class="leia-mais-progresso-toggle">' . __( 'Leia Mais', 'leia-mais-progresso' ) . '</button>';
    $output .= '<div class="leia-mais-progresso-conteudo">' . $content . '</div>';
    $output .= '</div>';

    return $output;
}
add_shortcode( 'leia_mais_start', 'leia_mais_progresso_botao' );
add_shortcode( 'leia_mais_end', 'leia_mais_progresso_botao' );

// Cria o menu de configuração do plugin
function leia_mais_progresso_menu() {
    add_menu_page( 'Configurações da Barra de Progresso de Leitura', 'Barra de Progresso', 'manage_options', 'leia-mais-progresso-settings', 'leia_mais_progresso_settings_page', 'dashicons-admin-generic', 99 );
}
add_action( 'admin_menu', 'leia_mais_progresso_menu' );

// Cria a página de configurações do plugin
function leia_mais_progresso_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    
    // Verifica se o formulário foi enviado e atualiza as configurações
    if ( isset( $_POST['leia_mais_progresso_settings_submit'] ) ) {
        update_option( 'leia_mais_progresso_button_text', sanitize_text_field( $_POST['leia_mais_progresso_button_text'] ) );
        update_option( 'leia_mais_progresso_button_color', sanitize_text_field( $_POST['leia_mais_progresso_button_color'] ) );
        update_option( 'leia_mais_progresso_button_hover_color', sanitize_text_field( $_POST['leia_mais_progresso_button_hover_color'] ) );
        update_option( 'leia_mais_progresso_bar_color', sanitize_text_field( $_POST['leia_mais_progresso_bar_color'] ) );
        update_option( 'leia_mais_progresso_bar_background_color', sanitize_text_field( $_POST['leia_mais_progresso_bar_background_color'] ) );
        update_option( 'leia_mais_progresso_bar_height', absint( $_POST['leia_mais_progresso_bar_height'] ) );
    }
    
    // Exibe o formulário de configurações
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form method="post" action="">
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="leia_mais_progresso_button_text">Texto do Botão "Leia Mais"</label></th>
                    <td>
                        <input name="leia_mais_progresso_button_text" type="text" id="leia_mais_progresso_button_text" value="<?php echo esc_attr( get_option( 'leia_mais_progresso_button_text', 'Leia Mais' ) ); ?>" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="leia_mais_progresso_button_color">Cor do Botão</label></th>
                    <td>
                        <input name="leia_mais_progresso_button_color" type="color" id="leia_mais_progresso_button_color" value="<?php echo esc_attr( get_option( 'leia_mais_progresso_button_color', '#000000' ) ); ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="leia_mais_progresso_button_hover_color">Cor do Botão (Ao passar o mouse)</label></th>
                    <td>
                        <input name="leia_mais_progresso_button_hover_color" type="color" id="leia_mais_progresso_button_hover_color" value="<?php echo esc_attr( get_option( 'leia_mais_progresso_button_hover_color', '#ff0000' ) ); ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="leia_mais_progresso_bar_color">Cor da Barra de Progresso (Preenchida)</label></th>
                    <td>
                        <input name="leia_mais_progresso_bar_color" type="color" id="leia_mais_progresso_bar_color" value="<?php echo esc_attr( get_option( 'leia_mais_progresso_bar_color', '#0000ff' ) ); ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="leia_mais_progresso_bar_background_color">Cor de Fundo da Barra de Progresso</label></th>
                    <td>
                        <input name="leia_mais_progresso_bar_background_color" type="color" id="leia_mais_progresso_bar_background_color" value="<?php echo esc_attr( get_option( 'leia_mais_progresso_bar_background_color', '#eaeaea' ) ); ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="leia_mais_progresso_bar_height">Altura da Barra de Progresso (em pixels)</label></th>
                    <td>
                        <input name="leia_mais_progresso_bar_height" type="number" id="leia_mais_progresso_bar_height" value="<?php echo esc_attr( get_option( 'leia_mais_progresso_bar_height', 5 ) ); ?>" min="1" max="100" step="1" class="small-text">
                    </td>
                </tr>
            </table>
            <p class="submit">
                <input type="submit" name="leia_mais_progresso_settings_submit" id="leia_mais_progresso_settings_submit" class="button-primary" value="Salvar alterações">
            </p>
        </form>
    </div>
    <?php
}

// Adiciona o shortcode do botão no menu
function leia_mais_progresso_menu_shortcode() {
    $button_text = get_option( 'leia_mais_progresso_button_text', 'Leia Mais' );
    $output = '<button class="leia-mais-progresso-menu-button">' . esc_html( $button_text ) . '</button>';
    return $output;
}
add_shortcode( 'leia_mais_progresso_menu_button', 'leia_mais_progresso_menu_shortcode' );
