<?php if ($price && $priceSections && count($price)>0 && count($priceSections)>0) : ?>
    <table class="price-table">
        <thead class="price-table-header">
            <tr>
                <td class="first-col-cell">Название</td>
                <td class="second-col-cell">Ведущий(е)</td>
                <td class="third-col-cell">Цена</td>
            </tr>
        </thead>
        <tbody>
            <?php $sectionsCount=0; ?>
            <?php foreach($priceSections as $section) : ?>
                <tr class="price-table-subheader opened-header">
                    <td colspan="3"><?=$section['category'] ?></td>
                </tr>

                <?php if ($price) : ?>
                    <?php foreach($price as $service) : ?>
                        <?php $rowCount=0; ?>
                        <?php if ($service['category']==$section['category']): ?>
                            <tr class="price-table-row opened-row">
                                <td class="first-col-cell"><?=$service['service'] ?></td>
                                <td class="second-col-cell"><?=$service['leaders'] ?></td>
                                <td class="third-col-cell"><?=$service['price'] ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php $sectionsCount++; ?>
            <?php endforeach; ?>
        </tbody>                    
    </table>
<?php endif; ?>
<script src="/public/js/price.js"></script>