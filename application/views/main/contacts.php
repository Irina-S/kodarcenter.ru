<div class="all-contacts">


    <?php if (isset($contactsIds) && isset($contacts)) : ?>

        <?php if (($key=array_search('address', $contactsIds))!==FALSE) : ?>
                <div class="contact-name"><?=$contacts[$key]['name'].':' ?></div>
                <div class="contact-value"><?=$contacts[$key]['value'] ?></div>
        <?php endif; ?>

        <?php if (($key=array_search('phone', $contactsIds))!==FALSE) : ?>
                <div class="contact-name"><?=$contacts[$key]['name'].':' ?></div>
                <div class="contact-value"><?=$contacts[$key]['value'] ?></div>
        <?php endif; ?>

        <?php if (($key=array_search('email', $contactsIds))!==FALSE) : ?>
                <div class="contact-name"><?=$contacts[$key]['name'].':' ?></div>
                <div class="contact-value"><?=$contacts[$key]['value'] ?></div>
        <?php endif; ?>

        <?php if (($key=array_search('shedule', $contactsIds))!==FALSE) : ?>
                <div class="contact-name"><?=$contacts[$key]['name'].':' ?></div>
                <div class="contact-value"><?=nl2br($contacts[$key]['value']) ?></div>
        <?php endif; ?>

        <?php if (($key=array_search('vk', $contactsIds))!==FALSE) : ?>
            <div class="social-net"><a class="vk" href=<?=$contacts[$key]['value'] ?>></a></div>
        <?php endif; ?>

        <?php if (($key=array_search('instagram', $contactsIds))!==FALSE) : ?>
            <div class="social-net"><a class="ig" href=<?=$contacts[$key]['value'] ?>></a></div>
        <?php endif; ?>

    <?php endif; ?>

</div>
<div class="map">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2454.8156632902137!2d113.5064533558176!3d52.02845576320735!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x5dcbcacb3c3b0b51%3A0x418ed4fff7a84199!2z0JrQvtC00LDRgCwg0L_RgdC40YXQvtGC0LXRgNCw0L_QtdCy0YLQuNGH0LXRgdC60LjQuSDRhtC10L3RgtGA!5e0!3m2!1sru!2sru!4v1588172068438!5m2!1sru!2sru" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
</div>