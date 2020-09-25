<form class="price-edit-form" id="price-edit-form" method="POST" action="editprice">
    <table class="price-edit-table" id="price-edit-table">
        <thead>
            <th>Название <span class="asteriks">*</span></th>
            <th>Ведущий(е)</th>
            <th>Цена <span class="asteriks">*</span></th>
            <th><button class="plus" title="Добавить новый раздел" tabindex="-1" id="section-create-button" type="button"></button></th>
        </thead>
        <tbody>
            <?php if ($priceSections) : ?>
                <?php $sectionsCount=0; ?>
                <?php foreach($priceSections as $section) : ?>
                    <tr data-section-number=<?=$sectionsCount ?> class="section-header">
                        <td colspan="3"><input type="text" name="sections[]" placeholder="Введите название раздела" value=<?= '"'.$section['category'].'"'?>></td>
                        <td><button class="cross del-section-button" title="Удалить этот раздел" tabindex="-1" type="button" data-section-number=<?=$sectionsCount ?>></button></td>
                    </tr>

                    <?php if ($price) : ?>
                        <?php foreach($price as $service) : ?>
                            <?php $rowCount=0; ?>
                            <?php if ($service['category']==$section['category']): ?>
                                <tr>
                                    <td><input type="text" name="services[name][]" placeholder="Введите название услуги" value=<?= '"'.$service['service'].'"'?>></td>
                                    <td><input type="text" name="services[leaders][]" placeholder="Введите ФИО ведущего(их)" value=<?= '"'.$service['leaders'].'"'?>></td>
                                    <td><input type="text" name="services[price][]" placeholder="Введите цену" value=<?= '"'.$service['price'].'"'?>></td>
                                    <td><input type="hidden" name="services[sectionNumber][]" value=<?=$sectionsCount?>><button class="cross del-row-button" title="Удалить эту строку" tabindex="-1" type="button"></button></td>
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

    <input name="price-submit" type="submit" value="Сохранить">
</form>
<script src="/public/js/price-edit.js"></script>
