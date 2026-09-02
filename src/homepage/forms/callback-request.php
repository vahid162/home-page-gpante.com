<?php

defined( 'ABSPATH' ) || exit;

function gpante_home_register_callback_post_type(): void {
    register_post_type(
        'gpante_callback',
        [
            'labels' => [
                'name'          => 'درخواست‌های تماس',
                'singular_name' => 'درخواست تماس',
            ],
            'public'              => false,
            'publicly_queryable'  => false,
            'exclude_from_search' => true,
            'show_ui'             => true,
            'show_in_menu'        => 'tools.php',
            'show_in_rest'        => false,
            'supports'            => [ 'title' ],
            'map_meta_cap'        => false,
            'capabilities'        => [
                'edit_post'          => 'manage_options',
                'read_post'          => 'manage_options',
                'delete_post'        => 'manage_options',
                'edit_posts'         => 'manage_options',
                'edit_others_posts'  => 'manage_options',
                'publish_posts'      => 'manage_options',
                'read_private_posts' => 'manage_options',
                'create_posts'       => 'do_not_allow',
            ],
        ]
    );
}
add_action( 'init', 'gpante_home_register_callback_post_type' );

function gpante_home_normalize_mobile( string $value ): string {
    $map = [
        '۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4',
        '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9',
        '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4',
        '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9',
    ];

    $value = strtr( $value, $map );

    return preg_replace( '/\D+/', '', $value ) ?: '';
}

function gpante_home_callback_recipient(): string {
    $recipient = defined( 'GPANTE_HOME_CALLBACK_EMAIL' ) ? (string) GPANTE_HOME_CALLBACK_EMAIL : '';

    return (string) apply_filters( 'gpante_home_callback_recipient', $recipient );
}

function gpante_home_callback_redirect( string $status ): void {
    $referer = wp_get_referer();
    $base    = $referer ? wp_validate_redirect( $referer, home_url( '/' ) ) : home_url( '/' );
    $url     = add_query_arg( 'gpante_callback_status', sanitize_key( $status ), $base );

    wp_safe_redirect( $url . '#contact-request' );
    exit;
}

function gpante_home_handle_callback_request(): void {
    if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ?? '' ) ) {
        gpante_home_callback_redirect( 'invalid-request' );
    }

    $nonce = isset( $_POST['_gpante_nonce'] )
        ? sanitize_text_field( wp_unslash( $_POST['_gpante_nonce'] ) )
        : '';

    if ( ! wp_verify_nonce( $nonce, 'gpante_home_callback_request' ) ) {
        gpante_home_callback_redirect( 'invalid-request' );
    }

    // Honeypot: legitimate users never fill this field.
    $website = isset( $_POST['website'] )
        ? sanitize_text_field( wp_unslash( $_POST['website'] ) )
        : '';

    if ( '' !== $website ) {
        gpante_home_callback_redirect( 'success' );
    }

    $mobile = isset( $_POST['mobile'] )
        ? gpante_home_normalize_mobile( sanitize_text_field( wp_unslash( $_POST['mobile'] ) ) )
        : '';

    if ( ! preg_match( '/^09\d{9}$/', $mobile ) ) {
        gpante_home_callback_redirect( 'invalid-mobile' );
    }

    $rate_key = 'gpante_cb_' . substr( hash_hmac( 'sha256', $mobile, wp_salt( 'nonce' ) ), 0, 32 );

    if ( get_transient( $rate_key ) ) {
        gpante_home_callback_redirect( 'rate-limited' );
    }

    set_transient( $rate_key, 1, MINUTE_IN_SECONDS );

    $post_id = wp_insert_post(
        [
            'post_type'   => 'gpante_callback',
            'post_status' => 'private',
            'post_title'  => sprintf( 'درخواست تماس — %s', current_time( 'Y-m-d H:i' ) ),
            'meta_input'  => [
                '_gpante_callback_mobile'       => $mobile,
                '_gpante_callback_email_status' => 'pending',
            ],
        ],
        true
    );

    if ( is_wp_error( $post_id ) ) {
        delete_transient( $rate_key );
        gpante_home_callback_redirect( 'storage-failed' );
    }

    $recipient = gpante_home_callback_recipient();

    if ( ! is_email( $recipient ) ) {
        update_post_meta( $post_id, '_gpante_callback_email_status', 'not-configured' );
        gpante_home_callback_redirect( 'email-not-configured' );
    }

    $subject = 'درخواست تماس جدید از صفحه اصلی پانته';
    $message = "شماره موبایل: {$mobile}\n";
    $message .= 'زمان ثبت: ' . current_time( 'mysql' );

    $sent = wp_mail( $recipient, $subject, $message );

    update_post_meta(
        $post_id,
        '_gpante_callback_email_status',
        $sent ? 'sent' : 'failed'
    );

    gpante_home_callback_redirect( $sent ? 'success' : 'email-failed' );
}

add_action( 'admin_post_gpante_home_callback_request', 'gpante_home_handle_callback_request' );
add_action( 'admin_post_nopriv_gpante_home_callback_request', 'gpante_home_handle_callback_request' );

function gpante_home_callback_status_message(): ?array {
    if ( empty( $_GET['gpante_callback_status'] ) ) {
        return null;
    }

    $status = sanitize_key( wp_unslash( $_GET['gpante_callback_status'] ) );

    $messages = [
        'success'              => [ 'success', 'درخواست شما ثبت شد. برای تماس با شما اقدام می‌کنیم.' ],
        'invalid-mobile'       => [ 'error', 'شماره موبایل را به شکل 09xxxxxxxxx وارد کنید.' ],
        'rate-limited'         => [ 'error', 'این شماره به‌تازگی ثبت شده است. کمی بعد دوباره تلاش کنید.' ],
        'storage-failed'       => [ 'error', 'ثبت درخواست انجام نشد. لطفاً دوباره تلاش کنید.' ],
        'email-not-configured' => [ 'error', 'درخواست ذخیره شد، اما اعلان ایمیل هنوز در محیط جدید پیکربندی نشده است.' ],
        'email-failed'         => [ 'error', 'درخواست ذخیره شد، اما ارسال اعلان ایمیل ناموفق بود.' ],
        'invalid-request'      => [ 'error', 'درخواست معتبر نبود. صفحه را تازه‌سازی و دوباره تلاش کنید.' ],
    ];

    return $messages[ $status ] ?? null;
}
