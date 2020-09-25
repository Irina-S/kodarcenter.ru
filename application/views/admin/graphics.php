<form class="graphics-edit-form" id="graphics-edit-form" method="POST" action="editgraphics">
    <table class="graphics-edit-table" id="graphics-edit-table">
        <thead>
            <th>Дата<span class="asteriks">*</span></th>
            <th>Время</th>
            <th>Ведущий(е)<span class="asteriks">*</span></th>
            <th><button class="plus" title="Добавить новый вид группы" tabindex="-1" id="section-create-button" type="button"></button></th>
        </thead>
        <tbody>
            <?php if ($graphicsSections) : ?>
                <?php $sectionsCount=0; ?>
                <?php foreach($graphicsSections as $section) : ?>
                    <tr data-section-number=<?=$sectionsCount ?> class="section-header">
                        <td colspan="3"><input type="text" name="sections[]" placeholder="Введите название групп(ы)" value=<?= '"'.$section['group_name'].'"'?>></td>
                        <td><button class="cross del-section-button" title="Удалить этот раздел" tabindex="-1" type="button" data-section-number=<?=$sectionsCount ?>></button></td>
                    </tr>

                    <?php if ($graphics) : ?>
                        <?php foreach($graphics as $group) : ?>
                            <?php $rowCount=0; ?>
                            <?php if ($group['group_name']==$section['group_name']): ?>
                                <tr>
                                    <td><input type="text" name="groups[dates][]" placeholder="Введите дату" value=<?= '"'.$group['dates'].'"'?>></td>
                                    <td><input type="text" name="groups[time][]" placeholder="Введите время" value=<?= '"'.$group['time'].'"'?>></td>
                                    <td><input type="text" name="groups[leaders][]" placeholder="Введите ФИО ведущего(их)" value=<?= '"'.$group['leaders'].'"'?>></td>
                                    <td><input type="hidden" name="groups[sectionNumber][]" value=<?=$sectionsCount?>><button class="cross del-row-button" title="Удалить эту строку" tabindex="-1" type="button"></button></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <tr class="section-last-row">
                        <td colspan="4"><button class="plus create-row-button" data-section-number=<?=$sectionsCount ?> title="Добавить новую строку в этот раздел" tabindex="-1" type="button"></button></td>
                    </tr>
                    <?php $sectionsCount++; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <p><span class="asteriks">*</span> - обязательно для заполнения</p>

    <input name="graphics-submit" type="submit" value="Сохранить">
</form>
<script src="/public/js/graphics-edit.js"></script>