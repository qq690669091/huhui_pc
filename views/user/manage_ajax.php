
    <?php if($user_help_list) foreach($user_help_list as $l):?>
    <tr >
        <td><?=$l["help_id"]?></td>
        <td><?=$l["nickname"]?></td>
        <td><?=$l["money"]?></td>
        <td><?=$l["help_type"]?></td>
        <td>
            <button type="button" class="btn btn-outline btn-primary tan1"><?=$l["order_status"]?></button>
        </td>
    </tr>
    <?php endforeach;?>
    <!--btn-primary btn-info btn-warning-->


