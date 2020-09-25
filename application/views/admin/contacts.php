<form class="contacts-edit-form" action="contacts" method="POST">
    <h3>Редактирование контактов</h3>

    <?php foreach($contacts as $contact) : ?>
        <label for=<?= '"'.$contact['input_id'].'"'?>><?=$contact['name']?></label>
        <?php if ($contact['input_id']=='shedule') : ?>
            <textarea name="contacts[value][]" id=<?= $contact['input_id']?>><?=$contact['value'] ?></textarea>
        <?php else : ?>
            <input type="text" name="contacts[value][]" id=<?= $contact['input_id']?> value=<?='"'.$contact['value'].'"'?>>
        <?php endif; ?>
        <input type="hidden" name="contacts[id][]" value=<?= $contact['contact_id']?>>
    <?php endforeach; ?>

    <input name="contacts-submit" type="submit" value="Сохранить">
</form>