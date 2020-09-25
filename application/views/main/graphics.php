<?php if ($graphics && $graphicsSections && count($graphics)>0 && count($graphicsSections)>0) : ?>

    <table class="graphics-table">
        <thead class="graphics-table-header">
            <tr>
                <td class="first-col-cell">Дата</td>
                <td class="second-col-cell">Время</td>
                <td class="third-col-cell">Ведущий(е)</td>
            </tr>
        </thead>
        <tbody>

            <?php $sectionsCount=0; ?>
            <?php foreach($graphicsSections as $section) : ?>
                <tr class="graphics-table-subheader opened-header">
                    <td colspan="3"><?=$section['group_name'] ?></td>
                </tr>

                <?php if ($graphics) : ?>
                    <?php foreach($graphics as $group) : ?>
                        <?php $rowCount=0; ?>
                        <?php if ($group['group_name']==$section['group_name']): ?>
                            <tr class="graphics-table-row opened-row">
                                <td class="first-col-cell"><?=$group['dates']?></td>
                                <td class="second-col-cell"><?=$group['time'] ?></td>
                                <td class="third-col-cell"><?=$group['leaders'] ?></td>
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