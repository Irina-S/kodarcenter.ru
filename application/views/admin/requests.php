<div class="request-table-container">
    <table class="request-table">
        <thead>
            <th>Имя</th>
            <th>Телефон</th>
            <th>Комментарий</th>
            <th>Статус</th>
            <th></th>
        </thead>
        <tbody>
            <?php if ($requests) : ?>
                <?php foreach($requests as $request) : ?>
                    <tr>
                        <td><?=$request['name'] ?></td>
                        <td><?=$request['phone_number'] ?></td>
                        <td><?=$request['comment'] ?></td>
                        <td><?=$request['status']?'обработана':'не обработана' ?></td>
                        <td>
                            <?php if (!$request['status']) :?>
                                <button class="tick proc-button" title="Пометить заявку как обработанную" tabindex="-1" type="button" data-id=<?=$request['request_id'] ?>></button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>