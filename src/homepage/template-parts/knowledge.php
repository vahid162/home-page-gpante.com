<?php

defined( 'ABSPATH' ) || exit;

$forum_items = $data['forum_items'] ?? [];
$articles    = $data['articles'] ?? [];

if ( ! $forum_items && ! $articles ) {
    return;
}
?>
<section class="hp-section hp-shell hp-knowledge" aria-label="دانش و پاسخ">
    <?php if ( $forum_items ) : ?>
        <article class="hp-list-panel" aria-labelledby="qa-title">
            <div class="hp-list-panel__head">
                <div><p class="hp-eyebrow">پرسش‌های تخصصی</p><h2 id="qa-title">جدیدترین پرسش و پاسخ‌ها</h2></div>
                <a class="hp-text-link" href="<?php echo esc_url( gpante_home_get_forum_questions_url() ); ?>">همه پرسش‌ها <span aria-hidden="true">←</span></a>
            </div>
            <div class="hp-list">
                <?php foreach ( $forum_items as $item ) : ?>
                    <a class="hp-list-item" href="<?php echo esc_url( $item['url'] ); ?>">
                        <span class="hp-list-item__mark" aria-hidden="true">؟</span>
                        <span>
                            <strong><?php echo esc_html( $item['title'] ); ?></strong>
                            <small><?php echo esc_html( trim( $item['type'] . ( $item['relative'] ? ' • ' . $item['relative'] : '' ) ) ); ?></small>
                        </span>
                    </a>
                <?php endforeach; ?>
            </div>
        </article>
    <?php endif; ?>

    <?php if ( $articles ) : ?>
        <article class="hp-list-panel" aria-labelledby="articles-title">
            <div class="hp-list-panel__head">
                <div><p class="hp-eyebrow">دانش و آموزش</p><h2 id="articles-title">مقالات کاربردی</h2></div>
                <?php if ( gpante_home_get_posts_index_url() ) : ?>
                    <a class="hp-text-link" href="<?php echo esc_url( gpante_home_get_posts_index_url() ); ?>">همه مقالات <span aria-hidden="true">←</span></a>
                <?php endif; ?>
            </div>
            <div class="hp-list">
                <?php foreach ( $articles as $article ) : ?>
                    <a class="hp-list-item hp-list-item--article" href="<?php echo esc_url( $article['url'] ); ?>">
                        <span class="hp-list-item__thumb" aria-hidden="true">
                            <?php if ( ! empty( $article['image_id'] ) ) : ?>
                                <?php
                                echo wp_get_attachment_image(
                                    (int) $article['image_id'],
                                    'thumbnail',
                                    false,
                                    [
                                        'alt'      => '',
                                        'loading'  => 'lazy',
                                        'decoding' => 'async',
                                    ]
                                ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                ?>
                            <?php endif; ?>
                        </span>
                        <span>
                            <strong><?php echo esc_html( $article['title'] ); ?></strong>
                            <small><?php echo esc_html( $article['date'] ); ?></small>
                        </span>
                    </a>
                <?php endforeach; ?>
            </div>
        </article>
    <?php endif; ?>
</section>
