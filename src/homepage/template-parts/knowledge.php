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
            <header class="hp-list-panel__head">
                <div>
                    <h2 id="qa-title">جدیدترین پرسش و پاسخ ها</h2>
                    <p>Question &amp; Answer</p>
                </div>
            </header>

            <div class="hp-list">
                <?php foreach ( $forum_items as $item ) : ?>
                    <a class="hp-list-item" href="<?php echo esc_url( $item['url'] ); ?>">
                        <span class="hp-list-item__mark" aria-hidden="true">؟</span>
                        <span>
                            <strong><?php echo esc_html( $item['title'] ); ?></strong>
                            <small><?php echo esc_html( trim( $item['type'] . ( $item['relative'] ? '، ' . $item['relative'] : '' ) ) ); ?></small>
                        </span>
                    </a>
                <?php endforeach; ?>
            </div>

            <a class="hp-more-link" href="<?php echo esc_url( gpante_home_get_forum_questions_url() ); ?>">نمایش همه ی پرسش و پاسخ ها</a>
        </article>
    <?php endif; ?>

    <?php if ( $articles ) : ?>
        <article class="hp-list-panel" aria-labelledby="articles-title">
            <header class="hp-list-panel__head">
                <h2 id="articles-title">جدیدترین مقاله ها</h2>
            </header>

            <div class="hp-article-list">
                <?php foreach ( $articles as $article ) : ?>
                    <article class="hp-article-item">
                        <a class="hp-article-item__title" href="<?php echo esc_url( $article['url'] ); ?>"><?php echo esc_html( $article['title'] ); ?></a>
                        <?php if ( ! empty( $article['excerpt'] ) ) : ?>
                            <p><?php echo esc_html( $article['excerpt'] ); ?></p>
                        <?php endif; ?>
                        <div>
                            <a href="<?php echo esc_url( $article['url'] ); ?>">بیشتر بخوانید»</a>
                            <time><?php echo esc_html( $article['date'] ); ?></time>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <?php if ( gpante_home_get_posts_index_url() ) : ?>
                <a class="hp-more-link" href="<?php echo esc_url( gpante_home_get_posts_index_url() ); ?>">نمایش مقاله های دیگر</a>
            <?php endif; ?>
        </article>
    <?php endif; ?>
</section>
